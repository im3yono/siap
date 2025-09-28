<!-- 
INSERT INTO `tb_dstaf` (`id_dstaf`, `id_staf`, `nm_staf`, `nik`, `nkk`, `nuptk`, `nip`, `jk`, `tmp_l`, `tgl_l`, `ppdk`, `glar`, `sklh_univ`, `stt_pgw`, `jptk`, `agm`, `almt`, `kontak`, `tgs_tmbh`, `sk_cpns`, `tgl_cpns`, `sk_pengaktn`, `tmt_angkt`, `lbg_angkt`, `pngkat_gl`, `sgaji`, `nm_ibu`, `sts_kwn`, `psngn`, `tmt_pns`, `npwp`, `nm_npwp`, `warga`, `rcd`, `upd`, `sts`) VALUES (NULL, '1', '1', '1', '1', '1', '1', 'L', '1', '2025-09-25', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2025-09-25', '1', '2025-09-25', '1', '1', '1', '1', '1', '1', '2025-09-25', '1', '1', '1', current_timestamp(), current_timestamp(), 'Y');
-->

<?php
require_once("../../config/server.php");
require_once("../../assets/vendor/autoload.php");


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;

$dt = $_FILES['file'];

if (isset($dt)) {
	$file = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

	$start = 1;
	$dt_pr_in = 0;
	$dt_pr_up = 0;

	if (isset($dt) && in_array($dt['type'], $file)) {
		$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
		$reader->setLoadSheetsOnly("Data Staf");
		$reader->setReadDataOnly(true);
		$spreadsheet = $reader->load($dt['tmp_name']);
		$Data = $spreadsheet->getActiveSheet()->toArray();
		$baris = count($Data);

		for ($i = $start; $i < $baris; $i++) {
			$id_staf     = $Data[$i][1];
			$nm_staf     = f_nama($Data[$i][2]);
			$nik         = $Data[$i][3];
			$nkk         = $Data[$i][4]??'';
			$nuptk       = $Data[$i][5]??'-';
			$nip         = $Data[$i][6]??'-';
			$jk         = $Data[$i][7];
			$tmp_lahir   = $Data[$i][8];
			// $tgl_lahir = $Data[$i][9];
			if (!empty($Data[$i][9])) {
				if ($Data[$i][9] != date('Y-m-d', strtotime($Data[$i][9]))) {
					# code...
					$dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Data[$i][9]);
					$tgl_lahir = $dateObj->format('Y-m-d'); // Format menjadi yyyy-mm-dd
				} else {
					$tgl_lahir = $Data[$i][9];
				}
			} else {
				$tgl_lahir = null; // Atur menjadi null jika kosong
			}
			$ppdk       = $Data[$i][10]??'';
			$glar       = $Data[$i][11]??'';
			$sklh_univ   = $Data[$i][12]??'';
			$stt_pgw     = $Data[$i][13]??'';
			$jptk       = $Data[$i][14];
			$agm         = $Data[$i][15];
			$almt_arr = array(
				"almt"   => ($Data[$i][16]),
				"rt"     => $Data[$i][17],
				"rw"     => $Data[$i][18]??'',
				"dusun" => ($Data[$i][19]??''),
				"kel"   => ($Data[$i][20]),
				"kec"   => ($Data[$i][21]),
				"kdpos" => $Data[$i][22]??''
			);
			$almt     = json_encode($almt_arr);
			$kontak_arr = array(
				"tlp" => ($Data[$i][23]??''),
				"hp"   => ($Data[$i][24]??''),
				"email" => ($Data[$i][25]??'')
			);
			$kontak     = json_encode($kontak_arr);
			$tgs_tmbh   = $Data[$i][26]??'';
			$sk_cpns     = $Data[$i][27]??'';
			// $tgl_cpns = $Data[$i][28];
			if (!empty($Data[$i][28])) {
				if ($Data[$i][28] != date('Y-m-d', strtotime($Data[$i][28]))) {
					# code...
					$dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Data[$i][28]);
					$tgl_cpns = $dateObj->format('Y-m-d'); // Format menjadi yyyy-mm-dd
				} else {
					$tgl_cpns = $Data[$i][28];
				}
			} else {
				$tgl_cpns = ''; // Atur menjadi null jika kosong
			}
			$sk_pengaktn = $Data[$i][29];
			// $tmt_angkt = $Data[$i][30];
			if (!empty($Data[$i][30])) {
				if ($Data[$i][30] != date('Y-m-d', strtotime($Data[$i][30]))) {
					# code...
					$dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Data[$i][30]);
					$tmt_angkt = $dateObj->format('Y-m-d'); // Format menjadi yyyy-mm-dd
				} else {
					$tmt_angkt = $Data[$i][30];
				}
			} else {
				$tmt_angkt = ''; // Atur menjadi null jika kosong
			}
			$lbg_angkt   = $Data[$i][31]??'';
			$pngkat_gl   = $Data[$i][32]??'';
			$sgaji     = $Data[$i][33]??'';
			$nm_ibu     = (f_nama($Data[$i][34]));
			$sts_kwn     = $Data[$i][35];
			$psngan    = json_encode(array(
				"nm"   => (f_nama($Data[$i][36]??'')),
				"nip" => $Data[$i][37]??'',
				"kerja"   => ($Data[$i][38]??'')
			));
			// $tmt_pns = $Data[$i][40];
			if (!empty($Data[$i][39])) {
				if ($Data[$i][39] != date('Y-m-d', strtotime($Data[$i][39]))) {
					# code...
					$dateObj = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Data[$i][39]);
					$tmt_pns = $dateObj->format('Y-m-d'); // Format menjadi yyyy-mm-dd
				} else {
					$tmt_pns = $Data[$i][39];
				}
			} else {
				$tmt_pns = ''; // Atur menjadi null jika kosong
			}
			$npwp     = $Data[$i][40]??'';
			$nm_npwp   = ($Data[$i][41]??'');
			$warga     = $Data[$i][42];
			$rcd       = date('Y-m-d H:i:s');
			$upd       = date('Y-m-d H:i:s');
			$sts       = 'Y';

			
			// Cek apakah data dengan id_staf sudah ada
			$stmt = $pdo_conn->prepare("SELECT COUNT(*) FROM tb_dstaf WHERE id_staf = :id_staf");
			$stmt->bindParam(':id_staf', $id_staf);
			$stmt->execute();
			$count = $stmt->fetchColumn();
			if ($count > 0) {
				// Jika ada, lakukan update
				$sql = "UPDATE tb_dstaf SET 
                nm_staf = :nm_staf,
                nik = :nik,
                nkk = :nkk,
                nuptk = :nuptk,
                nip = :nip,
                jk = :jk,
                tmp_l = :tmp_l,
                tgl_l = :tgl_l,
                ppdk = :ppdk,
                glar = :glar,
                sklh_univ = :sklh_univ,
                stt_pgw = :stt_pgw,
                jptk = :jptk,
                agm = :agm,
                almt = :almt,
                kontak = :kontak,
                tgs_tmbh = :tgs_tmbh,
                sk_cpns = :sk_cpns,
                tgl_cpns = :tgl_cpns,
                sk_pengaktn = :sk_pengaktn,
                tmt_angkt = :tmt_angkt,
                lbg_angkt = :lbg_angkt,
                pngkat_gl = :pngkat_gl,
                sgaji = :sgaji,
                nm_ibu = :nm_ibu,
                sts_kwn = :sts_kwn,
                psngn = :psngn,
                tmt_pns = :tmt_pns,
                npwp = :npwp,
                nm_npwp = :nm_npwp,
                warga = :warga,
                upd = :upd
              WHERE id_staf = :id_staf";
				$stmt = $pdo_conn->prepare($sql);
				$stmt->bindParam(':id_staf', $id_staf);
				$stmt->bindParam(':nm_staf', $nm_staf);
				$stmt->bindParam(':nik', $nik);
				$stmt->bindParam(':nkk', $nkk);
				$stmt->bindParam(':nuptk', $nuptk);
				$stmt->bindParam(':nip', $nip);
				$stmt->bindParam(':jk', $jk);
				$stmt->bindParam(':tmp_l', $tmp_lahir);
				$stmt->bindParam(':tgl_l', $tgl_lahir);
				$stmt->bindParam(':ppdk', $ppdk);
				$stmt->bindParam(':glar', $glar);
				$stmt->bindParam(':sklh_univ', $sklh_univ);
				$stmt->bindParam(':stt_pgw', $stt_pgw);
				$stmt->bindParam(':jptk', $jptk);
				$stmt->bindParam(':agm', $agm);
				$stmt->bindParam(':almt', $almt);
				$stmt->bindParam(':kontak', $kontak);
				$stmt->bindParam(':tgs_tmbh', $tgs_tmbh);
				$stmt->bindParam(':sk_cpns', $sk_cpns);
				$stmt->bindParam(':tgl_cpns', $tgl_cpns);
				$stmt->bindParam(':sk_pengaktn', $sk_pengaktn);
				$stmt->bindParam(':tmt_angkt', $tmt_angkt);
				$stmt->bindParam(':lbg_angkt', $lbg_angkt);
				$stmt->bindParam(':pngkat_gl', $pngkat_gl);
				$stmt->bindParam(':sgaji', $sgaji);
				$stmt->bindParam(':nm_ibu', $nm_ibu);
				$stmt->bindParam(':sts_kwn', $sts_kwn);
				$stmt->bindParam(':psngn', $psngan);
				$stmt->bindParam(':tmt_pns', $tmt_pns);
				$stmt->bindParam(':npwp', $npwp);
				$stmt->bindParam(':nm_npwp', $nm_npwp);
				$stmt->bindParam(':warga', $warga);
				$stmt->bindParam(':upd', $upd);
				$stmt->execute();
				$dt_pr_up++;
			} else {
				// Jika tidak ada, lakukan insert baru
				$sql = "INSERT INTO tb_dstaf (
                id_staf, nm_staf, nik, nkk, nuptk, nip, jk, tmp_l, tgl_l, ppdk, glar,
                sklh_univ, stt_pgw, jptk, agm, almt, kontak, tgs_tmbh, sk_cpns,
                tgl_cpns, sk_pengaktn, tmt_angkt, lbg_angkt, pngkat_gl, sgaji,
                nm_ibu, sts_kwn, psngn, tmt_pns, npwp, nm_npwp, warga,
                rcd, upd, sts
              ) VALUES (
                :id_staf, :nm_staf, :nik, :nkk, :nuptk, :nip, :jk, :tmp_l, :tgl_l,
                :ppdk, :glar, :sklh_univ, :stt_pgw, :jptk, :agm, :almt,
                :kontak, :tgs_tmbh, :sk_cpns, :tgl_cpns, :sk_pengaktn,
                :tmt_angkt, :lbg_angkt, :pngkat_gl, :sgaji,
                :nm_ibu, :sts_kwn, :psngn, :tmt_pns,
                :npwp, :nm_npwp, :warga,
                :rcd, :upd, :sts
              )";
				$stmt = $pdo_conn->prepare($sql);
				$stmt->bindParam(':id_staf', $id_staf);
				$stmt->bindParam(':nm_staf', $nm_staf);
				$stmt->bindParam(':nik', $nik);
				$stmt->bindParam(':nkk', $nkk);
				$stmt->bindParam(':nuptk', $nuptk);
				$stmt->bindParam(':nip', $nip);
				$stmt->bindParam(':jk', $jk);
				$stmt->bindParam(':tmp_l', $tmp_lahir);
				$stmt->bindParam(':tgl_l', $tgl_lahir);
				$stmt->bindParam(':ppdk', $ppdk);
				$stmt->bindParam(':glar', $glar);
				$stmt->bindParam(':sklh_univ', $sklh_univ);
				$stmt->bindParam(':stt_pgw', $stt_pgw);
				$stmt->bindParam(':jptk', $jptk);
				$stmt->bindParam(':agm', $agm);
				$stmt->bindParam(':almt', $almt);
				$stmt->bindParam(':kontak', $kontak);
				$stmt->bindParam(':tgs_tmbh', $tgs_tmbh);
				$stmt->bindParam(':sk_cpns', $sk_cpns);
				$stmt->bindParam(':tgl_cpns', $tgl_cpns);
				$stmt->bindParam(':sk_pengaktn', $sk_pengaktn);
				$stmt->bindParam(':tmt_angkt', $tmt_angkt);
				$stmt->bindParam(':lbg_angkt', $lbg_angkt);
				$stmt->bindParam(':pngkat_gl', $pngkat_gl);
				$stmt->bindParam(':sgaji', $sgaji);
				$stmt->bindParam(':nm_ibu', $nm_ibu);
				$stmt->bindParam(':sts_kwn', $sts_kwn);
				$stmt->bindParam(':psngn', $psngan);
				$stmt->bindParam(':tmt_pns', $tmt_pns);
				$stmt->bindParam(':npwp', $npwp);
				$stmt->bindParam(':nm_npwp', $nm_npwp);
				$stmt->bindParam(':warga', $warga);
				$stmt->bindParam(':rcd', $rcd);
				$stmt->bindParam(':upd', $upd);
				$stmt->bindParam(':sts', $sts);
				$stmt->execute();
				$dt_pr_in++;
			}
			// $output = ['progress' => ceil(($dt_pr_up / ($baris - $start)) * 100)];
			// echo json_encode($output);
			// $pr = ceil(($dt_pr_up / ($baris - $start)) * 100);
			// echo $pr;
		}
		echo "Data berhasil diupload. <br>Data baru: $dt_pr_in <br>Data diperbarui: $dt_pr_up.";
	} else {
		echo "Format file tidak valid. Harap unggah file Excel (.xlsx) yang sesuai.";
	}
} else {
	echo "Tidak ada file yang diunggah.";
}
?>