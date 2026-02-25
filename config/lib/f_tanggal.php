<?php

function tgl_hari($waktu)
{
	if ($waktu == "0000-00-00") {
		return '-';
	}
	$hari_array = array(
		'Minggu',
		'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu'
	);
	$hr = date('w', strtotime($waktu));
	$hari = $hari_array[$hr];
	$tanggal = date('j', strtotime($waktu));
	$bulan_array = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember',
	);
	$bl = date('n', strtotime($waktu));
	$bulan = $bulan_array[$bl];
	$tahun = date('Y', strtotime($waktu));
	$jam = date('H:i:s', strtotime($waktu));

	//untuk menampilkan hari, tanggal bulan tahun jam
	//return "$hari, $tanggal $bulan $tahun $jam";

	//untuk menampilkan hari, tanggal bulan tahun
	return "$hari, $tanggal $bulan $tahun";
}

function tgl($tgl, $format = 'Y-M-D')
{
	$tanggal = date('j', strtotime($tgl));
	$bulan_array = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember',
	);
	$bl = date('n', strtotime($tgl));
	$bulan = $bulan_array[$bl];
	$tahun = date('Y', strtotime($tgl));
	$jam = date('H:i:s', strtotime($tgl));

	//untuk menampilkan hari, tanggal bulan tahun jam
	//return "$hari, $tanggal $bulan $tahun $jam";

	//untuk menampilkan hari, tanggal bulan tahun
	if ($format == 'Y-M-D') {
		return "$tanggal $bulan $tahun";
	} elseif ($format == 'Y-M') {
		return "$bulan $tahun";
	} elseif ($format == 'Y') {
		return "$tahun";
	} else {
		return "$tanggal $bulan $tahun";
	}
}
function tglJam($tgl, $format = 'Y-M-D')
{
	$hari_array = array(
		'Minggu',
		'Senin',
		'Selasa',
		'Rabu',
		'Kamis',
		'Jumat',
		'Sabtu'
	);
	$hr = date('w', strtotime($tgl));
	$hari = $hari_array[$hr];

	$tanggal = date('j', strtotime($tgl));
	$bulan_array = array(
		1 => 'Januari',
		2 => 'Februari',
		3 => 'Maret',
		4 => 'April',
		5 => 'Mei',
		6 => 'Juni',
		7 => 'Juli',
		8 => 'Agustus',
		9 => 'September',
		10 => 'Oktober',
		11 => 'November',
		12 => 'Desember',
	);
	$bl = date('n', strtotime($tgl));
	$bulan = $bulan_array[$bl];
	$tahun = date('Y', strtotime($tgl));
	$jam = date('H:i:s', strtotime($tgl));

	//untuk menampilkan hari, tanggal bulan tahun jam
	//return "$hari, $tanggal $bulan $tahun $jam";

	//untuk menampilkan hari, tanggal bulan tahun
	if ($format == 'Y-M-D') {
		return "$tanggal $bulan $tahun";
	} elseif ($format == 'Y-M') {
		return "$bulan $tahun";
	} elseif ($format == 'Y') {
		return "$tahun";
	} else {
		return "$hari, $tanggal $bulan $tahun. $jam";
	}
}

function menitToJam($time, $format = '00:00')
{
	if ($time < 1) {
		return;
	}
	$hours = floor($time / 60);
	$minutes = ($time % 60);
	if ($format == '00:00:00') {
		// Format jam, menit, detik
		$seconds = 0; // Set detik ke 0 jika tidak ada
		return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
	} elseif ($format == '00:00') {
		// Format jam dan menit
		return sprintf('%02d:%02d', $hours, $minutes);
	} elseif ($format == '00') {
		// Format hanya jam
		return sprintf('%02d', $hours);
	} else {
		return sprintf('%02d:%02d', $hours, $minutes);
	}
}

function selisihJamToMenit($time_awal, $time_akhir)
{
	$waktu_awal		= $time_awal;
	$waktu_akhir	= $time_akhir;

	$awal  = strtotime(($waktu_awal));
	$akhir = strtotime(($waktu_akhir));
	$diff  = ($akhir - $awal) / 60;

	return $diff;
}

function selisihJam($time_awal, $time_akhir)
{
	// $rubah =strtotime($time)-strtotime("00:00:00");

	// $jam = floor($rubah/60);
	// $menit = ($rubah-($jam * 3600)) / 60;

	$waktu_awal		= $time_awal;
	$waktu_akhir	= $time_akhir; // bisa juga waktu sekarang now()

	$awal  = strtotime(($waktu_awal));
	$akhir = strtotime(($waktu_akhir));
	// $awal  = strtotime("08:00:00");
	// $akhir = strtotime("02:00:00");

	$nol = strtotime("00:00:00");
	$diff  = ($awal - $nol) + ($akhir - $nol);

	$jam   = floor($diff / (60 * 60));
	$menit = $diff - ($jam * (60 * 60));
	$detik = $diff % 60;

	$jmak  = floor($jam / (60 * 60));
	$minak = $menit - ($jmak * (60 * 60));
	$selisih = (($jmak * 60) + floor($minak / 60));
	return sprintf($selisih);
}

function db_JamToMenit($timeDB)
{
	list($jam, $menit, $detik) = explode(':', $timeDB);

	return ($jam * 60) + $menit;
}

function jamZone($time)
{
	$jam = date('H:i', strtotime($time));
	$zone = date_default_timezone_get();
	if ($zone == "Asia/Makassar") {
		$jam = $jam . " WITA";
	} else if ($zone == "Asia/Jakarta") {
		$jam = $jam . " WIB";
	} else if ($zone == "Asia/Jayapura") {
		$jam = $jam . " WIT";
	} else if ($zone == "Asia/Makassar") {
		$jam = $jam . " WITA";
	}
	// $jam = str_replace(":", ":", $jam);
	return $jam;
}

function tambahJam($awal, $tambah)
{

	// Ubah jadi objek DateTime
	$time1 = new DateTime($awal);
	$time2 = new DateTime($tambah);

	// Konversi waktu tambahan menjadi interval
	$interval = DateInterval::createFromDateString($time2->format("H") . " hours " . $time2->format("i") . " minutes " . $time2->format("s") . " seconds");

	// Tambahkan interval ke waktu awal
	$time1->add($interval);

	// Tampilkan hasil
	return $time1->format("H:i:s"); // Output: 12:36:00

}

function f_bln_ta($ta, $bln)
{
	$bln_ta = explode('/', $ta);
	if ($bln > 6) {
		return $bln_ta[1];
	} else {
		return $bln_ta[0];
	}
}

function f_bulan_nama($bln)
{
	$bln = (string)$bln;
	switch ($bln) {
		case '1':
		case '01':
			return 'Januari';
		case '2':
		case '02':
			return 'Februari';
		case '3':
		case '03':
			return 'Maret';
		case '4':
		case '04':
			return 'April';
		case '5':
		case '05':
			return 'Mei';
		case '6':
		case '06':
			return 'Juni';
		case '7':
		case '07':
			return 'Juli';
		case '8':
		case '08':
			return 'Agustus';
		case '9':
		case '09':
			return 'September';
		case '10':
			return 'Oktober';
		case '11':
			return 'November';
		case '12':
			return 'Desember';
		default:
			return str_repeat(chr(160), 16); // non-breaking spaces for FPDF
	}
}

function f_tglIndoKeSql($tanggal)
{
	$bulan = [
		'Januari' => '01',
		'Februari' => '02',
		'Maret' => '03',
		'April' => '04',
		'Mei' => '05',
		'Juni' => '06',
		'Juli' => '07',
		'Agustus' => '08',
		'September' => '09',
		'Oktober' => '10',
		'November' => '11',
		'Desember' => '12'
	];

	$pecah = explode(' ', $tanggal);
	return $pecah[2] . '-' . $bulan[$pecah[1]] . '-' . str_pad($pecah[0], 2, '0', STR_PAD_LEFT);
}

