<?php
require "../config.php";
$id_karyawan = $_GET['id_karyawan'];
$tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE tk . id_karyawan = '$id_karyawan'"); ?>


<table class="table text-uppercase">
   <tr>
      <td>nip</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['nip'] ?></td>
   </tr>
   <tr>
      <td>nama</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['nama'] ?></td>
   </tr>
   <tr>
      <td>lahir</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['tempat_lahir'] . ', ' . $tb_karyawan['tanggal_lahir'] ?></td>
   </tr>
   <tr>
      <td>alamat</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['alamat'] ?></td>
   </tr>
   <tr>
      <td>jabatan</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['jabatan'] ?></td>
   </tr>
   <tr>
      <td>password</td>
      <td><span class="mr-3">:</span><?= $tb_karyawan['password'] ?></td>
   </tr>
   <tr>
      <td>profil</td>
      <td><span class="mr-3">:</span>
         <img src="<?= base_url() ?>/img/karyawan/<?= $tb_karyawan['profil'] ?>" alt="<?= $tb_karyawan['profil'] ?>" class="img-fluid" width="75" height="75">
      </td>
   </tr>
</table>