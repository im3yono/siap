<?php
require_once '../../config/server.php'; // sesuaikan path

if (empty($_POST['tkt'])) exit;

$tkt = $_POST['tkt'];

$stmt = $pdo_conn->prepare("
    SELECT nipd, nisn, nm, kls 
    FROM tb_dsis
    WHERE kls LIKE :tkt
    ORDER BY nm ASC
");
$stmt->execute([':tkt' => $tkt . '%']);

$no = 1;

if ($stmt->rowCount() == 0) {
	echo '<tr><td colspan="5" class="text-center">Data tidak ditemukan</td></tr>';
	exit;
}

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
?>
	<tr>
		<td><?= $no++; ?></td>
		<td><?= $row['nipd']; ?><br><?= $row['nisn']; ?></td>
		<td><?= $row['nm']; ?></td>
		<td><?= $row['kls']; ?></td>
		<td>
			<input class="form-check-input row-check"
				type="checkbox"
				name="siswa[]"
				value="<?= $row['nipd']; ?>">
		</td>
	</tr>
<?php } ?>