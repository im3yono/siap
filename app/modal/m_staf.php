<?php
require_once "../../config/server.php";


$id_staf = $_POST['id'];

$stmt = $pdo_conn->prepare("SELECT * FROM tb_dstaf WHERE id_staf=:id_staf");
$stmt->bindParam(":id_staf", $id_staf);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$gelar  = $row['glar'] != "" ? ", " . $row['glar'] : '';

$almt   = json_decode($row['almt'], true);
$jl     = $almt['almt'] != "" ? $almt['almt'] : '';
$rt     = $almt['rt'] != "" ? $almt['rt'] : '0';
$rw     = $almt['rw'] != "" ? $almt['rw'] : '0';
$dusun   = $almt['dusun'] != "" ? ", Dusun " . $almt['dusun'] : '';
$kel     = $almt['kel'] != "" ? $almt['kel'] : '';
$kec     = $almt['kec'] != "" ? $almt['kec'] : '';
$kdpos  = $almt['kdpos'] != "" ? ", Kode Pos " . $almt['kdpos'] : '';
$almt    = $jl . " RT " . $rt . "/" . $rw .  $dusun . ", Kel. " . $kel . ", Kec. " . $kec .  $kdpos;

$kontak    = json_decode($row['kontak'], true);

// $ayah		= json_decode($row['ayah'], true);
// $ibu		= json_decode($row['ibu'], true);
// $wali		= json_decode($row['wali'], true);
// $sdr		= json_decode($row['saudr'], true);


// $tb_bb_lk = json_decode($row['bb_tb_lk'], true);
// $bb = $tb_bb_lk['bb'] != "" ? $tb_bb_lk['bb'] . " Kg" : '';
// $tb = $tb_bb_lk['tb'] != "" ? $tb_bb_lk['tb'] . " Cm" : '';


function barisData($label, $data, $label2 = '', $data2 = '', $class = '')
{
	$cls = '-auto';
	if ($data2 != '' && $label2 != '') {
		$label2 = '<div class="col-3 text-start">
								<div class="row justify-content-between">
									<div class="col">' . $label2 . '</div>
									<div class="col-auto px-0">:</div>
								</div>
							</div>';
		$data2 = '<div class="col text-start"> ' . $data2 . '</div>';
		$cls = '-3';
	} else {
		$label2 = '';
		$data2 = '';
		$cls = '';
	}
	return '<div class="row' . $class . '">
						<div class="col-2 text-start text-nowrap">
							<div class="row justify-content-between">
								<div class="col">' . $label . '</div>
								<div class="col-auto px-0">:</div>
							</div>
						</div>
						<div class="col' . $cls . ' text-start" > ' . $data . '</div>
						' . $label2 . '
						' . $data2 . '
					</div>';
}
?>
<div class="row justify-content-around">
	<div class="col-lg-2 col-12 mx-2 p-2">
		<img src="<?= ft($row['kd_staf'], "staf", '../../'); ?>" alt="<?= $row['kd_staf'] ?> " class="img-thumbnail shadow" style="width: 150px; height: 200px; object-fit: cover;">'
	</div>
	<div class="col-lg-9 col-12">
		<?= barisData('ID Staf', $row['kd_staf']); ?>
		<?= barisData('Nama Lengkap', f_nama($row['nm_staf']) . $gelar, '', '', ' fw-bold'); ?>
		<?= barisData("NIP", $row['nip'], "NUPTK", $row['nuptk'], ' fst-italic'); ?>
		<?= barisData('Jenis Kelamin', $row['jk'] == 'L' ? "Laki-Laki" : "Perempuan", 'Tempat, Tanggal Lahir', f_nama($row['tmp_l']) . ", " . tgl($row['tgl_l'])); ?>
		<?= barisData("Agama", $row['agm'], "Pendidikan", $row['ppdk']); ?>
		<?= barisData('Status Pegawai', $row['stt_pgw'], "Jabatan/Tugas", $row['jptk']); ?>
		<?= barisData('Alamat', $almt); ?>
	</div>
</div>