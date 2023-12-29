<?php
require "../../config.php";
if (isset($_POST['nip'], $_POST['password'])) {
   $nip = htmlspecialchars($_POST['nip']);
   $password = htmlspecialchars($_POST['password']);

   $jml_karyawan = num_rows("SELECT nip FROM tb_karyawan WHERE nip = '$nip'");
   if ($jml_karyawan >= 1) {
      $tb_karyawan = query("SELECT * FROM tb_karyawan WHERE nip = '$nip'");
      if ($password == $tb_karyawan['password']) {
         unset($_SESSION['siswa']);
         unset($_SESSION['guru']);
         $_SESSION['karyawan'] = $tb_karyawan['id_karyawan'];
         setcookie('absensi_karyawan', $tb_karyawan['token_karyawan'], time() + 31536000, '/');
         echo 'berhasil';
      }
   }
}
