<?php
require_once "db_config.php";
require_once "lib/funct.php";
require_once("about.php");


//  Database connection
try {
	$pdo_conn = new PDO("mysql:host=$server;dbname=$db", $userdb, $passdb, [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	]);
} catch (PDOException $th) {
	// error in console
	error_log("Koneksi Database Error: " . $th->getMessage());
	die("Koneksi ke database gagal : " . $th->getMessage());
}

// List of Tables
$db_tbl = ['tb_dsis', 'tb_dstaf', 'tb_mpel', 'tb_jrnl', 'tb_kls'];
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
		// } catch (PDOException $e) {
		// 	// bisa log error ke file, jangan ditampilkan ke user
		// 	error_log("SQL Error: " . $e->getMessage());
		// 	return false;
	} catch (PDOException $e) {
		echo "SQL Error: " . $e->getMessage();
		return false;
	}
}


// $user_sm = "mytbk";
// $pass_sm = "admintbk";
// Koneksi ke database MyTbk
function db_Mytbk()
{
	try {
		$conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS, [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		]);
		// $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn;
	} catch (PDOException $e) {
		// bisa log error ke file, jangan ditampilkan ke user
		error_log("SQL Error: " . $e->getMessage());
		return false;
		// } catch (PDOException $e) {
		// 	die("Koneksi MyTbk gagal: " . $e->getMessage());
	}
}
