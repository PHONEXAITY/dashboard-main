<?php
require_once __DIR__ . '/../includes/layout.php';
require_admin();
$pageTitle = 'ຜູ້ໃຊ້ລະບົບ';

$rows = $connect->query("SELECT id, username, fullname, role, status, created_at FROM users ORDER BY id DESC");
layout_head($pageTitle);
?>
<div class="row">
    <div class="col-12"><?php flash_banner(); ?></div>
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="mb-0">ຜູ້ໃຊ້ທັງໝົດ (<?= $rows->num_rows ?>)</h5>
                <a href="user-add.php" class="btn btn-primary">+ ເພີ່ມຜູ້ໃຊ້</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle">
                        <thead><tr>
                            <th>#</th><th>ຊື່ຜູ້ໃຊ້</th><th>ຊື່ເຕັມ</th><th>ບົດບາດ</th><th>ສະຖານະ</th><th>ສ້າງເມື່ອ</th><th width="140">ການກະທຳ</th>
                        </tr></thead>
                        <tbody>
                            <?php while ($u = $rows->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$u['id'] ?></td>
                                <td><code><?= e($u['username']) ?></code></td>
                                <td><?= e($u['fullname']) ?></td>
                                <td>
                                    <?php if ($u['role'] === 'admin'): ?>
                                        <span class="badge bg-soft-primary text-primary">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-soft-info text-info">Staff</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ((int)$u['status'] === 1): ?>
                                        <span class="badge bg-soft-success text-success">ໃຊ້ງານ</span>
                                    <?php else: ?>
                                        <span class="badge bg-soft-danger text-danger">ລະງັບ</span>
                                    <?php endif; ?>
                                </td>
                                <td class="small text-muted"><?= e($u['created_at']) ?></td>
                                <td>
                                    <a href="user-add.php?id=<?= (int)$u['id'] ?>" class="btn btn-sm btn-soft-primary">ແກ້ໄຂ</a>
                                    <?php if ((int)$u['id'] !== (int)current_user()['id']): ?>
                                    <form method="post" action="../controller/users.php" class="d-inline"
                                          data-confirm="ຜູ້ໃຊ້ '<?= e($u['username']) ?>' ຈະຖືກລົບອອກຈາກລະບົບ. ດຳເນີນຕໍ່?"
                                          data-confirm-title="ລົບຜູ້ໃຊ້"
                                          data-confirm-ok="ລົບ">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">
                                        <button class="btn btn-sm btn-soft-danger">ລົບ</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
