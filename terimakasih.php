<?php
require "config.php";
if (!isset($_SESSION['siswa'])) {
   header('location: auth/siswa');
   return false;
}
if (isset($_SESSION['absen'])) { ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta http-equiv="X-UA-Compatible" content="ie=edge">
      <title>Terimakasih, <?= $tb_siswa['nama_depan'] ?>!</title>
      <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
      <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   </head>

   <body>

      <div class="container">
         <div class="my-5">
            <div class="terimakasih">
               <div class="terimakasih-header">
                  Terimakasih, <?= $tb_siswa['nama_depan'] ?>!
               </div>
               <div class="terimakasih-body">
                  <p><?php
                        if ($_SESSION['absen'] == 'masuk') {
                           echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya.';
                        } elseif ($_SESSION['absen'] == 'pulang') {
                           echo 'Kamu sudah melakukan absen pulang hari ini.';
                        } ?></p>
                  <a href="<?= base_url() ?>/absen" class="btn btn-linear-primary my-1 waves-effect waves-light">
                     Beranda
                  </a>
               </div>
            </div>
         </div>
      </div>

      <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
      <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   </body>

   </html>
<?php
   unset($_SESSION['absen']);
} else {
   header('location: auth/siswa');
} ?>