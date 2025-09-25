<?php

$route = $_POST['route'] != '' ? $_POST['route'] : 'dashboard';
$id = $_POST['id'] ?? '';

// whitelist halaman agar aman
$allowed = ['dashboard', 'v_siswa', 'up_sis', 'edt_sis', 'v_guru', 'v_tendik', 'up_staf'];


if (!in_array($route, $allowed)) {
	include_once "error/404.php";
	exit;
}

if (file_exists("views/{$route}.php")) {
	include_once "views/{$route}.php";
} else {
	include_once "error/404.php";
}
// echo "views/{$route}.php";
