<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ໃບເສັດ';
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) { header('Location: pos.php'); exit(); }

$stmt = $connect->prepare("SELECT s.*, u.fullname AS cashier FROM sales s LEFT JOIN users u ON u.id = s.user_id WHERE s.id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$sale = $stmt->get_result()->fetch_assoc();
if (!$sale) { header('Location: pos.php'); exit(); }

$stmt = $connect->prepare("SELECT * FROM sale_items WHERE sale_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$items = $stmt->get_result();

layout_head($pageTitle);
?>
<div class="row justify-content-center">
    <div class="col-md-7">
        <?php flash_banner(); ?>
        <div class="card">
            <div class="card-body" id="receipt">
                <div class="text-center mb-3">
                    <img src="../assets/logo.png" width="60">
                    <h3 class="mt-2 mb-0">SMS</h3>
                    <small class="text-muted">ໃບເສັດຮັບເງິນ</small>
                </div>
                <hr>
                <div class="d-flex justify-content-between small">
                    <div>
                        <div>ເລກທີ: <strong>#<?= (int)$sale['id'] ?></strong></div>
                        <div>ວັນທີ: <?= e($sale['created_at']) ?></div>
                    </div>
                    <div class="text-end">
                        <div>ພະນັກງານ: <?= e($sale['cashier'] ?? '-') ?></div>
                    </div>
                </div>
                <table class="table table-sm mt-3">
                    <thead>
                        <tr><th>ສິນຄ້າ</th><th class="text-center">x</th><th class="text-end">ລາຄາ</th><th class="text-end">ລວມ</th></tr>
                    </thead>
                    <tbody>
                        <?php while ($it = $items->fetch_assoc()): ?>
                            <tr>
                                <td><?= e($it['product_name']) ?></td>
                                <td class="text-center"><?= (int)$it['qty'] ?></td>
                                <td class="text-end"><?= number_format($it['price']) ?></td>
                                <td class="text-end"><?= number_format($it['subtotal']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
                <hr>
                <div class="d-flex justify-content-between"><span>ລວມທັງໝົດ:</span><strong><?= money($sale['total']) ?></strong></div>
                <div class="d-flex justify-content-between"><span>ຮັບເງິນ:</span><span><?= money($sale['paid']) ?></span></div>
                <div class="d-flex justify-content-between"><span>ເງິນທອນ:</span><span><?= money($sale['change_amount']) ?></span></div>
                <div class="text-center mt-3 text-muted small">ຂອບໃຈທີ່ໃຊ້ບໍລິການ</div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <a href="pos.php" class="btn btn-link">ກັບໄປໜ້າຂາຍ</a>
                <button class="btn btn-primary" onclick="window.print()">ພິມໃບເສັດ</button>
            </div>
        </div>
    </div>
</div>
<style>
@media print {
    body * { visibility: hidden; }
    #receipt, #receipt * { visibility: visible; }
    #receipt { position: absolute; left: 0; top: 0; width: 100%; }
}
</style>
<?php layout_foot(); ?>
