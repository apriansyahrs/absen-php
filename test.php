<?php
require 'config.php';

$jadwal = $tb_kelas['masuk_akhir'];;
$jam_sekarang = date('H:i:s');
$sekarang_jam = date('H', strtotime($jam_sekarang));
$akhir_jam = date('H', strtotime($jadwal));
$terlambat_jam = $sekarang_jam - $akhir_jam;

$sekarang_menit = date('i', strtotime($jam_sekarang));
$akhir_menit = date('i', strtotime($jadwal));

if ($sekarang_menit < $akhir_menit) {
  $terlambat_jam = $terlambat_jam - 1;
  $terlambat_menit = 60 - $akhir_menit + $sekarang_menit;
} else {
  $terlambat_menit = $sekarang_menit - $akhir_menit;
}

$sekarang_detik = date('s', strtotime($jam_sekarang));
$akhir_detik = date('s', strtotime($jadwal));

$terlambat_detik = $sekarang_detik - $akhir_detik;

$jam_ke_detik = $terlambat_jam * 3600;
$menit_ke_detik = $terlambat_menit * 60;
$terlambat = $jam_ke_detik + $menit_ke_detik + $terlambat_detik;

echo $terlambat;