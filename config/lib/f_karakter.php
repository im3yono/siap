<?php

function f_singkatNama($nama, $max = 3)
{
	$nm_umum = ['Muhammad', 'Mohammad','Muhamad', 'Ahmad', 'Akhmad'];
	$nama = ucwords(strtolower($nama)); // ubah menjadi huruf kecil dan kapitalisasi awal kata
	$kata = explode(' ', $nama);
	$jumlah = count($kata);

	if ($jumlah <= $max) {
		return $nama; // tidak disingkat
	}

	$singkat = implode(' ', array_slice($kata, 0, $max)) . ' ';

	// ambil inisial dari kata tengah
	for ($i = $max; $i < $jumlah; $i++) {
		$singkat .= strtoupper(substr($kata[$i], 0, 1)) . '. ';
	}

	return $singkat;
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
