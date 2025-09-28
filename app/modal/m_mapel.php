<?php
require_once "../../config/server.php";



$id = $_POST['id'] ?? '';
$nm = $_POST['nm'] ?? '';
$skt = $_POST['skt'] ?? '';

$idgr = '';
if ($id != '') {
	$ck = $pdo_conn->prepare("SELECT * FROM tb_mpel WHERE kd_mpel = :id");
	$ck->bindParam(':id', $id);
	$ck->execute();
	while ($a = $ck->fetch(PDO::FETCH_ASSOC)) {
		$idgr = json_decode($a['guru']);
	}
}

?>


<div class="col mb-3">
	<label for="kode" class="form-label">Kode Mata Pelajaran</label>
	<input type="text" name="kode" id="kode" class="form-control" maxlength="10" value="<?= $id; ?>">
</div>
<div class="col mb-3">
	<label for="mpel" class="form-label">Mata Pelajaran</label>
	<input type="text" name="mpel" id="mpel" class="form-control" value="<?= $nm; ?>">
</div>
<div class="col mb-3">
	<label for="sgkat" class="form-label">Singkat Mata Pelajaran</label>
	<input type="text" name="sgkat" id="sgkat" class="form-control" maxlength="8" value="<?= $skt; ?>">
</div>
<div class="col mb-3">
	<div class="form-label">Guru Yang Mengajar</div>
	<div class="row">
		<?php
		$gr = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE jptk = ?");
		$gr->execute(['Guru']);
		while ($rw = $gr->fetch(PDO::FETCH_ASSOC)) {

			$cek = '';
			if ($idgr != '') {
				foreach ($idgr as $key) {
					$ck = $pdo_conn->prepare("SELECT * FROM tb_mpel WHERE guru LIKE :idgr");
					$ck->bindParam(':idgr', $key);
					$ck->execute();
					$ck->rowCount();

					if ($ck != 0 && $rw['id_staf'] == $key) {
						$cek = 'checked';
					}
				}
			}
		?>
			<div class="col-6 from-check">
				<input type="checkbox" name="<?= $rw['id_staf']; ?>" id="guru[]" class="form-check-input" value="<?= $rw['id_staf']; ?>" <?= $cek; ?>>
				<label for="<?= $rw['id_staf']; ?>" class="form-check-label"><?= $rw['nm_staf']; ?></label>
			</div>
		<?php
		}
		?>
	</div>
</div>