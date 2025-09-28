<style>
	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 120px;
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
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		width: auto;
		min-width: 200px;
		text-align: left;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 100px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7) {
		min-width: 250px;
		max-width: 300px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive td:nth-child(7) {
		min-width: 250px;
		max-width: 300px;
		text-align: start;
		align-content: baseline;
	}

	/* .table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 150px;
		text-align: center;
		align-content: baseline;
	} */

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 100px;
		max-width: 100px;
		text-align: center;
		align-content: baseline;
	}
</style>

<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Data Tenaga Kependidikan
</div>
<div class="row">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData"><i class="bi bi-plus-lg"></i> Tambah Data</button>
	</div>
	<div class="col-auto">
		<button data-route="up_staf" data-id="tendik" type="button" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Upload Data</button>
	</div>
</div>
<div class="row mt-5">
	<div class="table-responsive">
		<table class="table table-hover" id="jtable">
			<thead>
				<tr>
					<th>No</th>
					<th>ID Staf</th>
					<th>NIP/NUPTK</th>
					<th>Nama</th>
					<th>Jenis Kelamin</th>
					<th>Tempat, Tanggal Lahir</th>
					<th>Alamat</th>
					<!-- <th>Pasangan</th> -->
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php

				require_once "../config/server.php";

				$stmt = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE jptk !='Guru' ORDER BY id_staf ASC");
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

					$psngan		= json_decode($row['psngn'], true);

					// $ft = "app/images/siswa/" . $row['id_staf'];
					// $ft = "assets/img/account.png";
				?>

					<tr>
						<td><?= $notbl++; ?>
							<img src="<?= ft($row['id_staf'], "staf"); ?>" alt="<?= $row['id_staf']; ?>" class="" style="width: 75px; height: 100px; object-fit: cover;">
						</td>
						<td><?= $row['id_staf']; ?></td>
						<td><?= $row['nip'].'<br>'.$row['nuptk']; ?></td>
						<td><?= f_nama($row['nm_staf']); ?></td>
						<td><?= $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan"; ?></td>
						<td><?= f_nama($row['tmp_l']) . "<br>" . tgl($row['tgl_l']); ?></td>
						<td><?= $almt; ?></td>
						<!-- <td>
							<?= $ayah['nm']; ?> (Ayah)
							<br>
							<?= $ibu['nm']; ?> (Ibu)
							<br>
							<?= $wali['nm'] != '' ? $wali['nm'] . ' (Wali)' : ''; ?>
						</td> -->
						<td>
							<div class="row g-1">
								<div class="col-12">
									<button data-route="p_data" data-id="<?= $row['id_staf']; ?>" class="btn btn-sm btn-primary" style="width: 80px;"><i class="bi bi-card-text"></i> Lihat</button>
								</div>
								<div class="col-12">
									<button data-route="edt_staf" data-id="<?= $row['id_staf']; ?>" class="btn btn-sm btn-info" style="width: 80px;"><i class="bi bi-pencil"></i> Edit</button>
								</div>
								<div class="col-12">
									<button class="btn btn-sm btn-danger" onclick="delData('<?= $row['id_staf']; ?>')" style="width: 80px;"><i class="bi bi-trash3"></i> Hapus</button>
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
<div class="modal fade" id="d_tendik">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_tendikLabel">Data Tendik</h1>
				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
			</div>
			<div class="modal-body">
				<div id="viewDataStaf"></div>
			</div>
			<div class="modal-footer">
				<button data-route="edt_staf" data-id="" class="btn btn-info" id="md_edit" data-bs-dismiss="modal"></i> <i class="bi bi-pencil"></i> Edit</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>



<!-- JavaScript -->
<script>
	function viewData(id) {
		$('#d_tendik').modal('show');
		$('#md_edit').attr('data-id', id);

		$.ajax({
			type: 'POST',
			url: 'app/modal/m_staf.php',
			data: {
				id: id
			},
			success: function(data) {
				$('#viewDataStaf').html(data);
			}
		});
	}

	function delData(id) {
		Swal.fire({
			title: 'Yakin menghapus data?',
			text: "Data yang dihapus tidak dapat dikembalikan!",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Hapus!',
			cancelButtonText: 'Batal'
		}).then((result) => {
			if (result.isConfirmed) {
				$.ajax({
					type: 'POST',
					url: 'app/hapus/h_sis.php',
					data: {
						id: id
					},
					success: function(response) {
						if (response === 'success') {
							Swal.fire(
								'Terhapus!',
								'Data berhasil dihapus.',
								'success'
							).then(() => {
								loadRoute('siswa', false); // Muat ulang halaman tanpa menambah ke riwayat
							});
						} else {
							Swal.fire(
								'Gagal!',
								'Gagal menghapus data. Silahkan coba lagi.',
								'error'
							);
						}
					},
					error: function() {
						Swal.fire(
							'Gagal!',
							'Gagal menghapus data. Silahkan coba lagi.',
							'error'
						);
					}
				});
			}
		});
	}
</script>