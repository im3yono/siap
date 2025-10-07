<?php
require_once "../../config/server.php";

$tkt	= $_POST['tkt'] ?? '';
$kls	= $_POST['kls'] ?? '';
$walas	= $_POST['walas'] ?? '';
$id_kls	= $_POST['id'] ?? '';

$prd	= $_POST['prd'] ?? '';
if ($prd == 'add') {
	$qr = 'INSERT INTO tb_kls (tkt, kls, kd_staf) VALUES (?, ?, ?)';
	$data = [$tkt, $kls, $walas];
	$stmt	= db_Proses($pdo_conn, $qr, $data);
	if (($stmt)) {
		echo 'ok';
	}
}

if ($prd == 'edt' && $id_kls != '') {
	$qr = 'UPDATE tb_kls SET tkt = ?, kls = ?, kd_staf = ? WHERE id_kls = ?';
	$data = [$tkt, $kls, $walas, $id_kls];
	$stmt	= db_Proses($pdo_conn, $qr, $data);
	if (($stmt)) {
		echo 'update';
	}
}

if ($prd == 'del' && $id_kls != '') {
	$stmt = db_Proses($pdo_conn, 'DELETE FROM tb_kls WHERE id_kls = ?', [$id_kls]);
	if ($stmt) echo 'ok';
}
