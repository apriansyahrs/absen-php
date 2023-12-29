<?php
require "config.php";
$filter_tgl = htmlspecialchars($_POST['filter_tgl']);
$filter_bln_thn = htmlspecialchars($_POST['filter_bln_thn']);
$token_kelas = htmlspecialchars($_POST['token_kelas']);
$id_siswa = htmlspecialchars($_POST['id_siswa']);

$result_masuk = mysqli_query($conn, "SELECT * FROM a_masuk am JOIN tb_siswa s ON am . id_siswa = s . id_siswa JOIN a_masukket aket ON am . `$filter_tgl` = aket . token_masuk WHERE am . id_siswa = '$id_siswa' && am . m_bulan_tahun = '$filter_bln_thn' && am . token_kelas = '$token_kelas'");

while ($post = mysqli_fetch_assoc($result_masuk)) {
   $data['m_foto_masuk'] = $post['m_foto'];
   $data['nis_masuk'] = $post['nis'];
   $data['nama_siswa_masuk'] = $post['nama_depan'] . ' ' . $post['nama_belakang'];
   $data['m_alasan_masuk'] = $post['m_alasan'];
   $data['m_pada_masuk'] = hari(date('D', $post['m_pada'])) . ', ' . date('d', $post['m_pada']) . ' ' . bulan(date('m', $post['m_pada'])) . ' ' . date('Y', $post['m_pada']) . ' ' . date('H:i', $post['m_pada']);
   $data['latitude_masuk'] = $post['latitude'];
   $data['longitude_masuk'] = $post['longitude'];
}

$result_pulang = mysqli_query($conn, "SELECT * FROM a_pulang ap JOIN tb_siswa s ON ap . id_siswa = s . id_siswa JOIN a_pulangket aket ON ap . `$filter_tgl` = aket . token_pulang WHERE ap . id_siswa = '$id_siswa' && ap . p_bulan_tahun = '$filter_bln_thn' && ap . token_kelas = '$token_kelas'");
while ($post = mysqli_fetch_assoc($result_pulang)) {
   $data['nis_pulang'] = $post['nis'];
   $data['nama_siswa_pulang'] = $post['nama_depan'] . ' ' . $post['nama_belakang'];
   $data['p_pada_pulang'] = hari(date('D', $post['p_pada'])) . ', ' . date('d', $post['p_pada']) . ' ' . bulan(date('m', $post['p_pada'])) . ' ' . date('Y', $post['p_pada']) . ' ' . date('H:i', $post['p_pada']);
   $data['latitude_pulang'] = $post['latitude'];
   $data['longitude_pulang'] = $post['longitude'];
}


echo json_encode($data);
