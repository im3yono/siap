<?php
require_once '../../config/server.php'; // sesuaikan path


$d_jurnal = db_Proses($pdo_conn, "SELECT * FROM tb_jrnl ORDER BY tgl DESC, kd_staf ASC");

while ($r = $d_jurnal->fetch(PDO::FETCH_ASSOC)): ?>

	<tr>
		<td align="end"><?= $notbl++; ?></td>
		<td><?= $r['kd_staf']; ?></td>
		<td><?= $r['kd_mpel']; ?></td>
		<td><?= $r['kls']; ?></td>
		<td><?= $r['tgl']; ?></td>
		<td><?= $r['materi']; ?></td>
		<td><?= $r['kgitan']; ?></td>
		<td><?= $r['ket']; ?></td>
	</tr>


<?php endwhile; ?>