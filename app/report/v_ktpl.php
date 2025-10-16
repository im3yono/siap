<?php
require_once "../../config/server.php";
require_once("../../assets/fpdf/fpdf.php");  // Include FPDF 
require_once("../../assets/phpqrcode/qrlib.php");


$kls = $_POST['kls'] ?? '';
$nis = $_POST['nis'] ?? '';
$nma = $_POST['nama'] ?? '';
$kertas = $_POST['kertas'];


// $nx 	= 14.5; // Modifikasi Left
// $ny 	= 4; // Default Header
// // $jrk 	= 7.5; //f4
// $jrk 	= 0; // Ukuran Kertas

switch ($kertas) {
	case 'pvc':
		$kertas = [200, 300];
		$nx 		= 6;
		$jrk 		= 0;
		break;
	case 'a4':
		$kertas = [210, 297];
		$nx 		= 11;
		$jrk 		= -0.5;
		break;
	case 'f4':
		$kertas = [215, 330];
		$nx 		= 14.5;
		$jrk 		= 7.5;
		break;
	default:
		$kertas = [200, 300];
		$nx 		= 6;
		$jrk 		= 0;
		break;
}

if ($kls == '' && $nis == '' && $nma == '') {
	include_once("../error/403.php");
	exit;
}

$sql = 'SELECT * FROM tb_dsis';
$params = [];
$conditions = [];

// Jika ada kelas
if ($kls != '') {
	$conditions[] = 'kls = ?';
	$params[] = $kls;
}

// Jika ada NIPD (bisa satu atau banyak)
if ($nis != '') {
	$nipdList = array_map('trim', explode(',', $nis));
	$placeholders = rtrim(str_repeat('?,', count($nipdList)), ',');
	$conditions[] = "nipd IN ($placeholders)";
	$params = array_merge($params, $nipdList);
}

// Jika tidak ada NIPD tapi ada nama (mirip)
elseif ($nma != '') {
	$conditions[] = 'nm LIKE ?';
	$params[] = '%' . $nma . '%';
}

// Gabungkan semua kondisi jika ada
if (!empty($conditions)) {
	$sql .= ' WHERE ' . implode(' AND ', $conditions);
}

$sql .= ' ORDER BY tb_dsis.kls, nm ASC';

// Eksekusi query
$stmt = db_Proses($pdo_conn, $sql, $params);





class PDF extends FPDF
{
	function addDepan($x, $y, $bg, $nama, $nisn, $nipd, $ttl, $alamat)
	{
		$w = 88; // lebar kartu
		$h = 55; // tinggi kartu

		// Tambahkan background kartu
		$this->Image(ft($nipd, 'siswa', '../../', '../../'), $x + 4.5, $y + 15, 15);
		$this->Image($bg, $x, $y, $w, $h);

		// Tambahkan teks di atas background
		$this->SetTextColor(0, 0, 0);

		// Posisi teks relatif terhadap posisi kartu
		$this->SetXY($x + 20, $y + 14);
		$this->SetFont('aladin', '', 14);
		$this->MultiCell(60, 4, f_nama($nama), 0, 2);
		$this->SetXY($x + 20, $y + 22);
		$this->SetFont('arialnarrow', 'I', 12);
		$this->Cell(40, 4, "NISN $nisn", 0, 0);
		$this->Cell(20, 4, "NIS $nipd", 0, 1);
		$this->SetFont('arialnarrow', '', 9);
		$this->SetXY($x + 20, $y + 26);
		$this->Cell(60, 4, "$ttl", 0, 2);
		$this->MultiCell(43, 4, "$alamat", 0, 2);

		// === QR-Code ===
		$qr_data = "$nama\nNISN $nisn\nNIS $nipd\n$ttl\n$alamat";

		// Buat QR base64 (tidak disimpan ke file)
		$qr_base64 = f_pdfqrCode($qr_data);

		// Decode base64 menjadi data gambar biner
		$qr_binary = base64_decode($qr_base64);

		// Simpan sementara ke stream memori (tanpa file fisik)
		$qr_img = 'data://text/plain;base64,' . $qr_base64;

		// Masukkan ke FPDF
		$this->Image($qr_img, $x + 66, $y + 33, 20, 20, 'PNG');
		// $this->Image($bg, $x + 66, $y + 33, 20, 20, 'PNG');


		$this->SetFontSize(5);
		$this->SetXY($x + 1, $y + 50);
		$this->Cell(70, 4, 'Berlaku selama masih menjadi siswa SMAN 1 Sungai Tabuk', 0, 2);
	}
	function addBelakang($x, $y, $bg)
	{
		$w = 88; // lebar kartu
		$h = 55; // tinggi kartu

		// Tambahkan background kartu
		$this->Image($bg, $x, $y, $w, $h);

		// Tambahkan teks di atas background
		$this->SetFont('Arial', '', 8);
		$this->SetTextColor(0, 0, 0);

		// Posisi teks relatif terhadap posisi kartu
		$this->SetXY($x + 22, $y + 14);
		$this->Cell(280, 4, '', 0, 2);
	}
}

$pdf = new PDF('P', 'mm', $kertas);
$pdf->AddFont('Arialnarrow', '', 'arialnarrow.php');
$pdf->AddFont('Arialnarrow', 'I', 'arialnarrow_italic.php');
$pdf->AddFont('Aladin', '', 'aladin.php');
$pdf->SetTitle('Kartu Pelajar');

// for ($i = 0; $i <= 0; $i++) {
$pdf->AddPage();
$pdf->SetMargins(6, 3, 6);
$pdf->SetAutoPageBreak(true, 2);

// Contoh data 10 kartu (5 baris × 2 kolom)
$data = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$almt 	= json_decode($row['almt'], true);
	$jl 		= $almt['almt'] != "" ? $almt['almt'] : '';
	$rt 		= $almt['rt'] != "" ? $almt['rt'] : '0';
	$rw 		= $almt['rw'] != "" ? $almt['rw'] : '0';
	$dusun 	= $almt['dusun'] != "" ? ", Dusun " . $almt['dusun'] : '';
	$kel 		= $almt['kel'] != "" ? $almt['kel'] : '';
	$kec 		= $almt['kec'] != "" ? $almt['kec'] : '';
	$kdpos 	= $almt['kdpos'] != "" ? ", Kode Pos " . $almt['kdpos'] : '';
	$alamat = $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;
	$ttl		= f_nama($row['tmp_lahir']) . ", " . tgl($row['tgl_lahir']);

	$data[] = [
		$row['nm'],   // sesuaikan dengan nama kolom di tabel tb_dsis
		$row['nisn'],
		$row['nipd'],
		$ttl,
		$alamat
	];
}

// Variabel posisi awal
$ny 		= 4; // Default Header
$x 			= $nx;
$y 			= $ny;
$w 			= 88; // Default Id Card
$h 			= 55; // Default Id Card
$count 	= 0;

foreach ($data as $d) {
	$pdf->addDepan($x, $y, 'bg_depan.png', $d[0], $d[1], $d[2], $d[3], $d[4]);
	$pdf->addBelakang($x + 100, $y, 'bg_belakang.png');
	$count++;

	$y += 59 + $jrk; // jarak antar baris

	// Batas 5 baris per halaman
	if ($count % 5 == 0 && $count < count($data)) {
		$pdf->AddPage();
		$x = $nx;
		$y = $ny;
	}
}
// }

$pdf->SetDisplayMode('real');  // Menampilkan ukuran asli (bukan fit to page)
$pdf->Output();
