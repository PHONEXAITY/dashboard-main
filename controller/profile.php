<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();

$action = $_POST['action'] ?? '';
$uid = (int)$_SESSION['user']['id'];

try {
    if ($action === 'change_password') {
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['confirm_password'] ?? '';
        if ($current === '' || $new === '' || $confirm === '') throw new Exception('ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ');
        if ($new !== $confirm) throw new Exception('ລະຫັດໃໝ່ ແລະ ການຢືນຢັນບໍ່ຕົງກັນ');
        if (strlen($new) < 4) throw new Exception('ລະຫັດໃໝ່ຕ້ອງມີຢ່າງໜ້ອຍ 4 ຕົວ');

        $stmt = $connect->prepare('SELECT password_hash FROM users WHERE id = ?');
        $stmt->bind_param('i', $uid);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if (!$row || !password_verify($current, $row['password_hash'])) throw new Exception('ລະຫັດປັດຈຸບັນບໍ່ຖືກຕ້ອງ');

        $hash = password_hash($new, PASSWORD_DEFAULT);
        $stmt = $connect->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
        $stmt->bind_param('si', $hash, $uid);
        $stmt->execute();

        $_SESSION['success'] = 'ປ່ຽນລະຫັດຜ່ານສຳເລັດ';
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
header('Location: ../Views/user-profile.php');
exit();
