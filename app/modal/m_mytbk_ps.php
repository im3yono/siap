<?php
require_once "../../config/server.php";


$md = $_POST['md'];


if ($md == 'sync'): ?>

	<form method="post">
		<div class="row gap-3 justify-content-center">
			<div class="col-11">
				<label for="syn" class="form-label">Data Singkron</label>
				<select class="form-select" name="syn" id="syn" required>
					<option selected disabled value="">--Pilih--</option>
					<option value="1">Semua siswa</option>
					<option value="2">Semua siswa kecuali tingkat akhir</option>
					<option value="3">Semua siswa tingkat akhir</option>
					<!-- <option value="3">Ujian Semester Ganjil</option>
					<option value="4">Ujian Semester Ganap</option> -->
				</select>
			</div>
			<div class="col-11">
				<label for="no_ps" class="form-label">Format Nama Pengguna</label>
				<input type="text" class="form-control" name="no_ps" id="no_ps" placeholder="isi awalan nama pengguna tanpa spasi" required>
			</div>
			<div class="col-12 text-center pt-3">
				<button type="button" class="btn btn-primary"><span class="myicon myicon-send"></span> Kirim</button>
				<!-- <button type="button" class="btn btn-outline-primary"><span class="myicon myicon-download"></span> Download File Upload Peserta</button> -->
			</div>
		</div>
	</form>


<?php
endif;

if ($md == 'down'): ?>

	<form action="./app/report/mytbk_fu_peserta" method="post">
		<div class="row gap-3 justify-content-center">
			<div class="col-11">
				<div class="col">Data kelas yang digunakan</div>
				<div class="row m-0">
					<?php
					$d_kls = db_Proses($pdo_conn, "SELECT tkt FROM tb_kls GROUP BY tkt");
					while ($row = $d_kls->fetch(PDO::FETCH_ASSOC)):
					?>
						<div class="form-check col-4">
							<input type="checkbox" name="tkt[]" id="<?= $row['tkt']; ?>" class="form-check-input" value="<?= $row['tkt']; ?>">
							<label for="<?= $row['tkt']; ?>" class="form-label"><?= $row['tkt']; ?></label>
						</div>
					<?php endwhile; ?>
				</div>
			</div>
			<div class="col-11">
				<label for="no_ps" class="form-label">Format Nama Pengguna</label>
				<input type="text" class="form-control" name="no_ps" id="no_ps" placeholder="isi awalan nama pengguna tanpa spasi (*****001)" required>
			</div>
			<div class="col-12 text-center pt-3">
				<!-- <button type="button" class="btn btn-primary"><span class="myicon myicon-send"></span> Kirim</button> -->
				<button type="submit" class="btn btn-outline-primary"><span class="myicon myicon-download"></span> Download File Upload Peserta</button>
			</div>
		</div>
	</form>


<?php
endif;

if ($md == 'sync_kls'): ?>
	<form method="post" id="sync">
		<div class="row gap-3 justify-content-center">
			<div class="col-12 text-center m-0">
				<p class="alert alert-info mx-3">
					Pastikan nama database sudah sesuai/sama dengan yang di Aplikasi MyTBK.
					Jika tidak sesuai silahkan perbaiki pada Aplikasi MyTBK.
				</p>
			</div>
			<div class="col-auto m-0 text-center" id="stt_sync">
				<label for="db" class="form-label">Database MyTBK</label>
				<input type="text" name="db" id="db" class="form-control text-center" value="<?= $acc_db; ?>" readonly>
			</div>
			<div class="col-12 text-center">
				<button type="button" class="btn btn-outline-primary" onclick="prData('sync','kls','stt_sync')">Proses</button>
			</div>
		</div>
	</form>
<?php
endif;

if ($md == 'gnert'):
	$data_post = $_POST['data'];
	$rombel = $data_post[1] != 'all' ? $data_post[1] : "Semua";
	$kls = $data_post[0] != 'all' ? $data_post[0] . ' (' . $rombel . ')' : $rombel;
?>
	<form method="post" id="gnert">
		<div class="row gap-3 justify-content-center">
			<div class="col-12 m-0" style="text-align: justify;">
				<p class="alert alert-info mx-3">
					<!-- Fitur ini digunakan untuk generate nama pengguna peserta asesmen, pastikan data peserta sudah sesuai dengan yang akan digunakan pada aplikasi MyTBK. <br> -->
					Format nama pengguna yang dihasilkan adalah awalan yang diinputkan pada form berikut diikuti dengan nomor urut peserta, contoh jika awalan yang diinputkan adalah <b>"siap"</b> maka nama pengguna yang dihasilkan adalah siap001, siap002, dst.
				</p>
			</div>
			<!-- <div class="col-11">
				<div class="col">Data kelas yang digunakan</div>
				<div class="row m-0">
					<?php
					$d_kls = db_Proses($pdo_conn, "SELECT tkt FROM tb_kls GROUP BY tkt");
					while ($row = $d_kls->fetch(PDO::FETCH_ASSOC)):
					?>
						<div class="form-check col-4">
							<input type="checkbox" name="tkt[]" id="<?= $row['tkt']; ?>" class="form-check-input" value="<?= $row['tkt']; ?>">
							<label for="<?= $row['tkt']; ?>" class="form-label"><?= $row['tkt']; ?></label>
						</div>
					<?php endwhile; ?>
				</div>
			</div> -->
			<div class="col-11">
				<div class="alert alert-success">Kelas : <?= $kls; ?></div>
			</div>
			<div class="col-11">
				<label for="no_ps" class="form-label">Format Nama Pengguna</label>
				<input type="text" class="form-control" name="no_ps" id="no_ps" placeholder="isi awalan nama pengguna tanpa spasi" required>
			</div>
			<div class="col-12 text-center">
				<button type="button" class="btn btn-outline-primary" id="generate"><span class="myicon myicon-manufacturing"></span> Generate</button>
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function() {
			$('#generate').on('click', function() {

				let prefix = $('#no_ps').val().trim();

				if (prefix.includes(' ')) {
					notif("warning", "", "format nama pengguna tidak boleh mengandung spasi");
					$('#no_ps').focus();
					return;
				}
				if (prefix === '') {
					notif("warning", "", "format nama pengguna tidak boleh kosong");
					$('#no_ps').focus();
					return;
				}
				$('.user').val('');
				let counter = 1;

				$('#tableData tbody tr').each(function() {

					let nomor = String(counter).padStart(3, '0');
					let username = prefix + nomor;

					$(this).find('.user').val(username);

					counter++;
				});
				$('#modal').modal('hide');
			});
		});
	</script>
<?php
endif;

if ($md == 'NSRIP'): ?>
	<div class="col-12 m-0" style="text-align: justify;">
		<?php 
		$start = db_Proses(db_Mytbk(),"SELECT MAX(user) AS up FROM cbt_peserta;");
		$start = $start->fetch(PDO::FETCH_ASSOC);

		?>
		<p class="alert alert-success mx-3">
			<!-- Fitur ini digunakan untuk generate nama pengguna peserta asesmen, pastikan data peserta sudah sesuai dengan yang akan digunakan pada aplikasi MyTBK. <br> -->
			Format nama pengguna yang dihasilkan adalah awalan yang diinputkan pada form berikut diikuti dengan nomor urut peserta <b>tanpa menggunakan spasi</b>, contoh jika awalan yang diinputkan adalah <b>"siap"</b> maka nama pengguna yang dihasilkan adalah siap001, siap002, dst. <br><br>
			Silahkan sesuaikan data pada tabel ini untuk menghasilkan generate data perkelas.
		</p>
	</div>
	<table class="table table-sriped" id="nsrip">
		<thead class="text-center">
			<th>No</th>
			<th>Kelas</th>
			<th>Siswa</th>
			<th>Format Nama Pengguna</th>
			<th>Sesi</th>
			<th>Ruang</th>
			<th>IP Server</th>
		</thead>
		<tbody>
			<?php
			//SELECT * FROM kelas WHERE kls = 'X' AND nm_kls = 'X B';
			$data_post = $_POST['data'];
			$kls = $data_post[0] != 'all' ? $data_post[0] : '';
			$rombel = $data_post[1] != 'all' ? $data_post[1] : '';

			$conditions = [];
			$params = [];

			if ($kls != '') {
				$conditions[] = "tkt = ?";
				$params[] = $kls;
			}

			if ($rombel != '') {
				$conditions[] = "kls = ?";
				$params[] = $rombel;
			}

			$params[] = 'R'; // sts_kls = 'R'
			$cr = count($conditions) > 0 ? 'WHERE ' . implode(" AND ", $conditions) . " AND sts_kls = ? " : "WHERE sts_kls = ? ";
			$sql = "SELECT * FROM tb_kls $cr ORDER BY kls ASC";
			$d_kls = db_Proses($pdo_conn, $sql, $params);

			while ($r = $d_kls->fetch(PDO::FETCH_ASSOC)):
				$jml_sis = db_Proses($pdo_conn, "SELECT COUNT(*) AS jml FROM tb_dsis WHERE kls = '$r[kls]' GROUP BY kls;");
				$jml_sis = $jml_sis->fetch(PDO::FETCH_ASSOC);
				$np = str_replace(' ','',$r['kls']);
			?>
				<tr>
					<td class="text-center"><?= $notbl; ?></td>
					<td><?= $r['kls']; ?></td>
					<td class="text-center"><?= $jml_sis['jml'] ?></td>
					<td style="min-width: 155px;max-width: 155px;">
						<input type="text" class="form-control form-control-sm in_user" placeholder="Nama pengguna tanpa spasi" value="<?= $np; ?>-">
					</td>
					<td style="min-width: 70px;max-width: 70px;">
						<input type="number" class="form-control form-control-sm in_sesi text-end" min="1" max="10" value="1">
					</td>
					<td style="min-width: 70px;max-width: 70px;">
						<input type="number" class="form-control form-control-sm in_ruang text-end" min="1" max="99" value="<?= $notbl++; ?>">
					</td>
					<td style="min-width: 155px;">
						<input type="text" class="form-control form-control-sm in_ip" placeholder="192.168.xxx.xxx" maxlength="15">
					</td>
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>
	<div class="col-12 text-center">
		<button type="button" class="btn btn-outline-primary" id="generate"><span class="myicon myicon-manufacturing"></span> Generate</button>
	</div>
	<script>
		$(document).ready(function() {

			$('#generate').on('click', function() {

				let tableMap = {};
				let pesanError = "";
				let valid = true;

				let ipRegex = /^(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)\.(25[0-5]|2[0-4]\d|1\d\d|[1-9]?\d)$/;

				// =========================
				// Ambil data dari tabel nsrip
				// =========================
				$('#nsrip tbody tr').each(function(index) {

					let tr = $(this);

					let kls = tr.find('td:eq(1)').text().trim();
					let user = tr.find('.in_user').val().trim();
					let sesi = tr.find('.in_sesi').val().trim();
					let ruang = tr.find('.in_ruang').val().trim();
					let ipsv = tr.find('.in_ip').val().trim();

					if (!user || !sesi || !ruang || !ipsv) {
						pesanError = "Baris ke-" + (index + 1) + " masih ada yang kosong!";
						valid = false;
						return false;
					}

					if (user.includes(' ')) {
						pesanError = "Format nama pengguna tidak boleh mengandung spasi (Baris ke-" + (index + 1) + ")";
						valid = false;
						return false;
					}

					if (!ipRegex.test(ipsv)) {
						pesanError = "Format IP tidak valid (Baris ke-" + (index + 1) + ")";
						valid = false;
						return false;
					}

					// Simpan berdasarkan key kelas
					tableMap[kls] = {
						user: user,
						sesi: sesi,
						ruang: ruang,
						ipsv: ipsv
					};

				});

				if (!valid) {
					notif('error', 'Validasi Gagal', pesanError);
					return;
				}

				// =========================
				// Terapkan ke tableData
				// =========================
				let counter = 1;
				$('#tableData tbody tr').each(function() {

					let tr = $(this);


					// ambil kelas dari kolom ke-5
					let klsTableData = tr.find('td:eq(5)').text().trim();

					if (tableMap[klsTableData]) {
						let nomor = String(counter).padStart(3, '0');
						let username = tableMap[klsTableData].user + nomor;

						tr.find('.user').val(username);
						tr.find('.user').attr('readonly', true);
						tr.find('.sesi').val(tableMap[klsTableData].sesi);
						tr.find('.ruang').val(tableMap[klsTableData].ruang);
						tr.find('.ip_server').val(tableMap[klsTableData].ipsv);

						counter++;
					}

				});
				stsView();
				$('#modal').modal('hide');

				notif('success', 'Berhasil', 'Generate berdasarkan kelas berhasil diterapkan.');

			});

		});
	</script>
<?php
endif;
?>

<script>
	function prData(idForm, prd, sts = '') {
		var formData = $('#' + idForm)[0];
		if (!formData) return;

		var btn = event.target;
		btn.disabled = true;
		var data = new FormData(formData);

		data.append('prd', prd);

		$.ajax({
			type: 'POST',
			url: 'app/proses/pr_mytbk',
			data: data,
			contentType: false,
			processData: false,
			success: function(res) {
				console.log(res);
				$('#' + sts).html('<div class="alert alert-success">' + res + '</div>');
				notif("success", "Berhasil", res, 'okay', 'mytbk_ps')
			}
		})

	}
</script>