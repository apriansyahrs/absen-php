<?php
require "../config.php";
if (isset($_GET['edit_data'])) {
   $id_karyawan = $_POST['id_karyawan'];
   $nama = htmlspecialchars($_POST['nama']);
   $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
   $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
   $jk = htmlspecialchars($_POST['jk']);
   $alamat = htmlspecialchars($_POST['alamat']);

   $query = mysqli_query($conn, "UPDATE tb_karyawan SET nama = '$nama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', jk = '$jk', alamat = '$alamat' WHERE id_karyawan = '$id_karyawan'");

   if ($query) {
      echo 'berhasil';
   } else {
      echo 'Terdapat kesalahan pada sistem';
   }
}
if (isset($_GET['edit_profil'])) {
   $id_karyawan = $_POST['id_karyawan'];
   $profil = $_FILES['profil']['name'];
   $ekstensi = strtolower($profil);
   $ekstensi = explode('.', $ekstensi);
   $ekstensi = end($ekstensi);
   $namafiks = substr(hash('sha256', time()), 0, 10) . '_' . time();
   $tujuan_upload = '../img/karyawan/' . $namafiks . '.' . $ekstensi;
   $profil = $namafiks . '.' . $ekstensi;
   $file_tmp = $_FILES['profil']['tmp_name'];

   $tb_karyawan = query("SELECT id_karyawan,profil FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'");

   if ($tb_karyawan['profil'] !== 'user.png') {
      unlink('../img/karyawan/' . $tb_karyawan['profil']);
   }

   $query = mysqli_query($conn, "UPDATE tb_karyawan SET profil = '$profil' WHERE id_karyawan = '$id_karyawan'");
   if (move_uploaded_file($file_tmp, $tujuan_upload)) {
      if ($query) {
         echo 'berhasil';
      }
   }
}
if (isset($_GET['edit_password'])) {
   $id_karyawan = $_POST['id_karyawan'];
   $password_lama = htmlspecialchars($_POST['password_lama']);

   $tb_karyawan = query("SELECT id_karyawan,password FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'");

   if ($tb_karyawan['password'] !== $password_lama) {
      echo 'password lama';
      return false;
   }

   $password = htmlspecialchars($_POST['password2']);

   $query = mysqli_query($conn, "UPDATE tb_karyawan SET password = '$password' WHERE id_karyawan = '$id_karyawan'");
   if ($query) {
      echo 'berhasil';
   }
}
