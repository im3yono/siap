<style>
	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 20px;
		text-align: center;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		width: auto;
		min-width: 200px;
		text-align: left;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6) {
		min-width: 250px;
		max-width: 300px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive td:nth-child(6) {
		min-width: 250px;
		max-width: 300px;
		text-align: start;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 100px;
		max-width: 100px;
		text-align: center;
		align-content: baseline;
	}
</style>

<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	<h4>Data Siswa</h4>
</div>
<div class="row">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData"><i class="bi bi-plus-lg"></i> Tambah Data</button>
	</div>
	<div class="col-auto">
		<button data-page="up_sis" type="button" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Upload Data</button>
	</div>
</div>
<div class="row mt-5">
	<div class="table-responsive">
		<table class="table table-hover" id="jtable">
			<thead>
				<tr>
					<th>No</th>
					<th>NIS/NISN</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Tempat, Tanggal Lahir</th>
					<th>Alamat</th>
					<th>Orang Tua/Wali</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// <!-- INSERT INTO `tb_dsis` (`id_dsis`, `nipd`, `nisn`, `nama`, `jk`, `tmp_lahir`, `tgl_lahir`, `nik`, `nkk`, `agm`, `almt`, `tmp_tinggal`, trasport, `tlp/hp`, `email`, `ayah`, `ibu`, `wali`, `masuk`, `kls`, `no_akta`, `disabel`, `sklh_asl`, `saudr`, `bb_tb_lk`, `jrk_rmh`, `sts`, `rcd`, `upd`) VALUES (NULL, '1', '1', '1', 'L', '1', '2025-09-01', '1', '1', '1', '1', '11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', current_timestamp(), current_timestamp()); -->

				require_once "../config/server.php";

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
					$kdpos 	= $almt['kdpos'] != "" ? ", Kode Pos " . $almt['kdpos'] : '';

					$almt = $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;

					$ayah		= json_decode($row['ayah'], true);
					$ibu		= json_decode($row['ibu'], true);
					$wali		= json_decode($row['wali'], true);
				?>

					<tr>
						<td><?= $notbl++; ?>
							<img src="app/images/account.png" alt="<?= $row['nipd']; ?>" class="img-thumbnail shadow" style="width: 75px; height: 100px; object-fit: cover;">
						</td>
						<td><?= $row['nipd'] . "/" . $row['nisn']; ?></td>
						<td><?= f_nama($row['nm']); ?></td>
						<td><?= $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan"; ?></td>
						<td><?= f_nama($row['tmp_lahir']) . "<br>" . tgl($row['tgl_lahir']); ?></td>
						<td><?= $almt; ?></td>
						<td>
							<?= $ayah['nm']; ?> (Ayah)
							<br>
							<?= $ibu['nm']; ?> (Ibu)
							<br>
							<?= $wali['nm'] != '' ? $wali['nm'] . ' (Wali)' : ''; ?>
						</td>
						<td>
							<div class="row g-1">
								<div class="col-12">
									<button class="btn btn-sm btn-primary" onclick="viewData('<?= $row['nipd']; ?>')" style="width: 80px;"><i class="bi bi-card-text"></i> Lihat</button>
								</div>
								<div class="col-12">
									<button data-page="edt_sis" data-id="<?= $row['nipd']; ?>" class="btn btn-sm btn-info" style="width: 80px;"><i class="bi bi-pencil"></i> Edit</button>
								</div>
								<div class="col-12">
									<button class="btn btn-sm btn-danger" style="width: 80px;"><i class="bi bi-trash3"></i> Hapus</button>
								</div>
							</div>
						</td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="d_siswa">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_siswaLabel">Data Siswa</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="viewDataSiswa"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>



<!-- JavaScript -->
<!-- 
<script>
	$(document).ready(function() {
		// Load table data via AJAX
		$.get('app/table/t_sis.php', function(data) {
			$('#jtable tbody').html(data);

			// Inisialisasi SimpleDatatables setelah data dimuat
			if (window.dataTableInstance) {
				window.dataTableInstance.destroy();
			}
			window.dataTableInstance = new simpleDatatables.DataTable("#jtable");
		});
	});
</script> -->

<script>
	function viewData(id) {
		$('#d_siswa').modal('show');


		$.ajax({
			type: 'POST',
			url: 'app/modal/m_siswa.php',
			data: {
				id: id
			},
			success: function(data) {
				$('#viewDataSiswa').html(data);
			}
		});
	}
</script>