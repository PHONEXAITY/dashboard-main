<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../Views/index.php');
    exit();
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['login_error'] = 'ກະລຸນາປ້ອນຊື່ຜູ້ໃຊ້ ແລະ ລະຫັດຜ່ານ';
    header('Location: ../Views/index.php');
    exit();
}

$stmt = $connect->prepare('SELECT id, username, password_hash, fullname, role, status FROM users WHERE username = ? LIMIT 1');
$stmt->bind_param('s', $username);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

if (!$user || !password_verify($password, $user['password_hash'])) {
    $_SESSION['login_error'] = 'ຊື່ຜູ້ໃຊ້ ຫຼື ລະຫັດຜ່ານບໍ່ຖືກຕ້ອງ';
    header('Location: ../Views/index.php');
    exit();
}

if ((int)$user['status'] !== 1) {
    $_SESSION['login_error'] = 'ບັນຊີນີ້ຖືກລະງັບ';
    header('Location: ../Views/index.php');
    exit();
}

$_SESSION['user'] = [
    'id' => (int)$user['id'],
    'username' => $user['username'],
    'fullname' => $user['fullname'],
    'role' => $user['role'],
];

header('Location: ../Views/main.php');
exit();
