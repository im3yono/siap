
<?php
require_once "../../config/server.php";
require_once("../../assets/fpdf/fpdf.php");  // Include FPDF


// echo '	<!-- <link rel="shortcut icon" href="../../assets/img/brand.png" type="image/x-icon"> -->';


if (isset($_POST['nama']) == '') {
	include_once("../error/403.php");
	exit;
}
$id_staf = $_POST['nama'];
$dt_staf = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE kd_staf =:id");
$dt_staf->bindParam(':id', $id_staf);
$dt_staf->execute();
$result = $dt_staf->fetch(PDO::FETCH_ASSOC);


$dt_kepsek = $pdo_conn->prepare("SELECT nm_staf, nip, glar FROM tb_dstaf WHERE jptk ='Kepsek'");
// $dt_kepsek->bindParam(':id', 'kepsek');
$dt_kepsek->execute();
$kepsek = $dt_kepsek->fetch(PDO::FETCH_ASSOC);
$kepsek_glr = $kepsek['glar'] == '' ? '' : ', ' . $kepsek['glar'];
$kepsek_nm = $kepsek['nm_staf'] . $kepsek_glr;


$nmpt = "SMAN 1 Sungai Tabuk";
$lksi = 'Sungai Tabuk';

$jdl 	= 'JURNAL MENGAJAR ' . f_kapital($nmpt);

$glr_gr	= $result['glar'] == '' ? '' : ', ' . $result['glar'];
$nm 	= $result['nm_staf'] . $glr_gr;
$nip 	= $_POST['nip'] ?? '';
$mpel = $_POST['mapel'] ?? '';
$alw 	= $_POST['al_waktu'] ?? '';
$alt 	= $_POST['al_temu'] ?? '';
$bln 	= $_POST['bln'] ?? '............................';
$thn 	= $_POST['thn_ajar'] ?? '............................';
$smt 	= $_POST['smt'] ?? '';
$kls 	= $_POST['kelas'] ?? ['............................'];
$orien = $_POST['orien'] ?? 'L';

if ($bln != '') {
	switch ($bln) {
		case '1':
			$bln = 'Januari';
			break;
		case '2':
			$bln = 'Februari';
			break;
		case '3':
			$bln = 'Maret';
			break;
		case '4':
			$bln = 'April';
			break;
		case '5':
			$bln = 'Mei';
			break;
		case '6':
			$bln = 'Juni';
			break;
		case '7':
			$bln = 'Juli';
			break;
		case '8':
			$bln = 'Agustus';
			break;
		case '9':
			$bln = 'September';
			break;
		case '10':
			$bln = 'Oktober';
			break;
		case '11':
			$bln = 'November';
			break;
		case '12':
			$bln = 'Desember';
			break;
		default:
			$bln = '';
			break;
	}
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
$pdf->SetTitle('Jurnal Mengajar ' . $nm . ' Bulan_' . $bln . '_' . $thn);

// Mengatur font
$pdf->AddFont('Cambria', 'B', 'cambria.php');
$pdf->AddFont('Cambria', '', 'cambria.php');
$pdf->AddFont('Arial Narrow', '', 'arialnarrow.php');
$pdf->SetFillColor(217, 217, 217); // Warna latar belakang


require_once("jrnl_page.php");

// Output PDF
if (isset($_POST['print'])) {
	$pdf->Output('I', 'Jurnal Mengajar ' . $nm . ' Bulan_' . $bln . '_' . $thn . '.pdf');
} else {
	$pdf->Output('D', 'Jurnal Mengajar ' . $nm . ' Bulan_' . $bln . '_' . $thn . '.pdf');
}
