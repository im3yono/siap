<?php
require_once "../config/server.php";

if (date('m') <= 6) $smt = 'Genap' . (date('Y') - 1) . '-' . date('Y');
else $smt = 'Ganjil' . date('Y') . '-' . date('Y') + 1;


$updt = $pdo_conn->prepare("SELECT upd FROM `tb_dsis` GROUP BY upd ORDER BY `tb_dsis`.`upd` DESC LIMIT 1;");
$updt->execute();
$updt = $updt->fetch(PDO::FETCH_ASSOC);
$date = date('d-m-Y', strtotime($updt['upd']));
?>
<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	Jurnal Mengajar
</div>
<div class="row">
	<div class="col-auto">
		<button class="btn btn-primary" id="tambahData" onclick="viewData('add')"><i class="bi bi-plus-lg"></i> Tambah Catatan Jurnal</button>
	</div>
	<div class="col-auto">
		<button type="button" class="btn btn-outline-primary" onclick="viewData('create')"><i class="bi bi-pencil"></i> Jurnal Manual</button>
	</div>
</div>

<div class="row mx-3">
	<div class="col" id="tampilJurnal">
		<!-- <iframe src="app/views/v_jurnal.php" id="prt" frameborder="0" style="height: 90vh; width: 100%;"></iframe> -->
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="d_mpel">
	<div class="modal-dialog modal-xl modal-dialog-scrollable">
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
		$('#d_mpel').modal('show');
		// $('#md_edit').attr('data-id', id);
		if (id == 'add') $('#d_title').text('Tambah Data Jurnal Mengajar');
		else if (id == 'create') $('#d_title').text('Form Jurnal Manual');
		else
			$('#d_title').text(id);

		$.ajax({
			type: 'POST',
			url: 'app/modal/m_jurnal.php',
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
	// $(document).ready(function() {
	// 	$('#simpanJurnal').on('click', function() {
	// 		const nama = $('#nama').val();
	// 		const nip = $('#nip').val();
	// 		const mapel = $('#mapel').val();
	// 		const al_waktu = $('#al_waktu').val();
	// 		const al_temu = $('#al_temu').val();
	// 		const bln = $('#bln').val();
	// 		const thn_ajar = $('#thn_ajar').val();
	// 		const smt = $('#smt').val();

	// 		// Ambil kelas yang dicentang
	// 		let kelas = [];
	// 		$('input[type="checkbox"]:checked').each(function() {
	// 			kelas.push($(this).attr('name'));
	// 		});

	// 		if (!nama || !nip || !mapel || kelas.length === 0) {
	// 			alert('Mohon lengkapi semua data dan pilih minimal satu kelas.');
	// 			return;
	// 		}

	// 		$.ajax({
	// 			type: 'POST',
	// 			url: 'app/views/v_jurnal.php',
	// 			data: {
	// 				nama: nama,
	// 				nip: nip,
	// 				mapel: mapel,
	// 				al_waktu: al_waktu,
	// 				al_temu: al_temu,
	// 				bln: bln,
	// 				thn_ajar: thn_ajar,
	// 				smt: smt,
	// 				kelas: kelas
	// 			},
	// 			success: function(res) {
	// 				// if (res === 'success') {
	// 				// 	alert('Data jurnal berhasil disimpan.');
	// 				// 	// Muat ulang iframe untuk menampilkan jurnal terbaru
	// 					$('#tampilJurnal iframe').attr('src', 'app/views/v_jurnal.php');
	// 				// } else {
	// 				// 	alert('Gagal menyimpan data jurnal. Silakan coba lagi.');
	// 				// }
	// 			},
	// 			error: function() {
	// 				alert('Terjadi kesalahan saat mengirim data. Silakan coba lagi.');
	// 			}
	// 		});
	// 	});
	// })
</script>