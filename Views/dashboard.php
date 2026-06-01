<?php
require_once __DIR__ . '/../includes/auth.php';
global $connect;

$today = date('Y-m-d');
$monthStart = date('Y-m-01');

$q1 = $connect->query("SELECT COALESCE(SUM(total),0) v, COUNT(*) c FROM sales WHERE DATE(created_at) = '$today'");
$today_data = $q1->fetch_assoc();
$q2 = $connect->query("SELECT COALESCE(SUM(total),0) v, COUNT(*) c FROM sales WHERE DATE(created_at) >= '$monthStart'");
$month_data = $q2->fetch_assoc();
$q3 = $connect->query("SELECT COUNT(*) c FROM products WHERE status=1");
$prod_count = (int)$q3->fetch_assoc()['c'];
$q4 = $connect->query("SELECT COUNT(*) c FROM products WHERE status=1 AND stock <= low_stock_threshold");
$low_count = (int)$q4->fetch_assoc()['c'];

$daily = [];
for ($i = 6; $i >= 0; $i--) {
    $d = date('Y-m-d', strtotime("-$i day"));
    $r = $connect->query("SELECT COALESCE(SUM(total),0) v FROM sales WHERE DATE(created_at) = '$d'");
    $daily[] = ['date' => $d, 'value' => (float)$r->fetch_assoc()['v']];
}
$chartLabels = array_map(fn($d) => date('d/m', strtotime($d['date'])), $daily);
$chartValues = array_map(fn($d) => $d['value'], $daily);

$topRes = $connect->query("SELECT product_name, SUM(qty) total_qty, SUM(subtotal) total_revenue
    FROM sale_items si JOIN sales s ON s.id = si.sale_id
    WHERE DATE(s.created_at) >= '$monthStart'
    GROUP BY product_name ORDER BY total_qty DESC LIMIT 7");
?>
<?php flash_banner(); ?>
<div class="row g-3">
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box">
                        <svg width="24" viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h2v8H3v-8zm4-5h2v13H7V8zm4-3h2v16h-2V5zm4 6h2v10h-2V11zm4-4h2v14h-2V7z"/></svg>
                    </div>
                    <div class="ms-3">
                        <div class="stat-label">ຍອດຂາຍວັນນີ້</div>
                        <div class="stat-value"><?= number_format($today_data['v']) ?> <span class="fs-6 fw-normal text-muted">ກີບ</span></div>
                        <div class="stat-meta"><?= (int)$today_data['c'] ?> ບິນ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box">
                        <svg width="24" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zm-7 14l-5-5h3V9h4v3h3l-5 5z"/></svg>
                    </div>
                    <div class="ms-3">
                        <div class="stat-label">ຍອດຂາຍເດືອນນີ້</div>
                        <div class="stat-value"><?= number_format($month_data['v']) ?> <span class="fs-6 fw-normal text-muted">ກີບ</span></div>
                        <div class="stat-meta"><?= (int)$month_data['c'] ?> ບິນ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <div class="card stat-card info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="icon-box">
                        <svg width="24" viewBox="0 0 24 24" fill="currentColor"><path d="M20 6H4V4h16v2zm-2 4H6v10h12V10z"/></svg>
                    </div>
                    <div class="ms-3">
                        <div class="stat-label">ສິນຄ້າທັງໝົດ</div>
                        <div class="stat-value"><?= $prod_count ?></div>
                        <div class="stat-meta">ລາຍການ</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-lg-3">
        <a href="inventory.php?low=1" class="text-decoration-none">
            <div class="card stat-card danger">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="icon-box">
                            <svg width="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L1 21h22L12 2zm-1 6v6h2V8h-2zm0 8v2h2v-2h-2z"/></svg>
                        </div>
                        <div class="ms-3">
                            <div class="stat-label">ສິນຄ້າໃກ້ໝົດ</div>
                            <div class="stat-value text-danger"><?= $low_count ?></div>
                            <div class="stat-meta">ຕ້ອງເຕີມສະຕັອກ</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-0">ຍອດຂາຍ 7 ວັນຍ້ອນຫຼັງ</h5>
                    <small class="text-muted">ໜ່ວຍ: ກີບ</small>
                </div>
                <span class="badge bg-soft-primary text-primary">7 ວັນ</span>
            </div>
            <div class="card-body">
                <?php $hasData = array_sum($chartValues) > 0; ?>
                <?php if ($hasData): ?>
                    <canvas id="salesChart" height="120"></canvas>
                <?php else: ?>
                    <div class="empty-state text-center py-5">
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none">
                            <rect x="10" y="14" width="60" height="48" rx="6" stroke="#cbd5e1" stroke-width="2"/>
                            <path d="M18 50l10-12 8 6 12-18 14 14" stroke="#cbd5e1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <circle cx="28" cy="38" r="2.5" fill="#94a3b8"/>
                            <circle cx="36" cy="44" r="2.5" fill="#94a3b8"/>
                            <circle cx="48" cy="26" r="2.5" fill="#94a3b8"/>
                            <circle cx="62" cy="40" r="2.5" fill="#94a3b8"/>
                        </svg>
                        <div class="empty-title mt-3">ຍັງບໍ່ມີຂໍ້ມູນການຂາຍ</div>
                        <div class="empty-sub text-muted small mb-3">ເລີ່ມການຂາຍຄັ້ງທຳອິດເພື່ອເຫັນກຣາຟ</div>
                        <a href="pos.php" class="btn btn-primary">→ ໄປຫາໜ້າຂາຍ</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="mb-0">🏆 ສິນຄ້າຂາຍດີ (ເດືອນນີ້)</h5>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php $rank = 1; while ($t = $topRes->fetch_assoc()):
                        $colors = ['#f59e0b','#64748b','#cd7f32','#5e72e4','#5e72e4','#5e72e4','#5e72e4'];
                        $color = $colors[$rank-1] ?? '#5e72e4';
                    ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-3 py-2">
                            <div class="d-flex align-items-center">
                                <span class="me-3 fw-bold text-center" style="color:<?= $color ?>;font-size:1.1rem;width:28px">#<?= $rank++ ?></span>
                                <div>
                                    <div class="fw-semibold" style="font-size:.92rem"><?= e($t['product_name']) ?></div>
                                    <small class="text-muted"><?= (int)$t['total_qty'] ?> ຊິ້ນ</small>
                                </div>
                            </div>
                            <div class="text-end fw-semibold text-primary" style="font-size:.92rem"><?= number_format($t['total_revenue']) ?></div>
                        </li>
                    <?php endwhile; ?>
                    <?php if ($topRes->num_rows === 0): ?>
                        <li class="list-group-item text-center text-muted py-4">ຍັງບໍ່ມີຂໍ້ມູນ</li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php if ($hasData): ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 300);
gradient.addColorStop(0, 'rgba(94,114,228,0.3)');
gradient.addColorStop(1, 'rgba(94,114,228,0.0)');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($chartLabels) ?>,
        datasets: [{
            label: 'ຍອດຂາຍ',
            data: <?= json_encode($chartValues) ?>,
            borderColor: '#5e72e4',
            backgroundColor: gradient,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#5e72e4',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { callback: v => v.toLocaleString() }, grid: { color: '#f0f1f5' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
<?php endif; ?>
