<?php
require_once "../config/server.php";

if (db_Mytbk() == false) { ?>
	<div class="row justify-content-center">
		<div class="col-auto">
			<div class='alert alert-danger mt-5'>Silahkan lakukan instalasi aplikasi MyTBK terlebih dahulu agar dapat menggunakan fitur ini.</div>
		</div>
	</div>
<?php
	exit();
}

$tes = db_Proses(db_Mytbk(), "SELECT * FROM `cbt_peserta` ORDER BY `id_peserta` ASC");

?>
<style>
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		min-width: 50px;
		text-align: center;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 150px;
		text-align: center;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		min-width: 250px;
		text-align: start;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 100px;
		text-align: center;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 50px;
		text-align: center;
	}
</style>
<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Daftar Peserta Asesmen
</div>
<div class="row my-3 mx-2 p-2 border-bottom">
	<div class="col-auto">
		<button class="btn btn-primary" onclick="modalShow('Singkronisasi data Peserta', 'sycn')"><span class="myicon myicon-rule_settings"></span> Singkronisasi</button>
	</div>
	<div class="col-auto">
		<button class="btn btn-outline-primary" data-route='mytbk_setps'>
			<span class="myicon myicon-manage_accounts"></span> Pengaturan Peserta</button>
	</div>
	<!-- <div class="col-auto">
		<button class="btn btn-primary"></button>
	</div> -->
</div>

<div class="row px-3 gap-3 justify-content-around">
	<div class="col-12 col-md-auto border p-2">
		<div class="col-12">
			<p class="alert alert-info text-center">Data yang ditampilkan pada table dibawah ini adalah data yang ada pada aplikasi SIAP</p>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped">
				<thead>
					<th>No</th>
					<th>NISN/NIS</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Status</th>
				</thead>
				<tbody>
					<?php
					$stmt = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE sts = ?", ['Y']);
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
					?>
						<tr>
							<td><?= $notbl++; ?></td>
							<td><?= $row['nipd']; ?></td>
							<td><?= $row['nm']; ?></td>
							<td><?= $row['kls']; ?></td>
							<td><?= $row['sts']; ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="col-12 col-md-auto border p-2">
		<div class="col-12">
			<p class="alert alert-success text-center">Data yang ditampilkan pada table dibawah ini adalah data yang tersedia di aplikasi MyTBK</p>
		</div>
		<div class="table-responsive">
			<table class="table table-hover table-striped" id="table2">
				<thead>
					<th>No</th>
					<th>NISN/NIS</th>
					<th>Nama</th>
					<th>Kelas</th>
					<th>Status</th>
				</thead>
				<tbody>
					<?php
					$notbl = 1;
					while ($row = $tes->fetch(PDO::FETCH_ASSOC)) :
					?>
						<tr>
							<td><?= $notbl++; ?></td>
							<td><?= $row['nis']; ?></td>
							<td><?= $row['nm']; ?></td>
							<td><?= $row['kd_kls']; ?></td>
							<td><?= $row['sts']; ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>



<!-- Modal -->
<div class="modal fade" id="modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="md_title">Modal title</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="isi">
				...
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
			</div> -->
		</div>
	</div>
</div>




<script>
	function modalShow(title, isi) {
		$('#modal').modal('show');
		$('#md_title').text(title);

		$.ajax({

			url: 'app/modal/m_mytbk_ps.php',
			type: 'POST',
			data: {
				prd: isi
			},
			success: function(res) {
				$('#isi').html(res);
			}
		})
	}
</script>