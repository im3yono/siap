<style>
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		width: 30px;
		text-align: center;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 100px;
		text-align: center;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		min-width: 100px;
		text-align: center;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 100px;
		text-align: center;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 100px;
		text-align: center;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		width: 150px;
		text-align: center;
	}
</style>
<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Kelas
</div>

<div class="row mb-3">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Data</button>
	</div>
	<div class="col-auto">
		<!-- <button data-route="up_staf" data-id="tendik" type="button" class="btn btn-outline-primary"><i class="bi bi-upload"></i> Upload Data</button> -->
	</div>
</div>

<div class="row">
	<div class="table-responsive">
		<table class="table table-hover border-black" id="jtable">
			<thead>
				<th>No</th>
				<th>Tingkat</th>
				<th>Kelas</th>
				<th>Wali Kelas</th>
				<th>Jumlah Siswa</th>
				<th>Opsi</th>
			</thead>
			<tbody id="isTable">
				<?php
				require_once("../config/server.php");

				$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC");
				while ($r_sis = $kls->fetch(PDO::FETCH_ASSOC)) {
					$jml_l = db_Proses($pdo_conn, "SELECT kls, jk FROM tb_dsis WHERE jk = ? AND kls = ?", ["L", $r_sis['kls']]);
					$jml_p = db_Proses($pdo_conn, "SELECT kls, jk FROM tb_dsis WHERE jk = ? AND kls = ?", ["P", $r_sis['kls']]);
					$cr_kls = db_Proses($pdo_conn, "SELECT * FROM tb_kls WHERE kls = ?", [$r_sis['kls']]);

					$jml_l = $jml_l->rowCount();
					$jml_p = $jml_p->rowCount();
					$r_kls	= $cr_kls->fetch(PDO::FETCH_ASSOC);
					// $r_rls = $r_kls['kd_staf'];
					$cr_kls = $cr_kls->rowCount();

					if ($cr_kls != 0) {
						$r_gr = '';
						if ($r_kls['kd_staf'] != '') {
							$r_gr = db_Proses($pdo_conn, "SELECT * FROM tb_dstaf WHERE kd_staf = ?", [$r_kls['kd_staf']]);
							$r_gr = $r_gr->fetch(PDO::FETCH_ASSOC);
							$r_gr = $r_gr['nm_staf'];
						}
				?>
						<tr>
							<td><?= $notbl++; ?></td>
							<td><?= $r_kls['tkt']; ?></td>
							<td><?= $r_sis['kls']; ?></td>
							<td><?= $r_gr; ?></td>
							<td><?= $jml_l . ' Laki-Laki <br>' . $jml_p . ' Perempuan'; ?></td>
							<td>
								<div class="row g-1 justify-content-center">
									<div class="col-auto">
										<button class="btn btn-sm btn-info" style="width: 80px;" onclick="viewData('edt','<?= $r_kls['id_kls']; ?>','modal-lg')"><i class="bi bi-pencil"></i> Edit</button>
									</div>
									<div class="col-auto">
										<button class="btn btn-sm btn-danger" style="width: 80px;" onclick="delData('<?= $r_kls['id_kls']; ?>','<?= $r_sis['kls']; ?>')"><i class="bi bi-trash3"></i> Hapus</button>
									</div>
								</div>
							</td>
						</tr>
				<?php }
				} ?>
			</tbody>
		</table>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="d_modal">
	<div class="modal-dialog  modal-dialog-scrollable" id="size">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_modalLabel"></h1>
				<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
			</div>
			<div class="modal-body">
				<div id="viewDataStaf"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" id="simpan" onclick="saveData('add')">Simpan</button>
				<button type="button" class="btn btn-info" id="md_edit" onclick="saveData('edt')"></i> <i class="bi bi-pencil"></i> Edit</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>

<script>
	function viewData(title = '', id = '', size = '') {
		$('#size').addClass(size);
		if (size == '') {
			$('#size').removeClass('modal-lg modal-sm');
		}
		if (title == 'add') {
			$('#d_modal').modal('show');
			$('#d_modalLabel').text('Tambah Data Kelas');
			$('#simpan').show();
			$('#md_edit').hide();
		} else if (title == 'edt' && id != '') {
			$('#d_modal').modal('show');
			$('#d_modalLabel').text('Edit Data Kelas');
			$('#simpan').hide();
			$('#md_edit').show();
			$('#md_edit').attr('data-id', id);
		}
		$.ajax({
			type: 'POST',
			url: 'app/modal/m_kelas.php',
			data: {
				id: id,
				prd: title
			},
			success: function(data) {
				$('#viewDataStaf').html(data);
			}
		});
	}

	function notif(icon, title, text, konfirmasi = '') {
		if (konfirmasi == '') {
			Swal.fire({
				icon: icon,
				title: title,
				text: text
			});
		} else {
			Swal.fire({
				icon: icon,
				title: title,
				text: text
			}).then((result) => {
				if (result.isConfirmed) {
					r_halaman();
				}
			})
		}
	}

	function saveData(prd) {
		var data = $('#add_kls').serialize();
		data += '&prd=' + encodeURIComponent(prd);

		$.ajax({
			type: 'POST',
			data: data,
			url: 'app/proses/pr_kls.php',
			success: function(res) {
				if (res == 'ok') {
					notif('success', 'Berhasil!', 'Data berhasil disimpan.', 'kon');
					$('#d_modal').modal('hide');
				} else if (res == 'update') {
					notif('success', 'Berhasil!', 'Data berhasil diupdate.', 'kon');
					$('#d_modal').modal('hide');
				} else if (res == 'err') {
					notif('error', 'Gagal!', 'Gagal menyimpan data. Silahkan coba lagi.');
				} else if (res == 'dup') {
					notif('warning', 'Peringatan!', 'Kode Mata Pelajaran Sudah Ada');
				} else {
					notif('error', 'Gagal!', 'Gagal menyimpan data. Silahkan coba lagi.');
				}
				// console.log(res);
			}
		})
	}

	function delData(id, kls) {
		Swal.fire({
			title: 'Yakin menghapus ' + kls + '?',
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
					url: 'app/proses/pr_kls.php',
					data: {
						id: id,
						prd: 'del'
					},
					success: function(response) {
						if (response === 'ok') {
							Swal.fire(
								'Terhapus!',
								kls + ' berhasil dihapus.',
								'success'
							).then(() => {
								r_halaman(); // Muat ulang halaman tanpa menambah ke riwayat
							});
						} else {
							Swal.fire(
								'Gagal!',
								'Gagal menghapus <b>' + kls + '</b>. Silahkan coba lagi.',
								'error'
							);
						}
						// console.log(response);
					},
					error: function() {
						Swal.fire(
							'Gagal!',
							'Silahkan coba lagi.',
							'error'
						);
					}
				});
			}
		});
	}
</script>