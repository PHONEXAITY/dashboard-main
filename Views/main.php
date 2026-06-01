<?php
require_once __DIR__ . '/../includes/layout.php';
require_login();
$pageTitle = 'ໜ້າຫຼັກ';
layout_head($pageTitle);
include __DIR__ . '/dashboard.php';
layout_foot();
