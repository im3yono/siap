<?php
require_once "db_config.php";
require_once "lib/funct.php";
require_once("about.php");


//  Koneksi ke database
try {
	$pdo_conn = new PDO("mysql:host=$server;dbname=$db", $userdb, $passdb, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
} catch (PDOException $th) {
	// eror pada console
	error_log("Koneksi Database Error: " . $th->getMessage());
	die("Koneksi ke database gagal : " . $th->getMessage());
}

$db_tbl = ['tb_dsis', 'tb_dstaf', 'tb_mpel'];
foreach ($db_tbl as $table) {
	$check = $pdo_conn->query("SHOW TABLES LIKE '$table'")->rowCount();
	if ($check == 0) {
		die('<script> Swal.fire({icon: "error", title: "Database Belum Siap", text: "Silakan hubungi administrator.", confirmButtonText: "OK"}).then(() => { window.location.href = ""; }); </script>');
	}
}
$notbl = 1;


function db_Proses(PDO $pdo, string $sql, array $data = [])
{
	$stmt = $pdo->prepare($sql);   // 1. Siapkan query dengan placeholder (:param)

	try {
		$stmt->execute($data);	// 2. Eksekusi query dengan data array
		return $stmt;						// 3. Kembalikan statement object
	} catch (PDOException $e) {
		// bisa log error ke file, jangan ditampilkan ke user
		error_log("SQL Error: " . $e->getMessage());
		return false;
	}
}
