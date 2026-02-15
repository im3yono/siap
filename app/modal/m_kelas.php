<?php
require_once "../../config/server.php";

$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC");
$guru = db_Proses($pdo_conn, "SELECT kd_staf AS id, nm_staf AS nama FROM tb_dstaf WHERE jptk = ? ORDER BY nama ASC", ["Guru"]);

$id_kls = $_POST['id'] ?? ''; // id_kls
$d_kls 	= $_POST['id2'] ?? ''; // kls
$prd 		= $_POST['prd'] ?? '';
$tkt 		= '';
$skls 	= '';
$walas 	= '';
if ($id_kls != '') {
	$dkls = db_Proses($pdo_conn, "SELECT * FROM tb_kls WHERE id_kls = ?", [$id_kls]);
	$dkls = $dkls->fetch(PDO::FETCH_ASSOC);
	$tkt 	= $dkls['tkt'];
	$skls = $dkls['kls'];
	$walas = $dkls['kd_staf'];
	$d_sis = json_decode($dkls['d_sis'], true);
}

// Tambah Kelas
if ($prd == 'add'):
?>
	<form method="post" id="add_kls">
		<input type="text" name="id" id="id" value="<?= $id_kls; ?>" hidden>
		<div class="row g-2">
			<div class="col-12 col-sm-6">
				<label for="kls" class="form-label">Kelas</label>
				<select name="kls" id="kls" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<?php 
					while ($r_kls = $kls->fetch(PDO::FETCH_ASSOC)) {
						$hide = db_Proses($pdo_conn, 'SELECT * FROM tb_kls WHERE kls = ?', [$r_kls['kls']])->fetch(PDO::FETCH_ASSOC);
						if ($hide['kd_staf'] != '' && $id_kls == '') {
							$hide = ' hidden';
						} else {
							$hide = '';
						}
					?>
						<option value="<?= $r_kls['kls']; ?>" <?= $hide; ?><?= $skls == $r_kls['kls'] ? 'selected' : ''; ?>><?= $r_kls['kls']; ?></option>
					<?php } ?>
				</select>
				<script>
					$(document).ready(function() {
						$('#kls').on('change', function() {
							let kls = $(this).val();

							if (kls != '') {
								$('#tkt').removeAttr('disabled', false);
								$('#walas').removeAttr('disabled', false);
							} else {
								$('#tkt').attr('disabled', true);
								$('#walas').attr('disabled', true);
							}
						});
					});
				</script>
			</div>
			<div class="col-12 col-sm-6">
				<label for="tkt" class="form-label">Tingkat</label>
				<select name="tkt" id="tkt" class="form-select" disabled>
					<option value="" selected>-- Pilih --</option>
					<option value="X" <?= $tkt == 'X' ? 'selected' : ''; ?>>X</option>
					<option value="XI" <?= $tkt == 'XI' ? 'selected' : ''; ?>>XI</option>
					<option value="XII" <?= $tkt == 'XII' ? 'selected' : ''; ?>>XII</option>
				</select>
			</div>
			<div class="col-12">
				<label for="walas" class="form-label">Wali Kelas</label>
				<select name="walas" id="walas" class="form-select" <?= $tkt == '' ? 'disabled' : '' ?>>
					<option value="" selected disabled>-- Pilih --</option>
					<?php while ($r_guru = $guru->fetch(PDO::FETCH_ASSOC)) {
						$hide = db_Proses($pdo_conn, 'SELECT * FROM tb_kls WHERE kd_staf = ?', [$r_guru['id']]);
						// $hide = $hide->fetch(PDO::FETCH_ASSOC);
						if ($hide->rowCount() > 0 && ($id_kls == '' || $walas != $r_guru['id'])) {
							$hide = ' hidden';
						} else {
							$hide = '';
						} ?>
						<option value="<?= $r_guru['id']; ?>" <?= $hide; ?><?= $walas == $r_guru['id'] ? 'selected' : ''; ?>><?= $r_guru['nama']; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
	</form>
<?php
endif;

// Tambah Kelas Khusus
if ($prd == 'addkk'):
?>
	<form method="post" id="add_kls">
		<input type="text" name="id" id="id" value="<?= $id_kls; ?>" hidden>
		<div class="row g-2">
			<div class="col-12 col-sm-6">
				<label for="kls" class="form-label">Nama Kelas</label>
				<input type="text" class="form-control" id="kls" name="kls" maxlength="20" value="<?= $d_kls; ?>">

				<?php if (empty($d_kls)): ?>
					<script>
						$(document).ready(function() {
							$('#kls').on('keydown, change', function() {
								let kls = $(this).val();

								if (kls != '') {
									$('#tkt').removeAttr('disabled', false);
									$('#walas').removeAttr('disabled', false);
								} else {
									$('#tkt').attr('disabled', true);
									$('#walas').attr('disabled', true);
								}
							});
						});
					</script>
				<?php endif; ?>
			</div>
			<div class="col-12 col-sm-6">
				<label for="tkt" class="form-label">Tingkat</label>
				<select name="tkt" id="tkt" class="form-select" required <?= empty($d_kls) ? 'disabled' : ''; ?>>
					<option value="" selected disabled>-- Pilih --</option>
					<option value="X" <?= $tkt == 'X' ? 'selected' : ''; ?>>X</option>
					<option value="XI" <?= $tkt == 'XI' ? 'selected' : ''; ?>>XI</option>
					<option value="XII" <?= $tkt == 'XII' ? 'selected' : ''; ?>>XII</option>
				</select>
			</div>
			<div class="col-12">
				<label for="walas" class="form-label">Wali Kelas</label>
				<select name="walas" id="walas" class="form-select" required <?= $tkt == '' ? 'disabled' : '' ?>>
					<option value="" selected disabled>-- Pilih --</option>
					<?php while ($r_guru = $guru->fetch(PDO::FETCH_ASSOC)) {
						$hide = db_Proses($pdo_conn, 'SELECT * FROM tb_kls WHERE kd_staf = ?', [$r_guru['id']]);
						// $hide = $hide->fetch(PDO::FETCH_ASSOC);
						if ($hide->rowCount() > 0 && ($id_kls == '' || $walas != $r_guru['id'])) {
							$hide = ' hidden';
						} else {
							$hide = '';
						} ?>
						<option value="<?= $r_guru['id']; ?>" <?= $hide; ?><?= $walas == $r_guru['id'] ? 'selected' : ''; ?>><?= $r_guru['nama']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="col-12 py-3">
				<div class="table-responsive" style="max-height: 350px;">
					<table class="table table-hover border-black" id="mjtable">
						<thead>
							<th>No</th>
							<th>NIS/NISN</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Pilih</th>
						</thead>
						<tbody id="tbody-siswa">
							<tr>
								<td colspan="5" class="text-center">Pilih tingkat terlebih dahulu</td>
							</tr>
						</tbody>

					</table>
				</div>
			</div>
		</div>
		<?php if (!empty($d_kls)) : ?>
			<script>
				$(document).ready(function() {
					$('#tkt').val('<?= $tkt ?>').trigger('change');
				});
			</script>
		<?php endif; ?>
		<script>
			$('#tkt').on('change', function() {
				let tingkat = $(this).val();
				let kls = $('#kls').val();

				$.ajax({
					url: 'app/table/t_md_kls',
					type: 'POST',
					data: {
						tkt: tingkat,
						kls: kls
					},
					beforeSend: function() {
						$('#tbody-siswa').html(
							'<tr><td colspan="5" class="text-center">Memuat data...</td></tr>'
						);
					},
					success: function(res) {
						$('#tbody-siswa').html(res);

						// let dtSiswa = new simpleDatatables.DataTable("#mjtable", {
						// 	searchable: true,
						// 	paging: false,
						// 	perPage: -1,
						// 	perPageSelect: false,
						// 	labels: {
						// 		placeholder: "Cari Siswa...",
						// 		noRows: "Tidak ada data yang ditemukan",
						// 		info: "Menampilkan {rows} Data"
						// 	}
						// });

						// // WAJIB: refresh setelah tbody diganti
						// dtSiswa.refresh();
					},
					error: function() {
						$('#tbody-siswa').html(
							'<tr><td colspan="5" class="text-danger text-center">Gagal memuat data</td></tr>'
						);
					}
				});
			});
		</script>


	</form>
<?php
endif;
if ($prd == 'edt' && $id_kls != '') :
	$dt_sis = db_Proses($pdo_conn, "SELECT nipd, nm, kls FROM tb_dsis WHERE kls = ''");
	$cek = $dt_sis->rowCount() > 0 ? '' : 'hidden';
?>
	<form method="post" id="add_kls">
		<input type="hidden" value="<?= $id_kls; ?>" name="id">
		<input type="hidden" value="<?= $tkt; ?>" name="tkt">
		<input type="hidden" value="<?= $d_kls; ?>" name="kls">
	<div class="row">
		<div class="col-12">
			<label for="walas" class="form-label">Wali Kelas</label>
			<select name="walas" id="walas" class="form-select">
				<option value="" selected disabled>-- Pilih --</option>
				<?php while ($r_guru = $guru->fetch(PDO::FETCH_ASSOC)) {
					$hide = db_Proses($pdo_conn, 'SELECT * FROM tb_kls WHERE kd_staf = ?', [$r_guru['id']]);
					// $hide = $hide->fetch(PDO::FETCH_ASSOC);
					if ($hide->rowCount() > 0 && ($id_kls == '' || $walas != $r_guru['id'])) {
						$hide = ' hidden';
					} else {
						$hide = '';
					} ?>
					<option value="<?= $r_guru['id']; ?>" <?= $hide; ?><?= $walas == $r_guru['id'] ? 'selected' : ''; ?>><?= $r_guru['nama']; ?></option>
				<?php } ?>
			</select>
		</div>
	</div>
	</form>
	<div class="row my-2" <?= $cek; ?>>
		<div class="col">
			<!-- <label for="nmsis" class="form-label">Nama Siswa</label> -->
			<select name="nmsis" id="nmsis" class="form-select form-select-sm">
				<option value="" selected disabled>-- Pilih Nama Siswa --</option>
				<?php
				while ($row = $dt_sis->fetch(PDO::FETCH_ASSOC)) {
					echo '<option value="' . $row['nipd'] . '">' . $row['nm'] . '</option>';
				}
				?>
				<!-- <option value="">1</option> -->
			</select>
		</div>
		<div class="col-auto">
			<button type="button" class="btn btn-primary" id="add">Tambah</button>
		</div>
	</div>
	<div class="row border-bottom my-3"></div>

	<table class="table border-black table-hover m-2" id="jtable">
		<thead>
			<th style="width: 30px;">No</th>
			<th style="width: 120px;">NIPD</th>
			<th style="width: auto;">Nama</th>
			<th style="width: 100px;">Opsi</th>
		</thead>
		<tbody>
			<?php
			// $d_kls = db_Proses($pdo_conn, "SELECT * FROM tb_kls WHERE kls = ?", [$skls]);
			if (empty(is_array($d_sis))) {
				$stmt = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE kls = ?", [$skls]);

				while ($r_sis = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
					<tr>
						<td><?= $notbl++; ?></td>
						<td><?= $r_sis['nipd']; ?></td>
						<td><?= $r_sis['nm']; ?></td>
						<td>
							<button type="button" class="btn btn-sm btn-danger" onclick="delData('<?= $r_sis['nipd']; ?>','<?= $d_kls; ?>','<?= $r_sis['nm']; ?>')"><i class="bi bi-trash3"></i></button>
						</td>
					</tr>
				<?php
				}
			} else if (is_array($d_sis)) {
				foreach ($d_sis as $nipd) {
					$r_sis = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE nipd = ?", [$nipd])->fetch(PDO::FETCH_ASSOC);
				?>
					<tr>
						<td><?= $notbl++; ?></td>
						<td><?= $r_sis['nipd']; ?></td>
						<td><?= $r_sis['nm']; ?></td>
						<td>
							<button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
						</td>
					</tr>
			<?php
				}
			} ?>
		</tbody>
	</table>

	<script>
		function delData(id, kls, nm = '') {
			Swal.fire({
				title: 'Hapus Data!',
				text: "Yakin menghapus " + nm + " dari kelas " + kls + "?",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Ya, Hapus!',
				cancelButtonText: 'Batal'
			}).then((result) => {
				if (result.isConfirmed) {
					// $.ajax({
					// 	type: 'POST',
					// 	url: 'app/proses/pr_kls.php',
					// 	data: {
					// 		id: id,
					// 		prd: 'del'
					// 	},
					// 	success: function(response) {
					// 		if (response === 'ok') {
					// 			Swal.fire(
					// 				'Terhapus!',
					// 				kls + ' berhasil dihapus.',
					// 				'success'
					// 			).then(() => {
					// 				r_halaman(); // Muat ulang halaman tanpa menambah ke riwayat
					// 			});
					// 		} else {
					// 			Swal.fire(
					// 				'Gagal!',
					// 				'Gagal menghapus <b>' + kls + '</b>. Silahkan coba lagi.',
					// 				'error'
					// 			);
					// 		}
					// 		// console.log(response);
					// 	},
					// 	error: function() {
					// 		Swal.fire(
					// 			'Gagal!',
					// 			'Silahkan coba lagi.',
					// 			'error'
					// 		);
					// 	}
					// });
				}
			});
		}
	</script>

<?php
endif;
?>