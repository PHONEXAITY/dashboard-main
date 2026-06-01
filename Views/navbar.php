<?php
require_once __DIR__ . '/../includes/auth.php';
global $connect;
$u = current_user();
$pageTitle = $pageTitle ?? 'ໜ້າຫຼັກ';
?>
<nav class="nav navbar navbar-expand-lg navbar-light iq-navbar" style="font-family: Noto Sans Lao;">
    <div class="container-fluid navbar-inner">
        <a href="main.php" class="navbar-brand">
            <h4 class="logo-title">ຮ້ານຄາເຟ່</h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <svg width="20px" height="20px" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z" />
                </svg>
            </i>
        </div>
        <h4 class="title text-primary"><?= e($pageTitle) ?></h4>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon">
                <span class="navbar-toggler-bar bar1 mt-2"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto navbar-list mb-2 mb-lg-0 align-items-center">
                <li class="nav-item dropdown">
                    <a class="nav-link py-0 d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <img src="../assets/images/avatars/01.png" alt="User-Profile" class="img-fluid avatar avatar-50 avatar-rounded">
                        <div class="caption ms-3 d-none d-md-block">
                            <h6 class="mb-0 caption-title"><?= e($u['fullname'] ?? 'User') ?></h6>
                            <p class="mb-0 caption-sub-title small text-muted">
                                <?= $u['role'] === 'admin' ? 'ຜູ້ດູແລ' : 'ພະນັກງານ' ?>
                            </p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="user-profile.php">ໜ້າໂປຣໄຟລ໌</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="../controller/logout.php">ອອກຈາກລະບົບ</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
