<?php

// function f_singkatNama($nama, $max = 3)
// {
// 	$nm_umum = ['Muhammad', 'Mohammad', 'Muhamad', 'Ahmad', 'Akhmad'];
// 	$nama = ucwords(strtolower($nama)); // ubah menjadi huruf kecil dan kapitalisasi awal kata
// 	$kata = explode(' ', $nama);
// 	$jumlah = count($kata);

// 	if ($jumlah <= $max) {
// 		return $nama; // tidak disingkat
// 	}

// 	$singkat = implode(' ', array_slice($kata, 0, $max)) . ' ';

// 	// ambil inisial dari kata tengah
// 	for ($i = $max; $i < $jumlah; $i++) {
// 		$singkat .= strtoupper(substr($kata[$i], 0, 1)) . '. ';
// 	}

// 	return $singkat;
// }

function f_singkatNama($nama, $maxChar = 25)
{
	$nm_umum = [
		'Muhammad' => 'M.',
		'Mohammad' => 'M.',
		'Muhamad'  => 'M.',
		'Ahmad'    => 'A.',
		'Akhmad'   => 'A.',
		'Gusti'    => 'Gst',
		'Gatot'    => 'Gt',
	];

	$nama = ucwords(strtolower(trim($nama)));
	$kata = preg_split('/\s+/', $nama);

	// Tahap 1: singkatkan kata yang wajib disingkat
	$hasil = [];
	foreach ($kata as $k) {
		if (isset($nm_umum[$k])) {
			$hasil[] = $nm_umum[$k];
		} else {
			$hasil[] = $k;
		}
	}

	// Jika setelah singkatan wajib sudah cukup, langsung kembalikan
	if (strlen(implode(' ', $hasil)) <= $maxChar) {
		return implode(' ', $hasil);
	}

	// Tahap 2: singkatkan kata dari belakang (selain yang sudah disingkat)
	for ($i = count($hasil) - 1; $i >= 0; $i--) {

		// Skip jika sudah berupa inisial
		if (substr($hasil[$i], -1) == '.') {
			continue;
		}

		$hasil[$i] = strtoupper(substr($hasil[$i], 0, 1)) . '.';

		if (strlen(implode(' ', $hasil)) <= $maxChar) {
			break;
		}
	}

	return implode(' ', $hasil);
}

function f_nama($nama)
{
	return ucwords(strtolower($nama)); // ubah menjadi huruf kecil dan kapitalisasi awal kata
}

function f_kapital($text)
{
	return strtoupper($text);
}

// token Acak
function GeraHash($qtd)
{
	//Under the string $Caracteres you write all the characters you want to be used to randomly generate the code. 
	$Caracteres = 'ABCDEFGHIJKLMNPQRSTUVWXYZ12345789';
	//$Caracteres = 'abcdefghijklmnpqrstuvwxyz'; 
	// $Caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	//$Caracteres = '123456789'; 
	$QuantidadeCaracteres = strlen($Caracteres);
	$QuantidadeCaracteres--;
	$Hash = NULL;
	for ($x = 1; $x <= $qtd; $x++) {
		$Posicao = rand(0, $QuantidadeCaracteres);
		$Hash .= substr($Caracteres, $Posicao, 1);
	}
	return $Hash;
}

function fileUser($file, $user, $pass)
{
	file_put_contents($file, '');
	$data = "<?php\n";
	$data .= "\$usdb = \"" . addslashes($user) . "\";\n";
	$data .= "\$psdb = \"" . addslashes($pass) . "\";\n";
	$data .= "?>";

	if (file_put_contents($file, $data, FILE_APPEND)) {
		return '<meta http-equiv="refresh" content="3">';
	} else {
		$err = "<p style='color: red;'>Gagal menyimpan data!</p>";
	}
	return $err;
}


function f_nmGelar($nm = '', $glr = '')
{
	$glr = json_decode($glr, true);
	$glrd	= $glr['gld'] ?? '';
	$glrb	= $glr['glb'] ?? '';
	if ($glrb != '') {
		$glrb = ', ' . $glrb;
	}
	if ($glrd != '') {
		$glrd = $glrd . '. ';
	}

	return $glrd . ($nm) . $glrb;
}

function f_almtL($almt)
{
	$almt 	= json_decode($almt, true);
	$jl 		= $almt['almt'] != "" ? $almt['almt'] : '';
	$rt 		= " RT " . ($almt['rt'] != "" ? $almt['rt'] : '0');
	$rw 		= "/" . ($almt['rw'] != "" ? $almt['rw'] : '0');
	$dusun 	= $almt['dusun'] != "" ? ", Dusun " . $almt['dusun'] : '';
	$kel 		=  $almt['kel'] != "" ? $almt['kel'] : '';
	$kec 		=  $almt['kec'] != "" ? $almt['kec'] : '';
	$kdpos 	= $almt['kdpos'] != "" ? ", Kode Pos " . $almt['kdpos'] : '';

	// remove any "Kel. " prefix (case-insensitive) and trim result
	$kel = ", Kel. " . trim(preg_replace('/\bkel\.\s*/i', '', $kel));
	$kec = ", Kec. " . trim(preg_replace('/\bkec\.\s*/i', '', $kec));

	$almt = $jl .  $rt .  $rw .  $dusun .  $kel .  $kec .  $kdpos;

	return $almt;
}

function f_nik($nik)
{
	// if ($label == 'NIK' || $label == 'NIKK') {
	// $data = substr($data, 0,3) . '****' . substr($data, -3);
	return substr($nik, 0, 4) . '****';
	// $data = $data . '<button class="btn btn-sm btn-tool" onclick="togglePassword()"><i class="bi bi-eye"></i></button>';

	// }
	// return preg_replace('/(\d{6})(\d{8})(\d{4})/', '$1 **** **** $3', $nik);
}
