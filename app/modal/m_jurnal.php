<?php
require_once "../../config/server.php";


if ($_POST['id'] == 'create') {
	if (date('m') <= 6) $smt = 'Genap' . (date('Y') - 1) . '-' . date('Y');
	else $smt = 'Ganjil' . date('Y') . '-' . date('Y') + 1;


	$updt = $pdo_conn->prepare("SELECT upd FROM `tb_dsis` GROUP BY upd ORDER BY `tb_dsis`.`upd` DESC LIMIT 1;");
	$updt->execute();
	if ($updt->rowCount() != 0) {
		$updt = $updt->fetch(PDO::FETCH_ASSOC);
		$date = tgl_hari(date('d-m-Y', strtotime($updt['upd'])));
		$date .= ', Pukul ' . date(('H:i'), strtotime($updt['upd']));
		$bgdt = 'bg-info-subtle';
	} else {
		$date = 'Data Belum Update';
		$bgdt = 'bg-danger-subtle';
	}
?>
	<form action="app/report/v_jurnal" method="post" id="form" target="blank">
		<div class="col-12 h5 <?= $bgdt; ?> mb-2 py-3 text-center" style="border-radius: 5px;">Update Data <br> <?= $date; ?></div>
		<div class="row">
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="nama" class="form-label">Nama Guru</label>
				<select name="nama" id="nama" class="form-select" required>
					<option value="" selected disabled>-- Pilih --</option>
					<?php
					$stmt = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE jptk='Guru' ORDER BY nm_staf ASC");
					$stmt->execute();
					while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$glr = json_decode($row['glar'], true);
						$glr_d	= $glr['gld'] ?? '';
						$glr_b	= $glr['glb'] ?? '';
						$nmglr	= $glr_b 	== '' ? $row['nm_staf'] : $row['nm_staf'] . ', ' . $glr_b;
						$nmglr	.= $glr_d == '' ? '' : $glr_d . '.';

						echo '<option value="' . $row['kd_staf'] . '">' .  $nmglr . '</option>';
					}
					?>
				</select>
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="nip" class="form-label">NIP/NUPTK</label>
				<input type="text" name="nip" id="nip" class="form-control" placeholder="NIP/NUPTK">
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="mapel" class="form-label">Mata Pelajaran</label>
				<input type="text" name="mapel" id="mapel" class="form-control" placeholder="Nama Mata Pelajaran" value="">
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="al_waktu" class="form-label">Alokasi Waktu</label>
				<div class="input-group">
					<select name="al_waktu" id="al_waktu" class="form-select" required>
						<option value="" selected disabled>-- Pilih --</option>
						<option value="1">1 Jam Pelajaran</option>
						<option value="2">2 Jam Pelajaran</option>
						<option value="3">3 Jam Pelajaran</option>
						<option value="4">4 Jam Pelajaran</option>
						<option value="5">5 Jam Pelajaran</option>
						<option value="6">6 Jam Pelajaran</option>
					</select>
					<select name="al_temu" id="al_temu" class="form-select" required>
						<option value="" selected disabled>-- Pilih --</option>
						<option value="1">1 Pertemuan/Pekan</option>
						<option value="2">2 Pertemuan/Pekan</option>
						<option value="3">3 Pertemuan/Pekan</option>
						<option value="4">4 Pertemuan/Pekan</option>
					</select>
				</div>

			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="bln" class="form-label">Bulan Pelaksanaan</label>
				<select name="bln" id="bln" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<option value="1">Januari</option>
					<option value="2">Februari</option>
					<option value="3">Maret</option>
					<option value="4">April</option>
					<option value="5">Mei</option>
					<option value="6">Juni</option>
					<option value="7">Juli</option>
					<option value="8">Agustus</option>
					<option value="9">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">Desember</option>
				</select>
			</div>
			<div class="col-lg-4 col-md-6 col-12 mb-3">
				<label for="thn_ajar" class="form-label">Tahun Ajar</label>
				<?php
				$thn = date('Y');
				$bln = date('n'); // 1-12

				// Tentukan tahun dasar
				$baseYear = ($bln <= 6) ? $thn - 1 : $thn;

				// Jumlah pilihan tahun ajaran yang ditampilkan
				$jumlahPilihan = 4;
				?>
				<div class="input-group">
					<select name="thn_ajar" id="thn_ajar" class="form-select">
						<?php for ($i = -1; $i < $jumlahPilihan; $i++):
							$awal = $baseYear - $i;
							$akhir = $awal + 1;
							$value = "$awal/$akhir";
							$selected = ($value == date('Y') . '/' . (date('Y') + 1)) ? ' selected' : '';
						?>
							<option value="<?= $value ?>" <?= $selected; ?>><?= $value ?></option>
						<?php endfor; ?>
					</select>
					<select class="form-select" name="smt" id="smt">
						<option value="Ganjil" <?= $smt == 'Ganjil' ? ' selected' : '' ?>>Ganjil</option>
						<option value="Genap" <?= $smt == 'Genap' ? ' selected' : '' ?>>Genap</option>
					</select>
				</div>
			</div>
		</div>
		<div class="row mb-3 mx-3">
			<div class="col-12 p-0">Mengajar di Kelas</div>
			<div class="col-12 py-2 ps-0">
				<input type="checkbox" id="all" class="form-check-input">
				<label for="all" class="form-check-label fw-bold">Pilih Semua</label>
			</div>
			<?php
			$kls = $pdo_conn->prepare("SELECT kls FROM tb_dsis GROUP BY kls;");
			$kls->execute();
			while ($r = $kls->fetch(PDO::FETCH_ASSOC)) { ?>
				<div class="col-md-4 col-lg-3 col-sm-6 col-12 form-check">
					<input type="checkbox" name="kelas[]" id="<?= $r['kls']; ?>" class="form-check-input ckall" value="<?= $r['kls']; ?>">
					<label for="<?= $r['kls']; ?>" class="form-check-label"><?= $r['kls']; ?></label>
				</div>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-lg-3 col-12 mb-3">
				<label for="kertas" class="form-label">Ukuran kertas yang akan digunakan</label>
				<select name="kertas" id="kertas" class="form-select">
					<option value="a4">A4</option>
					<option value="f4">Folio/F4</option>
				</select>
			</div>
			<div class="col-lg-3 col-12 mb-3">
				<label for="orien" class="form-label">Orientasi Kertas</label>
				<select name="orien" id="orien" class="form-select">
					<option value="L" selected>Landscape</option>
					<option value="P">Portrait</option>
				</select>
			</div>
		</div>
		<div class="row g-2 justify-content-center">
			<div class="col-auto">
				<button type="submit" class="btn btn-primary" id="print" name="print"><i class="bi bi-printer"></i> Cetak Langsung</button>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-outline-dark" id="download" name="download"><i class="bi bi-download"></i> Unduh File Jurnal</button>
			</div>
		</div>
	</form>
	<script>
		$('label').addClass(' text-black');

		$(document).ready(function() {
			$('#nama').on('change', function() {
				const id = $(this).val();
				$.ajax({
					type: 'POST',
					url: 'app/proses/simpel.php',
					data: {
						id: id
					},
					success: function(res) {
						$('#nip').val(res);
					}
				})
			})
		})

$(document).ready(function() {
    $('#bln').on('change', function() {
        const bln = parseInt($(this).val());     // bulan yang dipilih
        const now = new Date();
        let thn = now.getFullYear();            // tahun sekarang
        const bln_now = now.getMonth() + 1;     // bulan sekarang (1-12)

        // === LOGIKA PERGANTIAN TAHUN ===
        // Jika ingin cetak Januari padahal sekarang Desember
        // atau bulan dipilih < bulan sekarang → artinya untuk tahun depan
        if (bln < bln_now) {
            thn = thn + 1;
        }

        // === TENTUKAN SEMESTER ===
        let smt = (bln >= 7) ? 'Ganjil' : 'Genap';
        $('#smt').val(smt);

        // === HITUNG TAHUN AJAR BERDASARKAN BULAN TERPILIH ===
        let thn_ajar;
        if (smt === 'Ganjil') {
            // Tahun ajar ganjil: thn/thn+1
            thn_ajar = thn + '/' + (thn + 1);
        } else {
            // Semester genap: (thn-1)/thn
            thn_ajar = (thn - 1) + '/' + thn;
        }
        
        $('#thn_ajar').val(thn_ajar);
    });
});


		$(document).ready(function() {
			$('#all').on('change', function() {
				$('.ckall').prop('checked', $(this).prop('checked'));
			});
			$('.ckall').on('change', function() {
				$('#all').prop('checked', $('.ckall:checked').length === $('.ckall').length);
			});
		});
	</script>
<?php }

if ($_POST['id'] == 'add') { ?>
	Tahap Pengembangan

<?php }
