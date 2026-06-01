<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ລາຍການສິນຄ້າ';

$search = trim($_GET['q'] ?? '');
$catFilter = (int)($_GET['cat'] ?? 0);

$where = ["p.status = 1"];
$types = '';
$params = [];
if ($search !== '') {
    $where[] = 'p.name LIKE ?';
    $types .= 's';
    $params[] = '%' . $search . '%';
}
if ($catFilter > 0) {
    $where[] = 'p.category_id = ?';
    $types .= 'i';
    $params[] = $catFilter;
}
$sql = "SELECT p.*, c.name AS category_name FROM products p
        LEFT JOIN categories c ON c.id = p.category_id
        WHERE " . implode(' AND ', $where) . "
        ORDER BY p.id DESC";
$stmt = $connect->prepare($sql);
if ($params) $stmt->bind_param($types, ...$params);
$stmt->execute();
$rows = $stmt->get_result();

$cats = $connect->query("SELECT * FROM categories ORDER BY name");

layout_head($pageTitle);
?>
<div class="row">
    <div class="col-12"><?php flash_banner(); ?></div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="mb-0">ສິນຄ້າທັງໝົດ (<?= $rows->num_rows ?>)</h5>
                <?php if (is_admin()): ?>
                <a href="product-form.php" class="btn btn-primary">
                    + ເພີ່ມສິນຄ້າໃໝ່
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <form method="get" class="row g-2 mb-3">
                    <div class="col-md-5">
                        <div class="search-input-wrap">
                            <span class="search-icon">
                                <svg width="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                            </span>
                            <input type="search" name="q" class="form-control" placeholder="ຄົ້ນຫາຊື່ສິນຄ້າ..." value="<?= e($search) ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select name="cat" class="form-select">
                            <option value="0">— ທຸກໝວດໝູ່ —</option>
                            <?php while ($c = $cats->fetch_assoc()): ?>
                                <option value="<?= (int)$c['id'] ?>" <?= $catFilter === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-3 d-grid">
                        <button class="btn btn-soft-primary" type="submit">ຄົ້ນຫາ</button>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead>
                            <tr>
                                <th width="80">ຮູບ</th>
                                <th>ຊື່ສິນຄ້າ</th>
                                <th>ໝວດໝູ່</th>
                                <th class="text-end">ລາຄາ</th>
                                <th class="text-center">ສະຕັອກ</th>
                                <?php if (is_admin()): ?><th width="180">ການກະທຳ</th><?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if ($rows->num_rows === 0): ?>
                            <tr><td colspan="6"><?= empty_state('ບໍ່ພົບສິນຄ້າ', 'ລອງປ່ຽນຄຳຄົ້ນຫາ', '🔍') ?></td></tr>
                        <?php else: while ($r = $rows->fetch_assoc()):
                            $isLow = $r['stock'] <= $r['low_stock_threshold'];
                        ?>
                            <tr>
                                <td><?= product_avatar($r, 'sm') ?></td>
                                <td>
                                    <div class="fw-semibold"><?= e($r['name']) ?></div>
                                </td>
                                <td><span class="badge bg-soft-info text-info"><?= e($r['category_name'] ?? '-') ?></span></td>
                                <td class="text-end fw-semibold"><?= money($r['price']) ?></td>
                                <td class="text-center">
                                    <span class="<?= $isLow ? 'low-stock' : '' ?>">
                                        <?= (int)$r['stock'] ?>
                                    </span>
                                    <?php if ($isLow): ?>
                                        <span class="badge bg-danger ms-1">ໃກ້ໝົດ</span>
                                    <?php endif; ?>
                                </td>
                                <?php if (is_admin()): ?>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="product-form.php?id=<?= (int)$r['id'] ?>" class="btn btn-sm btn-soft-primary">ແກ້ໄຂ</a>
                                        <form method="post" action="../controller/products.php" class="d-inline"
                                              data-confirm="ສິນຄ້າ '<?= e($r['name']) ?>' ຈະຖືກລົບອອກຈາກລະບົບ. ດຳເນີນຕໍ່?"
                                              data-confirm-title="ລົບສິນຄ້າ"
                                              data-confirm-ok="ລົບ">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
                                            <button class="btn btn-sm btn-soft-danger">ລົບ</button>
                                        </form>
                                    </div>
                                </td>
                                <?php endif; ?>
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
