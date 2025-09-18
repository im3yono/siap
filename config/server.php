<?php
require_once "db_config.php";
require_once "lib/funct.php";


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
	die("Koneksi ke database gagal : ". $th->getMessage());
}


$notbl = 1;