<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ປະຫວັດການຂາຍ';

$preset = $_GET['preset'] ?? '';
switch ($preset) {
    case 'today':   $from = $to = date('Y-m-d'); break;
    case 'week':    $from = date('Y-m-d', strtotime('monday this week')); $to = date('Y-m-d'); break;
    case 'month':   $from = date('Y-m-01'); $to = date('Y-m-d'); break;
    default:        $from = $_GET['from'] ?? date('Y-m-01'); $to = $_GET['to'] ?? date('Y-m-d');
}

$stmt = $connect->prepare("SELECT s.*, u.fullname AS cashier,
    (SELECT COUNT(*) FROM sale_items WHERE sale_id = s.id) AS item_count
    FROM sales s LEFT JOIN users u ON u.id = s.user_id
    WHERE DATE(s.created_at) BETWEEN ? AND ?
    ORDER BY s.id DESC");
$stmt->bind_param('ss', $from, $to);
$stmt->execute();
$rows = $stmt->get_result();

$sumStmt = $connect->prepare("SELECT COUNT(*) AS cnt, COALESCE(SUM(total),0) AS sum_total FROM sales WHERE DATE(created_at) BETWEEN ? AND ?");
$sumStmt->bind_param('ss', $from, $to);
$sumStmt->execute();
$sum = $sumStmt->get_result()->fetch_assoc();

layout_head($pageTitle);
?>
<?php flash_banner(); ?>
<div class="row g-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-12">
                        <div class="chip-group">
                            <a href="?preset=today" class="<?= $preset==='today'?'active':'' ?>">ມື້ນີ້</a>
                            <a href="?preset=week" class="<?= $preset==='week'?'active':'' ?>">ອາທິດນີ້</a>
                            <a href="?preset=month" class="<?= $preset==='month'?'active':'' ?>">ເດືອນນີ້</a>
                        </div>
                    </div>
                    <div class="col-12">
                        <form method="get" class="row g-2 align-items-end">
                            <div class="col-md-3">
                                <label class="form-label">ຈາກວັນທີ</label>
                                <input type="date" name="from" class="form-control" value="<?= e($from) ?>">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">ຫາວັນທີ</label>
                                <input type="date" name="to" class="form-control" value="<?= e($to) ?>">
                            </div>
                            <div class="col-md-2"><button class="btn btn-primary w-100">ກັ່ນຕອງ</button></div>
                            <div class="col-md-4 text-end">
                                <div class="text-muted small">ຈຳນວນບິນ <strong class="text-dark"><?= (int)$sum['cnt'] ?></strong></div>
                                <div class="text-muted small">ຍອດລວມ <strong class="text-primary fs-5"><?= money($sum['sum_total']) ?></strong></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <?php if ($rows->num_rows === 0): ?>
                    <?= empty_state('ບໍ່ມີຂໍ້ມູນໃນຊ່ວງເວລານີ້', 'ລອງປ່ຽນຊ່ວງວັນທີ', '📋') ?>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th width="80">#</th>
                                <th>ວັນທີ</th>
                                <th>ພະນັກງານ</th>
                                <th class="text-center">ລາຍການ</th>
                                <th class="text-end">ລວມ</th>
                                <th width="120"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($r = $rows->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?= (int)$r['id'] ?></td>
                                    <td><?= format_datetime($r['created_at']) ?></td>
                                    <td><?= e($r['cashier'] ?? '-') ?></td>
                                    <td class="text-center"><?= (int)$r['item_count'] ?></td>
                                    <td class="text-end fw-semibold"><?= money($r['total']) ?></td>
                                    <td><a href="sale-receipt.php?id=<?= (int)$r['id'] ?>" class="btn btn-sm btn-soft-primary">ໃບເສັດ</a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
