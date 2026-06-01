<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

try {
    if ($action === 'add') {
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] === 'admin' ? 'admin' : 'staff';
        $status = (int)($_POST['status'] ?? 1) === 1 ? 1 : 0;
        if ($username === '' || $fullname === '' || $password === '') throw new Exception('ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ');
        $check = $connect->prepare('SELECT id FROM users WHERE username = ?');
        $check->bind_param('s', $username);
        $check->execute();
        if ($check->get_result()->num_rows > 0) throw new Exception('ມີຊື່ຜູ້ໃຊ້ນີ້ແລ້ວ');
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $connect->prepare('INSERT INTO users (username,password_hash,fullname,role,status) VALUES (?,?,?,?,?)');
        $stmt->bind_param('ssssi', $username, $hash, $fullname, $role, $status);
        $stmt->execute();
        $_SESSION['success'] = 'ເພີ່ມຜູ້ໃຊ້ສຳເລັດ';
        header('Location: ../Views/user-list.php');
        exit();
    }

    if ($action === 'edit') {
        if ($id <= 0) throw new Exception('ບໍ່ພົບຜູ້ໃຊ້');
        $username = trim($_POST['username'] ?? '');
        $fullname = trim($_POST['fullname'] ?? '');
        $password = $_POST['password'] ?? '';
        $role = $_POST['role'] === 'admin' ? 'admin' : 'staff';
        $status = (int)($_POST['status'] ?? 1) === 1 ? 1 : 0;
        if ($username === '' || $fullname === '') throw new Exception('ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ');
        $check = $connect->prepare('SELECT id FROM users WHERE username = ? AND id <> ?');
        $check->bind_param('si', $username, $id);
        $check->execute();
        if ($check->get_result()->num_rows > 0) throw new Exception('ມີຊື່ຜູ້ໃຊ້ນີ້ແລ້ວ');

        if ($password !== '') {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $connect->prepare('UPDATE users SET username=?, fullname=?, role=?, status=?, password_hash=? WHERE id=?');
            $stmt->bind_param('sssisi', $username, $fullname, $role, $status, $hash, $id);
        } else {
            $stmt = $connect->prepare('UPDATE users SET username=?, fullname=?, role=?, status=? WHERE id=?');
            $stmt->bind_param('sssii', $username, $fullname, $role, $status, $id);
        }
        $stmt->execute();
        $_SESSION['success'] = 'ແກ້ໄຂຜູ້ໃຊ້ສຳເລັດ';
        header('Location: ../Views/user-list.php');
        exit();
    }

    if ($action === 'delete') {
        if ($id <= 0) throw new Exception('ບໍ່ພົບຜູ້ໃຊ້');
        if ($id === (int)$_SESSION['user']['id']) throw new Exception('ບໍ່ສາມາດລົບຕົນເອງ');
        $stmt = $connect->prepare('DELETE FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $_SESSION['success'] = 'ລົບຜູ້ໃຊ້ສຳເລັດ';
        header('Location: ../Views/user-list.php');
        exit();
    }
    throw new Exception('ບໍ່ຮູ້ຄຳສັ່ງ');
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../Views/user-list.php');
    exit();
}
