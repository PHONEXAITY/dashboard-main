<?php
require_once __DIR__ . '/../includes/auth.php';
global $connect;
$current = basename($_SERVER['SCRIPT_NAME']);
$user = current_user();
$role = $user['role'] ?? 'staff';

function nav_active($files, $current) {
    return in_array($current, (array)$files) ? 'active' : '';
}

// low stock count for badge
$lowStockCount = 0;
$r = $connect->query("SELECT COUNT(*) c FROM products WHERE status=1 AND stock <= low_stock_threshold");
if ($r) { $lowStockCount = (int)$r->fetch_assoc()['c']; }
?>
<aside class="sidebar sidebar-default navs-shape" style="font-family: Noto Sans Lao;">
    <div class="sidebar-header d-flex align-items-center justify-content-start">
        <a href="main.php" class="navbar-brand d-flex justify-content-center align-items-center">
            <img src="../assets/logo.png" class="sidebar-color-logo" width="95">
            <h4 class="logo-title m-0">SMS</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar" style="font-family: Noto Sans Lao;">
        <div class="collapse navbar-collapse" id="sidebar-parent">
            <ul class="navbar-nav iq-main-menu py-4">
                <li class="nav-item">
                    <a class="nav-link <?= nav_active('main.php', $current) ?>" href="main.php">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
                            </svg>
                        </i>
                        <span class="item-name">ໜ້າຫຼັກ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= nav_active('pos.php', $current) ?>" href="pos.php">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 4a2 2 0 00-2 2v3h14V6a2 2 0 00-2-2H7z" fill="currentColor" opacity="0.4"/>
                                <path d="M5 11v8a2 2 0 002 2h10a2 2 0 002-2v-8H5zm3 2h2v2H8v-2zm4 0h2v2h-2v-2zm4 0h2v2h-2v-2zm-8 4h2v2H8v-2zm4 0h4v2h-4v-2z" fill="currentColor"/>
                            </svg>
                        </i>
                        <span class="item-name">ໜ້າຂາຍ (POS)</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= nav_active(['products.php','product-form.php'], $current) ?>" data-bs-toggle="collapse" href="#sidebar-products" role="button" aria-expanded="<?= in_array($current, ['products.php','product-form.php','categories.php']) ? 'true' : 'false' ?>">
                        <i class="icon"><img src="../assets/img/file.png" alt="" width="20"></i>
                        <span class="item-name">ຈັດການສິນຄ້າ</span>
                        <i class="right-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse <?= in_array($current, ['products.php','product-form.php','categories.php']) ? 'show' : '' ?>" id="sidebar-products" data-bs-parent="#sidebar-parent">
                        <li class="nav-item">
                            <a class="nav-link <?= nav_active(['products.php','product-form.php'], $current) ?>" href="products.php">
                                <i class="icon"><svg width="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"></circle></svg></i>
                                <i class="sidenav-mini-icon"> P </i>
                                <span class="item-name">ລາຍການສິນຄ້າ</span>
                            </a>
                        </li>
                        <?php if ($role === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= nav_active('categories.php', $current) ?>" href="categories.php">
                                <i class="icon"><svg width="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"></circle></svg></i>
                                <i class="sidenav-mini-icon"> C </i>
                                <span class="item-name">ໝວດໝູ່ສິນຄ້າ</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= nav_active('inventory.php', $current) ?>" href="inventory.php">
                        <i class="icon"><img src="../assets/img/inventory.png" alt="" width="20"></i>
                        <span class="item-name">ສິນຄ້າຄົງເຫຼືອ</span>
                        <?php if ($lowStockCount > 0): ?>
                            <span class="badge bg-danger rounded-pill ms-auto"><?= $lowStockCount ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= nav_active('sales-list.php', $current) ?>" href="sales-list.php">
                        <i class="icon"><img src="../assets/img/delivery.png" alt="" width="20"></i>
                        <span class="item-name">ປະຫວັດການຂາຍ</span>
                    </a>
                </li>

                <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link <?= nav_active('reports.php', $current) ?>" href="reports.php">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 13h4v8H3v-8zm7-9h4v17h-4V4zm7 5h4v12h-4V9z" fill="currentColor"/>
                            </svg>
                        </i>
                        <span class="item-name">ລາຍງານການຂາຍ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= nav_active(['user-list.php','user-add.php'], $current) ?>" data-bs-toggle="collapse" href="#sidebar-user" role="button">
                        <i class="icon"><img src="../assets/img/worker.png" alt="" width="20"></i>
                        <span class="item-name">ຈັດການຜູ້ໃຊ້</span>
                        <i class="right-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </i>
                    </a>
                    <ul class="sub-nav collapse <?= in_array($current, ['user-list.php','user-add.php']) ? 'show' : '' ?>" id="sidebar-user" data-bs-parent="#sidebar-parent">
                        <li class="nav-item">
                            <a class="nav-link <?= nav_active('user-list.php', $current) ?>" href="user-list.php">
                                <i class="icon"><svg width="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"></circle></svg></i>
                                <i class="sidenav-mini-icon"> U </i>
                                <span class="item-name">ຜູ້ໃຊ້ທັງໝົດ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= nav_active('user-add.php', $current) ?>" href="user-add.php">
                                <i class="icon"><svg width="10" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="8"></circle></svg></i>
                                <i class="sidenav-mini-icon"> A </i>
                                <span class="item-name">ເພີ່ມຜູ້ໃຊ້</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>

                <li><hr class="hr-horizontal"></li>
                <li class="nav-item">
                    <a class="nav-link" href="../controller/logout.php">
                        <i class="icon">
                            <svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </i>
                        <span class="item-name">ອອກຈາກລະບົບ</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
