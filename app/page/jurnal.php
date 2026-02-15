<?php
require_once "../config/server.php";

if (date('m') <= 6) $smt = 'Genap' . (date('Y') - 1) . '-' . date('Y');
else $smt = 'Ganjil' . date('Y') . '-' . date('Y') + 1;


$updt = $pdo_conn->prepare("SELECT upd FROM `tb_dsis` GROUP BY upd ORDER BY `tb_dsis`.`upd` DESC LIMIT 1;");
$updt->execute();
$updt = $updt->fetch(PDO::FETCH_ASSOC);

if (!$updt || empty($updt['upd'])) {
	$updt = ['upd' => date('Y-m-d')]; // Atur default jika data kosong
}
$date = date('d-m-Y', strtotime($updt['upd']));
?>


<style>
	/* Gaya tabel */
	.table-responsive th:nth-child(1),
	.table-responsive td:nth-child(1) {
		width: 80px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(2),
	.table-responsive td:nth-child(2) {
		min-width: 180px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(3),
	.table-responsive td:nth-child(3) {
		min-width: 180px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(4),
	.table-responsive td:nth-child(4) {
		min-width: 180px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(5),
	.table-responsive td:nth-child(5) {
		min-width: 120px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(6),
	.table-responsive td:nth-child(6) {
		min-width: 140px;
		text-align: center;
		align-content: baseline;
	}

	.table-responsive th:nth-child(7),
	.table-responsive td:nth-child(7) {
		min-width: 200px;
		text-align: start;
		align-content: baseline;
	}

	.table-responsive th:nth-child(8),
	.table-responsive td:nth-child(8) {
		min-width: 200px;
		text-align: start;
		align-content: baseline;
	}

	.table-responsive th:nth-child(9),
	.table-responsive td:nth-child(9) {
		min-width: 150px;
		text-align: start;
		align-content: baseline;
	}

	.table-responsive th:nth-child(10),
	.table-responsive td:nth-child(10) {
		min-width: 100px;
		text-align: start;
		align-content: baseline;
	}
</style>
<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Jurnal Mengajar
</div>
<div class="row g-2">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Catatan Jurnal</button>
	</div>
	<div class="col-auto">
		<button type="button" class="btn btn-outline-primary" onclick="viewData('create')"><i class="bi bi-pencil"></i> Jurnal Manual</button>
	</div>
	<div class="col-auto">
		<button type="button" class="btn btn-outline-danger" onclick="viewData('cetak')"><i class="bi bi-printer"></i> Cetak</button>
	</div>
</div>

<div class="row my-3 ">
	<div class="col-12">
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<thead>
					<th>No</th>
					<th>Tanggal Mengajar</th>
					<th>Nama Guru</th>
					<th>Mata Pelajaran</th>
					<th>Kelas</th>
					<th>Kehadiran</th>
					<th>Materi/Pokok Bahasan</th>
					<th>Kegiatan/Penilaian</th>
					<th>Keterangan</th>
					<th>Opsi</th>
				</thead>
				<tbody id="data_jrnl">
					<?php
					$d_jurnal = db_Proses($pdo_conn, "SELECT * FROM tb_jrnl ORDER BY tgl DESC, kd_staf ASC");
					while ($r = $d_jurnal->fetch(PDO::FETCH_ASSOC)):
						$absen = json_decode($r['d_sis'], true);
						$nm_gr = db_Proses($pdo_conn, "SELECT nm_staf FROM tb_dstaf WHERE kd_staf = ?", [$r['kd_staf']])->fetch(PDO::FETCH_ASSOC);
						$mpel = db_Proses($pdo_conn, "SELECT mpel FROM tb_mpel WHERE kd_mpel =?", [$r['kd_mpel']])->fetch(PDO::FETCH_ASSOC);

						$rekap = [
							'H' => 0,
							'I' => 0,
							'S' => 0,
							'A' => 0
						];

						foreach ($absen as $siswa) {
							$kode = $siswa['hadir'] ?? null;
							if (isset($rekap[$kode])) {
								$rekap[$kode]++;
							}
						}

					?>
						<tr>
							<td class="text-center"><?= $notbl++; ?></td>
							<td><?= tgl_hari($r['tgl']); ?></td>
							<td><?= $nm_gr['nm_staf']; ?></td>
							<td><?= $mpel['mpel']; ?></td>
							<td><?= $r['kls']; ?></td>
							<td><?= $rekap['H'] . ' Hadir, ' . $rekap['I'] . ' Ijin <br>' . $rekap['S'] . ' Sakit, ' . $rekap['A'] . ' Alfa'; ?></td>
							<td><?= $r['materi']; ?></td>
							<td><?= $r['kgitan']; ?></td>
							<td><?= $r['ket']; ?></td>
							<td></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="d_jrnl">
	<div class="modal-dialog modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h1 class="modal-title fs-5" id="d_title"></h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div id="viewData"></div>
			</div>
			<!-- <div class="modal-footer">
				<button data-route="edt_staf" data-id="" class="btn btn-info" id="md_edit" data-bs-dismiss="modal"></i> <i class="bi bi-pencil"></i> Edit</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
			</div> -->
		</div>
	</div>
</div>


<script>
	function viewData(id) {
		$('#d_jrnl').modal('show');
		// $('#md_edit').attr('data-id', id);
		if (id == 'add') {
			$('#d_title').text('Tambah Data Jurnal Mengajar');
			$('.modal-dialog').addClass('modal-fullscreen');
			$('.modal-dialog').removeClass('modal-xl modal-lg');
			$('.btn-close').show();
		} else if (id == 'create') {
			$('#d_title').text('Form Jurnal Manual');
			$('.modal-dialog').removeClass('modal-fullscreen modal-lg');
			$('.modal-dialog').addClass('modal-xl');
			$('.btn-close').hide();
		} else if (id == 'cetak') {
			$('#d_title').text('Pengaturan Cetak');
			$('.modal-dialog').addClass('modal-lg');
			$('.modal-dialog').removeClass('modal-fullscreen modal-xl');
			$('.btn-close').hide();

		}
		$.ajax({
			type: 'POST',
			url: 'app/modal/m_jurnal',
			data: {
				id: id
			},
			success: function(data) {
				$('#viewData').html(data);
			}
		});
	}
</script>
<script>
	// function LoadJurnal() {
	// 	$.ajax({
	// 		type: 'POST',
	// 		url: 'app/table/t_jurnal',
	// 		success: function(data) {
	// 			$('#data_jrnl').html(data);
	// 			// console.log(data);
	// 		}
	// 	})
	// }
	// $(document).ready(function() {
	// 	LoadJurnal();
	// });
</script>