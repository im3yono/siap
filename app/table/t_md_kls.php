<?php
require_once '../../config/server.php'; // sesuaikan path

if (empty($_POST['tkt'])) {
	exit;
}

$tkt = $_POST['tkt'];
$kls = $_POST['kls'] ?? '';

// default agar tidak undefined
$dt_sis = [];

// ambil data siswa terpilih dari tb_kls
$d_sis = db_Proses(
	$pdo_conn,
	"SELECT d_sis FROM tb_kls WHERE kls = ?",
	[$kls]
);

if ($d_sis->rowCount() > 0) {
	$rowSis = $d_sis->fetch(PDO::FETCH_ASSOC);

	if (!empty($rowSis['d_sis'])) {
		$decoded = json_decode($rowSis['d_sis'], true);
		if (is_array($decoded)) {
			$dt_sis = $decoded;
		}
	}
}

// ambil data siswa
$stmt = db_Proses(
	$pdo_conn,
	"SELECT nipd, nisn, nm, kls FROM tb_dsis WHERE kls LIKE ? ORDER BY nm ASC",
	[$tkt . ' %']
);

$no = 1;

if ($stmt->rowCount() == 0) {
	echo '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
	exit;
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$cek = in_array($row['nipd'], $dt_sis) ? 'checked' : '';
?>
	<tr>
		<td><?= $no++; ?></td>
		<td><?= $row['nipd']; ?><br><?= $row['nisn']; ?></td>
		<td><?= $row['nm']; ?></td>
		<td><?= $row['kls']; ?></td>
		<td>
			<input class="form-check-input row-check" type="checkbox" name="siswa[]" value="<?= $row['nipd']; ?>" <?= $cek; ?>>
		</td>
	</tr>
<?php } ?>