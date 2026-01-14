<?php
require_once "../../config/server.php";
require_once("../../assets/fpdf/fpdf.php");  // Include FPDF



$nm_file = 'BIODATA SISWA';
$nipd = $_POST['nipd'] ?? '';
if ($nipd == '') {
	include_once("../error/403.php");
	exit;
}


function dataView($pdf, $label, $data, $baris = 0, $wdata = 0, $wlabel = 45)
{
	empty($data) ? $gr = '' : $gr = '';
	$pdf->Cell($wlabel, 7, $label, 0, 0);
	$pdf->Cell(5, 7, ':', 0, 0);
	if (strlen($data) > 50) {
		$pdf->MultiCell($wdata, 7, $data, $gr, 'L');
	} else {
		$pdf->Cell($wdata, 7, $data, $gr, 0, 'L');
	}
	$pdf->Cell(5, 7, '', '', $baris);
	// $pdf->Ln();
}


$d_sis = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE nipd = ?", [$nipd]);
$d_sis = $d_sis->fetch(PDO::FETCH_ASSOC);


$nisn 		= $d_sis['nisn'] ?? '-';
$nama 		= f_nama($d_sis['nm']) ?? '-';
$ttl 			= f_nama($d_sis['tmp_lahir']) . ', ' . tgl($d_sis['tgl_lahir']) ?? '-';
$jk 			= $d_sis['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan';
$nik 			= $d_sis['nik'] ?? '-';
$nikk 		= $d_sis['nikk'] ?? '-';
$agm 			= $d_sis['agm'] ?? '-';

$almt 		= json_decode($d_sis['almt'], true) ?? '-';
$jl 		= $almt['almt'] 	!= "" ? $almt['almt'] : '';
$rt 		= $almt['rt'] 		!= "" ? $almt['rt'] : '0';
$rw 		= $almt['rw'] 		!= "" ? $almt['rw'] : '0';
$dusun 	= $almt['dusun'] 	!= "" ? ", Dusun " . $almt['dusun'] : '';
$kel 		= $almt['kel'] 		!= "" ? $almt['kel'] : '';
$kec 		= $almt['kec'] 		!= "" ? $almt['kec'] : '';
$kdpos	= $almt['kdpos'] 	!= "" ? ", Kode Pos " . $almt['kdpos'] : '';
$almt		= $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;

$tlphp		= json_decode($d_sis['tlp/hp'], true);
$tlp 			= $tlphp['tlp'] ?? '-';
$hp 			= $tlphp['hp'] ?? '-';
$email 		= $d_sis['email'] ?? '-';
$stsm 		= $d_sis['masuk'] ?? '-';
$asl_s 		= $d_sis['sklh_asl'] ?? '-';


$sdr			= json_decode($d_sis['saudr'], true);
$anak 		= 'Anak	 Ke ' . $sdr['ke'] . " dengan " . $sdr['sdr'] . " saudara";

$tb_bb_lk = json_decode($d_sis['bb_tb_lk'], true);
$bb 			= $tb_bb_lk['bb'] != "" ? $tb_bb_lk['bb'] . " kg " : '';
$tb 			= $tb_bb_lk['tb'] != "" ? $tb_bb_lk['tb'] . " cm " : '';
$lk 			= $tb_bb_lk['lk'] != "" ? $tb_bb_lk['lk'] . " cm " : '';
$tmp_tgl 	= $d_sis['tmp_tinggal'] ?? '-';
$transp 	= $d_sis['trasport'] ?? '-';


$ayah 		= json_decode($d_sis['ayah'], true);
$ibu 			= json_decode($d_sis['ibu'], true);
$wali 		= json_decode($d_sis['wali'], true);

$a_sts 		= isset($ayah['sts']) == 'N' ? '(Alm)' : '';
$i_sts 		= isset($ibu['sts']) == 'N' ? '(Alm)' : '';

$a_nm 		= f_nama($ayah['nm']) ?? '-';
$a_nik 		= $ayah['nik'] ?? '-';
$a_thn 		= $ayah['thn_l'] ?? '-';
$a_almt 	= $ayah['almt'] ?? '-';
$a_pddk 	= $ayah['pddk'] ?? '-';
$a_kerja 	= $ayah['kerja'] ?? '-';
$a_upah 	= $ayah['upah'] ?? '-';

$i_nm 		= f_nama($ibu['nm']) ?? '-';
$i_nik 		= $ibu['nik'] ?? '-';
$i_thn 		= $ibu['thn_l'] ?? '-';
$i_almt 	= $ibu['almt'] ?? '-';
$i_pddk 	= $ibu['pddk'] ?? '-';
$i_kerja 	= $ibu['kerja'] ?? '-';
$i_upah 	= $ibu['upah'] ?? '-';

$w_nm 		= f_nama($wali['nm']) ?? '-';
$w_nik 		= $wali['nik'] ?? '-';
$w_thn 		= $wali['thn_l'] ?? '-';
$w_almt 	= $wali['almt'] ?? '-';
$w_pddk 	= $wali['pddk'] ?? '-';
$w_kerja 	= $wali['pddk'] ?? '-';
$w_upah 	= $wali['upah'] ?? '-';



// Kepsek
$dt_kepsek = $pdo_conn->prepare("SELECT nm_staf, nip, glar FROM tb_dstaf WHERE jptk ='Kepsek'");
// $dt_kepsek->bindParam(':id', 'kepsek');
$dt_kepsek->execute();
$kepsek = $dt_kepsek->fetch(PDO::FETCH_ASSOC);
$kepsek_nm = f_nmGelar($kepsek['nm_staf'], $kepsek['glar']);
$kepsek_nip = $kepsek['nip'] ?? '.........................';




// Class PDF dengan halaman
class PDF extends FPDF
{
	private $nama = '';

	public function setNama($nipd, $nama)
	{
		$this->nama = $nipd . ' ' . $nama;
	}

	// Footer halaman
	function Footer()
	{
		// Posisi 1.5 cm dari bawah
		$this->SetY(-13);

		// Font
		$this->SetFont('Arial', 'I', 8);

		// Nama Siswa
		$this->Cell(50, 10, $this->nama, 'T', 0, 'L');

		// Nomor halaman
		$this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 'T', 0, 'R');
	}
}


// Membuat objek FPDF
$pdf = new PDF();
$pdf->setNama($nipd, $nama);
// $pdf->__construct("L","mm",array(210,330)); // Landscape, mm, Folio
// $pdf->__construct("L", "mm", array(210, 297)); // Landscape, mm, A4
// $pdf->__construct("L", "mm", "A4"); // Landscape, mm, A4
// $pdf->SetMargins(5, 2, 2);
$pdf->SetAutoPageBreak(true, 15);
// $pdf->PageNo();
$pdf->AliasNbPages();
$pdf->SetTitle($nm_file . ' ' . $nipd);

// Mengatur font
$pdf->AddFont('Cambria', 'B', 'cambria.php');
$pdf->AddFont('Cambria', '', 'cambria.php');
$pdf->AddFont('Arial Narrow', '', 'arialnarrow.php');

$pdf->AddPage('P', [210, 297], 0);

$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, $nm_file, 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(63, 10, 'Identitas Siswa :', 'B', 1);

// $pdf->SetXY(160,35);
// $pdf->Text(171.5,62, 'FOTO');
$pdf->Image(ft($nipd, 'siswa', '../../', '../../'), 160, 35, 35, 45);
$pdf->Rect(160, 35, 35, 45, 'D');
// $pdf->Ln();

$pdf->SetFont('Arial', '', 12);

dataView($pdf, 'NIPD', $nipd, 0, 35);
dataView($pdf, 'NISN', $nisn, 1, 35, 15);
dataView($pdf, 'Nama', $nama, 1);
dataView($pdf, 'Tempat, Tanggal Lahir', $ttl, 1, 85);
dataView($pdf, 'Jenis Kelamin', $jk, 1, 85);
dataView($pdf, 'NIK', $nik, 1, 85);
dataView($pdf, 'NIKK', $nikk, 1, 85);
dataView($pdf, 'Agama', $agm, 1, 85);
dataView($pdf, 'Alamat', $almt, 1);
dataView($pdf, 'No. Telepon', $tlp, 0, 35);
dataView($pdf, 'No. Handphone', $hp, 1);
dataView($pdf, 'Email', $email, 1);
dataView($pdf, 'Status Masuk', $stsm, 1);
dataView($pdf, 'Asal Sekolah', $asl_s, 1);
dataView($pdf, 'Anak Ke', $anak, 1);
dataView($pdf, 'Berat', $bb, 0, 20);
dataView($pdf, 'Tinggi', $tb, 0, 20, 16);
dataView($pdf, 'Lingkar Kepala', $lk, 1, 10,33);
dataView($pdf, 'Tempat Tinggal', $tmp_tgl, 1);
dataView($pdf, 'Transportasi', $transp, 1);
$pdf->ln(10);

$pdf->Cell(63, 10, 'Identitas Orang Tua/Wali Siswa :', 'B', 1);
$pdf->Cell(47, 8, 'Ayah', 'B', 1);
dataView($pdf, 'Nama', $a_nm . ' ' . $a_sts, 1);
dataView($pdf, 'NIK', $a_nik, 1);
dataView($pdf, 'Tahun Lahir', $a_thn, 1);
dataView($pdf, 'Alamat', $a_almt, 1);
dataView($pdf, 'Pendidikan', $a_pddk, 1);
dataView($pdf, 'Pekerjaan', $a_kerja, 1);
dataView($pdf, 'Penghasilan', $a_upah, 1);
$pdf->Cell(47, 8, 'Ibu', 'B', 1);
dataView($pdf, 'Nama', $i_nm . ' ' . $i_sts, 1);
dataView($pdf, 'NIK', $i_nik, 1);
dataView($pdf, 'Tahun Lahir', $i_thn, 1);
dataView($pdf, 'Alamat', $i_almt, 1);
dataView($pdf, 'Pendidikan', $i_pddk, 1);
dataView($pdf, 'Pekerjaan', $i_kerja, 1);
dataView($pdf, 'Penghasilan', $i_upah, 1);
$pdf->Cell(47, 8, 'Wali', 'B', 1);
dataView($pdf, 'Nama', $w_nm, 1);
dataView($pdf, 'NIK', $w_nik, 1);
dataView($pdf, 'Tahun Lahir', $w_thn, 1);
dataView($pdf, 'Alamat', $w_almt, 1);
dataView($pdf, 'Pendidikan', $w_pddk, 1);
dataView($pdf, 'Pekerjaan', $w_kerja, 1);
dataView($pdf, 'Penghasilan', $w_upah, 1);
$pdf->Ln(10);


// TTD
// $pdf->Cell(50,8,'Mengetahui,',0,1);
$pdf->SetX(125);
// $pdf->Cell(0, 8, '...................., .................... 20....', 0, 2);
$pdf->Cell(0, 8, '...................., ' . tgl(date('Y-m-d')), 0, 2);
$pdf->Cell(125, 8, 'Kepala Sekolah', 0, 2);
$pdf->Ln(20);
$pdf->SetX(125);
$pdf->Cell(125, 8, $kepsek_nm, 0, 2);
$pdf->Cell(125, 8, 'NIP ' . $kepsek_nip, 0, 2);

$pdf->Output('I', $nm_file . ' ' . $nipd);
