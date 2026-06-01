<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ໂປຣໄຟລ໌ຂອງຂ້ອຍ';

$u = current_user();
$uid = (int)$u['id'];

// fetch fresh user info + activity stats
$stmt = $connect->prepare('SELECT username, fullname, role, status, created_at FROM users WHERE id = ?');
$stmt->bind_param('i', $uid);
$stmt->execute();
$me = $stmt->get_result()->fetch_assoc();

$stmt = $connect->prepare("SELECT COUNT(*) cnt, COALESCE(SUM(total),0) total FROM sales WHERE user_id = ?");
$stmt->bind_param('i', $uid);
$stmt->execute();
$myStats = $stmt->get_result()->fetch_assoc();

$stmt = $connect->prepare("SELECT COUNT(*) cnt, COALESCE(SUM(total),0) total FROM sales WHERE user_id = ? AND DATE(created_at) = CURDATE()");
$stmt->bind_param('i', $uid);
$stmt->execute();
$todayStats = $stmt->get_result()->fetch_assoc();

$stmt = $connect->prepare("SELECT id, total, created_at FROM sales WHERE user_id = ? ORDER BY id DESC LIMIT 8");
$stmt->bind_param('i', $uid);
$stmt->execute();
$recentSales = $stmt->get_result();

[$c1, $c2] = avatar_gradient($me['fullname']);
$initial = mb_strtoupper(mb_substr($me['fullname'], 0, 1, 'UTF-8'), 'UTF-8');

layout_head($pageTitle);
?>
<?php flash_banner(); ?>
<div class="row g-3">
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                     style="width:120px;height:120px;border-radius:50%;font-size:3rem;background:linear-gradient(135deg,<?= $c1 ?>,<?= $c2 ?>)">
                    <?= e($initial) ?>
                </div>
                <h4 class="mb-1"><?= e($me['fullname']) ?></h4>
                <div class="text-muted small">@<?= e($me['username']) ?></div>
                <div class="mt-2">
                    <?php if ($me['role'] === 'admin'): ?>
                        <span class="badge bg-soft-primary text-primary">ຜູ້ດູແລລະບົບ (Admin)</span>
                    <?php else: ?>
                        <span class="badge bg-soft-info text-info">ພະນັກງານ (Staff)</span>
                    <?php endif; ?>
                </div>
                <hr>
                <div class="text-start small text-muted">
                    <div class="d-flex justify-content-between py-1">
                        <span>ສະຖານະ</span>
                        <span class="text-success">● ໃຊ້ງານ</span>
                    </div>
                    <div class="d-flex justify-content-between py-1">
                        <span>ເຂົ້າຮ່ວມເມື່ອ</span>
                        <span class="text-dark"><?= format_date($me['created_at']) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0">ປ່ຽນລະຫັດຜ່ານ</h5></div>
            <div class="card-body">
                <form method="post" action="../controller/profile.php">
                    <input type="hidden" name="action" value="change_password">
                    <div class="mb-3">
                        <label class="form-label">ລະຫັດປັດຈຸບັນ</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ລະຫັດໃໝ່</label>
                        <input type="password" name="new_password" class="form-control" minlength="4" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ຢືນຢັນລະຫັດໃໝ່</label>
                        <input type="password" name="confirm_password" class="form-control" minlength="4" required>
                    </div>
                    <button class="btn btn-primary w-100">ປ່ຽນລະຫັດຜ່ານ</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card stat-card primary">
                    <div class="card-body">
                        <div class="stat-label">ຍອດຂາຍຂອງຂ້ອຍວັນນີ້</div>
                        <div class="stat-value"><?= number_format($todayStats['total']) ?> <span class="fs-6 fw-normal text-muted">ກີບ</span></div>
                        <div class="stat-meta"><?= (int)$todayStats['cnt'] ?> ບິນ</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card success">
                    <div class="card-body">
                        <div class="stat-label">ຍອດຂາຍສະສົມ</div>
                        <div class="stat-value"><?= number_format($myStats['total']) ?> <span class="fs-6 fw-normal text-muted">ກີບ</span></div>
                        <div class="stat-meta">ທັງໝົດ <?= (int)$myStats['cnt'] ?> ບິນ</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0">ບິນຂາຍຫຼ້າສຸດຂອງຂ້ອຍ</h5></div>
            <div class="card-body p-0">
                <?php if ($recentSales->num_rows === 0): ?>
                    <?= empty_state('ຍັງບໍ່ມີການຂາຍ', 'ບິນຂາຍຈະປະກົດທີ່ນີ້', '🧾') ?>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>ເລກບິນ</th>
                                <th>ວັນທີ</th>
                                <th class="text-end">ຍອດ</th>
                                <th width="100"></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($s = $recentSales->fetch_assoc()): ?>
                            <tr>
                                <td>#<?= (int)$s['id'] ?></td>
                                <td><?= format_datetime($s['created_at']) ?></td>
                                <td class="text-end fw-semibold"><?= money($s['total']) ?></td>
                                <td><a href="sale-receipt.php?id=<?= (int)$s['id'] ?>" class="btn btn-sm btn-soft-primary">ໃບເສັດ</a></td>
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
