<?php
// <!-- INSERT INTO `tb_dsis` (`id_dsis`, `nipd`, `nisn`, `nama`, `jk`, `tmp_lahir`, `tgl_lahir`, `nik`, `nkk`, `agm`, `almt`, `tmp_tinggal`, trasport, `tlp/hp`, `email`, `ayah`, `ibu`, `wali`, `masuk`, `kls`, `no_akta`, `disabel`, `sklh_asl`, `saudr`, `bb_tb_lk`, `jrk_rmh`, `sts`, `rcd`, `upd`) VALUES (NULL, '1', '1', '1', 'L', '1', '2025-09-01', '1', '1', '1', '1', '11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', current_timestamp(), current_timestamp()); -->

require_once "../../config/server.php";

$stmt = $pdo_conn->prepare("SELECT * FROM tb_dsis");
$stmt->execute();


while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	$almt 	= json_decode($row['almt'], true);
	$jl 		= $almt['almt'] != "" ? $almt['almt'] : '';
	$rt 		= $almt['rt'] != "" ? $almt['rt'] : '0';
	$rw 		= $almt['rw'] != "" ? $almt['rw'] : '0';
	$dusun 	= $almt['dusun'] != "" ? ", Dusun " . $almt['dusun'] : '';
	$kel 		= $almt['kel'] != "" ? $almt['kel'] : '';
	$kec 		= $almt['kec'] != "" ? $almt['kec'] : '';
	$kdpos 	= $almt['kdpos'] != "" ? ", Kode Pos " .$almt['kdpos'] : '';

	$almt = $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;
?>

	<tr>
		<th><?= $notbl++; ?></th>
		<td><?= $row['nipd'] . "/" . $row['nisn']; ?></td>
		<td><?= f_nama($row['nm']); ?></td>
		<td><?= $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan"; ?></td>
		<td><?= f_nama($row['tmp_lahir']) . "<br>" . tgl($row['tgl_lahir']); ?></td>
		<td><?= $almt; ?></td>
		<td>
			<?= $row['ayah']; ?> (Ayah)
			<br>
			<?= $row['ibu']; ?> (Ibu)
			<br>
			<?= $row['wali']; ?> (Wali)
		</td>
		<td>
			<div class="row g-1">
				<div class="col-12">
					<button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal" style="width: 80px;"><i class="bi bi-card-text"></i> Lihat</button>
				</div>
				<div class="col-12">
					<button class="btn btn-sm btn-info" style="width: 80px;"><i class="bi bi-pencil"></i> Edit</button>
				</div>
				<div class="col-12">
					<button class="btn btn-sm btn-danger" style="width: 80px;"><i class="bi bi-trash3"></i> Hapus</button>
				</div>
			</div>
		</td>
	</tr>
<?php } ?>