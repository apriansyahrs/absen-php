<?php
require "../../config.php";
if (isset($_POST['username'], $_POST['password'])) {
   $username = htmlspecialchars($_POST['username']);
   $password = htmlspecialchars($_POST['password']);

   $jml_admin = num_rows("SELECT username FROM tb_admin WHERE username = '$username'");
   if ($jml_admin >= 1) {
      $tb_admin = query("SELECT id_admin,password FROM tb_admin");
      if (password_verify($password, $tb_admin['password'])) {
         unset($_SESSION['siswa']);
         unset($_SESSION['guru']);
         $_SESSION['admin'] = $tb_admin['id_admin'];
         setcookie('absensi_admin', $tb_admin['password'], time() + 31536000, '/');
         echo 'berhasil';
      }
   }
}
