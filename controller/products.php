<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

function handle_image_upload($field, $existing = null) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return $existing;
    }
    if ($_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
        throw new Exception('ອັບໂຫຼດຮູບບໍ່ສຳເລັດ');
    }
    $allowed = ['image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp','image/gif'=>'gif'];
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($_FILES[$field]['tmp_name']);
    if (!isset($allowed[$mime])) throw new Exception('ຮູບແບບໄຟລ໌ບໍ່ຮອງຮັບ (jpg/png/webp/gif ເທົ່ານັ້ນ)');
    if ($_FILES[$field]['size'] > 5 * 1024 * 1024) throw new Exception('ຮູບໃຫຍ່ເກີນ 5MB');

    $dir = __DIR__ . '/../assets/uploads/products';
    if (!is_dir($dir)) mkdir($dir, 0775, true);
    $name = bin2hex(random_bytes(8)) . '.' . $allowed[$mime];
    if (!move_uploaded_file($_FILES[$field]['tmp_name'], $dir . '/' . $name)) {
        throw new Exception('ບໍ່ສາມາດບັນທຶກຮູບໄດ້');
    }
    if ($existing && file_exists($dir . '/' . $existing)) @unlink($dir . '/' . $existing);
    return $name;
}

try {
    if ($action === 'add') {
        $name = trim($_POST['name'] ?? '');
        $cat = (int)($_POST['category_id'] ?? 0) ?: null;
        $price = (float)($_POST['price'] ?? 0);
        $cost = (float)($_POST['cost'] ?? 0);
        $stock = (int)($_POST['stock'] ?? 0);
        $threshold = (int)($_POST['low_stock_threshold'] ?? 5);
        if ($name === '' || $price <= 0) throw new Exception('ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ');

        $img = handle_image_upload('image');

        $stmt = $connect->prepare('INSERT INTO products (category_id,name,price,cost,stock,low_stock_threshold,image) VALUES (?,?,?,?,?,?,?)');
        $stmt->bind_param('isddiis', $cat, $name, $price, $cost, $stock, $threshold, $img);
        $stmt->execute();
        $newId = $connect->insert_id;

        if ($stock > 0) {
            $uid = $_SESSION['user']['id'];
            $reason = 'initial';
            $note = 'ສະຕັອກເລີ່ມຕົ້ນ';
            $stmt = $connect->prepare('INSERT INTO stock_movements (product_id,change_qty,reason,note,user_id) VALUES (?,?,?,?,?)');
            $stmt->bind_param('iissi', $newId, $stock, $reason, $note, $uid);
            $stmt->execute();
        }
        $_SESSION['success'] = 'ເພີ່ມສິນຄ້າສຳເລັດ';
        header('Location: ../Views/products.php');
        exit();
    }

    if ($action === 'edit') {
        if ($id <= 0) throw new Exception('ບໍ່ພົບສິນຄ້າ');
        $name = trim($_POST['name'] ?? '');
        $cat = (int)($_POST['category_id'] ?? 0) ?: null;
        $price = (float)($_POST['price'] ?? 0);
        $cost = (float)($_POST['cost'] ?? 0);
        $threshold = (int)($_POST['low_stock_threshold'] ?? 5);
        $existing = $_POST['existing_image'] ?? null;
        if ($name === '' || $price <= 0) throw new Exception('ກະລຸນາປ້ອນຂໍ້ມູນໃຫ້ຄົບ');

        $img = handle_image_upload('image', $existing);

        $stmt = $connect->prepare('UPDATE products SET category_id=?, name=?, price=?, cost=?, low_stock_threshold=?, image=? WHERE id=?');
        $stmt->bind_param('isddisi', $cat, $name, $price, $cost, $threshold, $img, $id);
        $stmt->execute();
        $_SESSION['success'] = 'ແກ້ໄຂສິນຄ້າສຳເລັດ';
        header('Location: ../Views/products.php');
        exit();
    }

    if ($action === 'delete') {
        if ($id <= 0) throw new Exception('ບໍ່ພົບສິນຄ້າ');
        // soft delete to preserve sale history
        $stmt = $connect->prepare('UPDATE products SET status = 0 WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $_SESSION['success'] = 'ລົບສິນຄ້າສຳເລັດ';
        header('Location: ../Views/products.php');
        exit();
    }

    throw new Exception('ບໍ່ຮູ້ຄຳສັ່ງ');
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: ../Views/products.php');
    exit();
}
