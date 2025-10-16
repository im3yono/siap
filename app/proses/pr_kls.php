<?php
require_once "../../config/server.php";

$tkt	= $_POST['tkt'] ?? '';
$prd	= $_POST['prd'] ?? '';


$kls	= $_POST['kls'] ?? '';
$walas	= $_POST['walas'] ?? '';
$id_kls	= $_POST['id'] ?? '';
// $m_kls = $_POST['m__kls'] ?? '';


if ($prd == 'add') {
	if ($tkt == '' || $walas == '') {
		echo 'err';
		exit;
	}
	$qr = 'INSERT INTO tb_kls (tkt, kls, kd_staf) VALUES (?, ?, ?)';
	$data = [$tkt, $kls, $walas];
	$stmt	= db_Proses($pdo_conn, $qr, $data);
	if (($stmt)) {
		echo 'ok';
	}
}

if ($prd == 'edt' && $id_kls != '') {
	if ($tkt == '' || $walas == '') {
		echo 'err';
		exit;
	}
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


// if ($prd == 'ch_tkt'):
// 	if ($tkt != '') {
// 		$sql = "SELECT kls FROM tb_kls WHERE tkt = ? GROUP BY kls ORDER BY kls ASC";
// 		$stmt = db_Proses($pdo_conn, $sql, [$tkt]);
// 	} else {
// 		// Jika tidak dipilih, tampilkan semua
// 		$sql = "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC";
// 		$stmt = db_Proses($pdo_conn, $sql);
// 	}

// 	echo '<option value="" selected disabled>-- Pilih --</option>';
// 	while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
// 		$dkls = db_Proses($pdo_conn, 'SELECT * FROM tb_dsis WHERE kls = ?', [$r['kls']]);
// 		if ($cek->rowCount() != 0) {
// 			echo "<option value='{$r['kls']}'>{$r['kls']}</option>";
// 		}
// 	}
// endif;