<?php
require_once __DIR__ . '/../includes/layout.php';
require_admin();
$pageTitle = 'ລາຍງານການຂາຍ';

$from = $_GET['from'] ?? date('Y-m-01');
$to = $_GET['to'] ?? date('Y-m-d');

// daily breakdown
$stmt = $connect->prepare("SELECT DATE(created_at) d, COUNT(*) cnt, SUM(total) total
    FROM sales WHERE DATE(created_at) BETWEEN ? AND ?
    GROUP BY DATE(created_at) ORDER BY d");
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$dailyRows = $stmt->get_result();
$dailyData = [];
while ($r = $dailyRows->fetch_assoc()) $dailyData[] = $r;

// monthly breakdown (last 6 months)
$monthRes = $connect->query("SELECT DATE_FORMAT(created_at, '%Y-%m') ym, COUNT(*) cnt, SUM(total) total
    FROM sales
    WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
    GROUP BY ym ORDER BY ym");
$monthData = [];
while ($r = $monthRes->fetch_assoc()) $monthData[] = $r;

// best sellers
$stmt = $connect->prepare("SELECT product_name, SUM(qty) total_qty, SUM(subtotal) total_revenue
    FROM sale_items si JOIN sales s ON s.id = si.sale_id
    WHERE DATE(s.created_at) BETWEEN ? AND ?
    GROUP BY product_name
    ORDER BY total_qty DESC LIMIT 10");
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$best = $stmt->get_result();

// totals summary
$stmt = $connect->prepare("SELECT COUNT(*) cnt, COALESCE(SUM(total),0) total
    FROM sales WHERE DATE(created_at) BETWEEN ? AND ?");
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$summary = $stmt->get_result()->fetch_assoc();

layout_head($pageTitle);
?>
<div class="row">
    <div class="col-12"><?php flash_banner(); ?></div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="get" class="row g-2 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">ຈາກວັນທີ</label>
                        <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">ຫາວັນທີ</label>
                        <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
                    </div>
                    <div class="col-md-2"><button class="btn btn-primary w-100">ສ້າງລາຍງານ</button></div>
                    <div class="col-md-4 text-end">
                        <div class="text-muted">ບິນທັງໝົດ <strong class="text-dark"><?= (int)$summary['cnt'] ?></strong></div>
                        <div class="text-muted">ຍອດລວມ <strong class="text-primary fs-5"><?= money($summary['total']) ?></strong></div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">ຍອດຂາຍລາຍວັນ</h5></div>
            <div class="card-body"><canvas id="dailyChart" height="120"></canvas></div>
        </div>
        <div class="card">
            <div class="card-header"><h5 class="mb-0">ຍອດຂາຍລາຍເດືອນ (6 ເດືອນຍ້ອນຫຼັງ)</h5></div>
            <div class="card-body"><canvas id="monthChart" height="120"></canvas></div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">🏆 ສິນຄ້າຂາຍດີ Top 10</h5></div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>#</th><th>ສິນຄ້າ</th><th class="text-end">ຈຳນວນ</th><th class="text-end">ຍອດ</th></tr>
                    </thead>
                    <tbody>
                    <?php $rank=1; while ($r = $best->fetch_assoc()): ?>
                        <tr>
                            <td><?= $rank++ ?></td>
                            <td><?= e($r['product_name']) ?></td>
                            <td class="text-end"><?= (int)$r['total_qty'] ?></td>
                            <td class="text-end small"><?= number_format($r['total_revenue']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <?php if ($best->num_rows === 0): ?>
                        <tr><td colspan="4" class="text-center text-muted py-3">ບໍ່ມີຂໍ້ມູນ</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const dailyData = <?= json_encode($dailyData) ?>;
const monthData = <?= json_encode($monthData) ?>;

new Chart(document.getElementById('dailyChart'), {
    type: 'bar',
    data: {
        labels: dailyData.map(d => d.d),
        datasets: [{ label: 'ຍອດຂາຍ (ກີບ)', data: dailyData.map(d => d.total), backgroundColor: '#5e72e4' }]
    },
    options: { responsive: true }
});

new Chart(document.getElementById('monthChart'), {
    type: 'line',
    data: {
        labels: monthData.map(d => d.ym),
        datasets: [{
            label: 'ຍອດຂາຍລາຍເດືອນ',
            data: monthData.map(d => d.total),
            borderColor: '#11cdef',
            backgroundColor: 'rgba(17,205,239,0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: { responsive: true }
});
</script>
<?php layout_foot(); ?>
