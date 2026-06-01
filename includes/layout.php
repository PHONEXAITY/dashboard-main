<?php
require_once __DIR__ . '/auth.php';

function layout_head($title = 'SMS') {
    ?>
<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= e($title) ?> - SMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Lao:wght@100..900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/images/favicon.ico" />
    <link rel="stylesheet" href="../assets/css/libs.min.css">
    <link rel="stylesheet" href="../assets/css/tecdig.css?v=1.0.0">
    <style>
        :root {
            /* Brand */
            --brand: #5e72e4;
            --brand-dark: #4757c4;
            --brand-soft: #eef0fb;
            /* Semantic */
            --success: #2dce89;
            --success-soft: #e9faf2;
            --warning: #fb9237;
            --warning-soft: #fff3e6;
            --danger: #f5365c;
            --danger-soft: #ffe9ee;
            --info: #11cdef;
            --info-soft: #e3f8fb;
            /* Neutrals */
            --surface: #f5f6fa;
            --ink: #1e293b;
            --muted: #94a3b8;
            --border: #e3e6ee;

            /* Category tints (used for product cards) */
            --cat-coffee-bg: #f5ede0; --cat-coffee-ic: #8b5e34;
            --cat-tea-bg:    #e8f1ea; --cat-tea-ic:    #4a7c59;
            --cat-juice-bg:  #fff2e3; --cat-juice-ic:  #ea7c1f;
            --cat-cake-bg:   #fde8ef; --cat-cake-ic:   #c43d6a;
            --cat-other-bg:  #eef0fb; --cat-other-ic:  #5e72e4;
        }
        body { background: var(--surface); font-family: 'Noto Sans Lao', sans-serif !important; }
        body, .card, .form-control, .form-select, .btn, .table, .nav-link, h1, h2, h3, h4, h5, h6, p, span, div, a, li {
            font-family: 'Noto Sans Lao', sans-serif !important;
        }

        /* navbar (sticky, clean) */
        .main-content .iq-navbar {
            position: sticky; top: 0; z-index: 1000;
            background: #fff;
            box-shadow: 0 2px 12px rgba(15, 23, 42, .04);
            border-bottom: 1px solid #eef0f4;
            margin-bottom: 0;
        }
        .main-content .iq-navbar .navbar-inner { min-height: 64px; padding: 0 1.25rem; }
        .main-content .iq-navbar h4.title { display: none; }
        .main-content .iq-navbar .navbar-brand h4.logo-title { display: none; }
        @media (max-width: 575.98px) {
            .main-content .iq-navbar .navbar-inner { min-height: 56px; padding: 0 .85rem; }
            .main-content .iq-navbar .caption-title { font-size: .9rem; }
            .main-content .iq-navbar .avatar-50 { width: 38px !important; height: 38px !important; }
        }

        /* page content — sits below sticky navbar with proper spacing */
        .page-content {
            padding: 1.5rem 1.75rem 2.5rem;
            min-height: calc(100vh - 64px);
        }
        @media (max-width: 991.98px) { .page-content { padding: 1.25rem 1.25rem 2rem; } }
        @media (max-width: 575.98px) { .page-content { padding: 1rem .85rem 1.5rem; } }

        /* fix sidebar/content offset so content never slides under fixed sidebar */
        @media (min-width: 992px) {
            .sidebar + .main-content { margin-left: 16.2rem !important; }
        }
        @media (max-width: 991.98px) {
            .sidebar + .main-content { margin-left: 0 !important; }
            aside.sidebar {
                transform: translateX(-100%);
                transition: transform .28s cubic-bezier(.16,1,.3,1);
                z-index: 1050;
                box-shadow: 0 0 30px rgba(15, 23, 42, .15);
            }
            aside.sidebar.sidebar-open { transform: translateX(0); }
            .sidebar-backdrop {
                position: fixed; inset: 0;
                background: rgba(15, 23, 42, .4);
                z-index: 1040;
                opacity: 0; pointer-events: none;
                transition: opacity .25s ease;
            }
            .sidebar-backdrop.show { opacity: 1; pointer-events: auto; }
            body.sidebar-open-state { overflow: hidden; }
        }

        /* page title row */
        .page-title-row {
            margin-bottom: 1.5rem;
            padding-top: .25rem;
        }
        .page-title-row h2 {
            font-weight: 700;
            color: var(--ink);
            margin: 0;
            font-size: 1.5rem;
            line-height: 1.3;
        }
        @media (max-width: 575.98px) {
            .page-title-row h2 { font-size: 1.25rem; }
            .page-title-row .breadcrumb-trail { font-size: .78rem; }
            .page-title-row { margin-bottom: 1rem; }
        }
        .page-title-row .breadcrumb-trail {
            color: var(--muted);
            font-size: .85rem;
            margin-top: .25rem;
        }

        /* cards */
        .card {
            border: 0;
            border-radius: 14px;
            box-shadow: 0 1px 3px rgba(15, 23, 42, .05), 0 1px 2px rgba(15, 23, 42, .03);
            margin-bottom: 1.25rem;
        }
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid #f0f1f5;
            padding: 1rem 1.25rem;
            border-radius: 14px 14px 0 0 !important;
        }
        .card-header h5 { font-weight: 600; font-size: 1rem; color: var(--ink); }
        .card-body { padding: 1.25rem; }
        @media (max-width: 575.98px) {
            .card-header { padding: .85rem 1rem; }
            .card-body { padding: 1rem; }
        }

        /* stat cards */
        .stat-card {
            background: linear-gradient(135deg, #fff 0%, #fafbff 100%);
            border-left: 4px solid var(--brand);
            transition: transform .15s, box-shadow .15s;
            height: 100%;
        }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(94, 114, 228, .1); }
        .stat-card .icon-box {
            width: 52px; height: 52px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        @media (max-width: 575.98px) {
            .stat-card .icon-box { width: 44px; height: 44px; }
            .stat-card .stat-value { font-size: 1.4rem; }
            .stat-card .stat-label { font-size: .78rem; }
            .stat-card .card-body { padding: .9rem; }
        }
        /* chart canvas wrappers shrink on mobile */
        @media (max-width: 575.98px) {
            canvas { max-height: 240px; }
        }
        .stat-card .stat-value {
            font-size: 1.75rem; line-height: 1.15; font-weight: 700; color: var(--ink);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .stat-card .stat-label {
            font-size: .82rem; color: var(--muted); margin-bottom: .25rem;
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .stat-card .stat-meta { font-size: .78rem; color: var(--muted); margin-top: .15rem; }
        .stat-card .ms-3 { min-width: 0; flex: 1; }
        .stat-card.success { border-left-color: #2dce89; }
        .stat-card.success .icon-box { background: #e9faf2; color: #2dce89; }
        .stat-card.info { border-left-color: #11cdef; }
        .stat-card.info .icon-box { background: #e3f8fb; color: #11cdef; }
        .stat-card.danger { border-left-color: #f5365c; }
        .stat-card.danger .icon-box { background: #ffe9ee; color: #f5365c; }
        .stat-card.primary .icon-box { background: var(--brand-soft); color: var(--brand); }

        /* buttons */
        .btn { border-radius: 10px; font-weight: 500; padding: .5rem 1.1rem; }
        .btn-primary { background: var(--brand); border-color: var(--brand); color: #fff !important; }
        .btn-primary:hover { background: var(--brand-dark); border-color: var(--brand-dark); }
        .btn-sm { padding: .35rem .75rem; font-size: .85rem; }
        .btn-soft-primary { background: var(--brand-soft); color: var(--brand); border: 0; }
        .btn-soft-primary:hover { background: var(--brand); color: #fff; }

        /* tables */
        .table { margin-bottom: 0; }
        .table > :not(caption) > * > * { padding: .85rem 1rem; }
        .table thead th {
            background: #f9fafc;
            border-top: 0;
            border-bottom: 1px solid #eef0f4;
            font-weight: 600;
            font-size: .8rem;
            color: #65718a;
            text-transform: uppercase;
            letter-spacing: .03em;
        }
        .table-striped > tbody > tr:nth-of-type(odd) > * { background: #fafbfd; }
        .table tbody tr:hover > * { background: #f3f6fd !important; }
        .table-responsive { -webkit-overflow-scrolling: touch; }
        @media (max-width: 767.98px) {
            .table > :not(caption) > * > * { padding: .6rem .65rem; font-size: .88rem; }
            .table thead th { font-size: .72rem; padding: .55rem .65rem; }
            .table .btn-sm { padding: .25rem .55rem; font-size: .78rem; }
            .hide-sm { display: none !important; }
        }
        @media (max-width: 575.98px) {
            .hide-xs { display: none !important; }
        }

        /* forms */
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #e3e6ee;
            padding: .55rem .85rem;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 .2rem rgba(94, 114, 228, .12);
        }
        .form-label { font-weight: 500; color: #334155; margin-bottom: .35rem; font-size: .9rem; }

        /* SIDEBAR — comfortable touch targets (≥48px), tablet-friendly */
        aside.sidebar { background: #fff !important; }
        aside.sidebar .sidebar-header {
            padding: 1.1rem 1rem;
            border-bottom: 1px solid #f0f1f5;
            min-height: 64px;
        }
        aside.sidebar .sidebar-header .navbar-brand img { width: 44px !important; height: 44px; flex-shrink: 0; }
        aside.sidebar .sidebar-header .logo-title {
            font-size: 1.45rem;
            font-weight: 800;
            letter-spacing: .08em;
            margin-left: .7rem !important;
            color: var(--brand);
        }
        /* sale-receipt logo title — keep readable on print */
        #receipt h3 { font-size: 1.5rem; letter-spacing: .08em; }
        aside.sidebar .sidebar-toggle { display: none !important; }  /* hide the confusing arrow inside sidebar header */
        aside.sidebar .nav-link {
            border-radius: 10px;
            margin: 2px 10px;
            padding: .75rem .9rem !important;
            color: #475569 !important;
            background: transparent !important;
            font-size: .92rem;
            min-height: 44px;
        }
        aside.sidebar .nav-link:hover {
            background: #f3f5fa !important;
            color: var(--brand) !important;
        }
        aside.sidebar .nav-link.active,
        aside.sidebar ul.iq-main-menu > li.nav-item > a.nav-link.active {
            background: var(--brand-soft) !important;
            color: var(--brand) !important;
            font-weight: 600;
        }
        aside.sidebar .nav-link .icon { color: inherit; opacity: .85; }
        aside.sidebar .sub-nav .nav-link { padding-left: 2.2rem !important; font-size: .88rem; min-height: 38px; }
        aside.sidebar hr.hr-horizontal { margin: .75rem 1rem; }

        /* Fix HopeUI .navs-shape corner decoration — SVG color hardcoded to dark purple
           in tecdig.css; recolor to match white sidebar background */
        .navs-shape .navbar-nav .nav-item .nav-link:not(.disabled).active::before,
        .navs-shape .navbar-nav .nav-item .nav-link:not(.disabled)[aria-expanded="true"]::before,
        .navs-shape .navbar-nav .nav-item .nav-link:not(.disabled).active::after,
        .navs-shape .navbar-nav .nav-item .nav-link:not(.disabled)[aria-expanded="true"]::after {
            content: url("data:image/svg+xml,%3csvg width='32' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3e%3cpath fill-rule='evenodd' clip-rule='evenodd' d='M8 16H16C12 16 8 13 8 8V16Z' fill='%23ffffff'/%3e%3c/svg%3e") !important;
        }
        /* navbar sidebar-toggle (mobile hamburger): hide on desktop only */
        @media (min-width: 992px) {
            .main-content .iq-navbar .sidebar-toggle { display: none !important; }
        }

        /* product card */
        .product-card { cursor: pointer; transition: transform .15s, box-shadow .15s; border-radius: 12px; overflow: hidden; }
        .product-card:hover { transform: translateY(-3px); box-shadow: 0 10px 24px rgba(15, 23, 42, .08); }
        .product-card.out-of-stock { opacity: .45; cursor: not-allowed; }
        .product-card.out-of-stock:hover { transform: none; box-shadow: none; }
        .product-card .product-thumb { width: 100% !important; height: 130px !important; border-radius: 0; font-size: 3rem !important; }

        /* product thumbnail in tables */
        .product-thumb { object-fit: cover; border-radius: 10px; background: #f3f5fa; }
        .product-thumb-coffee { background: var(--cat-coffee-bg) !important; color: var(--cat-coffee-ic); }
        .product-thumb-tea    { background: var(--cat-tea-bg) !important;    color: var(--cat-tea-ic); }
        .product-thumb-juice  { background: var(--cat-juice-bg) !important;  color: var(--cat-juice-ic); }
        .product-thumb-cake   { background: var(--cat-cake-bg) !important;   color: var(--cat-cake-ic); }
        .product-thumb-other  { background: var(--cat-other-bg) !important;  color: var(--cat-other-ic); }
        table .product-thumb { width: 48px !important; height: 48px !important; font-size: 1.4rem !important; }

        /* empty state */
        .empty-state { color: #94a3b8; }
        .empty-state .empty-icon { font-size: 3rem; opacity: .6; }
        .empty-state .empty-title { font-weight: 600; color: #475569; font-size: 1rem; }

        /* search input with icon */
        .search-input-wrap { position: relative; }
        .search-input-wrap .form-control { padding-left: 2.4rem; }
        .search-input-wrap .search-icon { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }

        /* quick filter chips */
        .chip-group { display: flex; flex-wrap: wrap; gap: .4rem; }
        .chip-group a, .chip-group button {
            border: 1px solid #e3e6ee; background: #fff; color: #475569;
            padding: .25rem .75rem; border-radius: 999px; font-size: .82rem;
            text-decoration: none; cursor: pointer;
        }
        .chip-group a:hover, .chip-group button:hover { border-color: var(--brand); color: var(--brand); }
        .chip-group .active { background: var(--brand); border-color: var(--brand); color: #fff !important; }

        /* destructive button — stronger */
        .btn-soft-danger { background: #ffe9ee; color: #d32449; border: 0; font-weight: 500; }
        .btn-soft-danger:hover { background: #f5365c; color: #fff; }
        .table .btn-sm + .btn-sm, .table form + form, .table .btn-sm + form { margin-left: .25rem; }

        .cart-table td { vertical-align: middle; }
        .low-stock { color: #f5365c; font-weight: 600; }

        /* badges */
        .badge { padding: .4em .65em; border-radius: 8px; font-weight: 500; }

        /* alerts */
        .alert { border-radius: 12px; border: 0; padding: 1rem 1.15rem; }
        .alert-success { background: #e9faf2; color: #117a4f; }
        .alert-danger { background: #ffe9ee; color: #ad1d3b; }
        .alert-warning { background: #fff7e6; color: #8a5a00; }

        /* footer */
        .footer { background: transparent !important; padding: 1rem 1.75rem; border-top: 1px solid #eef0f4; margin-top: 1rem; }
        .footer .footer-body { display: flex; justify-content: space-between; align-items: center; font-size: .85rem; color: var(--muted); }

        /* TOAST NOTIFICATIONS */
        .toast-stack {
            position: fixed;
            top: 80px;
            right: 1.25rem;
            z-index: 1080;
            display: flex;
            flex-direction: column;
            gap: .6rem;
            pointer-events: none;
            max-width: calc(100vw - 2.5rem);
        }
        .toast-item {
            pointer-events: auto;
            min-width: 300px;
            max-width: 420px;
            background: #fff;
            border-radius: 12px;
            border: 1px solid #eef0f4;
            box-shadow: 0 12px 32px rgba(15, 23, 42, .12), 0 4px 10px rgba(15, 23, 42, .06);
            padding: .9rem 1rem;
            display: flex;
            align-items: flex-start;
            gap: .75rem;
            transform: translateX(120%);
            opacity: 0;
            transition: transform .35s cubic-bezier(.16,1,.3,1), opacity .25s ease;
            overflow: hidden;
            position: relative;
        }
        .toast-item.show { transform: translateX(0); opacity: 1; }
        .toast-item.hide { transform: translateX(120%); opacity: 0; }
        .toast-item::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0; width: 4px;
            background: var(--brand);
        }
        .toast-item.toast-success::before { background: var(--success); }
        .toast-item.toast-error::before   { background: var(--danger); }
        .toast-item.toast-warning::before { background: var(--warning); }
        .toast-item.toast-info::before    { background: var(--info); }

        .toast-item .toast-icon {
            width: 32px; height: 32px;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 1rem;
            font-weight: bold;
        }
        .toast-item.toast-success .toast-icon { background: var(--success-soft); color: var(--success); }
        .toast-item.toast-error   .toast-icon { background: var(--danger-soft);  color: var(--danger); }
        .toast-item.toast-warning .toast-icon { background: var(--warning-soft); color: var(--warning); }
        .toast-item.toast-info    .toast-icon { background: var(--info-soft);    color: var(--info); }

        .toast-item .toast-body { flex: 1; min-width: 0; }
        .toast-item .toast-title { font-weight: 600; color: var(--ink); font-size: .92rem; line-height: 1.3; }
        .toast-item .toast-msg { font-size: .85rem; color: #64748b; margin-top: .15rem; word-break: break-word; }
        .toast-item .toast-close {
            background: transparent; border: 0; color: #94a3b8; cursor: pointer;
            padding: 0 .25rem; font-size: 1.1rem; line-height: 1; align-self: flex-start;
        }
        .toast-item .toast-close:hover { color: var(--ink); }
        .toast-item .toast-progress {
            position: absolute; left: 0; bottom: 0; height: 2px;
            background: rgba(0,0,0,.06); width: 100%;
        }
        .toast-item .toast-progress::after {
            content: ''; display: block; height: 100%;
            background: var(--brand);
            width: 100%;
            transform-origin: left;
            animation: toastProgress var(--toast-duration, 4s) linear forwards;
        }
        .toast-item.toast-success .toast-progress::after { background: var(--success); }
        .toast-item.toast-error   .toast-progress::after { background: var(--danger); }
        .toast-item.toast-warning .toast-progress::after { background: var(--warning); }
        .toast-item.toast-info    .toast-progress::after { background: var(--info); }
        @keyframes toastProgress { from { transform: scaleX(1); } to { transform: scaleX(0); } }

        @media (max-width: 575px) {
            .toast-stack { right: .5rem; left: .5rem; top: 70px; }
            .toast-item { min-width: 0; max-width: none; }
        }

        /* CONFIRMATION MODAL */
        .confirm-backdrop {
            position: fixed; inset: 0; background: rgba(15, 23, 42, .45);
            z-index: 1090;
            display: flex; align-items: center; justify-content: center;
            opacity: 0; pointer-events: none;
            transition: opacity .2s ease;
            padding: 1rem;
        }
        .confirm-backdrop.show { opacity: 1; pointer-events: auto; }
        .confirm-modal {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 25px 60px rgba(15, 23, 42, .25);
            max-width: 420px; width: 100%;
            transform: scale(.92) translateY(8px);
            transition: transform .25s cubic-bezier(.16,1,.3,1);
            overflow: hidden;
        }
        .confirm-backdrop.show .confirm-modal { transform: scale(1) translateY(0); }
        .confirm-modal .confirm-body {
            padding: 1.5rem 1.5rem 1.25rem;
            text-align: center;
        }
        .confirm-modal .confirm-icon {
            width: 64px; height: 64px;
            margin: 0 auto 1rem;
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 2rem;
            background: var(--danger-soft);
            color: var(--danger);
        }
        .confirm-modal.variant-warning .confirm-icon { background: var(--warning-soft); color: var(--warning); }
        .confirm-modal.variant-info .confirm-icon { background: var(--info-soft); color: var(--info); }
        .confirm-modal .confirm-title {
            font-size: 1.15rem; font-weight: 600; color: var(--ink);
            margin-bottom: .35rem;
        }
        .confirm-modal .confirm-msg { color: #64748b; font-size: .92rem; }
        .confirm-modal .confirm-actions {
            display: flex; gap: .5rem;
            padding: 1rem 1.5rem 1.5rem;
        }
        .confirm-modal .confirm-actions .btn { flex: 1; padding: .65rem 1rem; font-weight: 500; }
        .confirm-modal .btn-confirm { background: var(--danger); border-color: var(--danger); color: #fff; }
        .confirm-modal .btn-confirm:hover { background: #d32449; border-color: #d32449; color: #fff; }
        .confirm-modal.variant-warning .btn-confirm { background: var(--warning); border-color: var(--warning); }
        .confirm-modal.variant-info .btn-confirm { background: var(--brand); border-color: var(--brand); }
        .confirm-modal .btn-cancel { background: #f1f5f9; border-color: #f1f5f9; color: var(--ink); }
        .confirm-modal .btn-cancel:hover { background: #e2e8f0; border-color: #e2e8f0; color: var(--ink); }
    </style>
</head>
<body class="">
    <div id="loading"><div class="loader simple-loader"><div class="loader-body"></div></div></div>
    <div class="toast-stack" id="toastStack" aria-live="polite" aria-atomic="true"></div>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="confirm-backdrop" id="confirmBackdrop" role="dialog" aria-modal="true">
        <div class="confirm-modal">
            <div class="confirm-body">
                <div class="confirm-icon" id="confirmIcon">?</div>
                <div class="confirm-title" id="confirmTitle">ຢືນຢັນ</div>
                <div class="confirm-msg" id="confirmMsg"></div>
            </div>
            <div class="confirm-actions">
                <button type="button" class="btn btn-cancel" id="confirmCancelBtn">ຍົກເລີກ</button>
                <button type="button" class="btn btn-confirm" id="confirmOkBtn">ຢືນຢັນ</button>
            </div>
        </div>
    </div>
    <?php include __DIR__ . '/../Views/sidebar.php'; ?>
    <main class="main-content">
        <?php include __DIR__ . '/../Views/navbar.php'; ?>
        <div class="page-content">
            <div class="page-title-row d-flex justify-content-between align-items-center">
                <div>
                    <h2><?= e($title) ?></h2>
                    <div class="breadcrumb-trail">SMS &nbsp;/&nbsp; <?= e($title) ?></div>
                </div>
            </div>
            <?php
}

function layout_foot() {
    ?>
        </div>
        <?php include __DIR__ . '/../Views/footer.php'; ?>
    </main>
    <script src="../assets/js/libs.min.js"></script>
    <script src="../assets/js/app.js"></script>
    <script>
    (function(){
        const stack = document.getElementById('toastStack');
        if (!stack) return;
        const ICONS = { success: '✓', error: '✕', warning: '!', info: 'i' };
        const TITLES = {
            success: 'ສຳເລັດ', error: 'ຜິດພາດ',
            warning: 'ແຈ້ງເຕືອນ', info: 'ຂໍ້ມູນ'
        };
        window.showToast = function(type, message, opts = {}) {
            type = ['success','error','warning','info'].includes(type) ? type : 'info';
            const duration = opts.duration ?? 4000;
            const title = opts.title ?? TITLES[type];

            const el = document.createElement('div');
            el.className = 'toast-item toast-' + type;
            el.style.setProperty('--toast-duration', duration + 'ms');
            el.innerHTML = `
                <div class="toast-icon">${ICONS[type]}</div>
                <div class="toast-body">
                    <div class="toast-title"></div>
                    <div class="toast-msg"></div>
                </div>
                <button type="button" class="toast-close" aria-label="ປິດ">&times;</button>
                <div class="toast-progress"></div>
            `;
            el.querySelector('.toast-title').textContent = title;
            el.querySelector('.toast-msg').textContent = message ?? '';

            const close = () => {
                el.classList.remove('show');
                el.classList.add('hide');
                setTimeout(() => el.remove(), 400);
            };
            el.querySelector('.toast-close').addEventListener('click', close);
            let timer = setTimeout(close, duration);
            el.addEventListener('mouseenter', () => { clearTimeout(timer); el.querySelector('.toast-progress').style.animationPlayState = 'paused'; });
            el.addEventListener('mouseleave', () => { timer = setTimeout(close, 1500); el.querySelector('.toast-progress').style.animationPlayState = 'running'; });

            stack.appendChild(el);
            requestAnimationFrame(() => el.classList.add('show'));
            return el;
        };

        // queued server-side messages
        const queued = window.__toastQueue || [];
        queued.forEach(t => showToast(t.type, t.message, t.opts || {}));
    })();

    // MOBILE SIDEBAR TOGGLE
    (function(){
        const sidebar = document.querySelector('aside.sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (!sidebar || !backdrop) return;

        const open = () => {
            sidebar.classList.add('sidebar-open');
            backdrop.classList.add('show');
            document.body.classList.add('sidebar-open-state');
        };
        const close = () => {
            sidebar.classList.remove('sidebar-open');
            backdrop.classList.remove('show');
            document.body.classList.remove('sidebar-open-state');
        };
        const toggle = () => sidebar.classList.contains('sidebar-open') ? close() : open();

        // Hamburger / toggle buttons in navbar
        document.querySelectorAll('.main-content .sidebar-toggle, .navbar-toggler').forEach(btn => {
            btn.addEventListener('click', (e) => { e.preventDefault(); toggle(); });
        });
        backdrop.addEventListener('click', close);
        // Auto-close on navigation (clicking any sidebar link) at mobile
        sidebar.addEventListener('click', (e) => {
            if (window.innerWidth >= 992) return;
            const a = e.target.closest('a.nav-link');
            if (a && !a.hasAttribute('data-bs-toggle')) close();
        });
        // Auto-close when resizing up to desktop
        window.addEventListener('resize', () => { if (window.innerWidth >= 992) close(); });
        document.addEventListener('keydown', (e) => { if (e.key === 'Escape' && sidebar.classList.contains('sidebar-open')) close(); });
    })();

    // CONFIRMATION MODAL
    (function(){
        const backdrop = document.getElementById('confirmBackdrop');
        if (!backdrop) return;
        const modal = backdrop.querySelector('.confirm-modal');
        const iconEl = document.getElementById('confirmIcon');
        const titleEl = document.getElementById('confirmTitle');
        const msgEl = document.getElementById('confirmMsg');
        const okBtn = document.getElementById('confirmOkBtn');
        const cancelBtn = document.getElementById('confirmCancelBtn');

        const VARIANT_ICONS = { danger: '✕', warning: '!', info: 'i' };
        let currentResolve = null;

        function close(result) {
            backdrop.classList.remove('show');
            const r = currentResolve;
            currentResolve = null;
            if (r) r(result);
        }

        backdrop.addEventListener('click', (e) => { if (e.target === backdrop) close(false); });
        cancelBtn.addEventListener('click', () => close(false));
        okBtn.addEventListener('click', () => close(true));
        document.addEventListener('keydown', (e) => {
            if (!backdrop.classList.contains('show')) return;
            if (e.key === 'Escape') close(false);
            if (e.key === 'Enter') close(true);
        });

        window.showConfirm = function(opts = {}) {
            const {
                title = 'ຢືນຢັນການກະທຳ',
                message = '',
                confirmText = 'ຢືນຢັນ',
                cancelText = 'ຍົກເລີກ',
                variant = 'danger'
            } = (typeof opts === 'string') ? { message: opts } : opts;

            modal.classList.remove('variant-warning','variant-info');
            if (variant === 'warning') modal.classList.add('variant-warning');
            else if (variant === 'info') modal.classList.add('variant-info');

            iconEl.textContent = VARIANT_ICONS[variant] || '?';
            titleEl.textContent = title;
            msgEl.textContent = message;
            okBtn.textContent = confirmText;
            cancelBtn.textContent = cancelText;

            return new Promise((resolve) => {
                currentResolve = resolve;
                backdrop.classList.add('show');
                setTimeout(() => okBtn.focus(), 50);
            });
        };

        // Auto-wire: any form with data-confirm shows modal instead of submitting directly
        document.addEventListener('submit', async (e) => {
            const form = e.target;
            if (!(form instanceof HTMLFormElement)) return;
            const msg = form.getAttribute('data-confirm');
            if (!msg) return;
            if (form.dataset._confirmed === '1') return; // already confirmed, allow submit
            e.preventDefault();
            const ok = await showConfirm({
                title: form.getAttribute('data-confirm-title') || 'ຢືນຢັນການກະທຳ',
                message: msg,
                confirmText: form.getAttribute('data-confirm-ok') || 'ຢືນຢັນ',
                variant: form.getAttribute('data-confirm-variant') || 'danger',
            });
            if (ok) {
                form.dataset._confirmed = '1';
                form.submit();
            }
        }, true);

        // Same for links with data-confirm
        document.addEventListener('click', async (e) => {
            const link = e.target.closest('a[data-confirm]');
            if (!link) return;
            e.preventDefault();
            const ok = await showConfirm({
                title: link.getAttribute('data-confirm-title') || 'ຢືນຢັນການກະທຳ',
                message: link.getAttribute('data-confirm'),
                confirmText: link.getAttribute('data-confirm-ok') || 'ຢືນຢັນ',
                variant: link.getAttribute('data-confirm-variant') || 'danger',
            });
            if (ok) window.location.href = link.href;
        }, true);
    })();
    </script>
</body>
</html>
    <?php
}

// Queue server-side flash messages as toasts (rendered by global toast JS in layout_foot)
function flash_banner() {
    $queue = [];
    foreach (['success' => 'success', 'error' => 'error', 'warning' => 'warning', 'info' => 'info'] as $key => $type) {
        $msg = flash_get($key);
        if ($msg !== null && $msg !== '') {
            $queue[] = ['type' => $type, 'message' => $msg];
        }
    }
    if (!$queue) return;
    echo '<script>window.__toastQueue = (window.__toastQueue || []).concat(' . json_encode($queue, JSON_UNESCAPED_UNICODE) . ');</script>';
}
