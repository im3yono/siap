<?php

if ($_POST['kertas'] == 'a4') {
	// Menambahkan halaman baru
	$pdf->AddPage('L', array(210, 297), 0);
	// Set tampilan
	$jt 	= 4;
	$j_L 	= 45;
	$j_C 	= 30;
	$j_R 	= 25;
	$js_L	= 45;
	$js_C = 90;
	$js_R	= 60;

	$h_no 		= 7; 	// lebar No
	$h_nm 		= 43;	// Lebar nama
	$h_dh			= 42;	// Lebar daftar Hadir
	$h_dh_np	= 17;	// Lebar daftar Hadir NP
	$h_np_jk	= 5;
	$h_dh_no	= 5; 	// Lebar daftar Hadir no
	$h_dn			= 35;	// Lebar daftar Nilai
	$h_dn_no	= 7; 	// Lebar daftar Nilai no
	$h_ket		= 10;	// Lebar Ket
	$h_ket2		= 18;	// Lebar Ket
	$h_ctt 		= 60;	// Lebar catatan

	$rw27 = [90, 20];
	$rw32 = [90, 20];
	$rw28 = [20, 70, 20];
	$rw29 = [20, 70, 20];
	$rw33 = [20, 70, 20];
	$rw34 = [20, 70, 20];

	$jrk 		= 1.5; // Jrak antar table
	$jrk2 		= 2; // Jrak antar table
	$th_tbl = 5; // Tinggi baris tabel 1 baris
	$th_tbl2 = 10; // Tinggi baris tabel 2 baris jadi 1

	// Singkat nama
	$skt_nm = 2;
}

if ($_POST['kertas'] == 'f4') {
	// Menambahkan halaman baru
	$pdf->AddPage('L', array(210, 330), 0);
	// Set tampilan
	$jt 	= 4;
	$j_L 	= 45;
	$j_C 	= 35;
	$j_R 	= 30;
	$js_L	= 55;
	$js_C = 100;
	$js_R	= 60;

	$h_no 		= 7; 	// lebar No
	$h_nm 		= 55;	// Lebar nama
	$h_dh			= 45;	// Lebar daftar Hadir
	$h_dh_np	= 20;	// Lebar daftar Hadir NP
	$h_np_jk	= 5;
	$h_dh_no	= 5; 	// Lebar daftar Hadir no
	$h_dn			= 35;	// Lebar daftar Nilai
	$h_dn_no	= 7; 	// Lebar daftar Nilai no
	$h_ket		= 10;	// Lebar Ket
	$h_ket2		= 18;	// Lebar Ket
	$h_ctt 		= 70;	// Lebar catatan

	$rw27 = [90, 20];
	$rw32 = [90, 20];
	$rw28 = [20, 70, 20];
	$rw29 = [20, 70, 20];
	$rw33 = [20, 70, 20];
	$rw34 = [20, 70, 20];

	$jrk 		= 1.5; // Jrak antar table
	$jrk2 		= 2; // Jrak antar table
	$th_tbl = 5; // Tinggi baris tabel 1 baris
	$th_tbl2 = 10; // Tinggi baris tabel 2 baris jadi 1

	// Singkat nama
	$skt_nm = 3;
}


foreach ($kls as $kls) {
	foreach ($kl as $tm) {
		// for ($i=0; $i < 1; $i++) { 

		$siswal = $pdo_conn->prepare("SELECT nm, jk, nipd FROM tb_dsis WHERE jk = 'L' AND kls = :kls");
		$siswal->bindParam(':kls', $kls);
		$siswal->execute();
		$siswap = $pdo_conn->prepare("SELECT nm, jk, nipd FROM tb_dsis WHERE jk = 'P' AND kls = :kls");
		$siswap->bindParam(':kls', $kls);
		$siswap->execute();
		$jml_l = $siswal->rowCount();
		$jml_p = $siswap->rowCount();

		$jml_l = $jml_l == "0" ? '       ' : $jml_l;
		$jml_p = $jml_p == "0" ? '       ' : $jml_p;

		$pdf->SetFont('Cambria', 'B', 18);

		// Menulis teks
		//Membuat sel 20*10 mm dengan teks rata tengah dan ganti baris
		$pdf->Cell(0, 10, $jdl, 0, 1, 'C');

		//coba
		// $pdf->Cell(100,10, $kls[0],0,1,"L");

		// Tahun Ajaran/Semester, Mata Pelajaran, dan info lainnya
		$pdf->SetFont('Cambria', '', 12);
		$pdf->Cell($j_L, $jt, 'Tahun Ajaran/Semester ', 0, 0);
		$pdf->Cell($js_L, $jt, ': ' . $thn . ' ' . $smt, 0, 0);
		$pdf->Cell($j_C, $jt, 'Mata Pelajaran', 0, 0);
		$pdf->Cell($js_C, $jt, ': ' . $mpel, 0, 0);
		$pdf->Cell($j_R, $jt, 'Wali Kelas', 0, 0);
		$pdf->Cell($js_R, $jt, ': ............................', 0, 1);

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
		$pdf->Cell($h_ctt, $th_tbl2, 'TP / Materi Pelajaran/ Pokok Bahasan', 1, 0, 'C', true);
		$pdf->Cell($h_ctt, $th_tbl2, 'Kegiatan Pembelajaran dan Penilaian', 1, 0, 'C', true);
		$pdf->Cell($h_ket2, $th_tbl2, 'Ket**', 1, 0, 'C', true);
		$pdf->Cell(7, $th_tbl, '', 0, 1, 'C');

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
		$pdf->Cell($h_ket, $th_tbl, '', 0, 1, 'C');
		// $pdf->Cell($jrk);
		// $pdf->Cell(7, $th_tbl, '', 0, 1, 'C');



		// Daftar Nama Siswa, Hadir dan Nilai

		$siswa = $pdo_conn->prepare("SELECT nm, jk, nipd FROM tb_dsis WHERE kls = :kls");
		$siswa->bindParam(':kls', $kls);
		$siswa->execute();
		// $dt_sis = $siswa->fetch(PDO::FETCH_ASSOC);



		$pdf->SetFont('Arial Narrow', '', 11);
		$t_tbl = 4.7; // Tinggi baris tabel
		// for ($i = 1; $i <= 36; $i++) 
		// for ($i = 1; $i <= 36; $i++) 
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
			$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($jrk2);


			$set = $i;
			$set = $set - 1;
			if ($set <= 25) {
				// Set border for every 5th row
				$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

				// Nomor urut untuk kolom NP (setiap 5 baris)
				$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

				$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
				if ($set % 5 == 1) {
					$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
					$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
					$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
				} else {
					$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
					$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
					$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
				}
			} elseif ($set == 27) {
				$pdf->Cell($rw27[0]);
				$pdf->Cell($rw27[1], $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
			} elseif ($set == 28) {
				$pdf->Cell($rw28[0]);
				$pdf->Cell($rw28[1], $t_tbl, 'Mengetahui, ', 0, 0, 'L');
				$pdf->Cell($rw28[2], $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
			} elseif ($set == 29) {
				$pdf->Cell($rw29[0]);
				$pdf->Cell($rw29[1], $t_tbl, 'Kepala ' . $nmpt.',', 0, 1, 'L');
			} elseif ($set == 32) {
				$pdf->Cell($rw32[0]);
				$pdf->Cell($rw32[1], $t_tbl, $nm, 0, 1, 'L');
			} elseif ($set == 33) {
				$pdf->Cell($rw33[0]);
				$pdf->Cell($rw33[1], $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
				$pdf->Cell($rw33[2], $t_tbl, $nip, 0, 1, 'L');
			} elseif ($set == 34) {
				$pdf->Cell($rw34[0]);
				$pdf->Cell($rw34[1], $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
			} elseif ($set == 36) {
				$pdf->Cell(7);
				$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
				$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
			} else {
				$pdf->Cell(10, $t_tbl, '', 0, 1, 'C');
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
			$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
			$pdf->Cell($jrk2);

			$set = $j;
			$set = $set - 1;
			if ($set <= 25) {
				// Set border for every 5th row
				$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

				// Nomor urut untuk kolom NP (setiap 5 baris)
				$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

				$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
				if ($set % 5 == 1) {
					$pdf->Cell($h_ctt, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
					$pdf->Cell($h_ctt, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
					$pdf->Cell($h_ket2, $t_tbl, '', "LR", 1, 'L');
				} else {
					$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
					$pdf->Cell($h_ctt, $t_tbl, '', $brd, 0, 'L');
					$pdf->Cell($h_ket2, $t_tbl, '', $brd, 1, 'L');
				}
			} elseif ($set == 27) {
				$pdf->Cell($rw27[0]);
				$pdf->Cell($rw27[1], $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
			} elseif ($set == 28) {
				$pdf->Cell($rw28[0]);
				$pdf->Cell($rw28[1], $t_tbl, 'Mengetahui, ', 0, 0, 'L');
				$pdf->Cell($rw28[2], $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
			} elseif ($set == 29) {
				$pdf->Cell($rw29[0]);
				$pdf->Cell($rw29[1], $t_tbl, 'Kepala ' . $nmpt.',', 0, 1, 'L');
			} elseif ($set == 32) {
				$pdf->Cell($rw32[0]);
				$pdf->Cell($rw32[1], $t_tbl, $nm, 0, 1, 'L');
			} elseif ($set == 33) {
				$pdf->Cell($rw33[0]);
				$pdf->Cell($rw33[1], $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
				$pdf->Cell($rw33[2], $t_tbl, $nip, 0, 1, 'L');
			} elseif ($set == 34) {
				$pdf->Cell($rw34[0]);
				$pdf->Cell($rw34[1], $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
			} elseif ($set == 36) {
				$pdf->Cell(7);
				$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
				$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
			} else {
				$pdf->Cell(10, $t_tbl, '', 0, 1, 'C');
			}
		}

		// Footer
		// $pdf->Ln(10);
		// $pdf->SetFont('Arial Narrow', '', 8);
		// $pdf->Cell(0, 10, 'Mengetahui, Kepala SMA Negeri 1 Sungai Tabuk, ' . 'Sungai Tabuk, 2025', 0, 1, 'L');
		// $pdf->Cell(0, 10, 'Guru Pengajar, ....................................', 0, 1, 'L');
		// $pdf->Cell(0, 10, 'Wali Kelas, ....................................', 0, 1, 'L');
	}
}
