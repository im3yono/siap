<?php
require_once "../../config/server.php";


$nipd = $_POST['id'];

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


$tb_bb_lk = json_decode($row['bb_tb_lk'], true);
$bb = $tb_bb_lk['bb'] != "" ? $tb_bb_lk['bb'] . " Kg" : '';
$tb = $tb_bb_lk['tb'] != "" ? $tb_bb_lk['tb'] . " Cm" : '';


function barisData($label, $data, $class = '')
{
	$view1 = '
	<div class="col-2">' . $label . '</div>
	<div class="col">: ' . $data . '</div>';
	return '<div class="row ' . $class . '">' . $view1 . '</div>';
}
?>
<div class="row">
	<div class="col-auto mx-4 p-2">
		<img src="<?= ft($row['nipd'],'siswa','../../'); ?>" alt="<?= $row['nipd'] ?> " class="img-thumbnail shadow" style="width: 150px; height: 200px; object-fit: cover;">'
	</div>
	<div class="col">
		<div class="row fw-bold text-bg-dark">
			<div class="col-2">NIPD</div>
			<div class="col-auto">: <?= $row['nipd']; ?></div>
			<div class="col-2">NISN</div>
			<div class="col">: <?= $row['nisn']; ?></div>
		</div>
		<?php
		echo barisData('Nama', f_nama($row['nm']), 'fw-bold h5 py-2')
			. barisData('Tempat, Tanggal Lahir', f_nama($row['tmp_lahir']) . ", " . tgl($row['tgl_lahir']))
			. barisData('Jenis Kelamin', $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan")
			. barisData('Agama', $row['agm'])
			. barisData('Alamat', $almt)
			. barisData('Transportasi', $row['trasport'])
			. barisData('No. Telpon', $tlp['tlp'] ?? '')
			. barisData('No. Handphone', $tlp['hp'] ?? '')
			. barisData('Email', $row['email'])
			. barisData('Kelas', $row['kls'])
			. barisData('No. Akta', $row['no_akta'])
			. barisData('Disabilitas', $row['disabel'])
			. barisData('Status Masuk', $row['masuk'])
			. barisData('Sekolah Asal', $row['sklh_asl'])
			. barisData('Anak	 Ke', $sdr['ke'] . " dari " . $sdr['sdr'] . " bersaudara")
			. barisData('Berat', $bb)
			. barisData('Tinggi', $tb)
			. barisData(('Lingkar Kepala'), $tb_bb_lk['lk'] . ' Cm')
			. barisData('Jarak Rumah', $row['jrk_rmh'] . ' Km')
			. '<hr>'
			. '<div class="bg-info p-2 h6" style="border-radius:5px;">Data Orang Tua/Wali</div>'
			. '<h6 class="border-bottom">Ayah</h6>'
			. barisData('Nama ', $ayah['nm'], 'fw-bold')
			. barisData('NIK ', $ayah['nik'])
			. barisData('Tahun Lahir ', $ayah['thn_l'])
			. barisData('Alamat ', $ayah['almt'])
			. barisData('Pendidikan ', $ayah['pddk'])
			. barisData('Pekerjaan ', $ayah['kerja'])
			. barisData('Penghasilan ', $ayah['upah'])
			. '<h6 class="mt-3 border-bottom">Ibu</h6>'
			. barisData('Nama ', $ibu['nm'], 'fw-bold')
			. barisData('NIK ', $ibu['nik'])
			. barisData('Tahun Lahir ', $ibu['thn_l'])
			. barisData('Alamat ', $ibu['almt'])
			. barisData('Pendidikan ', $ibu['pddk'])
			. barisData('Pekerjaan ', $ibu['kerja'])
			. barisData('Penghasilan ', $ibu['upah']);
		if ($wali['nm'] != "") {
			echo '<h6 class="mt-3 border-bottom">Wali</h6>'
				. barisData('Nama ', $wali['nm'], 'fw-bold')
				. barisData('NIK ', $wali['nik'])
				. barisData('Tahun Lahir ', $wali['thn_l'])
				. barisData('Alamat ', $wali['almt'])
				. barisData('Pendidikan ', $wali['pddk'])
				. barisData('Pekerjaan ', $wali['kerja'])
				. barisData('Penghasilan ', $wali['upah'])

				// . barisData('Status', $row['sts'] == '1' ? "Aktif" : "Tidak Aktif");
			;
		}
		?>
	</div>
</div>