<?php
require_once "../../config/server.php";

$kd_mpel = $_POST['kode'];
$nm_mpel = $_POST['mpel'] ?? '';
$sgkat = $_POST['sgkat'] ?? '';
$guru = $_POST['guru'] ?? '';
$prd  = $_POST['prd'];

if ($kd_mpel != '' && $prd == 'add') {
	// INSERT INTO `tb_mpel` (`id_mpel`, `kd_mpel`, `mpel`, `sgkat`, `guru`, `jdwl`, `rcd`, `upd`, `sts`) VALUES (NULL, 'U-123', 'Pendidikan Agama', 'PA', '{\"11021\",\"11014\"}', '{\"11021\",\"11014\"}', current_timestamp(), current_timestamp(), 'Y');
	$stmt = $pdo_conn->prepare(("INSERT INTO tb_mpel (kd_mpel, mpel, sgkat, guru, rcd, upd, sts) VALUES (:kd_mpel, :mpel, :sgkat, :guru, current_timestamp(), current_timestamp(), 'Y')"));
	$stmt->bindParam(':kd_mpel', $kd_mpel);
	$stmt->bindParam(':mpel', $nm_mpel);
	$stmt->bindParam(':sgkat', $sgkat);
	$gr = json_encode($guru);
	$stmt->bindParam(':guru', $gr);
	$stmt->execute();
	echo 'ok';
}

if ($kd_mpel != '' && $prd == 'edit') {
	// Update data pada tb_mpel
	$kd_mpel_lm = $_POST['kode_lm'];
	$cr_id = $pdo_conn->prepare("SELECT id_mpel FROM tb_mpel WHERE kd_mpel = :kd_mpel");
	$cr_id->bindParam(':kd_mpel', $kd_mpel_lm);
	$cr_id->execute();
	$cr_id = $cr_id->fetch(PDO::FETCH_ASSOC);
	$stmt = $pdo_conn->prepare("UPDATE tb_mpel SET kd_mpel = :kd_mpel, mpel = :mpel, sgkat = :sgkat, guru = :guru, upd = current_timestamp() WHERE id_mpel = :id_mpel");
	$stmt->bindParam(':id_mpel', $cr_id['id_mpel']);
	$stmt->bindParam(':kd_mpel', $kd_mpel);
	$stmt->bindParam(':mpel', $nm_mpel);
	$stmt->bindParam(':sgkat', $sgkat);
	$gr = json_encode($guru);
	$stmt->bindParam(':guru', $gr);
	if ($stmt->execute()) {
		echo 'update';
	}
}

if ($kd_mpel != '' && $prd == 'del') {
	$stmt = $pdo_conn->prepare("DELETE FROM `tb_mpel` WHERE kd_mpel = :kd_mpel");
	$stmt->bindParam(':kd_mpel', $kd_mpel);
	if ($stmt->execute()) {
		echo 'ok';
	}
}
