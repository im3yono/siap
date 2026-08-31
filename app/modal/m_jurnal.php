<?php
require_once "../../config/server.php";


$kls = db_Proses($pdo_conn, "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC");

// Jurnal Manual
if ($_POST['id'] == 'create') :
	if (date('m') <= 6) $smt = 'Genap' . (date('Y') - 1) . '-' . date('Y');
	else $smt = 'Ganjil' . date('Y') . '-' . date('Y') + 1;


	$updt = $pdo_conn->prepare("SELECT upd FROM tb_dsis GROUP BY upd ORDER BY upd DESC LIMIT 1;");
	$updt->execute();
	if ($updt->rowCount() != 0) {
		$updt = $updt->fetch(PDO::FETCH_ASSOC);
		$date = tgl_hari(date('d-m-Y', strtotime($updt['upd'])));
		$date .= ', Pukul ' . date(('H:i'), strtotime($updt['upd']));
		if (date('d-m-Y', strtotime($updt['upd'])) == date('d-m-Y')):
			$bgdt = 'text-bg-success';
		elseif (strtotime($updt['upd']) >= strtotime('-7 days')):
			$bgdt = 'text-bg-info';
		else:
			$bgdt = 'text-bg-danger';
		endif;
	} else {
		$date = 'Data Belum Update';
		$bgdt = 'bg-danger';
	}
?>
	<form action="app/report/v_jurnal" method="post" id="form" target="blank">

		<div class="col-12 h5 <?= $bgdt; ?> mb-2 py-3 text-center" style="border-radius: 5px;">Update Data <br> <?= $date; ?></div>

		<div class="row g-3 mb-3">
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nama" class="form-label">Nama Guru</label>
				<select name="nama" id="nama" class="form-select" required>
					<option value="" selected disabled>-- Pilih --</option>
					<option value="1" class="text-bg-info">******* Tanpa Nama *******</option>
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
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nip" class="form-label">NIP/NUPTK</label>
				<input type="text" name="nip" id="nip" class="form-control" placeholder="">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="mapel" class="form-label">Mata Pelajaran</label>
				<input type="text" name="mapel" id="mapel" class="form-control" placeholder="" value="" maxlength="35">
				<input type="hidden" name="kd_mpel" id="kd_mpel">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="al_waktu" class="form-label">Alokasi Waktu</label>
				<div class="input-group">
					<select name="al_waktu" id="al_waktu" class="form-select" required>
						<option value="" selected disabled>-- Pilih Jam --</option>
						<option value="1">1 Jam Pelajaran</option>
						<option value="2">2 Jam Pelajaran</option>
						<option value="3">3 Jam Pelajaran</option>
						<option value="4">4 Jam Pelajaran</option>
						<option value="5">5 Jam Pelajaran</option>
						<option value="6">6 Jam Pelajaran</option>
					</select>
					<select name="al_temu" id="al_temu" class="form-select" required>
						<option value="" selected disabled>Pilih Pertemuan</option>
						<option value="1">1 Pertemuan/Pekan</option>
						<option value="2">2 Pertemuan/Pekan</option>
						<option value="3">3 Pertemuan/Pekan</option>
						<option value="4">4 Pertemuan/Pekan</option>
					</select>
				</div>

			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="bln" class="form-label">Bulan Pelaksanaan</label>
				<select name="bln" id="bln" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<option value="16">Semester Genap</option>
					<option value="1">Januari</option>
					<option value="2">Februari</option>
					<option value="3">Maret</option>
					<option value="4">April</option>
					<option value="5">Mei</option>
					<option value="6">Juni</option>
					<option value="712">Semester Ganjil</option>
					<option value="7">Juli</option>
					<option value="8">Agustus</option>
					<option value="9">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">Desember</option>
				</select>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
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
			$kls = $pdo_conn->prepare("SELECT kls FROM tb_kls ORDER BY kls ASC");
			$kls->execute();
			while ($r = $kls->fetch(PDO::FETCH_ASSOC)) { ?>
				<div class="col-md-4 col-lg-3 col-sm-6 col-12 form-check">
					<input type="checkbox" name="kelas[]" id="<?= $r['kls']; ?>" class="form-check-input ckall" value="<?= $r['kls']; ?>">
					<label for="<?= $r['kls']; ?>" class="form-check-label"><?= $r['kls']; ?></label>
				</div>
			<?php } ?>
		</div>
		<div class="row mb-3">
			<div class="col-lg-3 col-12 mb-3">
				<label for="cvr" class="form-label">Sampul/Kover Jurnal</label>
				<select name="cvr" id="cvr" class="form-select">
					<option value="1">Sertakan</option>
					<option value="0">Kecualikan</option>
				</select>
			</div>
			<div class="col-lg-3 col-12 mb-3">
				<label for="kertas" class="form-label">Kertas</label>
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
			<div class="col-lg-3 col-12 mb-3">
				<label for="jilid" class="form-label">Jilid</label>
				<div class="input-group">
					<select name="jilid" id="jilid" class="form-select">
						<option value="N" selected>Tidak</option>
						<option value="Y">Ya</option>
					</select>
					<select name="jld_pss" id="jld_pss" class="form-select" style="display: none;">
						<option value="K" selected>Kiri</option>

					</select>
				</div>
			</div>
		</div>
		<div class="row g-2 justify-content-center">
			<div class="col-auto">
				<button type="submit" class="btn btn-outline-primary" id="print" name="print"><i class="bi bi-printer"></i> Cetak Langsung</button>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-outline-dark" id="download" name="download"><i class="bi bi-download"></i> Unduh File Jurnal</button>
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function() {
			$('#bln').on('change', function() {
				const bln = parseInt($(this).val(), 10);
				const now = new Date();
				const nowYear = now.getFullYear();
				const blnNow = now.getMonth() + 1;

				if (bln === 712) {
					$('#smt').val('Ganjil');
					$('#thn_ajar').val(nowYear + '/' + (nowYear + 1));
					return;
				}

				if (bln === 16) {
					$('#smt').val('Genap');
					$('#thn_ajar').val((nowYear - 1) + '/' + nowYear);
					return;
				}

				let thn = nowYear;
				if (bln < blnNow) thn++;

				const smt = (bln >= 7) ? 'Ganjil' : 'Genap';
				$('#smt').val(smt);

				const thnAjar = (smt === 'Ganjil') ?
					thn + '/' + (thn + 1) :
					(thn - 1) + '/' + thn;

				$('#thn_ajar').val(thnAjar);
			});
		});

		$("#orien").on("change", function() {
			let orien = $("#orien").val();
			if (orien == "P") {
				$("#jld_pss").html('<option value="K" selected>Kiri</option><option value="A">Atas</option>');
			} else {
				$("#jld_pss").html('<option value="K" selected>Kiri</option>');
			}
		})

		$("#jilid").on("change", function() {
			let jld = $("#jilid").val();
			if (jld == "Y") {
				$("#jld_pss").show();
			} else {
				$("#jld_pss").hide();
			}
		})
	</script>
<?php endif;



// Input Data Jurnal
if ($_POST['id'] == 'add') { ?>
	<form method="post" enctype="multipart/form-data" id="add_jrnl">
		<div class="row g-3 my-3 mx-0 border br-7 p-2">
			<div class="col-lg-3 col-md-6 col-12">
				<label for="kd_gr" class="form-label">Nama Guru</label>
				<select name="kd_gr" id="kd_gr" class="form-select" required>
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
			<div class="col-lg-3 col-md-6 col-12">
				<label for="nip" class="form-label">NIP/NUPTK</label>
				<input type="text" name="nip" id="nip" class="form-control" placeholder="">
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<label for="mapel" class="form-label">Mata Pelajaran</label>
				<input type="text" name="mapel" id="mapel" class="form-control" placeholder="" value="" maxlength="35">
				<input type="hidden" name="kd_mpel" id="kd_mpel">
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<label for="tgl" class="form-label">Tanggal</label>
				<input type="date" name="tgl" id="tgl" class="form-control">
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<label class="form-label">Jam Pelajaran</label>
				<div class="input-group">
					<label for="jp_m" class="input-group-text" style="width: 75px;">Mulai</label>
					<select name="jp_m" id="jp_m" class="form-select">
						<option value="" selected disabled>-- Pilih ---</option>
						<?php for ($i = 1; $i <= 11; $i++) {
							echo '<option value="' . $i . '"> Ke-' . $i . '</option>';
						} ?>
					</select>
					<label for="jp_s" class="input-group-text" style="width: 75px;">Selesai</label>
					<select name="jp_s" id="jp_s" class="form-select">
						<option value="" selected disabled>-- Pilih ---</option>
						<!-- <?php for ($i = 2; $i <= 11; $i++) {
										echo '<option value="' . $i . '"> Ke-' . $i . '</option>';
									} ?> -->
					</select>
				</div>
			</div>
			<div class="col-lg-3 col-md-6 col-12">
				<label for="kls" class="form-label">Kelas</label>
				<select name="kls" id="kls" class="form-select">
					<option value="" selected disabled>-- Pilih --</option>
					<?php
					while ($r_kls = $kls->fetch(PDO::FETCH_ASSOC)) {
						echo '<option value="' . $r_kls['kls'] . '"> ' . $r_kls['kls'] . '</option>';
					} ?>
				</select>
				<script>
					$(document).ready(function() {
						$('#kls').on('change', function() {
							const id_kls = $(this).val();
							$.ajax({
								type: 'POST',
								url: 'app/table/t_jurnal_sis',
								data: {
									id_kls: id_kls
								},
								success: function(data) {
									$('#tbody_siswa').html(data);
								}
							})
						})
					})
				</script>
			</div>
			<!-- <div class="col p-1"></div> -->
		</div>
		<div class="row gap-3 mx-0 mb-3">
			<div class="col-12 col-lg-7 border br-7">
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead>
							<th>No</th>
							<th>NIS/NISN</th>
							<th>Nama</th>
							<th>Kehadiran</th>
							<th>Nilai</th>
							<th>Keterangan</th>
						</thead>
						<tbody id="tbody_siswa">
							<tr>
								<td colspan="6" class="text-center">Pilih kelas terlebih dahulu</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-12 col-lg border br-7 p-3">
				<div class="row">
					<div class="col-12 mb-3">
						<label for="materi" class="form-label">Materi/Pokok Bahasan</label>
						<textarea name="materi" id="materi" class="form-control" rows="5" maxlength="200"></textarea>
					</div>
					<div class="col-12 mb-3">
						<label for="keg" class="form-label">Kegiatan/Penilaian</label>
						<textarea name="keg" id="keg" class="form-control" rows="5" maxlength="200"></textarea>
					</div>
					<div class="col-12 mb-3">
						<label for="ket_g" class="form-label">Keterangan</label>
						<textarea name="ket_g" id="ket_g" class="form-control" rows="5" placeholder="Dapat diisi dengan ketercapaian pembelajaran" maxlength="150"></textarea>
					</div>
				</div>
				<div class="row mx-3 justify-content-end">
					<div class="col-auto">
						<button type="button" class="btn btn-primary" id="simpan">Simpan</button>
					</div>
				</div>
			</div>
			<!-- <div class="col"></div> -->
		</div>
	</form>
	<script>
		$(document).ready(function() {
			$('#jp_m').on('change', function() {
				const start = parseInt($(this).val(), 10) + 1;
				let options = '';
				for (let i = start; i <= 11; i++) {
					options += `<option value="${i}"> Ke-${i} </option>`;
				}
				if (start == 12) {
					options = `<option value="11" selected> Ke-11 </option>`;
				}
				$('#jp_s').html(options).prop('hidden', false);
				$('label[for="jp_s"]').prop('hidden', false);
			});
		});

		$(document).ready(function() {
			$('#simpan').on('click', function() {
				let data = $('#add_jrnl').serializeArray();

				// mode proses
				data.push({
					name: 'prd',
					value: 'ctt'
				});

				$.ajax({
					type: 'POST',
					url: 'app/proses/pr_jurnal',
					data: $.param(data),
					success: function(res) {
						switch (res) {
							case 'ok':
								notif('success', 'Berhasil!', 'Data berhasil disimpan.', 'kon');
								$('#d_jrnl').modal('hide');
								break;

							case 'update':
								notif('success', 'Berhasil!', 'Data berhasil diupdate.', 'kon');
								$('#d_jrnl').modal('hide');
								break;

								// case 'dup':
								// 	notif('warning', 'Peringatan!', 'Kode kelas sudah ada');
								// 	break;

							case 'err':
								notif('error', 'Gagal!', 'Gagal menyimpan data. Silahkan coba lagi.');
								break;
							default:
								notif('error', res);
						}
						// console.log(res);
					}
				})
			})
		})
	</script>

<?php }



// Cetak Data Jurnal
if ($_POST['id'] == 'cetak'):
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
		<!-- <div class="col-12 h5 <?= $bgdt; ?> mb-2 py-3 text-center" style="border-radius: 5px;">Update Data <br> <?= $date; ?></div> -->
		<div class="row g-3 mb-3">
			<div class="col-md-6 col-12">
				<label for="nama" class="form-label">Nama Guru</label>
				<select name="nama" id="nama" class="form-select" required>
					<option value="" selected disabled>-- Pilih --</option>
					<option value="1" class="text-bg-info">******* Tanpa Nama *******</option>
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
			<div class="col-md-6 col-12">
				<label for="nip" class="form-label">NIP/NUPTK</label>
				<input type="text" name="nip" id="nip" class="form-control" placeholder="">
			</div>
			<div class="col-md-6 col-12">
				<label for="mapel" class="form-label">Mata Pelajaran</label>
				<input type="text" name="mapel" id="mapel" class="form-control" placeholder="" value="" maxlength="35">
				<input type="hidden" name="kd_mpel" id="kd_mpel">
			</div>
			<!-- <div class="col-md-6 col-12">
				<label for="al_waktu" class="form-label">Alokasi Waktu</label>
				<div class="input-group">
					<select name="al_waktu" id="al_waktu" class="form-select" required>
						<option value="" selected disabled>-- Pilih Jam --</option>
						<option value="1">1 Jam Pelajaran</option>
						<option value="2">2 Jam Pelajaran</option>
						<option value="3">3 Jam Pelajaran</option>
						<option value="4">4 Jam Pelajaran</option>
						<option value="5">5 Jam Pelajaran</option>
						<option value="6">6 Jam Pelajaran</option>
					</select>
					<select name="al_temu" id="al_temu" class="form-select" required>
						<option value="" selected disabled>Pilih Pertemuan</option>
						<option value="1">1 Pertemuan/Pekan</option>
						<option value="2">2 Pertemuan/Pekan</option>
						<option value="3">3 Pertemuan/Pekan</option>
						<option value="4">4 Pertemuan/Pekan</option>
					</select>
				</div>

			</div> -->
			<div class="col-md-6 col-12">
				<label for="bln" class="form-label">Bulan Pelaksanaan</label>
				<select name="bln" id="bln" class="form-select">
					<option value="" selected>-- Pilih --</option>
					<!-- <option value="16">Semester Genap</option> -->
					<option value="1">Januari</option>
					<option value="2">Februari</option>
					<option value="3">Maret</option>
					<option value="4">April</option>
					<option value="5">Mei</option>
					<option value="6">Juni</option>
					<!-- <option value="712">Semester Ganjil</option> -->
					<option value="7">Juli</option>
					<option value="8">Agustus</option>
					<option value="9">September</option>
					<option value="10">Oktober</option>
					<option value="11">November</option>
					<option value="12">Desember</option>
				</select>
			</div>
			<!-- <div class="col-md-6 col-12">
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
					<select name="thn_ajar" id="thn_ajar" class="form-select" >
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
			</div> -->
			<input type="hidden" name="ctjrl" value="ctk">
		</div>
		<div class="row mb-3 mx-3">
			<div class="col-12 p-0">Mengajar di Kelas</div>
			<div class="col-12 py-2 ps-0">
				<input type="checkbox" id="all" class="form-check-input">
				<label for="all" class="form-check-label fw-bold">Pilih Semua</label>
			</div>
			<!-- <?php
						$kls = $pdo_conn->prepare("SELECT kls FROM tb_jrnl GROUP BY kls ORDER BY kls ASC;");
						$kls->execute();
						while ($r = $kls->fetch(PDO::FETCH_ASSOC)) { ?>
				<div class="col-md-4 col-lg-3 col-sm-6 col-12 form-check">
					<input type="checkbox" name="kelas[]" id="<?= $r['kls']; ?>" class="form-check-input ckall" value="<?= $r['kls']; ?>">
					<label for="<?= $r['kls']; ?>" class="form-check-label"><?= $r['kls']; ?></label>
				</div>
			<?php } ?> -->
			<div class="row" id="ck_list"></div>
		</div>
		<div class="row">
			<div class="col-lg-6 col-12 mb-3">
				<label for="cvr" class="form-label">Sampul/Kover Jurnal</label>
				<select name="cvr" id="cvr" class="form-select">
					<option value="1">Sertakan</option>
					<option value="0">Kecualikan</option>
				</select>
			</div>
			<div class="col-lg-6 col-12 mb-3">
				<label for="kertas" class="form-label">Ukuran kertas yang akan digunakan</label>
				<select name="kertas" id="kertas" class="form-select">
					<option value="a4">A4</option>
					<option value="f4">Folio/F4</option>
				</select>
			</div>
			<div class="col-lg-6 col-12 mb-3">
				<label for="orien" class="form-label">Orientasi Kertas</label>
				<select name="orien" id="orien" class="form-select">
					<option value="L" selected>Landscape</option>
					<option value="P">Portrait</option>
				</select>
			</div>
		</div>
		<div class="row g-2 justify-content-center">
			<div class="col-auto">
				<button type="submit" class="btn btn-outline-primary" id="print" name="print"><i class="bi bi-printer"></i> Cetak Langsung</button>
			</div>
			<div class="col-auto">
				<button type="submit" class="btn btn-outline-dark" id="download" name="download"><i class="bi bi-download"></i> Unduh File Jurnal</button>
			</div>
		</div>
	</form>


	<script>
		$('label').addClass(' text-black');

		$(document).ready(function() {
			$('#nama, #kd_gr').on('change', function() {
				const id = $(this).val();
				if (id == '1') {
					return $('#nip').val('');
				}
				$.ajax({
					type: 'POST',
					url: 'app/proses/pr_jurnal',
					data: {
						id: id,
						prd: 'nm',
						ctk: 'ctk'
					},
					dataType: 'json',
					success: function(res) {
						// console.log(res);
						$('#nip').val(res.id || '');
						$('#mapel').val(res.mpel || '');
						$('#kd_mpel').val(res.kd_mpel || '');
						$('#ck_list').html(res.ck_list || '');
					},
					error: function(xhr, status, err) {
						console.error('AJAX error:', status, err, xhr.responseText);
					}
				});
			})
		})
	</script>
<?php endif;



if ($_POST['id'] == 'create' || $_POST['id'] == 'add' || $_POST['id'] == 'cetak') : ?>
	<script>
		$('label').addClass(' text-black');

		$(document).ready(function() {
			$('#nama, #kd_gr').on('change', function() {
				const id = $(this).val();
				if (id == '1') {
					return $('#nip').val('');
				}
				$.ajax({
					type: 'POST',
					url: 'app/proses/pr_jurnal',
					data: {
						id: id,
						prd: 'nm'
					},
					dataType: 'json',
					success: function(res) {
						// console.log(res);
						$('#nip').val(res.id || '');
						$('#mapel').val(res.mpel || '');
						$('#kd_mpel').val(res.kd_mpel || '');
					},
					error: function(xhr, status, err) {
						console.error('AJAX error:', status, err, xhr.responseText);
					}
				});
			})
		})

		$(document).ready(function() {
			$('#all').on('change', function() {
				$('.ckall').prop('checked', $(this).prop('checked'));
			});
			$('.ckall').on('change', function() {
				$('#all').prop('checked', $('.ckall:checked').length === $('.ckall').length);
			});
		});
	</script>
<?php endif;
if ($_POST['id'] == 'create' || $_POST['id'] == 'cetak') : ?>
	<script>
		$(document).ready(function() {
			$('#all').on('change', function() {
				$('.ckall').prop('checked', $(this).prop('checked'));
			});
			$('.ckall').on('change', function() {
				$('#all').prop('checked', $('.ckall:checked').length === $('.ckall').length);
			});
		});
	</script>
<?php endif; ?>