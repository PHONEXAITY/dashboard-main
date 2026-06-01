<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');

try {
    if ($action === 'add') {
        if ($name === '') throw new Exception('ກະລຸນາປ້ອນຊື່ໝວດໝູ່');
        $stmt = $connect->prepare('INSERT INTO categories (name) VALUES (?)');
        $stmt->bind_param('s', $name);
        $stmt->execute();
        $_SESSION['success'] = 'ເພີ່ມໝວດໝູ່ສຳເລັດ';
    } elseif ($action === 'edit') {
        if ($id <= 0 || $name === '') throw new Exception('ຂໍ້ມູນບໍ່ຄົບຖ້ວນ');
        $stmt = $connect->prepare('UPDATE categories SET name = ? WHERE id = ?');
        $stmt->bind_param('si', $name, $id);
        $stmt->execute();
        $_SESSION['success'] = 'ແກ້ໄຂໝວດໝູ່ສຳເລັດ';
    } elseif ($action === 'delete') {
        if ($id <= 0) throw new Exception('ບໍ່ພົບໝວດໝູ່');
        $stmt = $connect->prepare('DELETE FROM categories WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $_SESSION['success'] = 'ລົບໝວດໝູ່ສຳເລັດ';
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: ../Views/categories.php');
exit();
