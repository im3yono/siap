<?php require_once "pr_sacc.php";

$tkt = $_POST['tkt'] ?? '';
$prd = $_POST['prd'];

if ($prd == 'ch_tkt'):
	if ($tkt != '') {
		$sql = "SELECT kls FROM tb_kls WHERE tkt = ? GROUP BY kls ORDER BY kls ASC";
		$stmt = db_Proses($pdo_conn, $sql, [$tkt]);
	} else {
		// Jika tidak dipilih, tampilkan semua
		$sql = "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC";
		$stmt = db_Proses($pdo_conn, $sql);
	}

	echo '<option value="" selected>-- Pilih --</option>';
	while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
		echo "<option value='{$r['kls']}'>{$r['kls']}</option>";
	}
endif;


// Proses edit data siswa
if ($prd == 'edit_sis'):
	$ft 		= $_FILES['img'];
	$id_sis	= $_POST['id_sis'];
	$nipd		= $_POST['nipd'];
	$nipd2		= $_POST['nipd2'];
	$nisn		= $_POST['nisn'];
	$nm			= $_POST['nm'];
	$tmp_l	= $_POST['tmp_l'];
	$tgl_l	= $_POST['tgl_l'];
	$jk			= $_POST['jk'];
	$nik 		= $_POST['nik'];
	$nkk 		= $_POST['nkk'];
	$agm 		= $_POST['agm'];
	$almt 		= json_encode(array(
		"almt" 	=> $_POST['almt'],
		"rt" 		=> $_POST['rt'],
		"rw" 		=> $_POST['rw'],
		"dusun" => $_POST['dsn'],
		"kel" 	=> $_POST['desa'],
		"kec" 	=> $_POST['kec'],
		"kdpos" => $_POST['kdpos']
	));
	$tmp_t 			= $_POST['tmp_t'];
	$transport 	= $_POST['transpor'];
	$tlp 				= json_encode(array("tlp" => $_POST['tlp'], "hp" => $_POST['hp']));
	$email 			= $_POST['email'];
	$masuk 			= $_POST['masuk'];
	$kls 				= $_POST['kls'];
	$n_akta 		= $_POST['n_akte'];
	$disabel 		= $_POST['disabel'];
	$asl 				= $_POST['asl_sekl'];
	$sdr 				= json_encode(array("sdr" => $_POST['sdr'], "ke" => $_POST['a_ke']));
	$bmilk 			= json_encode(array("bb" => $_POST['bb'], "tb" => $_POST['tb'], "lk" => $_POST['lk']));
	$jrk 				= $_POST['jrk'];
	$ayah 		= json_encode(array(
		"nik" 	=> $_POST['nik_a'],
		"nm" 		=> f_nama($_POST['nm_a']),
		"thn_l" => $_POST['thnl_a'],
		"almt" 	=> $_POST['almt_a'],
		"pddk" 	=> $_POST['pddk_a'],
		"kerja" => $_POST['kerja_a'],
		"upah" 	=> $_POST['upah_a'],
		"sts"		=> $_POST['sts_a']
	));
	$ibu 		= json_encode(array(
		"nik" 	=> $_POST['nik_i'],
		"nm" 		=> f_nama($_POST['nm_i']),
		"thn_l" => $_POST['thnl_i'],
		"almt" 	=> $_POST['almt_i'],
		"pddk" 	=> $_POST['pddk_i'],
		"kerja" => $_POST['kerja_i'],
		"upah" 	=> $_POST['upah_i'],
		"sts"		=> $_POST['sts_i']
	));
	$wali 		= json_encode(array(
		"nik" 	=> $_POST['nik_w'],
		"nm" 		=> f_nama($_POST['nm_w']),
		"thn_l" => $_POST['thnl_w'],
		"almt" 	=> $_POST['almt_w'],
		"pddk" 	=> $_POST['pddk_w'],
		"kerja" => $_POST['kerja_w'],
		"upah" 	=> $_POST['upah_w']
	));

	// Upload Foto
	if (!empty($ft['name'])) {
		$file_tmp = $ft['tmp_name'];
		$file_name = basename($ft['name']);
		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
		$target = "../../app/images/siswa/" . $nipd . "." . $ext;

		if (move_uploaded_file($file_tmp, $target)) {
		} else {
			echo 'Gagal upload file';
			exit;
		}
	}

	$datain		= array($nipd, $nisn, $nm, $jk, $tmp_l, $tgl_l, $nik, $nkk, $agm, $almt, $tmp_t, $transport, $tlp, $email, $ayah, $ibu, $wali, $masuk, $kls, $n_akta, $disabel, $asl, $sdr, $bmilk, $jrk);

	$dataup		= array($nisn, $nm, $jk, $tmp_l, $tgl_l, $nik, $nkk, $agm, $almt, $tmp_t, $transport, $tlp, $email, $ayah, $ibu, $wali, $masuk, $kls, $n_akta, $disabel, $asl, $sdr, $bmilk, $jrk, $nipd, $id_sis);


	// SQL Insert
	$sql_in = "INSERT INTO tb_dsis (
						id_dsis, nipd, nisn, nm, jk, tmp_lahir, tgl_lahir, nik, nkk, agm, almt, tmp_tinggal,
						trasport, `tlp/hp`, email, ayah, ibu, wali, masuk, kls, no_akta, disabel, sklh_asl,
						saudr, bb_tb_lk, jrk_rmh, sts, rcd, upd
						) VALUES (
						NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Y', current_timestamp(), current_timestamp())";

	// SQL Update
	$sql_up = "UPDATE tb_dsis SET
						nisn = ?, nm = ?, jk = ?, tmp_lahir = ?, tgl_lahir = ?, nik = ?, nkk = ?, agm = ?,
						almt = ?, tmp_tinggal = ?, trasport = ?, `tlp/hp` = ?, email = ?, ayah = ?, ibu = ?,
						wali = ?, masuk = ?, kls = ?, no_akta = ?, disabel = ?, sklh_asl = ?, saudr = ?,
						bb_tb_lk = ?, jrk_rmh = ?,  nipd = ?, upd = current_timestamp()
						WHERE id_dsis = ?";

	// Cek data berdasarkan id dan nipd
	if ($id_sis != '') {
		$cek = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE id_dsis = ? AND nipd = ?", [$id_sis, $nipd2]);
	} else {
		$cek = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE nipd = ? AND nisn = ?", [$nipd, $nisn]);
	}

	if ($cek->rowCount() > 0) {
		if (db_Proses($pdo_conn, $sql_up, $dataup)) {
			echo 'up';
		}
	} else {
		if (db_Proses($pdo_conn, $sql_in, $datain)) {
			echo 'in';
		}
	}
// echo 'success';
endif;


// Event NIPD
if ($prd == 'ck_nipd'):
	$id = $_POST['id'];
	$stmt = db_Proses($pdo_conn, 'SELECT * FROM tb_dsis WHERE nipd = ?', [$id]);
	if ($stmt->rowCount() > 0) {
		$d = $stmt->fetch(PDO::FETCH_ASSOC);

		$almt = json_decode($d['almt'], true);
		$tlp  = json_decode($d['tlp/hp'], true);
		$ayah = json_decode($d['ayah'], true);
		$ibu  = json_decode($d['ibu'], true);
		$wali = json_decode($d['wali'], true);
		$sdr  = json_decode($d['saudr'], true);
		$bmilk = json_decode($d['bb_tb_lk'], true);

		$res = [
			// field utama
			// 'id_sis' => $d['id_dsis'],
			'ft' => ft($d['nipd'], 'siswa', '../../'),
			'nisn' => $d['nisn'],
			'nm' => $d['nm'],
			'jk' => $d['jk'],
			'tmp_l' => $d['tmp_lahir'],
			'tgl_l' => $d['tgl_lahir'],
			'nik' => $d['nik'],
			'nkk' => $d['nkk'],
			'agm' => $d['agm'],
			'tmp_t' => $d['tmp_tinggal'],
			'transpor' => $d['trasport'],
			'email' => $d['email'],
			'masuk' => $d['masuk'],
			'kls' => $d['kls'],
			'n_akte' => $d['no_akta'],
			'disabel' => $d['disabel'],
			'asl_sekl' => $d['sklh_asl'],
			'jrk' => $d['jrk_rmh'],

			// field json — pecah jadi key seperti di $_POST
			'almt' => $almt['almt'] ?? '',
			'rt' => $almt['rt'] ?? '',
			'rw' => $almt['rw'] ?? '',
			'dsn' => $almt['dusun'] ?? '',
			'desa' => $almt['kel'] ?? '',
			'kec' => $almt['kec'] ?? '',
			'kdpos' => $almt['kdpos'] ?? '',

			'tlp' => $tlp['tlp'] ?? '',
			'hp' => $tlp['hp'] ?? '',

			'sdr' => $sdr['sdr'] ?? '',
			'a_ke' => $sdr['ke'] ?? '',

			'bb' => $bmilk['bb'] ?? '',
			'tb' => $bmilk['tb'] ?? '',
			'lk' => $bmilk['lk'] ?? '',

			// Ayah
			'nik_a' => $ayah['nik'] ?? '',
			'nm_a' => $ayah['nm'] ?? '',
			'thnl_a' => $ayah['thn_l'] ?? '',
			'almt_a' => $ayah['almt'] ?? '',
			'pddk_a' => $ayah['pddk'] ?? '',
			'kerja_a' => $ayah['kerja'] ?? '',
			'upah_a' => $ayah['upah'] ?? '',
			'sts_a' => $ayah['sts'] ?? '',

			// Ibu
			'nik_i' => $ibu['nik'] ?? '',
			'nm_i' => $ibu['nm'] ?? '',
			'thnl_i' => $ibu['thn_l'] ?? '',
			'almt_i' => $ibu['almt'] ?? '',
			'pddk_i' => $ibu['pddk'] ?? '',
			'kerja_i' => $ibu['kerja'] ?? '',
			'upah_i' => $ibu['upah'] ?? '',
			'sts_i' => $ibu['sts'] ?? '',

			// Wali
			'nik_w' => $wali['nik'] ?? '',
			'nm_w' => $wali['nm'] ?? '',
			'thnl_w' => $wali['thn_l'] ?? '',
			'almt_w' => $wali['almt'] ?? '',
			'pddk_w' => $wali['pddk'] ?? '',
			'kerja_w' => $wali['kerja'] ?? '',
			'upah_w' => $wali['upah'] ?? '',
		];

		echo json_encode($res);
	} else {
		// echo '';
		$res = [
			// field utama
			// 'id_sis' => $d['id_dsis'],
			'ft' 			=> 'assets/img/account.png',
			'nisn' 		=> '',
			'nm' 			=> '',
			'jk' 			=> '',
			'tmp_l' 	=> '',
			'tgl_l' 	=> '',
			'nik' 		=> '',
			'nkk' 		=> '',
			'agm' 		=> '',
			'tmp_t' 	=> '',
			'transpor' => '',
			'email' 	=> '',
			'masuk' 	=> '',
			'kls' 		=> '',
			'n_akte' 	=> '',
			'disabel' => '',
			'asl_sekl' => '',
			'jrk' 		=> '',

			// field json — pecah jadi key seperti di $_POST
			'almt' 		=> $almt['almt'] ?? '',
			'rt' 			=> $almt['rt'] ?? '',
			'rw' 			=> $almt['rw'] ?? '',
			'dsn' 		=> $almt['dusun'] ?? '',
			'desa' 		=> $almt['kel'] ?? '',
			'kec' 		=> $almt['kec'] ?? '',
			'kdpos' 	=> $almt['kdpos'] ?? '',

			'tlp' 		=> $tlp['tlp'] ?? '',
			'hp' 			=> $tlp['hp'] ?? '',

			'sdr' 		=> $sdr['sdr'] ?? '',
			'a_ke' 		=> $sdr['ke'] ?? '',

			'bb' 			=> $bmilk['bb'] ?? '',
			'tb' 			=> $bmilk['tb'] ?? '',
			'lk' 			=> $bmilk['lk'] ?? '',

			// Ayah
			'nik_a' 	=> $ayah['nik'] ?? '',
			'nm_a' 		=> $ayah['nm'] ?? '',
			'thnl_a' 	=> $ayah['thn_l'] ?? '',
			'almt_a' 	=> $ayah['almt'] ?? '',
			'pddk_a' 	=> $ayah['pddk'] ?? '',
			'kerja_a' => $ayah['kerja'] ?? '',
			'upah_a' 	=> $ayah['upah'] ?? '',
			'sts_a' 	=> $ayah['sts'] ?? '',

			// Ibu
			'nik_i' 	=> $ibu['nik'] ?? '',
			'nm_i' 		=> $ibu['nm'] ?? '',
			'thnl_i' 	=> $ibu['thn_l'] ?? '',
			'almt_i' 	=> $ibu['almt'] ?? '',
			'pddk_i' 	=> $ibu['pddk'] ?? '',
			'kerja_i' => $ibu['kerja'] ?? '',
			'upah_i' 	=> $ibu['upah'] ?? '',
			'sts_i' 	=> $ibu['sts'] ?? '',

			// Wali
			'nik_w' 	=> $wali['nik'] ?? '',
			'nm_w' 		=> $wali['nm'] ?? '',
			'thnl_w' 	=> $wali['thn_l'] ?? '',
			'almt_w' 	=> $wali['almt'] ?? '',
			'pddk_w' 	=> $wali['pddk'] ?? '',
			'kerja_w' => $wali['kerja'] ?? '',
			'upah_w' 	=> $wali['upah'] ?? '',
		];
		echo json_encode($res);
		exit;
	}
endif;


// Proses hapus data siswa
if ($prd == 'del_sis'):
	$id = $_POST['id'];
	$stmt = db_Proses($pdo_conn, "DELETE FROM tb_dsis WHERE nipd = ?", [$id]);
	if ($stmt) {
		// unlink("../../app/images/siswa/".$id);
		unlink(ft($id, 'siswa', '../../', '../../'));
		echo 'success';
	}
endif;
