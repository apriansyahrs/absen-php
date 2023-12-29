<?php
require "../config.php";

$result = mysqli_query($conn, "SELECT g.nama, Count(*) as total, g.id_guru FROM tb_kegiatan_guru
kg JOIN tb_guru g ON kg.id_guru = g.id_guru WHERE
kg.tanggal_kegiatan LIKE '2021-11%' GROUP BY g.nama, g.id_guru");

foreach ($result as $data) {
      $q = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru kg JOIN tb_guru g ON kg.id_guru = g.id_guru WHERE
      kg.tanggal_kegiatan LIKE '" . date("Y-m") . "%' && kg.id_guru = " . $data['id_guru'] . "");
      print_r($data);
}