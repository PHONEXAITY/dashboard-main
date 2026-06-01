<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../config.php';

function current_user() {
    return $_SESSION['user'] ?? null;
}

function is_logged_in() {
    return !empty($_SESSION['user']);
}

function is_admin() {
    return is_logged_in() && $_SESSION['user']['role'] === 'admin';
}

function require_login() {
    if (!is_logged_in()) {
        header('Location: ' . url('Views/index.php'));
        exit();
    }
}

function require_admin() {
    require_login();
    if (!is_admin()) {
        $_SESSION['error'] = 'ສະເພາະ Admin ເທົ່ານັ້ນທີ່ສາມາດເຂົ້າເຖິງໜ້ານີ້ໄດ້';
        header('Location: ' . url('Views/main.php'));
        exit();
    }
}

function base_url() {
    $script = $_SERVER['SCRIPT_NAME'] ?? '';
    $parts = explode('/', trim($script, '/'));
    array_pop($parts);
    while (!empty($parts) && in_array(end($parts), ['Views', 'controller', 'auth', 'app', 'extra', 'icons', 'maps', 'errors'])) {
        array_pop($parts);
    }
    return empty($parts) ? '' : '/' . implode('/', $parts);
}

function url($path) {
    return base_url() . '/' . ltrim($path, '/');
}

function asset($path) {
    return url('assets/' . ltrim($path, '/'));
}

function flash_get($key) {
    if (isset($_SESSION[$key])) {
        $v = $_SESSION[$key];
        unset($_SESSION[$key]);
        return $v;
    }
    return null;
}

function e($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function money($v) {
    return number_format((float)$v, 0) . ' ກີບ';
}

// Lao month abbreviations
function format_datetime($ts) {
    if (!$ts) return '-';
    $t = is_numeric($ts) ? (int)$ts : strtotime($ts);
    if (!$t) return e($ts);
    $months = ['','ມ.ກ','ກ.ພ','ມີ.ນ','ມ.ສ','ພ.ພ','ມິ.ຖ','ກ.ລ','ສ.ຫ','ກ.ຍ','ຕ.ລ','ພ.ຈ','ທ.ວ'];
    return date('j', $t) . ' ' . $months[(int)date('n', $t)] . ' ' . date('Y', $t) . ', ' . date('H:i', $t);
}
function format_date($ts) {
    if (!$ts) return '-';
    $t = is_numeric($ts) ? (int)$ts : strtotime($ts);
    if (!$t) return e($ts);
    $months = ['','ມ.ກ','ກ.ພ','ມີ.ນ','ມ.ສ','ພ.ພ','ມິ.ຖ','ກ.ລ','ສ.ຫ','ກ.ຍ','ຕ.ລ','ພ.ຈ','ທ.ວ'];
    return date('j', $t) . ' ' . $months[(int)date('n', $t)] . ' ' . date('Y', $t);
}

// Pick a deterministic gradient based on a seed (used for user/profile avatars)
function avatar_gradient($seed) {
    $palettes = [
        ['#5e72e4','#825ee4'],
        ['#11cdef','#1171ef'],
        ['#2dce89','#2dcecc'],
        ['#fb6340','#fbb140'],
        ['#f5365c','#f56036'],
        ['#8965e0','#c5a4e4'],
        ['#f3a4b5','#f56991'],
        ['#5e72e4','#11cdef'],
    ];
    $idx = abs(crc32((string)$seed)) % count($palettes);
    return $palettes[$idx];
}

// Map a category name → emoji icon + tint variant. Falls back to "other".
function category_visual($categoryName) {
    $n = mb_strtolower((string)$categoryName);
    // Lao + English keywords
    $map = [
        ['kw' => ['ກາເຟ','coffee','espresso','latte','ກາ​ເຟ'], 'icon' => '☕', 'variant' => 'coffee'],
        ['kw' => ['ຊາ','tea','matcha','ໄຂ່ມຸກ'],              'icon' => '🧋', 'variant' => 'tea'],
        ['kw' => ['ນ້ຳ','ນ້ຳໝາກ','juice','soda','smoothie'],   'icon' => '🥤', 'variant' => 'juice'],
        ['kw' => ['ເຂົ້າໜົມ','ເຄັກ','cake','bakery','bread','dessert','ໂຣຕີ','cookie'],
            'icon' => '🍰', 'variant' => 'cake'],
    ];
    foreach ($map as $m) {
        foreach ($m['kw'] as $kw) {
            if (mb_stripos($n, mb_strtolower($kw)) !== false) {
                return ['icon' => $m['icon'], 'variant' => $m['variant']];
            }
        }
    }
    return ['icon' => '🛍', 'variant' => 'other'];
}

// Render a product visual — uploaded image if exists, otherwise category-tinted icon
function product_avatar($product, $size = 'md') {
    $h = $size === 'lg' ? '130px' : ($size === 'sm' ? '48px' : '56px');
    if (!empty($product['image'])) {
        $url = '../assets/uploads/products/' . $product['image'];
        return '<img src="' . e($url) . '" alt="" class="product-thumb" style="width:' . $h . ';height:' . $h . '">';
    }
    $cv = category_visual($product['category_name'] ?? '');
    $font = $size === 'lg' ? '3rem' : ($size === 'sm' ? '1.4rem' : '1.7rem');
    return '<div class="product-thumb product-thumb-' . $cv['variant'] . ' d-flex align-items-center justify-content-center" '
        . 'style="width:' . $h . ';height:' . $h . ';font-size:' . $font . '">'
        . $cv['icon']
        . '</div>';
}

function empty_state($title, $sub = '', $icon = '📭') {
    return '<div class="empty-state text-center py-5">'
        . '<div class="empty-icon">' . $icon . '</div>'
        . '<div class="empty-title mt-2">' . e($title) . '</div>'
        . ($sub ? '<div class="empty-sub text-muted small">' . e($sub) . '</div>' : '')
        . '</div>';
}
