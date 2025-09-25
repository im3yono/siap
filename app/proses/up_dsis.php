<?php
require_once("../../config/server.php");
require_once("../../assets/vendor/autoload.php");


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;

$dt = $_FILES['file'];

if (isset($dt)) {
	$file = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	$start = 2;
	$dt_pr_in = 0;
	$dt_pr_up = 0;

	if (isset($dt) && in_array($dt['type'], $file)) {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader->setLoadSheetsOnly("Data Siswa");
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($dt['tmp_name']);
		$Data = $spreadsheet->getActiveSheet()->toArray();
		$baris = count($Data);

		for ($i = $start; $i < $baris; $i++) {
			$nipd 			= $Data[$i][1];
			$nm 				= addslashes(f_nama($Data[$i][2]));
			$jk 				= $Data[$i][3];
			$nisn 			= $Data[$i][4];
			$tmp_lahir 	= $Data[$i][5];
			// $tgl_lahir = $Data[$i][6];
			if (!empty($Data[$i][6])) {
				if ($Data[$i][6] != date('Y-m-d', strtotime($Data[$i][6]))) {
					# code...
					$dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Data[$i][6]);
					$tgl_lahir = $dateObj->format('Y-m-d'); // Format menjadi yyyy-mm-dd
				} else {
					$tgl_lahir = $Data[$i][6];
				}
			} else {
				$tgl_lahir = null; // Atur menjadi null jika kosong
			}
			$nik 			= $Data[$i][7];
			$nkk 			= $Data[$i][8];
			$agm 			= $Data[$i][9];
			$almt_arr = array(
				"almt" 	=> addslashes($Data[$i][10]),
				"rt" 		=> $Data[$i][11],
				"rw" 		=> $Data[$i][12],
				"dusun" => addslashes($Data[$i][13]),
				"kel" 	=> addslashes($Data[$i][14]),
				"kec" 	=> addslashes($Data[$i][15]),
				"kdpos" => $Data[$i][16]
			);
			$almt 		= json_encode($almt_arr);
			$tmp_tinggal 	= $Data[$i][17];
			$trasport 		= $Data[$i][18];
			$tlp_hp = json_encode(array(
				"tlp" => addslashes($Data[$i][19]),
				"hp" 	=> addslashes($Data[$i][20])
			));
			$email 		= $Data[$i][21]??'';
			$ayah 		= json_encode(array(
				"nik" 	=> addslashes($Data[$i][22]),
				"nm" 		=> addslashes(f_nama($Data[$i][23])),
				"thn_l" => $Data[$i][24],
				"almt" 	=> addslashes($Data[$i][25]),
				"pddk" 	=> addslashes($Data[$i][26]),
				"kerja" => addslashes($Data[$i][27]),
				"upah" 	=> addslashes($Data[$i][28])
			));
			$ibu 		= json_encode(array(
				"nik" => addslashes($Data[$i][29]),
				"nm" 	=> addslashes(f_nama($Data[$i][30])),
				"thn_l" => $Data[$i][31],
				"almt" 	=> addslashes($Data[$i][32]),
				"pddk" 	=> addslashes($Data[$i][33]),
				"kerja" => addslashes($Data[$i][34]),
				"upah" 	=> addslashes($Data[$i][35])
			));
			$wali 		= json_encode(array(
				"nik" 	=> addslashes($Data[$i][36]),
				"nm" 		=> addslashes(f_nama($Data[$i][37])),
				"thn_l" => addslashes($Data[$i][38]),
				"almt" 	=> addslashes($Data[$i][39]),
				"pddk" 	=> addslashes($Data[$i][40]),
				"kerja" => addslashes($Data[$i][41]),
				"upah" 	=> addslashes($Data[$i][42])
			));
			$masuk 	= $Data[$i][43];
			$kls 		= $Data[$i][44];
			$akta 		= $Data[$i][45]??'';
			$disabel 	= $Data[$i][46]??'';
			$sklh_asl = $Data[$i][47]??'';
			$saudr 		= json_encode(array(
				"sdr" 	=> $Data[$i][48],
				"ke" 		=> $Data[$i][49]
			));
			$bb_tb_lk = json_encode(array(
				"bb" 		=> $Data[$i][50],
				"tb" 		=> $Data[$i][51],
				"lk" 		=> $Data[$i][52]
			));
			$jrk_rmh 	= $Data[$i][53]??'';

			// SQL Insert
			$sql_in = "INSERT INTO tb_dsis (
					id_dsis, nipd, nisn, nm, jk, tmp_lahir, tgl_lahir, nik, nkk, agm, almt, tmp_tinggal,
					trasport, `tlp/hp`, email, ayah, ibu, wali, masuk, kls, no_akta, disabel, sklh_asl,
					saudr, bb_tb_lk, jrk_rmh, sts, rcd, upd
			) VALUES (
					NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Y', current_timestamp(), current_timestamp()
			)";

			// SQL Update
			$sql_up = "UPDATE tb_dsis SET
					nisn = ?, nm = ?, jk = ?, tmp_lahir = ?, tgl_lahir = ?, nik = ?, nkk = ?, agm = ?,
					almt = ?, tmp_tinggal = ?, trasport = ?, `tlp/hp` = ?, email = ?, ayah = ?, ibu = ?,
					wali = ?, masuk = ?, kls = ?, no_akta = ?, disabel = ?, sklh_asl = ?, saudr = ?,
					bb_tb_lk = ?, jrk_rmh = ?, upd = current_timestamp()
			WHERE nipd = ?";

			// Cek data berdasarkan NIPD
			$ck_dt = $pdo_conn->prepare("SELECT * FROM tb_dsis WHERE nipd='$nipd'");
			$ck_dt->execute();
			if (empty($ck_dt->rowCount())) {

			$stmt_in = $pdo_conn->prepare($sql_in);
			$stmt_in->execute([
					$nipd, $nisn, $nm, $jk, $tmp_lahir, $tgl_lahir, $nik, $nkk, $agm, $almt, $tmp_tinggal,
					$trasport, $tlp_hp, $email, $ayah, $ibu, $wali, $masuk, $kls, $akta, $disabel,
					$sklh_asl, $saudr, $bb_tb_lk, $jrk_rmh
			]);
			$dt_pr_in++;
			} else {
			$stmt_up = $pdo_conn->prepare($sql_up);
			$stmt_up->execute([
					$nisn, $nm, $jk, $tmp_lahir, $tgl_lahir, $nik, $nkk, $agm,
					$almt, $tmp_tinggal, $trasport, $tlp_hp, $email, $ayah, $ibu,
					$wali, $masuk, $kls, $akta, $disabel, $sklh_asl, $saudr,
					$bb_tb_lk, $jrk_rmh, $nipd
			]);
			$dt_pr_up++;
			}
			// $output = ['progress' => ceil(($dt_pr_up / ($baris - $start)) * 100)];
			// echo json_encode($output);
			// $pr = ceil(($dt_pr_up / ($baris - $start)) * 100);
			// echo $pr;
		}
		// echo ceil(($dt_pr_up / ($baris - $start)) * 100);
		echo "Sukses upload $dt_pr_up data siswa. <br>Berhasil menambahkan $dt_pr_in data siswa baru.<br>Berhasil memperbarui $dt_pr_up data siswa.";
	}
}
