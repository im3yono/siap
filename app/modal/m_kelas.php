<?php
require_once "../../config/server.php";

$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC");
$guru = db_Proses($pdo_conn, "SELECT kd_staf AS id, nm_staf AS nama FROM tb_dstaf WHERE jptk = ? ORDER BY nama ASC", ["Guru"]);

$id_kls = $_POST['id'] ?? ''; //echo$id_kls;
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
					<?php while ($r_kls = $kls->fetch(PDO::FETCH_ASSOC)) {
						$hide = db_Proses($pdo_conn, 'SELECT * FROM tb_kls WHERE kls = ?', [$r_kls['kls']]);
						$hide = $hide->fetch(PDO::FETCH_ASSOC);
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
				<input type="text" class="form-control" id="kls" name="kls" maxlength="20">
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
			</div>
			<div class="col-12 col-sm-6">
				<label for="tkt" class="form-label">Tingkat</label>
				<select name="tkt" id="tkt" class="form-select" required disabled>
					<option value="" selected disabled>-- Pilih --</option>
					<option value="X">X</option>
					<option value="XI">XI</option>
					<option value="XII">XII</option>
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
		<script>
			// (function() {
			// 	function initTables(container) {
			// 		container.find('table').each(function() {
			// 			if (this.dataset.sdInit) return;
			// 			new simpleDatatables.DataTable(this, {
			// 				perPageSelect: '',
			// 				perPage: '',
			// 				labels: {
			// 					placeholder: "Cari Siswa...",
			// 					perPage: " Data per halaman",
			// 					noRows: "Tidak ada data yang ditemukan",
			// 					info: "Menampilkan {rows} Data",
			// 				}
			// 			});
			// 			this.dataset.sdInit = '1';
			// 		});
			// 	}

			// 	function loadSimpleDatatables(cb) {
			// 		var url = './assets/js/simple-datatables.js';
			// 		if (typeof simpleDatatables !== 'undefined') return cb();
			// 		var s = document.createElement('script');
			// 		s.src = url;
			// 		s.onload = cb;
			// 		document.head.appendChild(s);
			// 	}

			// 	// Initialize when modal is shown (works if modal content loaded via AJAX)
			// 	$(document).on('shown.bs.modal', function(e) {
			// 		loadSimpleDatatables(function() {
			// 			initTables($(e.target));
			// 		});
			// 	});

			// 	// Also initialize immediately for inline tables (non-modal)
			// 	$(function() {
			// 		loadSimpleDatatables(function() {
			// 			initTables($(document));
			// 		});
			// 	});
			// })();
		</script>
		<script>
			$('#tkt').on('change', function() {
				let tingkat = $(this).val();

				$.ajax({
					url: 'app/table/md_kls.php',
					type: 'POST',
					data: {
						tkt: tingkat
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
if ($prd == 'edt' && $id_kls != '') { ?>
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
			$stmt = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE kls = ?", [$skls]);

			while ($r_sis = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
				<tr>
					<td><?= $notbl++; ?></td>
					<td><?= $r_sis['nipd']; ?></td>
					<td><?= $r_sis['nm']; ?></td>
					<td>
						<button type="button" class="btn btn-sm btn-danger"><i class="bi bi-trash3"></i></button>
					</td>
				</tr>
			<?php
			} ?>
		</tbody>
	</table>
<?php
}
?>