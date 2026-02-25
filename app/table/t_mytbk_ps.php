<?php require_once "t_sacc.php";

$prd = $_POST['prd'];

if ($prd == "d_peserta"):
	$kls_filter     = $_POST['kls'] ?? 'all';
	$rombel_filter  = $_POST['rombel'] ?? 'all';
?>
	<div class="row my-3 mx-2 p-2 border-bottom">
		<!-- <div class="col-auto">
			<button type="button" class="btn btn-primary" onclick="modalShow('Generate Nama Pengguna','gnert', ['<?= $kls_filter; ?>', '<?= $rombel_filter; ?>'])"><span class="myicon myicon-manufacturing"></span> Generate Nama Pengguna</button>
		</div> -->
		<div class="col-auto">
			<button type="button" class="btn btn-outline-primary" onclick="modalShow('Generate Nama Pengguna | Sesi | Ruang | IP','NSRIP', ['<?= $kls_filter; ?>', '<?= $rombel_filter; ?>'])"><span class="myicon myicon-manufacturing"></span> Generate Data</button>
		</div>
	</div>
	<div class="row">
		<div class="table-responsive">
			<table class="table-sync table-hover table-striped" id="tableData">
				<thead class="text-center">
					<th>No</th>
					<th>NIS</th>
					<th>Nama Peserta</th>
					<th>Tempat Lahir</th>
					<th>Tanggal Lahir</th>
					<th>Kelas</th>
					<th>Jenis Kelamin</th>
					<th>Foto</th>
					<th>Nama Pengguna</th>
					<th>Password</th>
					<th>Sesi</th>
					<th>Ruang</th>
					<th>Ip Server</th>
					<th>Status</th>
				</thead>
				<tbody>
					<?php
					$sql    = "SELECT * FROM tb_dsis";
					$params = [];
					$where  = [];

					// Jika rombel dipilih (bukan all)
					if ($rombel_filter !== 'all') {
						$where[]  = "kls = ?";
						$params[] = $rombel_filter;
					}

					// Jika tingkat kelas dipilih (bukan all)
					if ($kls_filter !== 'all') {

						// Ambil daftar kelas berdasarkan tingkat
						$dkls = db_Proses(
							$pdo_conn,
							"SELECT kls FROM tb_kls WHERE tkt = ?",
							[$kls_filter]
						);

						$klsList = [];
						while ($r = $dkls->fetch(PDO::FETCH_ASSOC)) {
							$klsList[] = $r['kls'];
						}

						if (!empty($klsList)) {
							$placeholders = rtrim(str_repeat('?,', count($klsList)), ',');
							$where[] = "kls IN ($placeholders)";
							$params  = array_merge($params, $klsList);
						}
					}

					// Gabungkan kondisi WHERE jika ada
					if (!empty($where)) {
						$sql .= " WHERE " . implode(" AND ", $where);
					}

					$sql .= " ORDER BY kls ASC, nm ASC";

					$dbp = db_Proses($pdo_conn, $sql, $params);
					while ($r = $dbp->fetch(PDO::FETCH_ASSOC)):
						$r_mytbk = db_Proses(db_Mytbk(), "SELECT * FROM cbt_peserta WHERE nis = ?", [$r['nipd']]);
						$r_mytbk     = $r_mytbk->fetch(PDO::FETCH_ASSOC);
						$username   = $r_mytbk['user'] ?? '';
						$password   = $r_mytbk['pass'] ?? rand(1234, 9999) . '*';
						$sesi       = $r_mytbk['sesi'] ?? '';
						$ruang       = $r_mytbk['ruang'] ?? '';
						$ip_server   = $r_mytbk['ip_sv'] ?? '';
						$sts 				= $r_mytbk['sts'] ?? '';

						if ($sts != '') {
							$sts = '<span class="myicon myicon-sync_saved_locally"></span>';
						} else {
							$sts = '<span class="myicon myicon-check_box_blank"></span>';
						}
					?>
						<tr>
							<td><?= $notbl++; ?></td>
							<td><?= $r['nipd']; ?></td>
							<td><?= f_nama($r['nm']); ?></td>
							<td><?= f_nama($r['tmp_lahir']); ?></td>
							<td><?= tgl($r['tgl_lahir']); ?></td>
							<td><?= $r['kls']; ?></td>
							<td><?= $r['jk']; ?></td>
							<td><img src="<?= ft($r['nipd'], 'siswa', '../../'); ?>" alt="<?= ft_nama($r['nipd'], 'siswa', '../../'); ?>" class="img-size-32"></td>
							<!-- <td><?= ft_nama($r['nipd'], 'siswa', '../../'); ?></td> -->
							<td><input type="text" class="form-control form-control-sm user" value="<?= $username; ?>"></td>
							<td><?= $password ?></td>
							<td>
								<input type="number" class="form-control form-control-sm sesi" max="10" value="<?= $sesi; ?>">
							</td>
							<td>
								<input type="number" class="form-control form-control-sm ruang" max="99" value="<?= $ruang; ?>">
							</td>
							<td>
								<input type="text" class="form-control form-control-sm ip_server" placeholder="192.168.xxx.xxx" maxlength="15" value="<?= $ip_server; ?>">
							</td>
							<td>
								<div id="sts_s"><?= $sts; ?></div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		<div class="col-12">
		</div>
	</div>
	<div class="row justify-content-end mx-3">
		<div class="col-auto" id="load" style="display: none;">
			<div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span>
			</div>
		</div>
		<div class="col-auto"><button type="button" class="btn btn-primary" id="kirim"> Kirim</button></div>
	</div>

	<script>
		$('#kirim').click(function() {

			$('#load').show();
			let tableData = [];
			let pesanError = "";
			let ipRegex = /^(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)$/;

			let valid = true;

			$('#tableData tbody tr').each(function(index) {

				let tr = $(this);

				let user = tr.find('.user').val();
				let sesi = tr.find('.sesi').val();
				let ruang = tr.find('.ruang').val();
				let ipsv = tr.find('.ip_server').val();

				// Validasi kosong
				if (!user || !sesi || !ruang || !ipsv) {
					pesanError = "Baris ke-" + (index + 1) + " masih ada yang kosong!";
					valid = false;
					return false;
				}

				// Validasi IP
				if (!ipRegex.test(ipsv)) {
					pesanError = "Format IP tidak valid (Baris ke-" + (index + 1) + ")";
					valid = false;
					return false;
				}

				tableData.push({
					nis: tr.find('td:eq(1)').text(),
					nama: tr.find('td:eq(2)').text(),
					tmp_l: tr.find('td:eq(3)').text(),
					tgl_l: tr.find('td:eq(4)').text(),
					kls: tr.find('td:eq(5)').text(),
					jk: tr.find('td:eq(6)').text(),
					ft: 'noavatar.png',
					// ft: tr.find('td:eq(7)').text(),
					// ft: tr.find('td:eq(7) img').attr('src'),
					user: user,
					pass: tr.find('td:eq(9)').text(),
					sesi: sesi,
					ruang: ruang,
					ip: ipsv
				});

			});

			if (!valid) {
				notif('error', 'Validasi Gagal', pesanError);
				return;
			}

			$.ajax({
				url: 'app/proses/pr_mytbk',
				type: 'POST',
				data: {
					data: JSON.stringify(tableData),
					prd: 'sync',
					pesan: pesanError
				},
				success: function(response) {
					// console.log(response);
					if (response.includes("Menambahkan")) {
						$('#load').hide();
						notif('success', 'Berhasil', response + '');
					} else {
						notif('error', 'Gagal', response);
					}
				}
			});

		});

		function stsView() {
			let ipRegex = /^(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)$/;

			$('#tableData tbody tr').each(function() {
				let tr = $(this);

				let user = tr.find('.user').val().trim();
				let sesi = tr.find('.sesi').val().trim();
				let ruang = tr.find('.ruang').val().trim();
				let ipsv = tr.find('.ip_server').val().trim();

				if (user && sesi && ruang && ipsv) {

					// valid jika:
					// - username tidak mengandung spasi
					// - IP valid
					if (!user.includes(' ') && ipRegex.test(ipsv)) {
						tr.find('#sts_s')
							.html('<span class="myicon myicon-check_box"></span>');
					} else {
						tr.find('#sts_s')
							.html('<span class="myicon myicon-check_box_blank"></span>');
					}
				} else {
					tr.find('#sts_s')
						.html('<span class="myicon myicon-check_box_blank"></span>');
				}
			});
		}
		$('.user, .sesi, .ruang, .ip_server').on('input', function() {
			stsView();
		})
	</script>
<?php
endif;
