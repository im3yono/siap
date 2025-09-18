<?php

$page = $_POST['page'] != '' ? $_POST['page'] : 'dashboard';
$id = $_POST['id'] ?? '';

// whitelist halaman agar aman
$allowed = ['dashboard', 'v_siswa', 'v_guru', 'v_tendik', 'up_sis', 'edt_sis'];
if (!in_array($page, $allowed)) {
	include_once "error/404.php";
	exit;
}

if (file_exists("views/{$page}.php")) {
	include_once "views/{$page}.php";
} else {
	include_once "error/404.php";
}
// echo "views/{$page}.php";
