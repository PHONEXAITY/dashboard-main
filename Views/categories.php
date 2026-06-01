<?php
require_once __DIR__ . '/../includes/layout.php';
require_admin();
$pageTitle = 'ໝວດໝູ່ສິນຄ້າ';

$editing = null;
if (isset($_GET['edit'])) {
    $stmt = $connect->prepare('SELECT * FROM categories WHERE id = ?');
    $id = (int)$_GET['edit'];
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $editing = $stmt->get_result()->fetch_assoc();
}

$rows = $connect->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id=c.id) AS product_count FROM categories c ORDER BY c.id DESC");

layout_head($pageTitle);
?>
<div class="row">
    <div class="col-12"><?php flash_banner(); ?></div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= $editing ? 'ແກ້ໄຂໝວດໝູ່' : 'ເພີ່ມໝວດໝູ່ໃໝ່' ?></h5>
            </div>
            <div class="card-body">
                <form method="post" action="../controller/categories.php">
                    <input type="hidden" name="action" value="<?= $editing ? 'edit' : 'add' ?>">
                    <?php if ($editing): ?>
                        <input type="hidden" name="id" value="<?= (int)$editing['id'] ?>">
                    <?php endif; ?>
                    <div class="mb-3">
                        <label class="form-label">ຊື່ໝວດໝູ່</label>
                        <input type="text" name="name" class="form-control" required value="<?= e($editing['name'] ?? '') ?>">
                    </div>
                    <button class="btn btn-primary w-100" type="submit">
                        <?= $editing ? 'ບັນທຶກການແກ້ໄຂ' : 'ບັນທຶກ' ?>
                    </button>
                    <?php if ($editing): ?>
                        <a href="categories.php" class="btn btn-link w-100 mt-2">ຍົກເລີກ</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">ໝວດໝູ່ທັງໝົດ</h5>
                <span class="badge bg-primary"><?= $rows->num_rows ?> ໝວດ</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>ຊື່ໝວດໝູ່</th>
                                <th>ຈຳນວນສິນຄ້າ</th>
                                <th width="160">ການກະທຳ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($rows->num_rows === 0): ?>
                                <tr><td colspan="4" class="text-center text-muted py-4">ຍັງບໍ່ມີໝວດໝູ່</td></tr>
                            <?php else: while ($r = $rows->fetch_assoc()): ?>
                                <tr>
                                    <td><?= (int)$r['id'] ?></td>
                                    <td><?= e($r['name']) ?></td>
                                    <td><span class="badge bg-soft-primary text-primary"><?= (int)$r['product_count'] ?></span></td>
                                    <td>
                                        <a href="?edit=<?= (int)$r['id'] ?>" class="btn btn-sm btn-soft-primary">ແກ້ໄຂ</a>
                                        <form method="post" action="../controller/categories.php" class="d-inline"
                                              data-confirm="ໝວດໝູ່ '<?= e($r['name']) ?>' ຈະຖືກລົບ. ສິນຄ້າທີ່ຢູ່ໃນໝວດນີ້ຈະຖືກຍ້າຍໄປ ບໍ່ມີໝວດ. ດຳເນີນຕໍ່?"
                                              data-confirm-title="ລົບໝວດໝູ່"
                                              data-confirm-ok="ລົບ">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                            <button class="btn btn-sm btn-soft-danger" type="submit">ລົບ</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endwhile; endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
