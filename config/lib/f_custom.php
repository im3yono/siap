<?php

function ft($ft, $fldr = "siswa")
{
  $format = [
    ".jpg",
    ".jpeg",
    ".png",
    ".JPG",
    ".JPEG",
    ".PNG"
  ];
  $basePath = "../app/images/" . $fldr . "/";
  foreach ($format as $ext) {
    $filePath = $basePath . $ft . $ext;
    if (file_exists($filePath)) {
      return "app/images/" . $fldr . "/" . $ft . $ext;
    }
  }
  return "assets/img/account.png";
}
