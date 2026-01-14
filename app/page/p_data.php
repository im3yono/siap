<?php
require_once "../config/server.php";
$id = $_POST['id'];

$dt_sf = db_Proses($pdo_conn, "SELECT * FROM tb_dstaf WHERE kd_staf = ?", [$id]);
$dt_sf = $dt_sf->fetch(PDO::FETCH_ASSOC);

$kntk = json_decode($dt_sf['kontak'], true);
$tlp = ($kntk['tlp'] ?? '-') . ' / ' . ($kntk['hp'] ?? '-');
$psng = json_decode($dt_sf['psngn'], true);

$nm = f_nmGelar(f_nama($dt_sf['nm_staf']), $dt_sf['glar']);


function viewData($label, $data, $class = '')
{
	if ($label == 'NIK' || $label == 'NIKK') {
		// $data = substr($data, 0,3) . '****' . substr($data, -3);
		$data = substr($data, 0, 4) . '************';
		// $data = $data . '<button class="btn btn-sm btn-tool" onclick="togglePassword()"><i class="bi bi-eye"></i></button>';

	}
	if ($data == '') $data = '-';
	$view1 = '
	<div class="col-md-3 col-4">' . $label . '</div>
	<div class="col">
		<div class="row gap-0">
			<div class="col-auto" style="max-width: 5px;">:</div>
			<div class="col">' . $data . '</div>
		</div>
	</div>';
	return '<div class="row ' . $class . '">' . $view1 . '</div>';
}
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
	<div class="col-auto">Informasi Biodata Staf</div>
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

					<?=
					viewData('Nama Lengkap', $nm, 'fw-semibold')
						. viewData('NIP', $dt_sf['nip'])
						. viewData('NUPTK', $dt_sf['nuptk'])
						. viewData('NIK', $dt_sf['nik'])
						. viewData('NIKK', $dt_sf['nkk'])
						. viewData('Tempat, Tanggal Lahir', $dt_sf['tmp_l'] . ', ' . tgl($dt_sf['tgl_l']))
						. viewData('Jenis Kelamin', $dt_sf['jk'] == 'L' ? 'Laki-Laki' : 'Perempuan')
						. viewData('Agama', $dt_sf['agm'])
						. viewData('Alamat', f_almtL($dt_sf['almt']))
						. viewData('Kewarganegaraan', $dt_sf['warga'])
						. viewData('Email', $kntk['email'])
						. viewData('Telepon/Hp', $tlp)
						. viewData('Pendidikan', $dt_sf['ppdk'])
						. viewData('Nama Sekolah/Perguruan', $dt_sf['sklh_univ'])
						. viewData('Jabatan', $dt_sf['jptk'])
						. viewData('Status Kepegawaian', $dt_sf['stt_pgw'])
						. viewData('Tugas Tambahan', $dt_sf['tgs_tmbh'])
						. viewData('SK Pengangkatan', $dt_sf['sk_pengaktn'])
						. viewData('TMT Pengangkatan', tgl_hari($dt_sf['tmt_angkt']))
						. viewData('SK CPNS', $dt_sf['sk_cpns'])
						. viewData('Tanggal CPNS', tgl_hari($dt_sf['tgl_cpns']))
						. viewData('Lembaga Pengagkatan', $dt_sf['lbg_angkt'])
						. viewData('Pangkat/Golongan', $dt_sf['pngkat_gl'])
						. viewData('TMT PNS', tgl_hari($dt_sf['tmt_pns']))
						. viewData('Sumber Gajih', $dt_sf['sgaji'])
						. viewData('Nama Ibu', $dt_sf['nm_ibu'])
						. viewData('Status Perkawinan', $dt_sf['sts_kwn'])
						. viewData('Nama Suami/Istri', $psng['nm'])
						. viewData('NIP Suami/Istri', $psng['nip'])
						. viewData('Kerja Suami/Istri', $psng['kerja'])
						// . viewData('', $dt_sf[''])
					;
					?>

				</div>
				<div class="col-auto px-3">
					<button type="button" class="btn btn-outline-primary"><i class="bi bi-pencil"></i> Perbaiki Profil</button>
					<button type="button" class="btn btn-outline-secondary"><i class="bi bi-printer"></i> Cetak Profil</button>
				</div>
			</div>
		</div>
	</div>
</div>