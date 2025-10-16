<?php
require_once '../../config/server.php'; // sesuaikan jalur koneksi
$tkt = $_POST['tkt'] ?? '';
$prd = $_POST['prd'];

if ($prd == 'ch_tkt'):
  if ($tkt != '') {
    $sql = "SELECT kls FROM tb_kls WHERE tkt = ? GROUP BY kls ORDER BY kls ASC";
    $stmt = db_Proses($pdo_conn, $sql, [$tkt]);
  } else {
    // Jika tidak dipilih, tampilkan semua
    $sql = "SELECT kls FROM tb_dsis GROUP BY kls ORDER BY kls ASC";
    $stmt = db_Proses($pdo_conn, $sql);
  }

  echo '<option value="" selected>-- Pilih --</option>';
  while ($r = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<option value='{$r['kls']}'>{$r['kls']}</option>";
  }
endif;
