<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ສິນຄ້າຄົງເຫຼືອ';

$showLowOnly = isset($_GET['low']);
$where = ['p.status = 1'];
if ($showLowOnly) $where[] = 'p.stock <= p.low_stock_threshold';
$sql = "SELECT p.*, c.name AS category_name FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE " . implode(' AND ', $where) . "
        ORDER BY (p.stock <= p.low_stock_threshold) DESC, p.name";
$rows = $connect->query($sql);

$lowCountRes = $connect->query("SELECT COUNT(*) c FROM products WHERE status=1 AND stock <= low_stock_threshold");
$lowCount = (int)$lowCountRes->fetch_assoc()['c'];

$mvRes = $connect->query("SELECT m.*, p.name AS product_name, u.fullname AS user_name FROM stock_movements m
    LEFT JOIN products p ON p.id = m.product_id
    LEFT JOIN users u ON u.id = m.user_id
    ORDER BY m.id DESC LIMIT 20");

layout_head($pageTitle);
?>
<div class="row">
    <div class="col-12"><?php flash_banner(); ?></div>

    <?php if ($lowCount > 0): ?>
    <div class="col-12">
        <div class="alert alert-warning d-flex justify-content-between">
            <span><strong>⚠ ແຈ້ງເຕືອນ:</strong> ມີສິນຄ້າ <?= $lowCount ?> ລາຍການໃກ້ໝົດ</span>
            <a href="?low=1" class="alert-link">ສະແດງສະເພາະສິນຄ້າໃກ້ໝົດ →</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">ສະຕັອກສິນຄ້າ <?= $showLowOnly ? '(ໃກ້ໝົດ)' : '' ?></h5>
                <?php if ($showLowOnly): ?><a href="inventory.php" class="btn btn-sm btn-link">ສະແດງທັງໝົດ</a><?php endif; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th>ສິນຄ້າ</th>
                                <th>ໝວດໝູ່</th>
                                <th class="text-center">ຄົງເຫຼືອ</th>
                                <th class="text-center">ຂັ້ນຕ່ຳ</th>
                                <?php if (is_admin()): ?><th width="200">ປັບສະຕັອກ</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($r = $rows->fetch_assoc()):
                                $low = $r['stock'] <= $r['low_stock_threshold'];
                            ?>
                                <tr>
                                    <td><?= e($r['name']) ?></td>
                                    <td><span class="badge bg-soft-info text-info"><?= e($r['category_name'] ?? '-') ?></span></td>
                                    <td class="text-center">
                                        <span class="<?= $low ? 'low-stock' : '' ?>"><?= (int)$r['stock'] ?></span>
                                        <?php if ($low): ?><span class="badge bg-danger ms-1">ໃກ້ໝົດ</span><?php endif; ?>
                                    </td>
                                    <td class="text-center"><?= (int)$r['low_stock_threshold'] ?></td>
                                    <?php if (is_admin()): ?>
                                    <td>
                                        <form method="post" action="../controller/inventory.php" class="d-flex gap-1">
                                            <input type="hidden" name="product_id" value="<?= (int)$r['id'] ?>">
                                            <input type="number" name="change_qty" class="form-control form-control-sm" placeholder="+ ເຕີມ / - ລົດ" title="ໃສ່ບວກເພື່ອເຕີມສະຕັອກ, ໃສ່ລົບເພື່ອລົດ" required>
                                            <button class="btn btn-sm btn-primary" title="ບັນທຶກການປັບ">ບັນທຶກ</button>
                                        </form>
                                    </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endwhile; ?>
                            <?php if ($rows->num_rows === 0): ?>
                                <tr><td colspan="5"><?= empty_state('ບໍ່ມີຂໍ້ມູນ', '', '📦') ?></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h5 class="mb-0">ປະຫວັດການເຄື່ອນໄຫວສະຕັອກ</h5></div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php while ($m = $mvRes->fetch_assoc()):
                        $cls = $m['change_qty'] > 0 ? 'text-success' : 'text-danger';
                        $sign = $m['change_qty'] > 0 ? '+' : '';
                    ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <div class="fw-semibold"><?= e($m['product_name'] ?? '-') ?></div>
                                    <small class="text-muted"><?= e($m['reason']) ?> • <?= e($m['user_name'] ?? '-') ?></small>
                                </div>
                                <div class="text-end">
                                    <div class="<?= $cls ?> fw-bold"><?= $sign . (int)$m['change_qty'] ?></div>
                                    <small class="text-muted"><?= format_datetime($m['created_at']) ?></small>
                                </div>
                            </div>
                        </li>
                    <?php endwhile; ?>
                    <?php if ($mvRes->num_rows === 0): ?>
                        <li class="list-group-item"><?= empty_state('ບໍ່ມີຂໍ້ມູນ', '', '📦') ?></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
