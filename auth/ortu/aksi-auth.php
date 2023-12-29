<?php
require "../../config.php";
if (isset($_GET['login'])) {
   $username_ortu = htmlspecialchars($_POST['username_ortu']);

   $result = mysqli_query($conn, "SELECT id_siswa,username_ortu FROM tb_siswa WHERE username_ortu = '$username_ortu'");
   $tb_siswa = mysqli_fetch_assoc($result);

   if (mysqli_num_rows($result) == 0) {
      echo 'salah';
      return false;
   }

   unset($_SESSION['admin']);
   unset($_SESSION['guru']);
   unset($_SESSION['siswa']);
   $_SESSION['ortu'] = $tb_siswa['id_siswa'];
   setcookie('id_ortu', $tb_siswa['id_siswa'], time() + 31536000, '/');
   setcookie('absensi_ortu', hash('sha256', $tb_siswa['id_siswa']), time() + 31536000, '/');
   echo 'berhasil';
} else {
   echo 'salah';
}
