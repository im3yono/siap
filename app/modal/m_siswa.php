<?php
require_once "../../config/server.php";


$nipd = $_POST['id'] ?? '';
$prd 	= $_POST['prd'];


// Menampilkan Data Lengkap Siswa
if ($prd == 'edt'):
	$stmt = $pdo_conn->prepare("SELECT * FROM tb_dsis WHERE nipd=:nipd");
	$stmt->bindParam(":nipd", $nipd);
	$stmt->execute();
	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$almt 	= json_decode($row['almt'], true);
	$jl 		= $almt['almt'] != "" ? $almt['almt'] : '';
	$rt 		= $almt['rt'] != "" ? $almt['rt'] : '0';
	$rw 		= $almt['rw'] != "" ? $almt['rw'] : '0';
	$dusun 	= $almt['dusun'] != "" ? ", Dusun " . $almt['dusun'] : '';
	$kel 		= $almt['kel'] != "" ? $almt['kel'] : '';
	$kec 		= $almt['kec'] != "" ? $almt['kec'] : '';
	$kdpos	= $almt['kdpos'] != "" ? ", Kode Pos " . $almt['kdpos'] : '';
	$almt		= $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;

	$tlp		= json_decode($row['tlp/hp'], true);

	$ayah		= json_decode($row['ayah'], true);
	$ibu		= json_decode($row['ibu'], true);
	$wali		= json_decode($row['wali'], true);
	$sdr		= json_decode($row['saudr'], true);


	if (!empty($ayah['sts'])) $ayah['sts'] == 'N' ? $a_sts = ", Alm" : $a_sts = "";else $a_sts = "";
	if (!empty($ibu['sts'])) $ibu['sts'] == 'N' ? $i_sts = ", Alm" : $i_sts = "";else $i_sts = "";


	$tb_bb_lk = json_decode($row['bb_tb_lk'], true);
	$bb = $tb_bb_lk['bb'] != "" ? $tb_bb_lk['bb'] . " Kg" : '';
	$tb = $tb_bb_lk['tb'] != "" ? $tb_bb_lk['tb'] . " Cm" : '';


	function barisData($label, $data, $class = '')
	{
		if ($label == 'NIK' || $label == 'NIKK') {
			// $data = substr($data, 0,3) . '****' . substr($data, -3);
			$data = substr($data, 0, 4) . '****';
			// $data = $data . '<button class="btn btn-sm btn-tool" onclick="togglePassword()"><i class="bi bi-eye"></i></button>';

		}
		$view1 = '
	<div class="col-4">' . $label . '</div>:
	<div class="col">' . $data . '</div>';
		return '<div class="row ' . $class . '">' . $view1 . '</div>';
	}
	function barisData1($label, $data, $class = '')
	{
		$view1 = "<td>$label</td><td>:</td><td>$data</td>";
		return "<tr class='$class'>$view1</tr>";
	}
?>
	<div class="row">
		<div class="col-12 text-center p-2">
			<img src="<?= ft($row['nipd'], 'siswa', '../../'); ?>" alt="<?= $row['nipd'] ?> " class="img-thumbnail shadow" style="width: 150px; height: 200px; object-fit: cover;">'
		</div>
		<div class="col-12 text-center">
			<div class="fw-bold h5 text-uppercase">
				<?= ($row['nm']); ?>
			</div>
			<div class="fw-bold h5 pb-3">
				<?= $row['nipd']; ?>
			</div>
		</div>
		<div class="col-12">
			<div class="bg-info p-2 h6" style="border-radius:5px;">Biodata Siswa</div>
			<?php
			echo
			barisData('NISN', f_nama($row['nisn']), 'fw-bold')
				. barisData('NIK', f_nama($row['nik']))
				. barisData('NIKK', f_nama($row['nkk']))
				. barisData('Tempat, Tanggal Lahir', f_nama($row['tmp_lahir']) . ", " . tgl($row['tgl_lahir']))
				. barisData('Jenis Kelamin', $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan")
				. barisData('Agama', $row['agm'])
				. barisData('Alamat', $almt)
				. barisData('No. Telpon', $tlp['tlp'] ?? '')
				. barisData('No. Hp', $tlp['hp'] ?? '')
				. barisData('Email', $row['email'])
				. barisData('Kelas', $row['kls'])
				. barisData('No. Akta', $row['no_akta'])
				. barisData('Disabilitas', $row['disabel'])
				. barisData('Status Masuk', $row['masuk'])
				. barisData('Sekolah Asal', $row['sklh_asl'])
				. barisData('Anak	 Ke', $sdr['ke'] . " dengan " . $sdr['sdr'] . " saudara")
				. barisData('Berat', $bb)
				. barisData('Tinggi', $tb)
				. barisData(('Lingkar Kepala'), $tb_bb_lk['lk'] . ' Cm')
				. barisData('Tempat Tinggal', $row['tmp_tinggal'])
				. barisData('Jarak Rumah', $row['jrk_rmh'] . ' Km')
				. barisData('Transportasi', $row['trasport'])
				. '<hr>'
				. '<div class="bg-info p-2 h6" style="border-radius:5px;">Data Orang Tua/Wali</div>'
				. '<h6 class="border-bottom">Ayah</h6>'
				. barisData('Nama ', $ayah['nm'] . $a_sts, 'fw-bold')
				. barisData('NIK', $ayah['nik'])
				. barisData('Tahun Lahir ', $ayah['thn_l'])
				. barisData('Alamat ', $ayah['almt'])
				. barisData('Pendidikan ', $ayah['pddk'])
				. barisData('Pekerjaan ', $ayah['kerja'])
				. barisData('Penghasilan ', $ayah['upah'])
				. '<h6 class="mt-3 border-bottom">Ibu</h6>'
				. barisData('Nama ', $ibu['nm'] . $i_sts, 'fw-bold')
				. barisData('NIK', $ibu['nik'])
				. barisData('Tahun Lahir ', $ibu['thn_l'])
				. barisData('Alamat ', $ibu['almt'])
				. barisData('Pendidikan ', $ibu['pddk'])
				. barisData('Pekerjaan ', $ibu['kerja'])
				. barisData('Penghasilan ', $ibu['upah']);
			if ($wali['nm'] != "") {
				echo '<h6 class="mt-3 border-bottom">Wali</h6>'
					. barisData('Nama ', $wali['nm'], 'fw-bold')
					. barisData('NIK', $wali['nik'])
					. barisData('Tahun Lahir ', $wali['thn_l'])
					. barisData('Alamat ', $wali['almt'])
					. barisData('Pendidikan ', $wali['pddk'])
					. barisData('Pekerjaan ', $wali['kerja'])
					. barisData('Penghasilan ', $wali['upah'])

					// . barisData('Status', $row['sts'] == '1' ? "Aktif" : "Tidak Aktif");
				;
			}
			?>
			<form id="b_sis">
				<input type="hidden" name="nipd" id="nipd" value="<?= $row['nipd']; ?>">
			</form>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$("#form").on("click", function(e) {
				e.preventDefault();

				let nipd = $("#nipd").val();

				// Buat form POST secara dinamis
				let form = $('<form>', {
					method: 'POST',
					action: 'app/report/v_form_siswa',
					target: 'blank'
				});

				// Tambahkan field nipd
				$('<input>', {
					type: 'hidden',
					name: 'nipd',
					value: nipd
				}).appendTo(form);

				// Tambahkan form ke body, submit, lalu hapus
				form.appendTo('body').submit().remove();
			});
		});
	</script>

<?php
endif;


// Form Kartu Pelajar
if ($prd == 'ktpl'):
	$sql = "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC";
	$stmt = db_Proses($pdo_conn, $sql);
	while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
		$sql = "SELECT * FROM tb_kls WHERE kls = ?";
		$stmt1 = db_Proses($pdo_conn, $sql, [$r['kls']]);
		if ($stmt1->rowCount() == 0) {
			echo '<h6 class="text-center"> Kelas ' . $r['kls'] . ' belum di tambahkan pada menu kelas.</h6>';
			exit;
		}
	}

?>
	<!-- <div class="col text-center"> <button onclick="window.location.href='app/file/KTPL.psb'" class="btn btn-sm btn-success">
			<i class="bi bi-download"></i> Download PSD Kartu Pelajar
		</button></div> -->
	<form action="app/report/v_ktpl" method="post" id="f_data" target="blank">
		<div class="row g-2 px-2">
			<div class="col-12 col-md-6">
				<label for="tkt" class="form-label">Tingkat</label>
				<select name="tkt" id="tkt" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<option value="X">X</option>
					<option value="XI">XI</option>
					<option value="XII">XII</option>
				</select>
			</div>
			<div class="col-12 col-md-6">
				<label for="kls" class="form-label">Kelas</label>
				<select name="kls" id="kls" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<?php
					$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC");
					while ($r_kls = $kls->fetch(PDO::FETCH_ASSOC)) {
					?>
						<option value="<?= $r_kls['kls']; ?>"><?= $r_kls['kls']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div id="tmbh">
				<div class="col-12" id="ns">
					<label for="nis" class="form-label">NIS</label>
					<input type="text" name="nis" id="nis" class="form-control" placeholder="Nomor Induk Siswa">
				</div>
				<div class="col-12" id="nm">
					<label for="nama" class="form-label">Nama</label>
					<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Siswa">
				</div>
				<p class="pt-2 pb-0 m-2 text-start">
				<h6>Catatan:</h6>
				<ul>
					<li>Kosongkan NIS dan Nama Jika Ingin Cetak Seluruh kelas.</li>
					<li>Gunakan ','(koma) untuk cetak beberapa NIS/Kartu Pelajar. </li>
					<li>Gunakan kertas PVC ID Card dengan ukuran 200 x 300 mm.</li>
				</ul>
				</p>
			</div>
			<div id="ctk">
				<div class="col-12">
					<label for="ketas" class="form-label">Ukuran Kertas</label>
					<select name="kertas" id="kertas" class="form-select">
						<option value="pvc">PVC ID Card (200x300mm)</option>
						<option value="a4">A4 (210x297mm)</option>
						<option value="f4">F4 (215x330mm)</option>
					</select>
				</div>
				<div class="col-12 mt-3 text-center" id="cetak">
					<button type="submit" class="btn btn-outline-primary"><i class="bi bi-printer"></i> Cetak Kartu</button>
				</div>
			</div>
		</div>
	</form>

	<script>
		$(document).ready(function() {
			$('#tkt').on('change', function() {
				let tkt = $(this).val();

				// Ambil data via AJAX
				$.ajax({
					url: 'app/proses/pr_siswa.php',
					type: 'POST',
					data: {
						tkt: tkt,
						prd: 'ch_tkt'
					},
					success: function(res) {
						$('#kls').html(res);
						// console.log(res);
					},
					error: function() {
						alert('Gagal memuat data kelas!');
					}
				});
			});
		});
	</script>
	<script>
		$(document).ready(function() {
			$("#ctk").hide();

			function cekInput() {
				let tkt = $("#tkt").val();
				let kls = $("#kls").val();
				let nis = $("#nis").val().trim();
				let nama = $("#nama").val().trim();

				if (tkt || kls || nis || nama) {
					$("#ctk").fadeIn();
					// $('#cetak').slideDown(150)
					// 	.css('opacity', 0)
					// 	.animate({
					// 		opacity: 1
					// 	}, 200);
				} else {
					$("#ctk").fadeOut();
					// $("#cetak").animate({
					// 		opacity: 0
					// 	}, 150)
					// 	.slideUp(150);
				}

				if (nis !== "") {
					$("#nm").fadeOut();
				} else if (nama !== "") {
					$("#ns").fadeOut();
				} else {
					$("#ns, #nm").fadeIn();
				}
			}

			$("#tkt, #kls, #nis, #nama").on("input change", cekInput);

			$("#cetak").on("click", function(e) {
				e.preventDefault(); // cegah submit langsung

				Swal.fire({
					title: 'Cetak Kartu?',
					text: 'Pastikan data sudah benar sebelum mencetak!',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Ya, Cetak!',
					cancelButtonText: 'Batal',
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33'
				}).then((result) => {
					if (result.isConfirmed) {
						// Jika form punya id, misalnya <form id="formCetak"> ... </form>
						// kamu bisa trigger submit-nya di sini
						// $("#formCetak").submit();

						// atau kalau tombol ini ada di dalam form langsung:
						Swal.fire({
							title: 'Diproses...',
							text: 'Mencetak kartu siswa',
							icon: 'info',
							showConfirmButton: false,
							timer: 1500
						}).then(() => {
							// setelah pesan ditutup, baru submit form
							$(e.target).closest("form").submit();
						});
					}
				});
			});
		});
	</script>
<?php
endif;


// Form Tambah Siswa
if ($prd == 'add'):
	echo 'tes ok';
endif;
?>