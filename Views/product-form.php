<?php
require_once __DIR__ . '/../includes/layout.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$p = ['id'=>0,'category_id'=>0,'name'=>'','price'=>0,'cost'=>0,'stock'=>0,'low_stock_threshold'=>5,'image'=>null];

if ($id > 0) {
    $stmt = $connect->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) $p = $row;
}
$pageTitle = $id ? 'ແກ້ໄຂສິນຄ້າ' : 'ເພີ່ມສິນຄ້າໃໝ່';
$cats = $connect->query("SELECT * FROM categories ORDER BY name");
layout_head($pageTitle);
?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <?php flash_banner(); ?>
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><?= e($pageTitle) ?></h5></div>
            <div class="card-body">
                <form method="post" action="../controller/products.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?= $id ? 'edit' : 'add' ?>">
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                    <input type="hidden" name="existing_image" value="<?= e($p['image']) ?>">

                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">ຊື່ສິນຄ້າ *</label>
                            <input type="text" name="name" class="form-control" required value="<?= e($p['name']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ໝວດໝູ່</label>
                            <select name="category_id" class="form-select">
                                <option value="">-- ບໍ່ມີ --</option>
                                <?php while ($c = $cats->fetch_assoc()): ?>
                                    <option value="<?= (int)$c['id'] ?>" <?= (int)$p['category_id'] === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">ລາຄາຂາຍ (ກີບ) *</label>
                            <input type="number" name="price" class="form-control" min="0" step="100" required value="<?= e($p['price']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ຕົ້ນທຶນ (ກີບ)</label>
                            <input type="number" name="cost" class="form-control" min="0" step="100" value="<?= e($p['cost']) ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ສະຕັອກເລີ່ມຕົ້ນ</label>
                            <input type="number" name="stock" class="form-control" min="0" <?= $id ? 'readonly' : '' ?> value="<?= e($p['stock']) ?>">
                            <?php if ($id): ?><small class="text-muted">ໃຊ້ໜ້າສິນຄ້າຄົງເຫຼືອເພື່ອປັບສະຕັອກ</small><?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">ແຈ້ງເຕືອນເມື່ອສະຕັອກຕ່ຳກວ່າ</label>
                            <input type="number" name="low_stock_threshold" class="form-control" min="0" value="<?= e($p['low_stock_threshold']) ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ຮູບສິນຄ້າ</label>
                            <input type="file" name="image" class="form-control" accept="image/png,image/jpeg,image/webp,image/gif">
                            <?php if ($p['image']): ?>
                                <div class="mt-2"><img src="../assets/uploads/products/<?= e($p['image']) ?>" style="height:80px;border-radius:8px"></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2">
                        <button class="btn btn-primary" type="submit">ບັນທຶກ</button>
                        <a href="products.php" class="btn btn-link">ກັບຄືນ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
