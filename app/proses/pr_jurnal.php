<?php
require_once "../../config/server.php";


$id = $_POST['id'] ?? '';
$prd = $_POST['prd'] ?? '';

if ($prd == 'jrnl'):

	$stmt = db_Proses($pdo_conn, "SELECT * FROM tb_dstaf WHERE kd_staf = ?", [$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	$d_mpel = db_Proses($pdo_conn, "SELECT mpel FROM tb_mpel WHERE guru LIKE ?", ['%' . $result['kd_staf'] . '%']);

	$nip = $result['nip'] != '-' ? 'NIP ' . $result['nip'] : 'NUPTK ' . $result['nuptk'];
	// fetch mpel
	$d_mpel_stmt = db_Proses($pdo_conn, "SELECT mpel FROM tb_mpel WHERE guru LIKE ?", ['%' . $result['kd_staf'] . '%']);
	$d_mpel_row = $d_mpel_stmt->fetch(PDO::FETCH_ASSOC);
	$mpel = $d_mpel_row['mpel'] ?? '';

	header('Content-Type: application/json');
	if ($nip !== 'NUPTK -') {
		echo json_encode(['id' => $nip, 'mpel' => $mpel]);
	} else {
		echo json_encode(['id' => '', 'mpel' => '']);
	}
endif;
