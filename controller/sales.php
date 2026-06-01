<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'checkout') {
    $items = json_decode($_POST['items'] ?? '[]', true);
    $paid = (float)($_POST['paid'] ?? 0);
    $userId = $_SESSION['user']['id'];

    if (!is_array($items) || empty($items)) {
        $_SESSION['error'] = 'ກະຕ່າວ່າງ';
        header('Location: ../Views/pos.php');
        exit();
    }

    $connect->begin_transaction();
    try {
        // re-fetch products to verify price & stock server-side
        $ids = array_map(fn($i) => (int)$i['id'], $items);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $types = str_repeat('i', count($ids));
        $stmt = $connect->prepare("SELECT id, name, price, stock FROM products WHERE id IN ($placeholders) AND status=1 FOR UPDATE");
        $stmt->bind_param($types, ...$ids);
        $stmt->execute();
        $res = $stmt->get_result();
        $dbItems = [];
        while ($r = $res->fetch_assoc()) $dbItems[(int)$r['id']] = $r;

        $total = 0;
        $normalized = [];
        foreach ($items as $it) {
            $id = (int)$it['id'];
            $qty = (int)$it['qty'];
            if ($qty <= 0) throw new Exception('ຈຳນວນບໍ່ຖືກຕ້ອງ');
            if (!isset($dbItems[$id])) throw new Exception('ບໍ່ພົບສິນຄ້າ');
            $p = $dbItems[$id];
            if ($qty > (int)$p['stock']) throw new Exception("ສະຕັອກ '{$p['name']}' ບໍ່ພຽງພໍ");
            $sub = (float)$p['price'] * $qty;
            $total += $sub;
            $normalized[] = ['id'=>$id,'name'=>$p['name'],'price'=>(float)$p['price'],'qty'=>$qty,'subtotal'=>$sub];
        }

        $change = max(0, $paid - $total);

        $stmt = $connect->prepare('INSERT INTO sales (user_id,total,paid,change_amount) VALUES (?,?,?,?)');
        $stmt->bind_param('iddd', $userId, $total, $paid, $change);
        $stmt->execute();
        $saleId = $connect->insert_id;

        $insItem = $connect->prepare('INSERT INTO sale_items (sale_id,product_id,product_name,price,qty,subtotal) VALUES (?,?,?,?,?,?)');
        $decStock = $connect->prepare('UPDATE products SET stock = stock - ? WHERE id = ?');
        $logMv = $connect->prepare('INSERT INTO stock_movements (product_id,change_qty,reason,ref_id,user_id) VALUES (?,?,?,?,?)');
        $reason = 'sale';
        foreach ($normalized as $n) {
            $insItem->bind_param('iisdid', $saleId, $n['id'], $n['name'], $n['price'], $n['qty'], $n['subtotal']);
            $insItem->execute();
            $decStock->bind_param('ii', $n['qty'], $n['id']);
            $decStock->execute();
            $negQty = -$n['qty'];
            $logMv->bind_param('iisii', $n['id'], $negQty, $reason, $saleId, $userId);
            $logMv->execute();
        }

        $connect->commit();
        $_SESSION['success'] = 'ບັນທຶກການຂາຍ #' . $saleId . ' ສຳເລັດ (ລວມ ' . number_format($total) . ' ກີບ)';
        header('Location: ../Views/sale-receipt.php?id=' . $saleId);
        exit();
    } catch (Throwable $e) {
        $connect->rollback();
        $_SESSION['error'] = 'ຜິດພາດ: ' . $e->getMessage();
        header('Location: ../Views/pos.php');
        exit();
    }
}

header('Location: ../Views/pos.php');
exit();
