<?php require_once "pr_sacc.php";


$id = $_POST['id'] ?? '';
$prd = $_POST['prd'] ?? '';

// Jurnal Manual Pilih nama
if ($prd == 'nm'):

	$stmt = db_Proses($pdo_conn, "SELECT * FROM tb_dstaf WHERE kd_staf = ?", [$id]);
	$result = $stmt->fetch(PDO::FETCH_ASSOC);

	$d_mpel = db_Proses($pdo_conn, "SELECT mpel FROM tb_mpel WHERE guru LIKE ?", ['%' . $result['kd_staf'] . '%']);

	$nip = $result['nip'] != '-' ? 'NIP ' . $result['nip'] : 'NUPTK ' . $result['nuptk'];

	$d_mpel_stmt = db_Proses($pdo_conn, "SELECT kd_mpel, mpel FROM tb_mpel WHERE guru LIKE ?", ['%' . $result['kd_staf'] . '%']);
	$d_mpel_row = $d_mpel_stmt->fetch(PDO::FETCH_ASSOC);
	$kdmpel = $d_mpel_row['kd_mpel'] ?? '';
	$mpel   = $d_mpel_row['mpel'] ?? '';


	$cek_list = '';

	if (!empty($_POST['ctk'])):
		$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_jrnl WHERE kd_staf = ? GROUP BY kls ORDER BY kls ASC;", [$result['kd_staf']]);
		while ($r = $kls->fetch(PDO::FETCH_ASSOC)) {
			$cek_list .= '
			<div class="col-md-4 col-lg-3 col-sm-6 col-12 form-check">
				<input type="checkbox" name="kelas[]" id="' . $r['kls'] . '" class="form-check-input ckall" value="' . $r['kls'] . '">
				<label for="' . $r['kls'] . '" class="form-check-label">' . $r['kls'] . '</label>
			</div>';
		}
	endif;

	header('Content-Type: application/json');
	if ($nip !== 'NUPTK -') {
		echo json_encode(['id' => $nip, 'mpel' => $mpel, 'kd_mpel' => $kdmpel, 'ck_list' => $cek_list]);
	} else {
		echo json_encode(['id' => '', 'mpel' => '', 'kd_mpel' => '', 'ck_list' => '']);
	}
endif;

// Catatan jurnal mengajar
if ($prd == 'ctt'):
	$kd_staf 		= $_POST['kd_gr'];
	// $mpel 			= $_POST['mapel'];
	$mpel 			= $_POST['kd_mpel'];
	$tgl 				= $_POST['tgl'] ?? '';
	if (empty($tgl)) exit('Tanggal kosong');

	$jp_mulai 	= $_POST['jp_m'] ?? '';
	if (empty($jp_mulai)) exit('Jam pelajaran mulai kosong');

	$jp_selesai = $_POST['jp_s'] ?? '';
	if (empty($jp_selesai)) exit('Jam pelajaran selesai kosong');

	$jp 				= json_encode([$jp_mulai, $jp_selesai]);

	$kls 				= $_POST['kls'] ?? '';
	if (empty($kls)) exit('Kelas kosong');

	$d_sis 			= json_encode($_POST['siswa'] ?? []);
	// $hadir 			= json_encode($_POST['hadir'] ?? []);
	// $nilai 			= json_encode($_POST['nilai'] ?? []);
	// $ket_s 			= json_encode($_POST['ket_sis'] ?? []);

	$materi 		= $_POST['materi'];
	$keg 				= $_POST['keg'];
	$ket_g 			= $_POST['ket_g'];

	// echo 	$kd_staf.' '.
	// 			$mpel.' '.
	// 			$tgl.' '.
	// 			$jp_mulai.' '.
	// 			$jp_selesai.' '.
	// 			$kls.' '.
	// 			$nipd.' '.
	// 			$hadir.' '.
	// 			$nilai.' '.
	// 			$ket_s.' '.
	// 			$materi.' '.
	// 			$keg.' '.
	// 			$ket_g;

	// Insert data
	$qr_in = "INSERT INTO tb_jrnl (id_jrnl, kd_staf, kd_mpel, kls, tgl, jp, d_sis, materi, kgitan, ket, d_rec, d_up, sts) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, CURRENT_TIME(), ?, ?);";
	$data_in = [$kd_staf, $mpel, $kls, $tgl, $jp, $d_sis, $materi, $keg, $ket_g, '', 'Y'];

	// Update data
	$qr_up = "UPDATE tb_jrnl SET kd_mpel = ?, jp = ?, d_sis = ?, materi = ?, kgitan = ?, ket = ?, d_up = CURRENT_TIME() WHERE kd_staf = ? AND tgl = ? AND kls = ?";
	$data_up = [$mpel, $jp, $d_sis, $materi, $keg, $ket_g, $kd_staf, $tgl, $kls];

	// Cek data 
	$cek_data = db_Proses($pdo_conn, "SELECT * FROM tb_jrnl WHERE kd_staf = ? AND tgl = ? AND kls = ?", [$kd_staf, $tgl, $kls]);
	if ($cek_data->rowCount() > 0):
		$stmt = db_Proses($pdo_conn, $qr_up, $data_up);
		if ($stmt) echo 'update';
		else echo 'err';
	else:
		$stmt = db_Proses($pdo_conn, $qr_in, $data_in);
		if ($stmt) echo 'ok';
		else echo 'err';
	endif;
endif;
