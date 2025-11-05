<?php
require_once "../config/server.php";
require_once "../assets/vendor/autoload.php";
$id = $_REQUEST['id'];

// if (empty($id)) {
// 	include_once("error/403.php");
// 	exit;
// }

$dsis = db_Proses($pdo_conn, "SELECT * FROM tb_dsis WHERE nipd = ?", [$id]);

if ($dsis->rowCount() == 0) {
	// Buat array kosong agar tetap bisa digunakan di bawah
	$dsis = [];
} else {
	$dsis = $dsis->fetch(PDO::FETCH_ASSOC);
}

// ==== Gunakan null coalescing operator (?? '') agar aman ====
$id_sis	= $dsis['id_dsis'] ?? '';
$nm			= $dsis['nm'] ?? '';
$nisn		= $dsis['nisn'] ?? '';
$jkl		= (isset($dsis['jk']) && $dsis['jk'] == 'L') ? 'selected' : '';
$jkp		= (isset($dsis['jk']) && $dsis['jk'] == 'P') ? 'selected' : '';
$tmp_l	= $dsis['tmp_lahir'] ?? '';
$tgl_l	= $dsis['tgl_lahir'] ?? '';
$nik		= $dsis['nik'] ?? '';
$nkk		= $dsis['nkk'] ?? '';
$agm		= $dsis['agm'] ?? '';

$almtData	= !empty($dsis['almt']) ? json_decode($dsis['almt'], true) : [];
$rt				= $almtData['rt'] ?? '';
$rw				= $almtData['rw'] ?? '';
$dusun		= $almtData['dusun'] ?? '';
$kel			= $almtData['kel'] ?? '';
$kec			= $almtData['kec'] ?? '';
$kdpos		= $almtData['kdpos'] ?? '';
$almt			= $almtData['almt'] ?? '';

$tmp_t			= $dsis['tmp_tinggal'] ?? '';
$transport	= $dsis['trasport'] ?? '';

$tlpData	= !empty($dsis['tlp/hp']) ? json_decode($dsis['tlp/hp'], true) : [];
$hp				= $tlpData['hp'] ?? '';
$tlp			= $tlpData['tlp'] ?? '';

$email		= $dsis['email'] ?? '';

$ayah			= !empty($dsis['ayah']) ? json_decode($dsis['ayah'], true) : [];
$ibu			= !empty($dsis['ibu']) ? json_decode($dsis['ibu'], true) : [];
$wali			= !empty($dsis['wali']) ? json_decode($dsis['wali'], true) : [];

$a_nm			= $ayah['nm'] ?? '';
$a_nik		= $ayah['nik'] ?? '';
$a_thn_l	= $ayah['thn_l'] ?? '';
$a_almt		= $ayah['almt'] ?? '';
$a_pddk		= $ayah['pddk'] ?? '';
$a_kerja	= $ayah['kerja'] ?? '';
$a_upah		= $ayah['upah'] ?? '';

$i_nm			= $ibu['nm'] ?? '';
$i_nik		= $ibu['nik'] ?? '';
$i_thn_l	= $ibu['thn_l'] ?? '';
$i_almt		= $ibu['almt'] ?? '';
$i_pddk		= $ibu['pddk'] ?? '';
$i_kerja	= $ibu['kerja'] ?? '';
$i_upah		= $ibu['upah'] ?? '';

$w_nm			= $wali['nm'] ?? '';
$w_nik		= $wali['nik'] ?? '';
$w_thn_l	= $wali['thn_l'] ?? '';
$w_almt		= $wali['almt'] ?? '';
$w_pddk		= $wali['pddk'] ?? '';
$w_kerja	= $wali['kerja'] ?? '';
$w_upah		= $wali['upah'] ?? '';

$masuk		= $dsis['masuk'] ?? '';
$kls			= $dsis['kls'] ?? '';
$n_akta		= $dsis['no_akta'] ?? '';
$disabel	= $dsis['disabel'] ?? '';
$asl			= $dsis['sklh_asl'] ?? '';

$sdrData	= !empty($dsis['saudr']) ? json_decode($dsis['saudr'], true) : [];
$ake			= $sdrData['ke'] ?? '';
$sdr			= $sdrData['sdr'] ?? '';

$btlData	= !empty($dsis['bb_tb_lk']) ? json_decode($dsis['bb_tb_lk'], true) : [];
$bb				= $btlData['bb'] ?? '';
$tb				= $btlData['tb'] ?? '';
$lk				= $btlData['lk'] ?? '';

$jrk			= $dsis['jrk_rmh'] ?? '';
$rcd			= $dsis['rcd'] ?? '';
$upd			= $dsis['upd'] ?? '';


?>



<div class="row p-2 border-bottom fs-3 mb-4 shadow-sm ">
	<div class="col-auto ">
		<button data-route="siswa" class="btn btn-outline-dark"><i class="bi bi-arrow-left"></i> Kembali</button>
	</div>
	<div class="col-auto"><?= $id_sis != '' ? ' Edit Data Siswa | ID.' . $id_sis : 'Tambah Data Siswa'; ?></div>
</div>
<form method="post" enctype="multipart/form-data" id="edit_sis">
	<div class="row gap-lg-3 mx-lg-4 mx-1 mb-3 justify-content-lg-start justify-content-center">
		<h5 class="col-12 border-bottom p-2 bg-secondary-subtle" style="border-radius: 7px;"> Data Siswa</h5>

		<style>
			.image-upload-container {
				position: relative;
				display: inline-block;
				cursor: pointer;
			}

			.image-upload-container img {
				/* width: 150px;
				height: 150px; */
				object-fit: cover;
				border-radius: 10px;
				box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
			}

			.image-upload-container input[type="file"] {
				display: none;
				/* sembunyikan input file */
			}

			.upload-overlay {
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
				background: rgba(0, 0, 0, 0.5);
				color: #fff;
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: 2rem;
				opacity: 0;
				transition: opacity 0.3s ease;
				border-radius: 10px;
			}

			.image-upload-container:hover .upload-overlay {
				opacity: 1;
				/* muncul saat hover */
			}
		</style>
		<div class="col-sm-auto col-12 px-3 text-center">
			<label class="image-upload-container">
				<!-- Foto preview -->
				<img src="<?= ft($id, 'siswa'); ?>" alt="<?= $id; ?>" id="ft" class="img-thumbnail img-size-150">

				<!-- Overlay icon upload -->
				<div class="upload-overlay">
					<i class="bi bi-upload"></i>
				</div>

				<!-- Input file disembunyikan -->
				<input type="file" name="img" id="img" accept=".jpg,.jpeg,.png">
			</label>
		</div>
		<div class="col-lg-3 col-md-4 col-12 mb-3">
			<label for="nipd">NIPD</label>
			<input type="text" name="nipd" id="nipd" class="form-control mb-3" value="<?= $id; ?>">
			<input type="text" name="nipd2" id="nipd2" class="form-control mb-3" value="<?= $id; ?>" hidden>
			<input type="text" name="id_sis" id="id_sis" value="<?= $id_sis; ?>" hidden>
			<!-- </div>
		<div class="col-lg-4 col-md-6 col-12"> -->
			<label for="nisn">NISN</label>
			<input type="text" name="nisn" id="nisn" class="form-control mb-3" value="<?= $nisn; ?>">
		</div>
		<div class="col-lg col-md-10 col-auto bg-info-subtle p-3">
			<h5>Perhatian!!!</h5>
			<p>
				Pastikan data ini telah disesuaikan dengan data di <strong>Dapodik</strong>
				untuk menghindari ketidaksesuaian atau kesalahan dalam pendataan.
				Jika terdapat perbedaan, segera lakukan pengecekan dan pembaruan data melalui petugas atau operator sekolah.
				Ketelitian dalam memverifikasi data sangat penting agar informasi yang digunakan benar dan akurat.
			</p>
		</div>
	</div>
	<div class="row g-3 mx-lg-4 mx-1 mb-3">
		<div class="col-lg-4 col-md-6 col-12">
			<label for="nm">Nama</label>
			<input type="text" name="nm" id="nm" class="form-control" value="<?= $nm; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="tmp_l">Tempat, Tanggal Lahir</label>
			<div class="input-group">
				<input type="text" name="tmp_l" id="tmp_l" class="form-control" value="<?= $tmp_l; ?>">
				<input type="date" name="tgl_l" id="tgl_l" class="form-control" style="max-width: 170px;" value="<?= $tgl_l; ?>">
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="jk">Jenis Kelamin</label>
			<select name="jk" id="jk" class="form-select" style="max-width:140px ;">
				<option value="L" <?= $jkl; ?>>Laki-Laki</option>
				<option value="P" <?= $jkp; ?>>Perempuan</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="nik">NIK</label>
			<input type="text" name="nik" id="nik" class="form-control" value="<?= $nik; ?>" maxlength="16">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="nkk">NIKK</label>
			<input type="text" name="nkk" id="nkk" class="form-control" value="<?= $nkk; ?>" maxlength="16">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="agm">Agama</label>
			<select name="agm" id="agm" class="form-select" style="max-width:140px ;">
				<option value="Islam" <?= $agm == 'Islam' ? 'selected' : ''; ?>>Islam</option>
				<option value="Kristen" <?= $agm == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
				<option value="Katholik" <?= $agm == 'Katholik' ? 'selected' : ''; ?>>Katholik</option>
				<option value="Hindu" <?= $agm == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
				<option value="Buddha" <?= $agm == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
				<option value="Konghucu" <?= $agm == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="almt">Alamat</label>
			<textarea name="almt" id="almt" class="form-control"><?= $almt; ?></textarea>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="rt">RT/RW</label>
			<div class="input-group">
				<input type="text" name="rt" id="rt" class="form-control" value="<?= $rt; ?>" style="max-width:80px ;">
				<input type="text" name="rw" id="rw" class="form-control" value="<?= $rw; ?>" style="max-width:80px ;">
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="dsn">Dusun</label>
			<input type="text" name="dsn" id="dsn" class="form-control" value="<?= $dusun; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="desa">Kelurahan</label>
			<input type="text" name="desa" id="desa" class="form-control" value="<?= $kel; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="kec">Kecamatan</label>
			<input type="text" name="kec" id="kec" class="form-control" value="<?= $kec; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="kdpos">Kode Pos</label>
			<input type="text" name="kdpos" id="kdpos" class="form-control" value="<?= $kdpos; ?>" style="max-width:100px ;">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="tmp_t">Tempat Tinggal</label>
			<input type="text" name="tmp_t" id="tmp_t" class="form-control" value="<?= $tmp_t; ?>" style="max-width:200px ;">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="transpor">Transportasi</label>
			<input type="text" name="transpor" id="transpor" class="form-control" value="<?= $transport; ?>" style="max-width:200px ;">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="tlp">Telepon</label>
			<input type="text" name="tlp" id="tlp" maxlength="13" class="form-control" value="<?= $tlp; ?>" style="max-width:200px ;">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="hp">Henphone</label>
			<input type="text" name="hp" id="hp" maxlength="13" class="form-control" value="<?= $hp; ?>" style="max-width:200px ;">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="email">Email</label>
			<input type="text" name="email" id="email" class="form-control" value="<?= $email; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="masuk">Status Diterima</label>
			<!-- <input type="text" name="masuk" id="masuk" class="form-control" value="<?= $masuk; ?>"> -->
			<select name="masuk" id="masuk" class="form-select" style="max-width:200px ;">
				<option value="Baru" <?= $masuk == 'Baru' ? 'selected' : ''; ?>>Baru</option>
				<option value="Pindah" <?= $masuk == 'Pindah' ? 'selected' : ''; ?>>Pindah</option>
				<option value="Pertukaran" <?= $masuk == 'Pertukaran' ? 'selected' : ''; ?>>Pertukaran</option>
			</select>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="kls">Kelas</label>
			<input type="text" name="kls" id="kls" class="form-control" value="<?= $kls; ?>" style="max-width:200px ;">
			<!-- <select name="kls" id="kls" class="form-select">
			<option value="">-- Pilih --</option>
		</select> -->
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="n_akte">Nomor Akta Lahir</label>
			<input type="text" name="n_akte" id="n_akte" class="form-control" value="<?= $n_akta; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="disabel">Berkebutuhan Khusus</label>
			<input type="text" name="disabel" id="disabel" class="form-control" value="<?= $disabel; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="asl_sekl">Asal Sekolah</label>
			<input type="text" name="asl_sekl" id="asl_sekl" class="form-control" value="<?= $asl; ?>">
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="sdr">Jumlah Saudara</label>
			<div class="input-group">
				<span class="input-group-text">Dari</span>
				<input type="number" name="sdr" id="sdr" class="form-control" value="<?= $sdr; ?>" style="max-width:80px ;">
				<span class="input-group-text">Anak Ke</span>
				<input type="number" name="a_ke" id="a_ke" class="form-control" value="<?= $ake; ?>" style="max-width:80px ;">
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="bb">BMI dan Lingkar Kepala</label>
			<div class="input-group">
				<span class="input-group-text">BB</span>
				<input type="number" name="bb" id="bb" class="form-control" value="<?= $bb; ?>" style="max-width:80px ;">
				<span class="input-group-text">TB</span>
				<input type="number" name="tb" id="tb" class="form-control" value="<?= $tb; ?>" style="max-width:80px ;">
				<span class="input-group-text">LK</span>
				<input type="number" name="lk" id="lk" class="form-control" value="<?= $lk; ?>" style="max-width:80px ;">
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="jrk">Jarak Perjalanan</label>
			<div class="input-group">
				<input type="number" name="jrk" id="jrk" class="form-control" value="<?= $jrk; ?>" style="max-width:100px ;">
				<span class="input-group-text">KM</span>
			</div>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="tgl_df">Tanggal Input Data</label>
			<input type="text" name="tgl_df" id="tgl_df" class="form-control" value="<?= tglJam($rcd, ''); ?>" disabled>
		</div>
		<div class="col-lg-4 col-md-6 col-12">
			<label for="tgl_up">Tanggal Terakhir Update Data</label>
			<input type="text" name="tgl_up" id="tgl_up" class="form-control" value="<?= tglJam($upd, ''); ?>" disabled>
		</div>
	</div>
	<div class="row g-3 mx-lg-4 mx-1 mb-3 mt-5">
		<h5 class="col-12 border-bottom p-2 bg-secondary-subtle" style="border-radius: 7px;"> Data Orang Tua/Wali</h5>
		<div class="row g-3 mb-3">
			<h6 class="col-12 border-bottom p-1 bg-light"> Data Ayah</h6>
			<div class="row">
				<div class="col-auto">
					<label for="sts_a">Status Ayah</label>
					<select name="sts_a" id="sts_a" class="form-select">
						<option value="Y">Ada</option>
						<option value="N">Meninggal</option>
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nm_a">Nama </label>
				<input type="text" name="nm_a" id="nm_a" class="form-control" value="<?= $a_nm; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nik_a">NIK </label>
				<input type="text" name="nik_a" id="nik_a" class="form-control" value="<?= $a_nik; ?>" maxlength="16">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="thnl_a">Tahun Lahir </label>
				<input type="number" max="3000" min="1000" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" style="max-width: 100px;" name="thnl_a" id="thnl_a" class="form-control" value="<?= $a_thn_l; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="almt_a">Alamat </label>
				<textarea name="almt_a" id="almt_a" class="form-control"><?= $a_almt; ?></textarea>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="pddk_a">Pendidikan Terakhir </label>
				<input type="text" name="pddk_a" id="pddk_a" class="form-control" value="<?= $a_pddk; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="kerja_a">Pekerjaan </label>
				<input type="text" name="kerja_a" id="kerja_a" class="form-control" value="<?= $a_kerja; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="upah_a">Penghasilan Perbulan</label>
				<input type="text" name="upah_a" id="upah_a" class="form-control" value="<?= $a_upah; ?>">
			</div>
		</div>
		<div class="row g-3 mb-3">
			<h6 class="col-12 border-bottom p-1 bg-light"> Data Ibu</h6>
			<div class="row">
				<div class="col-auto">
					<label for="sts_i">Status Ibu</label>
					<select name="sts_i" id="sts_i" class="form-select">
						<option value="Y">Ada</option>
						<option value="N">Meninggal</option>
					</select>
				</div>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nm_i">Nama </label>
				<input type="text" name="nm_i" id="nm_i" class="form-control" value="<?= $i_nm; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nik_i">NIK </label>
				<input type="text" name="nik_i" id="nik_i" class="form-control" value="<?= $i_nik; ?>" maxlength="16">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="thnl_i">Tahun Lahir </label>
				<input type="number" max="3000" min="1000" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" style="max-width: 100px;" name="thnl_i" id="thnl_i" class="form-control" value="<?= $i_thn_l; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="almt_i">Alamat </label>
				<textarea name="almt_i" id="almt_i" class="form-control"><?= $i_almt; ?></textarea>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="pddk_i">Pendidikan Terakhir </label>
				<input type="text" name="pddk_i" id="pddk_i" class="form-control" value="<?= $i_pddk; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="kerja_i">Pekerjaan </label>
				<input type="text" name="kerja_i" id="kerja_i" class="form-control" value="<?= $i_kerja; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="upah_i">Penghasilan Perbulan</label>
				<input type="text" name="upah_i" id="upah_i" class="form-control" value="<?= $i_upah; ?>">
			</div>
		</div>
		<div class="row g-3 mb-3">
			<h6 class="col-12 border-bottom p-1 bg-light"> Data Wali</h6>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nm_w">Nama </label>
				<input type="text" name="nm_w" id="nm_w" class="form-control" value="<?= $w_nm; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="nik_w">NIK </label>
				<input type="text" name="nik_w" id="nik_w" class="form-control" value="<?= $w_nik; ?>" maxlength="16">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="thnl_w">Tahun Lahir </label>
				<input type="number" max="3000" min="1000" oninput="if(this.value.length > 4) this.value = this.value.slice(0, 4);" style="max-width: 100px;" name="thnl_w" id="thnl_w" class="form-control" value="<?= $w_thn_l; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="almt_w">Alamat </label>
				<textarea name="almt_w" id="almt_w" class="form-control"><?= $w_almt; ?></textarea>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="pddk_w">Pendidikan Terakhir </label>
				<input type="text" name="pddk_w" id="pddk_w" class="form-control" value="<?= $w_pddk; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="kerja_w">Pekerjaan </label>
				<input type="text" name="kerja_w" id="kerja_w" class="form-control" value="<?= $w_kerja; ?>">
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<label for="upah_w">Penghasilan Perbulan</label>
				<input type="text" name="upah_w" id="upah_w" class="form-control" value="<?= $w_upah; ?>">
			</div>
		</div>
	</div>
	<div class="row g-3 mx-lg-4 mx-1 mb-3">
		<div class="col-12">
			<button type="button" class="btn btn-primary" id="simpan" onclick="saveData()">Simpan</button>
			<button type="button" data-route="siswa" class="btn btn-outline-dark">Batal</button>
		</div>
	</div>
</form>


<script>
	imagePreview('#img', '#ft')

	// Proses Simpan
	function saveData() {
		var formEl = $('#edit_sis')[0];
		var data = new FormData(formEl);
		// add a marker field if needed by the server
		data.append('prd', 'edit_sis');
		$.ajax({
			url: 'app/proses/pr_siswa.php',
			type: 'POST',
			data: data,
			contentType: false,
			processData: false,
			beforeSend: function() {
				console.log("Mengirim data...");
			},
			success: function(response) {
				console.log(response); // untuk debugging
				if (response == 'in') {
					notif('success', "Berhasil!", "Data siswa telah ditambahkan.", 'kon', 'siswa')
				} else if (response == 'up') {
					notif('success', "Berhasil!", "Data siswa telah diperbarui.", 'kon', 'siswa')
				} else {
					notif('error', 'Gagal!', response)
				}
			},
			error: function(xhr, status, error) {
				console.error("AJAX Error:", error);
				Swal.fire("Gagal!", "Terjadi kesalahan saat mengirim data.", "error");
				notif('error', 'Gagal!', 'Terjadi kesalahan saat mengirim data.');
			}
		});
	}

	// otomatis isi ketika isi NIPD
	$(document).ready(function() {
		$('#nipd').on('change', function() {
			const id = $(this).val();
			$.ajax({
				type: 'POST',
				url: 'app/proses/pr_siswa.php',
				data: {
					id: id,
					prd: 'ck_nipd'
				},
				success: function(res) {
					if (!res) return;
					let data = res;
					if (typeof res === 'string') {
						try {
							data = JSON.parse(res);
						} catch (e) {
							console.error('Invalid JSON response', e, res);
							return;
						}
					}
					$.each(data, function(key, val) {
						const $el = $('#' + key);
						if (key == 'ft') {
							// update preview image if server returns image URL field
							$('#ft').attr('src', val);
						} else if ($el.length) {
							// set value for inputs, selects, textareas and trigger change if needed
							$el.val(val).trigger('change');
						} else {
							console.log('Element dengan id ' + key + ' tidak ditemukan');
						}
					});
				}
			})
		})
	})
</script>