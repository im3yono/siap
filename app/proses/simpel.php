<?php
require_once "../../config/server.php";


$id = $_POST['id'] ?? '';

$stmt = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE kd_staf = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
echo $result['nip'] != '-' ? 'NIP ' . $result['nip'] : 'NUPTK ' . $result['nuptk'];
