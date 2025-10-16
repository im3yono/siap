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