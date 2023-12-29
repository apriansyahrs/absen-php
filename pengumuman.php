<?php
require "config.php";
if (!isset($_SESSION['siswa'])) {
   header('location: auth/siswa');
   return false;
}
$id_pengumuman = $_GET['id_pengumuman'];
$token_kelas = $_GET['token_kelas'];
$tb_pengumuman = query("SELECT * FROM tb_pengumuman WHERE id_pengumuman = '$id_pengumuman' && token_kelas = '$token_kelas'");
if (num_rows("SELECT * FROM tb_pengumuman WHERE id_pengumuman = '$id_pengumuman' && token_kelas = '$token_kelas'") == 0) {
   echo "<script>history.back(1)</script>";
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Pengumuman <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   <style>
      html,
      body {
         background: #fff;
      }
   </style>
</head>

<body>
   <nav class="topbar">
      <div class="row">
         <div class="container">
            <div class="row m-0">
               <div class="col col-2">
                  <div class="menu">
                     <i class="la la-arrow-left waves-effect waves-light" id="kembali"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>

   <div class="card-body">
      <div class="p-5 text-center" style="background: #E0E4F9; border-left: 4px solid #46A4EC; margin-top: 65px;">
         <div style="color: #3B567F;">
            <p>
               <i class="la la-bullhorn la-3x infinite animated headShake"></i>
            </p>
            <p>
               <?= hari(date('D', $tb_pengumuman['ditambahkan'])) . ' ,' . date('d', $tb_pengumuman['ditambahkan']) . ' ' . bulan(date('m', $tb_pengumuman['ditambahkan'])) . ' ' . date('Y', $tb_pengumuman['ditambahkan']) . ' ' . date('H:i', $tb_pengumuman['ditambahkan']) ?>
            </p>
         </div>
         <p class="f-size-16px" style="color: #343336;">
            <?= $tb_pengumuman['pengumuman']; ?>
         </p>
      </div>
      <div class="row m-0 d-flex justify-content-center">
         <div class="col-md-6" style="margin: 75px 0;">
            <form id="formTanggapan">
               <input type="hidden" name="id_pengumuman" value="<?= $tb_pengumuman['id_pengumuman'] ?>">
               <div class="input-group mb-3">
                  <input type="text" name="tanggapan" id="tanggapan" class="form-control form-control2" placeholder="Berikan tanggapan (<?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?>)" required>
                  <div class="input-group-append">
                     <button type="submit" class="btn btn-primary btn-user border-0 waves-effect waves-light">
                        <i class="la la-telegram f-size-24px"></i>
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="row d-flex justify-content-center">
         <div class="col-md-8">
            <div id="loadDataTanggapan"></div>
         </div>
      </div>
   </div>
   <div class="scrolltop">
      <i class="la la-angle-up waves-effect waves-light"></i>
   </div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#formTanggapan').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-tanggapan?tanggapan',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               $('#tanggapan').val('');
               loadDataTanggapan();
            }
         });
      });

      loadDataTanggapan();

      function loadDataTanggapan() {
         $('#loadDataTanggapan').load('loadDataTanggapan?id_pengumuman=<?= $tb_pengumuman['id_pengumuman'] ?>');
      }

      $('#kembali').click(function() {
         setTimeout(function() {
            history.back(1);
         }, 300)
      })
   </script>
</body>

</html>