<?php require_once "pr_sacc.php";

$prd = $_POST['prd'];
$total_insert = 0;
$total_update = 0;
$total_gagal  = 0;

if ($prd == "kls"):
	if (!empty($_POST['db'])) {


		$siap_kls = db_Proses($pdo_conn, "SELECT * FROM tb_kls");

		while ($r_siap = $siap_kls->fetch(PDO::FETCH_ASSOC)):

			$kd_kls = 'siap_' . str_replace(" ", "", $r_siap['kls']);
			$nm_kls = $r_siap['kls'];
			$kls    = $r_siap['tkt'];
			$jur    = $r_siap['jur'];
			$minat  = '';

			$sql_insert = "INSERT INTO kelas (id_kls, kd_kls, nm_kls, kls, jur, kls_minat, sts) VALUES (NULL, ?, ?, ?, ?, ?, 'Y')";

			$sql_update = "UPDATE kelas SET nm_kls = ?, kls = ?, jur = ?, kls_minat = ? WHERE kd_kls = ?";

			$cek_kls = db_Proses(db_Mytbk(), "SELECT kd_kls FROM kelas WHERE kd_kls = ?", [$kd_kls]);

			if ($cek_kls->rowCount() == 0) {
				// INSERT
				$exec = db_Proses(db_Mytbk(), $sql_insert, [$kd_kls, $nm_kls, $kls, $jur, $minat]);

				if ($exec) {
					$total_insert++;
				} else {
					$total_gagal++;
				}
			} else {
				// UPDATE
				$exec = db_Proses(db_Mytbk(), $sql_update, [$nm_kls, $kls, $jur, $minat, $kd_kls]);

				if ($exec) {
					$total_update++;
				} else {
					$total_gagal++;
				}
			}

		endwhile;

		echo "Insert: $total_insert | Update: $total_update | Gagal: $total_gagal";
	}
endif;

if ($prd == "sync"):
	if (!isset($_POST['data'])) {
		exit("Data tidak diterima");
	}

	if (!empty($_POST['pesan'])) {
		echo $_POST['pesan'];
		return;
	}

	$data = json_decode($_POST['data'], true);

	if (!is_array($data)) {
		exit("Format JSON tidak valid");
	}
	foreach ($data as $row):
		// Gunakan null coalescing agar tidak undefined
		$nis   = $row['nis']   ?? '';
		$nm    = $row['nama']  ?? '';
		$tmp_l = $row['tmp_l'] ?? '';
		$tgl_l = f_tglIndoKeSql($row['tgl_l']) ?? '';
		$jk    = $row['jk']    ?? '';
		$ft    = $row['ft']    ?? '';
		$user  = $row['user']  ?? '';
		$pass  = $row['pass']  ?? '';
		$sesi  = $row['sesi']  ?? '';
		$ruang = $row['ruang'] ?? '';
		$ipsv  = $row['ip']    ?? '';

		// if (!$user || !$ipsv) {
		//     $total_gagal++;
		//     continue;
		// }

		$kd_kls = 'siap_' . str_replace(" ", "", ($row['kls'] ?? ''));

		$sql_in = "INSERT INTO cbt_peserta (id_peserta, ip_sv, nm, tmp_lahir, tgl_lahir, nis, kd_kls, jns_kel, ft, user, pass, sesi, ruang, sts) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Y')";

		$sql_up = "UPDATE cbt_peserta SET ip_sv = ?, nm = ?, tmp_lahir = ?, tgl_lahir = ?, kd_kls = ?, jns_kel = ?, ft = ?, pass = ?, sesi = ?, ruang = ? WHERE cbt_peserta.user = ? OR nis = ?";

		$ck_dt = db_Proses(db_Mytbk(), "SELECT * FROM cbt_peserta WHERE cbt_peserta.user= ? OR nis = ?", [$user, $nis]);

		if (empty($ck_dt->rowCount())):
			$exc = db_Proses(db_Mytbk(), $sql_in, [$ipsv, $nm, $tmp_l, $tgl_l, $nis, $kd_kls, $jk, $ft, $user, $pass, $sesi, $ruang]);
			if ($exc) $total_insert++;
			else	$total_gagal++;

		else:
			$exc = db_Proses(db_Mytbk(), $sql_up, [$ipsv, $nm, $tmp_l, $tgl_l, $kd_kls, $jk, $ft, $pass, $sesi, $ruang, $user, $nis]);
			if ($exc) $total_update++;
			else $total_gagal++;

		endif;

	endforeach;
	echo "Menambahkan: $total_insert | Merubah: $total_update | Gagal: $total_gagal";
endif;

if ($prd == "get_kls"):
	echo '<option value="all">Semua</option>';
	$rombel = $_POST['rombel'] ?? '';
	$sql = $rombel == 'all'
		? "SELECT kls FROM tb_kls WHERE sts_kls = ? ORDER BY kls ASC"
		: "SELECT kls FROM tb_kls WHERE sts_kls = ? AND tkt = ? ORDER BY kls ASC";
	$params = $rombel == 'all' ? ['R'] : ['R', $rombel];
	$kls = db_Proses($pdo_conn, $sql, $params);

	while ($r = $kls->fetch(PDO::FETCH_ASSOC)):
		echo '<option value="' . $r['kls'] . '">' . $r['kls'] . '</option>';
	endwhile;
endif;
