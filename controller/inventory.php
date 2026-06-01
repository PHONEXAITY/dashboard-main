<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$pid = (int)($_POST['product_id'] ?? 0);
$qty = (int)($_POST['change_qty'] ?? 0);

if ($pid <= 0 || $qty === 0) {
    $_SESSION['error'] = 'ຂໍ້ມູນບໍ່ຄົບ';
    header('Location: ../Views/inventory.php');
    exit();
}

$connect->begin_transaction();
try {
    $stmt = $connect->prepare('SELECT stock FROM products WHERE id = ? FOR UPDATE');
    $stmt->bind_param('i', $pid);
    $stmt->execute();
    $r = $stmt->get_result()->fetch_assoc();
    if (!$r) throw new Exception('ບໍ່ພົບສິນຄ້າ');
    if ($r['stock'] + $qty < 0) throw new Exception('ສະຕັອກບໍ່ສາມາດຕິດລົບ');

    $stmt = $connect->prepare('UPDATE products SET stock = stock + ? WHERE id = ?');
    $stmt->bind_param('ii', $qty, $pid);
    $stmt->execute();

    $uid = $_SESSION['user']['id'];
    $reason = $qty > 0 ? 'restock' : 'adjust';
    $stmt = $connect->prepare('INSERT INTO stock_movements (product_id,change_qty,reason,user_id) VALUES (?,?,?,?)');
    $stmt->bind_param('iisi', $pid, $qty, $reason, $uid);
    $stmt->execute();

    $connect->commit();
    $_SESSION['success'] = 'ປັບສະຕັອກສຳເລັດ (' . ($qty > 0 ? '+' : '') . $qty . ')';
} catch (Exception $e) {
    $connect->rollback();
    $_SESSION['error'] = $e->getMessage();
}
header('Location: ../Views/inventory.php');
exit();
