<?php
require "config.php";
if (isset($_GET['tanggapan'])) {
   $id_pengumuman = $_POST['id_pengumuman'];
   $id_siswa = $_SESSION['siswa'];
   $tanggapan = htmlspecialchars($_POST['tanggapan']);
   $pada = time();

   $query = mysqli_query($conn, "INSERT INTO tb_tanggapan (id_pengumuman,id_siswa,tanggapan,pada) VALUES ('$id_pengumuman','$id_siswa','$tanggapan','$pada')");
   if ($query) {
      echo 'berhasil';
   }
}
