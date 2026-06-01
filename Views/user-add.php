<?php
require_once __DIR__ . '/../includes/layout.php';
require_admin();

$id = (int)($_GET['id'] ?? 0);
$u = ['id'=>0,'username'=>'','fullname'=>'','role'=>'staff','status'=>1];
if ($id > 0) {
    $stmt = $connect->prepare('SELECT id,username,fullname,role,status FROM users WHERE id=?');
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if ($r) $u = $r;
}
$pageTitle = $id ? 'ແກ້ໄຂຜູ້ໃຊ້' : 'ເພີ່ມຜູ້ໃຊ້ໃໝ່';
layout_head($pageTitle);
?>
<div class="row justify-content-center">
    <div class="col-lg-5 col-md-7 mx-auto">
        <?php flash_banner(); ?>
        <div class="card">
            <div class="card-header"><h5 class="mb-0"><?= e($pageTitle) ?></h5></div>
            <div class="card-body">
                <form method="post" action="../controller/users.php">
                    <input type="hidden" name="action" value="<?= $id ? 'edit' : 'add' ?>">
                    <input type="hidden" name="id" value="<?= (int)$u['id'] ?>">

                    <div class="mb-3">
                        <label class="form-label">ຊື່ຜູ້ໃຊ້ (login) *</label>
                        <input type="text" name="username" class="form-control" required value="<?= e($u['username']) ?>" pattern="[A-Za-z0-9_.-]{3,}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ຊື່ເຕັມ *</label>
                        <input type="text" name="fullname" class="form-control" required value="<?= e($u['fullname']) ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ລະຫັດຜ່ານ <?= $id ? '(ປ່ອຍວ່າງເພື່ອບໍ່ປ່ຽນ)' : '*' ?></label>
                        <input type="password" name="password" class="form-control" <?= $id ? '' : 'required' ?>>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">ບົດບາດ</label>
                            <select name="role" class="form-select">
                                <option value="staff" <?= $u['role']==='staff'?'selected':'' ?>>ພະນັກງານ (Staff)</option>
                                <option value="admin" <?= $u['role']==='admin'?'selected':'' ?>>ຜູ້ດູແລ (Admin)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ສະຖານະ</label>
                            <select name="status" class="form-select">
                                <option value="1" <?= (int)$u['status']===1?'selected':'' ?>>ໃຊ້ງານ</option>
                                <option value="0" <?= (int)$u['status']===0?'selected':'' ?>>ລະງັບ</option>
                            </select>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button class="btn btn-primary">ບັນທຶກ</button>
                        <a href="user-list.php" class="btn btn-link">ກັບຄືນ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php layout_foot(); ?>
