<?php

if ($_POST['kertas'] == 'a4') {
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

			// Menambahkan halaman baru
			$pdf->AddPage('L', array(210, 297), 0);
			$pdf->SetFont('Cambria', 'B', 18);

			// Menulis teks
			//Membuat sel 20*10 mm dengan teks rata tengah dan ganti baris
			$pdf->Cell(0, 10, $jdl, 0, 1, 'C');

			//coba
			// $pdf->Cell(100,10, $kls[0],0,1,"L");

			// Tahun Ajaran/Semester, Mata Pelajaran, dan info lainnya
			$jt 	= 4;
			$j_L 	= 45;
			$j_C 	= 30;
			$j_R 	= 25;
			$js_L	= 45;
			$js_C = 90;
			$js_R	= 60;

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
			$pdf->SetFont('Arial Narrow', '', 12);
			$th_tbl = 5; // Tinggi baris tabel
			$pdf->Cell(7, 10, 'No', 1, 0, 'C');
			$pdf->Cell(35, $th_tbl, 'Nama Peserta ', "T", 0, 'C');
			$pdf->SetFillColor(217, 217, 217); // Warna latar belakang (biru muda)
			$pdf->Cell(42, $th_tbl, 'Daftar Hadir', 1, 0, 'C', true); // true untuk fill

			$pdf->Cell(1.5);
			$pdf->Cell(35, $th_tbl, 'Daftar Nilai', 1, 0, 'C', true);
			$pdf->Cell(10, 10, 'Ket', 1, 0, 'C');
			$pdf->Cell(2);
			$pdf->Cell(7, 10, 'NP', 1, 0, 'C', true);
			$pdf->Cell(65, 10, 'TP / Materi Pelajaran/ Pokok Bahasan', 1, 0, 'C', true);
			$pdf->Cell(65, 10, 'Kegiatan Pembelajaran dan Penilaian', 1, 0, 'C', true);
			$pdf->Cell(18, 10, 'Ket**', 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, '', 0, 1, 'C');

			$pdf->Cell(7, $th_tbl, '', 0, 0, 'C');
			$pdf->Cell(35, $th_tbl, 'Didik', 0, 0, 'C');
			$pdf->Cell(17, $th_tbl, 'NP*', 1, 0, 'C', true);

			($tm != 0) ? $tm_np = 5 * $tm : $tm_np = 0;

			$pdf->Cell(5, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(1.5);
			$pdf->Cell(7, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(10, $th_tbl, '', 0, 1, 'C');
			// $pdf->Cell(1.5);
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
				$s_nm 	= $dt_sis['nm'];
				$s_nipd = $dt_sis['nipd'];
				$s_jk 	= $dt_sis['jk'];

				$pdf->Cell(7, $t_tbl, $i++, 1, 0, 'C');
				$pdf->Cell(35, $t_tbl, f_singkatNama($s_nm, 2), 1, 0, 'L');
				$pdf->Cell(12, $t_tbl, $s_nipd, 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, $s_jk, 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');

				$pdf->Cell(1.5);
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');

				$set = $i;
				$set = $set - 1;
				if ($set <= 25) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(2);
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell(65, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						$pdf->Cell(65, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						$pdf->Cell(18, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell(65, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(65, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(18, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(90);
					$pdf->Cell(20, $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Kepala ' . $nmpt, 0, 1, 'L');
				} elseif ($set == 32) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(90);
					$pdf->Cell(20, $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell(10, $t_tbl, '', 1, 1, 'C');
				}
			}
			for ($j = $i; $j <= 36; $i++) {

				$pdf->Cell(7, $t_tbl, $j++, 1, 0, 'C');
				$pdf->Cell(35, $t_tbl, '', 1, 0, 'L');
				$pdf->Cell(12, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');

				$pdf->Cell(1.5);
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');

				$set = $j;
				$set = $set - 1;
				if ($set <= 25) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(2);
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell(65, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						$pdf->Cell(65, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						$pdf->Cell(18, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell(65, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(65, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(18, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(90);
					$pdf->Cell(20, $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Kepala ' . $nmpt, 0, 1, 'L');
				} elseif ($set == 32) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(90);
					$pdf->Cell(20, $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell(10, $t_tbl, '', 1, 1, 'C');
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
}

if ($_POST['kertas'] == 'f4') {
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

			// Menambahkan halaman baru
			$pdf->AddPage('L', array(210, 330), 0);
			$pdf->SetFont('Cambria', 'B', 18);

			// Menulis teks
			//Membuat sel 20*10 mm dengan teks rata tengah dan ganti baris
			$pdf->Cell(0, 10, $jdl, 0, 1, 'C');

			//coba
			// $pdf->Cell(100,10, $kls[0],0,1,"L");

			// Tahun Ajaran/Semester, Mata Pelajaran, dan info lainnya
			$jt 	= 4;
			$j_L 	= 45;
			$j_C 	= 35;
			$j_R 	= 30;
			$js_L	= 55;
			$js_C = 100;
			$js_R	= 60;

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
			$pdf->SetFont('Arial Narrow', '', 12);
			$th_tbl = 5; // Tinggi baris tabel
			$pdf->Cell(7, 10, 'No', 1, 0, 'C');
			$pdf->Cell(55, $th_tbl, 'Nama Peserta ', "T", 0, 'C');
			$pdf->SetFillColor(217, 217, 217); // Warna latar belakang (biru muda)
			$pdf->Cell(45, $th_tbl, 'Daftar Hadir', 1, 0, 'C', true); // true untuk fill

			$pdf->Cell(1.5);
			$pdf->Cell(35, $th_tbl, 'Daftar Nilai', 1, 0, 'C', true);
			$pdf->Cell(10, 10, 'Ket', 1, 0, 'C');
			$pdf->Cell(2);
			$pdf->Cell(7, 10, 'NP', 1, 0, 'C', true);
			$pdf->Cell(70, 10, 'TP / Materi Pelajaran/ Pokok Bahasan', 1, 0, 'C', true);
			$pdf->Cell(70, 10, 'Kegiatan Pembelajaran dan Penilaian', 1, 0, 'C', true);
			$pdf->Cell(18, 10, 'Ket**', 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, '', 0, 1, 'C');

			$pdf->Cell(7, $th_tbl, '', 0, 0, 'C');
			$pdf->Cell(55, $th_tbl, 'Didik', 0, 0, 'C');
			$pdf->Cell(20, $th_tbl, 'NP*', 1, 0, 'C', true);

			($tm != 0) ? $tm_np = 5 * $tm : $tm_np = 0;

			$pdf->Cell(5, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(5, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(1.5);
			$pdf->Cell(7, $th_tbl, 1 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 2 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 3 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 4 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(7, $th_tbl, 5 + $tm_np, 1, 0, 'C', true);
			$pdf->Cell(10, $th_tbl, '', 0, 1, 'C');
			// $pdf->Cell(1.5);
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
				$s_nm 	= $dt_sis['nm'];
				$s_nipd = $dt_sis['nipd'];
				$s_jk 	= $dt_sis['jk'];

				$pdf->Cell(7, $t_tbl, $i++, 1, 0, 'C');
				$pdf->Cell(55, $t_tbl, f_singkatNama($s_nm, 3), 1, 0, 'L');
				$pdf->Cell(15, $t_tbl, $s_nipd, 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, $s_jk, 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');

				$pdf->Cell(1.5);
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');

				$set = $i;
				$set = $set - 1;
				if ($set <= 25) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(2);
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell(70, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						$pdf->Cell(70, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						$pdf->Cell(18, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell(70, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(70, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(18, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(100);
					$pdf->Cell(20, $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(80, $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Kepala ' . $nmpt, 0, 1, 'L');
				} elseif ($set == 32) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(100);
					$pdf->Cell(20, $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(80, $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell(10, $t_tbl, '', 1, 1, 'C');
				}
			}
			for ($j = $i; $j <= 36; $i++) {

				$pdf->Cell(7, $t_tbl, $j++, 1, 0, 'C');
				$pdf->Cell(55, $t_tbl, '', 1, 0, 'L');
				$pdf->Cell(15, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(5, $t_tbl, '', 1, 0, 'C');

				$pdf->Cell(1.5);
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');
				$pdf->Cell(7, $t_tbl, '', 1, 0, 'C');

				$set = $j;
				$set = $set - 1;
				if ($set <= 25) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(2);
					// Set border for every 5th row
					$brd = ($set % 5 == 0) ? 'LRB' : 'LR';

					// Nomor urut untuk kolom NP (setiap 5 baris)
					$no = (($set - 2) % 5 == 1) ? ceil($set / 5) + $tm_np : '';

					$pdf->Cell(7, $t_tbl, $no, $brd, 0, 'C', true);
					if ($set % 5 == 1) {
						$pdf->Cell(70, $t_tbl, 'Hari, Tanggal :', "BL", 0, 'L');
						$pdf->Cell(70, $t_tbl, '                          JP Ke:         s.d.', "B", 0, 'L');
						$pdf->Cell(18, $t_tbl, '', "LR", 1, 'L');
					} else {
						$pdf->Cell(70, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(70, $t_tbl, '', $brd, 0, 'L');
						$pdf->Cell(18, $t_tbl, '', $brd, 1, 'L');
					}
				} elseif ($set == 27) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(100);
					$pdf->Cell(20, $t_tbl, $lksi . ',       ' . $bln . ' ' . tgl(date('Y'), "Y"), 0, 1, 'L');
				} elseif ($set == 28) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(80, $t_tbl, 'Mengetahui, ', 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, 'Guru Pengajar, ', 0, 1, 'L');
				} elseif ($set == 29) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'Kepala ' . $nmpt, 0, 1, 'L');
				} elseif ($set == 32) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(100);
					$pdf->Cell(20, $t_tbl, $nm, 0, 1, 'L');
				} elseif ($set == 33) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(80, $t_tbl, $kepsek['nm_staf'] . ', ' . $kepsek['glar'], 0, 0, 'L');
					$pdf->Cell(20, $t_tbl, $nip, 0, 1, 'L');
				} elseif ($set == 34) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(20);
					$pdf->Cell(70, $t_tbl, 'NIP ' . $kepsek['nip'], 0, 1, 'L');
				} elseif ($set == 36) {
					$pdf->Cell(10, $t_tbl, '', 1, 0, 'C');
					$pdf->Cell(7);
					$pdf->Cell(40, $t_tbl, '*) Nomor Pertemuan', 0, 0, 'L');
					$pdf->Cell(70, $t_tbl, '**) Dapat diisi ketercapaian pembelajaran (%)', 0, 1, 'L');
				} else {
					$pdf->Cell(10, $t_tbl, '', 1, 1, 'C');
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
}
