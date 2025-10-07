<?php

$config = [
	'a4' => [
		'L' => [
			'size' => [210, 297],
			'jt' => 4,
			'j_L' => 45,
			'j_C' => 30,
			'j_R' => 25,
			'js_L' => 45,
			'js_C' => 90,
			'js_R' => 60,
			'h_no' => 7,
			'h_nm' => 43,
			'h_dh' => 42,
			'h_dh_np' => 17,
			'h_np_jk' => 5,
			'h_dh_no' => 5,
			'h_dn' => 35,
			'h_dn_no' => 7,
			'h_ket' => 10,
			'h_ket2' => 18,
			'h_ctt' => 60,
			'rw27' => [90, 20],
			'rw32' => [90, 20],
			'rw28' => [20, 70, 20],
			'rw29' => [20, 70, 20],
			'rw33' => [20, 70, 20],
			'rw34' => [20, 70, 20],
			'jrk' => 1.5,
			'jrk2' => 2,
			'th_tbl' => 5,
			'th_tbl2' => 10,
			'skt_nm' => 2
		],
		'P' => [
			'size' => [210, 297],
			'jt' => 4,
			'j_L' => 26,
			'j_R' => 35,
			'js_L' => 55,
			'js_R' => 60,
			'h_no' => 5,
			'h_nm' => 38,
			'h_dh' => 37,
			'h_dh_np' => 17,
			'h_np_jk' => 5,
			'h_dh_no' => 4,
			'h_dn' => 20,
			'h_dn_no' => 4,
			'h_ket' => 7,
			'h_ket2' => 13,
			'h_ctt' => 37,
			'rw27' => [130, 20],
			'rw32' => [130, 20],
			'rw28' => [20, 110, 20],
			'rw29' => [20, 110, 20],
			'rw33' => [20, 110, 20],
			'rw34' => [20, 110, 20],
			'jrk' => 1.5,
			'jrk2' => 2,
			'th_tbl' => 5,
			'th_tbl2' => 10,
			'skt_nm' => 2
		]
	],
	'f4' => [
		'L' => [
			'size' => [210, 330],
			'jt' => 4,
			'j_L' => 45,
			'j_C' => 35,
			'j_R' => 30,
			'js_L' => 55,
			'js_C' => 100,
			'js_R' => 60,
			'h_no' => 7,
			'h_nm' => 55,
			'h_dh' => 45,
			'h_dh_np' => 20,
			'h_np_jk' => 5,
			'h_dh_no' => 5,
			'h_dn' => 35,
			'h_dn_no' => 7,
			'h_ket' => 10,
			'h_ket2' => 18,
			'h_ctt' => 70,
			'rw27' => [90, 20],
			'rw32' => [90, 20],
			'rw28' => [20, 70, 20],
			'rw29' => [20, 70, 20],
			'rw33' => [20, 70, 20],
			'rw34' => [20, 70, 20],
			'jrk' => 1.5,
			'jrk2' => 2,
			'th_tbl' => 5,
			'th_tbl2' => 10,
			'skt_nm' => 3
		],
		'P' => [
			'size' => [210, 330],
			'jt' => 4,
			'j_L' => 26,
			'j_R' => 35,
			'js_L' => 55,
			'js_R' => 60,
			'h_no' => 5,
			'h_nm' => 38,
			'h_dh' => 37,
			'h_dh_np' => 17,
			'h_np_jk' => 5,
			'h_dh_no' => 4,
			'h_dn' => 20,
			'h_dn_no' => 4,
			'h_ket' => 7,
			'h_ket2' => 13,
			'h_ctt' => 37,
			'rw27' => [130, 20],
			'rw32' => [130, 20],
			'rw28' => [20, 110, 20],
			'rw29' => [20, 110, 20],
			'rw33' => [20, 110, 20],
			'rw34' => [20, 110, 20],
			'jrk' => 2,
			'jrk2' => 2,
			'th_tbl' => 5,
			'th_tbl2' => 10,
			'skt_nm' => 2
		]
	]
];

// Ambil konfigurasi sesuai input
$kertas = strtolower($_POST['kertas']);
$cfg = $config[$kertas][$orien];

// Tambahkan halaman
$pdf->AddPage($orien, $cfg['size'], 0);

// Extract variabel biar sama seperti sebelumnya
extract($cfg);


foreach ($kls as $kls) {
	foreach ($kl as $tm) {
		$stmt = $pdo_conn->prepare("SELECT jk FROM tb_dsis WHERE kls = :kls");
		$stmt->bindParam(':kls', $kls);
		$stmt->execute();
		$jml_l = $jml_p = 0;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row['jk'] == 'L') $jml_l++;
			elseif ($row['jk'] == 'P') $jml_p++;
		}
		$jml_l = $jml_l == 0 ? '       ' : $jml_l;
		$jml_p = $jml_p == 0 ? '       ' : $jml_p;

		$dtkls		= db_Proses($pdo_conn, 'SELECT tk.*,tg.nm_staf AS nmgr, tg.glar AS glargr FROM tb_kls tk INNER JOIN tb_dstaf tg ON tk.kd_staf = tg.kd_staf WHERE tk.kls = ?;', [$kls]);
		$dtgr			= $dtkls->fetch(PDO::FETCH_ASSOC);
		$walas 		= $dtgr['nmgr'] ?? '';
		$glr 			= $dtgr['glargr'] ?? '';
		$glr			= $glr == '' ? '' : ', ' . $glr;
		$walas		= $walas == '' ? '' : f_singkatNama($walas, 2) . $glr;

		$pdf->SetFont('Cambria', 'B', 18);

		// Menulis teks
		//Membuat sel 20*10 mm dengan teks rata tengah dan ganti baris
		$pdf->Cell(0, 10, $jdl, 0, 1, 'C');

		// Sub judul dan Informasi Guru, Kelas, Wali Kelas, Jumlah Siswa
		if ($orien == 'L') {
			$pdf->SetFont('Cambria', '', 12);
			$pdf->Cell($j_L, $jt, 'Tahun Ajaran/Semester ', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $thn . ' ' . $smt, 0, 0);
			$pdf->Cell($j_C, $jt, 'Mata Pelajaran', 0, 0);
			$pdf->Cell($js_C, $jt, ': ' . $mpel, 0, 0);
			$pdf->Cell($j_R, $jt, 'Wali Kelas', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $walas, 0, 1);

			$pdf->Cell($j_L, $jt, 'Bulan Pelaksanaan', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $bln, 0, 0);
			$pdf->Cell($j_C, $jt, 'Guru Pengajar', 0, 0);
			$pdf->Cell($js_C, $jt, ': ' . $nm, 0, 0);
			$pdf->Cell($j_R, $jt, 'Laki-Laki', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $jml_l . ' Orang', 0, 1);

			// Wali Kelas dan info lainnya
			$pdf->Cell($j_L, $jt, 'Kelas', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $kls, 0, 0);
			$pdf->Cell($j_C, $jt, 'Alokasi Waktu', 0, 0);
			$pdf->Cell($js_C, $jt, ': ' . $alw . ' Jam Pelajaran, ' . $alt . ' Pertemuan/Pekan', 0, 0);
			$pdf->Cell($j_R, $jt, 'Perempuan', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $jml_p . ' Orang', 0, 1);
		} else {
			$pdf->SetFont('Cambria', '', 12);
			$pdf->Cell($j_L,  $jt, 'TA/Semester ', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $thn . ' ' . $smt, 0, 0);
			$pdf->Cell($j_R,  $jt, 'Bulan Pelaksanaan', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $bln, 0, 1);

			$pdf->Cell($j_L,  $jt, 'Kelas', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $kls, 0, 0);
			$pdf->Cell($j_R,  $jt, 'Mata Pelajaran', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $mpel, 0, 1);

			$pdf->Cell($j_L,  $jt, 'Wali Kelas', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $walas, 0, 0);
			$pdf->Cell($j_R,  $jt, 'Guru Pengajar', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $nm, 0, 1);

			$pdf->Cell($j_L,  $jt, 'Laki-Laki', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $jml_l . ' Orang', 0, 0);
			$pdf->Cell($j_R,  $jt, 'Alokasi Waktu', 0, 0);
			$pdf->Cell($js_R, $jt, ': ' . $alw . ' Jam Pelajaran, ' . $alt . ' Pertemuan/Pekan', 0, 1);

			$pdf->Cell($j_L,  $jt, 'Perempuan', 0, 0);
			$pdf->Cell($js_L, $jt, ': ' . $jml_p . ' Orang', 0, 1);
		}

		// Menambahkan spasi
		$pdf->Ln(2);

		// Tabel header untuk daftar hadir dan nilai
		($tm != 0) ? $tm_np = 5 * $tm : $tm_np = 0;

		$pdf->SetFont('Arial Narrow', '', 12);
		$pdf->Cell($h_no, $th_tbl2, 'No', 1, 0, 'C');
		$pdf->Cell($h_nm, $th_tbl, 'Nama Peserta ', "T", 0, 'C');
		$pdf->Cell($h_dh, $th_tbl, 'Daftar Hadir', 1, 0, 'C', true); // true untuk fill

		$pdf->Cell($jrk);
		$pdf->Cell($h_dn, $th_tbl, 'Daftar Nilai', 1, 0, 'C', true);
		$pdf->Cell($h_ket, $th_tbl2, 'Ket', 1, 0, 'C');
		$pdf->Cell($jrk2);
		$pdf->Cell($h_no, $th_tbl2, 'NP', 1, 0, 'C', true);
		if ($orien == 'L') {
			$pdf->Cell($h_ctt, $th_tbl2, 'TP / Materi Pelajaran/ Pokok Bahasan', 1, 0, 'C', true);
			$pdf->Cell($h_ctt, $th_tbl2, 'Kegiatan Pembelajaran dan Penilaian', 1, 0, 'C', true);
			$pdf->Cell($h_ket2, $th_tbl2, 'Ket**', 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, '', 0, 1, 'C');
		} else {
			$pdf->Cell($h_ctt, ($th_tbl2 / 2), 'TP / Materi Pelajaran', 'LTR', 0, 'C', true);
			$pdf->Cell($h_ctt, ($th_tbl2 / 2), 'Kegiatan Pembelajaran', 'LTR', 0, 'C', true);
			$pdf->Cell($h_ket2, $th_tbl2, 'Ket**', 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, '', 0, 1, 'C');
		}

		$pdf->Cell($h_no, $th_tbl, '', 0, 0, 'C');
		$pdf->Cell($h_nm, $th_tbl, 'Didik', 0, 0, 'C');
		$pdf->Cell($h_dh_np, $th_tbl, 'NP*', 1, 0, 'C', true);
		$pdf->Cell($h_dh_no, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dh_no, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dh_no, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dh_no, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dh_no, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($jrk);
		$pdf->Cell($h_dn_no, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dn_no, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dn_no, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dn_no, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
		$pdf->Cell($h_dn_no, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
		if ($orien == 'L') {
			$pdf->Cell($h_ket, $th_tbl, '', 0, 1, 'C');
		} else {
			$pdf->Cell($h_ket, $th_tbl, '', 0, 0, 'C');
			$pdf->Cell($jrk2);
			$pdf->Cell($h_no, $th_tbl2, '', 0, 0, 'C');
			$pdf->Cell($h_ctt, ($th_tbl2 / 2), '/Pokok Bahasan', 'LBR', 0, 'C', true);
			$pdf->Cell($h_ctt, ($th_tbl2 / 2), 'dan Penilaian', 'LBR', 0, 'C', true);
			$pdf->Cell($h_ket2, $th_tbl2, '', 0, 0, 'C');
			$pdf->Cell($h_ket, $th_tbl, '', 0, 1, 'C');
		}

		// Daftar Nama Siswa, Hadir dan Nilai
		$siswa = $pdo_conn->prepare("SELECT nm, jk, nipd FROM tb_dsis WHERE kls = :kls");
		$siswa->bindParam(':kls', $kls);
		$siswa->execute();

		$pdf->SetFont('Arial Narrow', '', 11);
		$t_tbl = 4.7; // Tinggi baris tabel Lanscape
		if ($orien == 'P' && $_POST['kertas'] == 'a4') {
			$t_tbl = 5.3; // Tinggi baris tabel Portrait A4
		} else if ($orien == 'P' && $_POST['kertas'] == 'f4') {
			$t_tbl = 6.1; // Tinggi baris tabel Portrait F4
		}

		$i = 1;
		while ($dt_sis = $siswa->fetch(PDO::FETCH_ASSOC)) {
			if ($i > 36) {
				break;
			}
			$s_nm 	= $dt_sis['nm'];
			$s_nipd = $dt_sis['nipd'];
			$s_jk 	= $dt_sis['jk'];

			$pdf->Cell($h_no, $t_tbl, $i++, 1, 0, 'C');
			$pdf->Cell($h_nm, $t_tbl, f_singkatNama($s_nm, $skt_nm), 1, 0, 'L');
			$pdf->Cell($h_dh_np - $h_np_jk, $t_tbl, $s_nipd, 1, 0, 'C');
			$pdf->Cell($h_np_jk, $t_tbl, $s_jk, 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');

			$pdf->Cell($jrk);
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_ket, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($jrk2);

			$set = $i;
			$set = $set - 1;
			if ($orien == 'L') {
				if ($set <= 25) {
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell($h_no, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						if ($orien == 'L') {
							$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						} else {
							$pdf->Cell($h_ctt, $t_tbl, '                JP Ke:    s.d.', "B", 0, 'L');
						}
						$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27 && $orien == 'L') {
					$pdf->Cell($rw27[0]);
					$pdf->Cell($rw27[1], $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28 && $orien == 'L') {
					$pdf->Cell($rw28[0]);
					$pdf->Cell($rw28[1], $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell($rw28[2], $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29 && $orien == 'L') {
					$pdf->Cell($rw29[0]);
					$pdf->Cell($rw29[1], $t_tbl, 'Kepala ' . $nmpt . ',', 0, 1, 'L');
				} elseif ($set == 32 && $orien == 'L') {
					$pdf->Cell($rw32[0]);
					$pdf->Cell($rw32[1], $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33 && $orien == 'L') {
					$pdf->Cell($rw33[0]);
					$pdf->Cell($rw33[1], $t_tbl, $kepsek_nm, 0, 0, 'L');
					$pdf->Cell($rw33[2], $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34 && $orien == 'L') {
					$pdf->Cell($rw34[0]);
					$pdf->Cell($rw34[1], $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36 && $orien == 'L') {
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell($h_ket, $t_tbl, '', 0, 1, 'C');
				}
			} else {
				if ($set <= 35) {
					// Set border for every 5th row
					$brd = ($set % 7 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 3) % 7 == 1) ? ceil($set / 7) + $tm_np : '';

					$pdf->Cell($h_no, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 7 == 1) {
						$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						if ($orien == 'L') {
							$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						} else {
							$pdf->Cell($h_ctt, $t_tbl, '                JP Ke:    s.d.', "B", 0, 'L');
						}
						$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
					}
				}
				if ($set == 36) {

					$pdf->Cell($h_ket2, $t_tbl, '', 0, 1, 'L');
				}
			}
		}

		for ($j = $i; $j <= 36; $i++) {
			$pdf->Cell($h_no, $t_tbl, $j++, 1, 0, 'C');
			$pdf->Cell($h_nm, $t_tbl, '', 1, 0, 'L');
			$pdf->Cell($h_dh_np - $h_np_jk, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_np_jk, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dh_no, $t_tbl, '', 1, 0, 'C');

			$pdf->Cell($jrk);
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_dn_no, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($h_ket, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($jrk2);

			$set = $j;
			$set = $set - 1;
			if ($orien == 'L') {
				if ($set <= 25) {
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell($h_no, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						if ($orien == 'L') {
							$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						} else {
							$pdf->Cell($h_ctt, $t_tbl, '                JP Ke:    s.d.', "B", 0, 'L');
						}
						$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27 && $orien == 'L') {
					$pdf->Cell($rw27[0]);
					$pdf->Cell($rw27[1], $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28 && $orien == 'L') {
					$pdf->Cell($rw28[0]);
					$pdf->Cell($rw28[1], $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell($rw28[2], $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29 && $orien == 'L') {
					$pdf->Cell($rw29[0]);
					$pdf->Cell($rw29[1], $t_tbl, 'Kepala ' . $nmpt . ',', 0, 1, 'L');
				} elseif ($set == 32 && $orien == 'L') {
					$pdf->Cell($rw32[0]);
					$pdf->Cell($rw32[1], $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33 && $orien == 'L') {
					$pdf->Cell($rw33[0]);
					$pdf->Cell($rw33[1], $t_tbl, $kepsek_nm, 0, 0, 'L');
					$pdf->Cell($rw33[2], $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34 && $orien == 'L') {
					$pdf->Cell($rw34[0]);
					$pdf->Cell($rw34[1], $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36 && $orien == 'L') {
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell($h_ket, $t_tbl, '', 0, 1, 'C');
				}
			} else {
				if ($set <= 35) {
					// Set border for every 5th row
					$brd = ($set % 7 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 3) % 7 == 1) ? ceil($set / 7) + $tm_np : '';

					$pdf->Cell($h_no, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 7 == 1) {
						$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						if ($orien == 'L') {
							$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						} else {
							$pdf->Cell($h_ctt, $t_tbl, '                JP Ke:    s.d.', "B", 0, 'L');
						}
						$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
					}
				}
				if ($set == 36) {

					$pdf->Cell($h_ket2, $t_tbl, '', 0, 1, 'L');
				}
			}
		}

		// Penutup untuk orientasi potrait
		if ($orien == 'P') {
			// $set = 27;
			// if ($set == 27) {
			$pdf->Ln(3);
			$pdf->Cell($rw27[0]);
			$pdf->Cell($rw27[1], $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
			// } elseif ($set == 28) {
			$pdf->Cell($rw28[0]);
			$pdf->Cell($rw28[1], $t_tbl, 'Mengetahui, ', 0, 0, 'L');
			$pdf->Cell($rw28[2], $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
			// } elseif ($set == 29) {
			$pdf->Cell($rw29[0]);
			$pdf->Cell($rw29[1], $t_tbl, 'Kepala ' . $nmpt . ',', 0, 1, 'L');
			$pdf->Ln(10);
			// } elseif ($set == 32) {
			$pdf->Cell($rw32[0]);
			$pdf->Cell($rw32[1], $t_tbl, $nm, 0, 1, 'L');
			// } elseif ($set == 33) {
			$pdf->Cell($rw33[0]);
			$pdf->Cell($rw33[1], $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
			$pdf->Cell($rw33[2], $t_tbl, $nip, 0, 1, 'L');
			// } elseif ($set == 34) {
			$pdf->Cell($rw34[0]);
			$pdf->Cell($rw34[1], $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
			// } elseif ($set == 36) {
			$pdf->Ln(7);
			$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
			$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
		}
	}
}
