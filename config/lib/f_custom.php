<?php

function ft($ft, $fldr, $path = "../")
{
	$format = [
		".jpg",
		".jpeg",
		".png",
		".JPG",
		".JPEG",
		".PNG"
	];
	$basePath = $path . "app/images/" . $fldr . "/";
	foreach ($format as $ext) {
		$filePath = $basePath . $ft . $ext;
		if (file_exists($filePath)) {
			return "app/images/" . $fldr . "/" . $ft . $ext;
		}
	}
	return "assets/img/account.png";
}
