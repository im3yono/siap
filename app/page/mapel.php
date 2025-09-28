<style>
	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		width: 80px;
		text-align: center;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 120px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		min-width: 250px;
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
		min-width: 300px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 80px;
		text-align: center;
		align-content: baseline;
	}
</style>


<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Mata Pelajaran
</div>
<div class="row">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Data</button>
	</div>
	<div class="col-auto">
		<!-- <button data-route="up_staf" data-id="tendik" type="button" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Upload Data</button> -->
	</div>
</div>



<!-- INSERT INTO `tb_mpel` (`id_mpel`, `kd_mpel`, `mpel`, `sgkat`, `guru`, `jdwl`, `rcd`, `upd`, `sts`) VALUES (NULL, 'U-123', 'Pendidikan Agama', 'PA', '{\"11021\",\"11014\"}', '{\"11021\",\"11014\"}', current_timestamp(), current_timestamp(), 'Y'); -->

<div class="row mt-5">
	<div class="table-responsive">
		<table class="table table-hover" id="jtable">
			<thead>
				<th>No</th>
				<th>Kode</th>
				<th>Nama Mata Pelajaran</th>
				<th>Nama Singkat</th>
				<th>Guru Mengajar</th>
				<th>Opsi</th>
			</thead>
			<tbody>
				<?php
				require_once("../config/server.php");

				$stmt = $pdo_conn->prepare("SELECT * FROM tb_mpel ORDER BY mpel ASC");
				$stmt->execute();


				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				?>
					<tr>
						<td><?= $notbl++; ?></td>
						<td><?= $row['kd_mpel']; ?></td>
						<td><?= $row['mpel']; ?></td>
						<td><?= $row['sgkat']; ?></td>
						<td>
							<?php
							$ar_gr = json_decode($row['guru']);
							foreach ($ar_gr as $dt) {
								$gr = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE jptk='Guru' AND id_staf ='$dt'");
								$gr->execute();
								$nm = $gr->fetch(PDO::FETCH_ASSOC);
								echo $nm['nm_staf'] == '' ? '' : $nm['nm_staf'] . ', ';
							}
							?></td>
						<td>
							<div class="row g-1 justify-content-center">
								<div class="col-auto">
									<button class="btn btn-sm btn-primary" style="width: 80px;" onclick="viewData('edt','<?= $row['kd_mpel']; ?>','<?= $row['mpel']; ?>','<?= $row['sgkat']; ?>')"><i class="bi bi-pencil"></i> Edit</button>
								</div>
								<div class="col-auto">
									<button class="btn btn-sm btn-danger" style="width: 80px;" onclick="delData('<?= $row['kd_mpel']; ?>')"><i class="bi bi-trash3"></i> Hapus</button>
								</div>
								<div class="col-12"></div>
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
	<div class="modal-dialog modal-dialog-scrollable" id="size">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_tendikLabel"></h1>
				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
			</div>
			<div class="modal-body">
				<div id="viewDataStaf"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="simpan"> Simpan</button>
				<button type="button" class="btn btn-info" id="md_edit"></i> <i class="bi bi-pencil"></i> Edit</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
	function viewData(title = '', id = '', nm = '', skt = '') {
		if (title == 'add') {
			$('#d_tendik').modal('show');
			$('#d_tendikLabel').text('Tambah Data Mata Pelajaran');
			$('#simpan').show();
			$('#md_edit').hide();
		} else if (title == 'edt' && id != '') {
			$('#d_tendik').modal('show');
			$('#d_tendikLabel').text('Edit Mata Pelajaran');
			$('#simpan').hide();
			$('#md_edit').show();
		}


		$.ajax({
			type: 'POST',
			url: 'app/modal/m_mapel.php',
			data: {
				id: id,
				nm: nm,
				skt: skt
			},
			success: function(data) {
				$('#viewDataStaf').html(data);
			}
		});
	}


	// Delete Data
	function delData(id) {
		Swal.fire({
			title: 'Yakin menghapus ' + id + '?',
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
					url: 'app/proses/',
					data: {
						id: id
					},
					success: function(response) {
						if (response === 'success') {
							Swal.fire(
								'Terhapus!',
								id + ' berhasil dihapus.',
								'success'
							).then(() => {
								loadRoute('siswa', false); // Muat ulang halaman tanpa menambah ke riwayat
							});
						} else {
							Swal.fire(
								'Gagal!',
								'Gagal menghapus <b>' + id + '</b>. Silahkan coba lagi.',
								'error'
							);
						}
					},
					error: function() {
						Swal.fire(
							'Gagal!',
							'Gagal menghapus <b>' + id + '</b>. Silahkan coba lagi.',
							'error'
						);
					}
				});
			}
		});
	}
</script>