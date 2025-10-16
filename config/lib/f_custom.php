<?php

function ft($ft, $fldr, $path = "../", $def = '')
{
	$format = [
		".jpg",
		".jpeg",
		".png",
		".JPG",
		".JPEG",
		".PNG"
	];
	$basePath = $path . "app/images/" . $fldr . "/";
	foreach ($format as $ext) {
		$filePath = $basePath . $ft . $ext;
		if (file_exists($filePath)) {
			return $def . "app/images/" . $fldr . "/" . $ft . $ext;
		}
	}
	return $def . "assets/img/account.png";
}

function f_qrCode($data)
{
	require_once("../../assets/phpqrcode/qrlib.php");

	// $data = 'Zulfa Kibrina
	// 				NISN 0107286662 NIS 255156
	// 				Pemakuan, 30 September 2010
	// 				Jln. Bahkti RT 3/0, Kel. Pemakuan,
	// 				Kec. Kec. Sungai Tabuk, Kode Pos
	// 				70653
	// 				';

	// Matikan header otomatis dan tangkap hasil QR ke buffer
	ob_start();
	QRcode::png($data, null, QR_ECLEVEL_L, 5);
	$imageString = ob_get_contents();
	ob_end_clean();

	// Set header agar browser tahu ini HTML (bukan gambar PNG langsung)
	header('Content-Type: text/html; charset=utf-8');

	// menampilkan qrcode 
	return '<img src="data:image/png;base64,' . base64_encode($imageString) . '" alt="QR Code">';
}

function f_pdfqrCode($data)
{
    require_once __DIR__ . "/../../assets/phpqrcode/qrlib.php";

    // Tangkap QR ke buffer
    ob_start();
    QRcode::png($data, null, QR_ECLEVEL_L, 5);
    $imageString = ob_get_contents();
    ob_end_clean();

    // Hasilkan string base64 tanpa tag HTML
    return base64_encode($imageString);
}