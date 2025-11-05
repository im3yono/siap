<?php
require_once "../config/server.php";
$id = $_POST['id'];

$dt_sf = db_Proses($pdo_conn, "SELECT * FROM tb_dstaf WHERE kd_staf = ?", [$id]);
$dt_sf = $dt_sf->fetch(PDO::FETCH_ASSOC);

$kntk = json_decode($dt_sf['kontak'], true);
$tlp = ($kntk['tlp'] ?? '-') . ' / ' . ($kntk['hp'] ?? '-');
$psng = json_decode($dt_sf['psngn'], true);

$nm = f_nmGelar(f_nama($dt_sf['nm_staf']), $dt_sf['glar'])
?>

<style>
	/* .row .label{
		white-space: nowrap;
		
	} */
</style>

<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm">
	<div class="col-auto">
		<button onclick="history.go(-1);" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</button>
	</div>
	<div class="col-auto">Informasi Data Staf</div>
</div>
<div class="row">
	<div class="col-xl-4">
		<div class="card mb-3">
			<div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
				<img src="<?= ft($dt_sf['kd_staf'], 'staf'); ?>" alt="Profile" class="rounded-circle img-size-150">
				<h3 class="text-uppercase text-center"><?= $nm; ?></h3>
				<h4><?= $dt_sf['kd_staf']; ?></h4>
			</div>
		</div>
		<div class="card mb-3">
			<div class="card-header">
				<div class="text-center h5">Ganti Password</div>
			</div>
			<div class="card-body pt-4">
				<!-- Change Password Form -->
				<form>

					<div class="row mb-3">
						<label for="currentPassword" class="col-md-6 col-lg-5 col-form-label">Password Lama</label>
						<div class="col">
							<input name="password" type="password" class="form-control" id="currentPassword">
						</div>
					</div>

					<div class="row mb-3">
						<label for="newPassword" class="col-md-6 col-lg-5 col-form-label">Password Baru</label>
						<div class="col">
							<input name="newpassword" type="password" class="form-control" id="newPassword">
						</div>
					</div>

					<div class="row mb-3">
						<label for="renewPassword" class="col-md-6 col-lg-5 col-form-label">Konfirmasi Password</label>
						<div class="col">
							<input name="renewpassword" type="password" class="form-control" id="renewPassword">
						</div>
					</div>

					<div class="text-start">
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form><!-- End Change Password Form -->
			</div>
		</div>
	</div>

	<div class="col-xl-8">
		<div class="card">
			<div class="card-body pt-3">
				<div class="col-12 px-3 pb-3">
					<!-- <h5 class="card-title">About</h5>
							<p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p> -->

					<h5 class="">Profil Lengakap</h5>

					<div class="row">
						<div class="col-lg-3 col-md-4 label ">Nama Lengkap</div>
						<div class="col-lg-9 col-md-8 fw-semibold"><?= $nm; ?></div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-4 label ">NIP</div>
						<div class="col-lg-9 col-md-8 fw-semibold"><?= $dt_sf['nip']; ?></div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-4 label ">NUPTK</div>
						<div class="col-lg-9 col-md-8 fw-semibold"><?= $dt_sf['nuptk']; ?></div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-4 label ">NIK</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['nik']; ?></div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-md-4 label ">NKK</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['nkk']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Tempat, Tanggal Lahir</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['tmp_l'] . ', ' . tgl($dt_sf['tgl_l']); ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Jenis Kelamin</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan'; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Agama</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['agm']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Alamat</div>
						<div class="col-lg-9 col-md-8"><?= f_almtL($dt_sf['almt']); ?></div>
					</div>

					<!-- <div class="row">
						<div class="col-lg-3 col-md-4 label">Kewarganegaraan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['warga']; ?></div>
					</div> -->

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Email</div>
						<div class="col-lg-9 col-md-8"><?= $kntk['email']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Tlp/Hp</div>
						<div class="col-lg-9 col-md-8"><?= $tlp; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Pendidikan Terakhir</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['ppdk']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Nama Sekolah/Perguruan Tinggi</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['sklh_univ']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Jabatan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['jptk']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Status Kepegawaian</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['stt_pgw']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Tugas Tambahan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['tgs_tmbh']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">SK Pengangkatan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['sk_pengaktn']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">TMT Pengangkatan</div>
						<div class="col-lg-9 col-md-8"><?= tgl_hari($dt_sf['jptk']); ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">SK CPNS</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['sk_cpns']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Tanggal CPNS</div>
						<div class="col-lg-9 col-md-8"><?= tgl_hari($dt_sf['tgl_cpns']); ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Lembaga Pengangkatan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['lbg_angkt']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Pangkat/Golongan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['pngkat_gl']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">TMT PNS</div>
						<div class="col-lg-9 col-md-8"><?= tgl_hari($dt_sf['tmt_pns']); ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Sumber Gajih</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['sgaji']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Nama Ibu</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['nm_ibu']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Status Perkawinan</div>
						<div class="col-lg-9 col-md-8"><?= $dt_sf['sts_kwn']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Nama Suami/Istri</div>
						<div class="col-lg-9 col-md-8"><?= $psng['nm']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">NIP Suami/Istri</div>
						<div class="col-lg-9 col-md-8"><?= $psng['nip']; ?></div>
					</div>

					<div class="row">
						<div class="col-lg-3 col-md-4 label">Kerja Suami/Istri</div>
						<div class="col-lg-9 col-md-8"><?= $psng['kerja']; ?></div>
					</div>

				</div>
				<div class="col-auto px-3">
					<button type="button" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Perbaiki Profil</button>
					<button type="button" class="btn btn-outline-secondary"><i class="bi bi-printer"></i> Cetak Profil</button>
				</div>
			</div>
		</div>
	</div>
</div>