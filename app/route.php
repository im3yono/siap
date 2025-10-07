<?php

$route 		= $_POST['route'] != '' ? $_POST['route'] : 'dashboard';
$id 			= $_POST['id'] ?? '';


// whitelist halaman agar aman
$allowed 	= ['dashboard', 'siswa', 'up_sis', 'edt_sis', 'guru', 'tendik', 'up_staf', 'p_data', 'jurnal', 'mapel', 'kelas', 'jadwal', 'absensi'];


if (!in_array($route, $allowed)) {
	include_once "error/404.php";
	exit;
}

if (file_exists("page/{$route}.php")) {
	include_once "page/{$route}.php";
} else {
	include_once "error/404.php";
}
// echo "views/{$route}.php";
