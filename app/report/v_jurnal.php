<?php
require_once "../../config/server.php";
require_once("../../assets/fpdf/fpdf.php");  // Include FPDF


// echo '	<!-- <link rel="shortcut icon" href="../../assets/img/brand.png" type="image/x-icon"> -->';


if (isset($_POST['nama']) == '') {
	include_once("../error/403.php");
	exit;
}
$id_staf = $_POST['nama'];
if ($id_staf != '1') {
	$dt_staf = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE kd_staf =:id");
	$dt_staf->bindParam(':id', $id_staf);
	$dt_staf->execute();
	$result = $dt_staf->fetch(PDO::FETCH_ASSOC);
} else {
	$result = ['nm_staf' => ' ', 'glar' => ' '];
}


$dt_kepsek = $pdo_conn->prepare("SELECT nm_staf, nip, glar FROM tb_dstaf WHERE jptk ='Kepsek'");
// $dt_kepsek->bindParam(':id', 'kepsek');
$dt_kepsek->execute();
$kepsek = $dt_kepsek->fetch(PDO::FETCH_ASSOC);
$kepsek_nm = f_nmGelar($kepsek['nm_staf'], $kepsek['glar']);


$nmpt = "SMAN 1 Sungai Tabuk";
$lksi = 'Sungai Tabuk';

$jdl 		= 'JURNAL MENGAJAR ';
$jdlpt 	= f_kapital($nmpt);

// $glr_gr	= $result['glar'] == '' ? '' : ', ' . $result['glar'];
$nm 		= f_nmGelar(f_nama($result['nm_staf']), $result['glar']);
$nip	 	= $_POST['nip'] ?? '';
$mpel 	= $_POST['mapel'] ?? '';
$alw 		= $_POST['al_waktu'] ?? '';
$alt 		= $_POST['al_temu'] ?? '';
$bln 		= $_POST['bln'] ?? '';
$thn 		= $_POST['thn_ajar'] ?? '';
$smt 		= $_POST['smt'] ?? '';
$pkls 	=	 $_POST['kelas'] ?? [''];
$orien 	= $_POST['orien'] ?? 'L';
$cvr 		= $_POST['cvr'] ?? '1';
$ctk		= $_POST['ctjrl'] ?? '';


if ($bln <= '6') {
	$ta = 'Genap';
	// $thn_a = 
} elseif ($bln > 6) {
	$ta = 'Ganjil';
} else {
	$ta = '';
}
if ($bln != '') {
	if ($bln == '16') {
		$nmbln = ' ' . $thn . ' ' . 'Genap';
	} elseif ($bln == '712') {
		$nmbln = ' ' . $thn . ' ' . 'Ganjil';
	} else {
		$bln = f_bulan_nama($bln);
		$nmbln = ' Bulan ' . ($bln) . ' ' . $thn;
	}
} else {
	$bln = str_repeat(chr(160), 22); // gunakan 6 non-breaking spaces agar tampil di FPDF
	$nmbln = ' Bulan ' . f_bulan_nama($bln);
}
$kl 	= [];
for ($i = 0; $i < $alt; $i++) {
	$kl[] = $i;
}
// $tmk = count($kl);

// Membuat objek FPDF
$pdf = new FPDF();

// $pdf->__construct("L","mm",array(210,330)); // Landscape, mm, Folio
// $pdf->__construct("L", "mm", array(210, 297)); // Landscape, mm, A4
// $pdf->__construct("L", "mm", "A4"); // Landscape, mm, A4
$pdf->SetMargins(5, 2, 2);
$pdf->SetAutoPageBreak(true, 2);
$pdf->SetTitle('Jurnal Mengajar ' . $nm . $nmbln);

// Mengatur font
$pdf->AddFont('Cambria', 'B', 'cambria.php');
$pdf->AddFont('Cambria', '', 'cambria.php');
$pdf->AddFont('Arial Narrow', '', 'arialnarrow.php');
$pdf->SetFillColor(217, 217, 217); // Warna latar belakang


if (empty($ctk)):
	require_once("jrnl_page.php");
else:
	// require_once("jrnl_onpage.php");
endif;


$pdf->SetDisplayMode('real');  // Menampilkan ukuran asli (bukan fit to page)
// Output PDF
if (isset($_POST['print'])) {
	$pdf->Output('I', 'Jurnal Mengajar ' . $nm . $nmbln . '.pdf');
} else {
	$pdf->Output('D', 'Jurnal Mengajar ' . $nm . $nmbln . '.pdf');
}
