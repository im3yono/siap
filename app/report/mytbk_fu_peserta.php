<?php
include_once("../../config/server.php");
require_once("../../assets/vendor/autoload.php");

$dps				= $_POST['tkt'];
$d_username = $_POST['no_ps'];

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use \PhpOffice\PhpSpreadsheet\IOFactory;
use \PhpOffice\PhpSpreadsheet\Writer\IWriter;
use \PhpOffice\PhpSpreadsheet\Reader\IReader;
// use PhpOffice\PhpSpreadsheet\Worksheet\DataValidation;
// use \PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use \PhpOffice\PhpSpreadsheet\Cell\DataValidation;



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$spreadsheet->getActiveSheet()->setTitle('Data Peserta');
$spreadsheet->setActiveSheetIndex(0);

$baris = 1;
// Head
$sheet->setCellValue([1, $baris], 'IP Server')->getColumnDimensionByColumn(1)->setAutoSize(true);
$sheet->setCellValue([2, $baris], 'NIS')->getColumnDimensionByColumn(2)->setAutoSize(true);
$sheet->setCellValue([3, $baris], 'Nama Peserta')->getColumnDimensionByColumn(3)->setAutoSize(true);
$sheet->setCellValue([4, $baris], 'Tempat Lahir')->getColumnDimensionByColumn(4)->setAutoSize(true);
$sheet->setCellValue([5, $baris], 'Tanggal Lahir dd/mm/yy')->getColumnDimensionByColumn(5)->setWidth(13);
$sheet->setCellValue([6, $baris], 'Kode Kelas')->getColumnDimensionByColumn(6)->setWidth(10);
$sheet->setCellValue([7, $baris], 'Jenis Kelamin')->getColumnDimensionByColumn(7)->setWidth(10);
$sheet->setCellValue([8, $baris], 'Nama File Foto')->getColumnDimensionByColumn(8)->setAutoSize(true);
$sheet->setCellValue([9, $baris], 'Username')->getColumnDimensionByColumn(9)->setAutoSize(true);
$sheet->setCellValue([10, $baris], 'Password')->getColumnDimensionByColumn(10)->setAutoSize(true);
$sheet->setCellValue([11, $baris], 'Sesi')->getColumnDimensionByColumn(11)->setAutoSize(true);
$sheet->setCellValue([12, $baris], 'Ruang')->getColumnDimensionByColumn(12)->setAutoSize(true);


$sheet->getStyle([1, $baris, 12, $baris])->getFont()->setBold(true);
$sheet->getStyle([1, $baris, 12, $baris])
	->getAlignment()
	->setWrapText(true)
	->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER) // Atur horizontal alignment ke tengah
	->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER); // Atur vertical alignment ke tengah



// body
$mdt_kls = db_Proses(db_Mytbk(), "SELECT * FROM kelas ORDER BY nm_kls ASC");

// Menyiapkan data validasi list (daftar pilihan kelas)
while ($data = $mdt_kls->fetch(PDO::FETCH_ASSOC)) {
	$pilihan[] = $data['kd_kls'];
}
$i = 1;
foreach ($dps as $kls):
	$dt_rombel = db_Proses($pdo_conn, "SELECT kls FROM tb_kls WHERE tkt = ? ORDER BY kls ASC;", [$kls]);
	while ($r = $dt_rombel->fetch(PDO::FETCH_ASSOC)):
		$d_sis = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE kls = ? ORDER BY `kls` ASC;", [$r['kls']]);
		while ($r_sis = $d_sis->fetch(PDO::FETCH_ASSOC)):
			$jk = ['L', 'P'];
			$jml =  10;
			// for ($i = 1; $i <= $jml; $i++) {
			// Menentukan sel atau rentang sel untuk data validasi list
			$nis 	= [2, $baris + $i];
			$nm 	= [3, $baris + $i];
			$tmp_l = [4, $baris + $i];
			$tgl_l = [5, $baris + $i];
			$kls 	= [6, $baris + $i];
			$jkl 	= [7, $baris + $i];
			$img 	= [8, $baris + $i];
			$user = [9, $baris + $i];
			$pass = [10, $baris + $i];

			$sheet->getStyle([5, $baris + $i])->getNumberFormat()->setFormatCode('dd/mm/yy');
			// Membuat objek data validasi list
			$dv = $sheet->getCell($kls)->getDataValidation();
			$dv->setType(DataValidation::TYPE_LIST)
				->setErrorStyle(DataValidation::STYLE_STOP)
				->setAllowBlank(false)
				->setShowDropDown(true)
				->setShowInputMessage(true)
				->setShowErrorMessage(true)
				->setErrorTitle('Kesalahan Validasi')
				->setError('Harap pilih nilai dari daftar.')
				->setPromptTitle('Pilih dari Daftar')
				->setPrompt('Pilih salah satu dari daftar berikut.')
				->setFormula1('"' . implode(',', $pilihan) . '"');

			// Membuat objek data validasi list
			$dv2 = $sheet->getCell($jkl)->getDataValidation();
			$dv2->setType(DataValidation::TYPE_LIST)
				->setErrorStyle(DataValidation::STYLE_STOP)
				->setAllowBlank(false)
				->setShowDropDown(true)
				->setShowInputMessage(true)
				->setShowErrorMessage(true)
				->setErrorTitle('Kesalahan Validasi')
				->setError('Harap pilih nilai dari daftar.')
				->setPromptTitle('Pilih dari Daftar')
				->setPrompt('Pilih salah satu dari daftar berikut.')
				->setFormula1('"' . implode(',', ['L', 'P']) . '"');

			$sheet->setCellValue($img, 'noavatar.png');
			$dv4 = $sheet->getCell($img)->getDataValidation();
			$dv4->setShowInputMessage(true)
				->setPromptTitle('Nama dan Format File')
				->setPrompt('Perhatikan nama dan format file jangan sampai tertiggal
		contoh format yg diterima.
		Gambar = JPG, JPEG, PNG');

			// // $sheet->setCellValue($pass, '=RANDBETWEEN(3000,9999)&"*"');
			// $notbl < "100" ? $notbl = '00' . $notbl : $notbl;
			// $notbl < "10" ? $notbl = '000' . $notbl : $notbl;
			if ($notbl < 100 && $notbl < 10) {
				$notbl = '00' . $notbl;
			} elseif ($notbl < 100) {
				$notbl = '0' . $notbl;
			}


			$sheet->setCellValue($nis, $r_sis['nipd']);
			$sheet->setCellValue($nm, $r_sis['nm']);
			$sheet->setCellValue($tmp_l, f_nama($r_sis['tmp_lahir']));
			$sheet->setCellValue($tgl_l, $r_sis['tgl_lahir']);
			$sheet->setCellValue($kls, 'siap_' . str_replace(" ", "", $r_sis['kls']));
			$sheet->setCellValue($jkl, $r_sis['jk']);
			$sheet->setCellValue($user, $d_username . $notbl++);
			// $sheet->setCellValue($user, $dps . $notbl++);
			$sheet->setCellValue($pass, rand(1234, 9999) . '*');
			// $sheet->setCellValue($jk, 'tes');
			// }
			$i++;
		endwhile;
	endwhile;
endforeach;

$styleArray = [
	'borders' => [
		'allBorders' => [
			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
		],
	],
];
// $i = $i - 1;
$sheet->getStyle([1, $baris, 12, $baris + $i])->applyFromArray($styleArray);

// Output
// header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Data_Upload_Peserta_MyTBK.xlsx"');
header('Cache-Control: max-age=0');

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, "Xlsx");
$writer->save('php://output');

// DEMO
// $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
// $writer->save("demo.xlsx");
