<?php
require "../../config.php";
if (isset($_COOKIE['id'], $_COOKIE['absensi_siswa'])) {
   $id = $_COOKIE['id'];
   $absensi_siswa = $_COOKIE['absensi_siswa'];
   $result = mysqli_query($conn, "SELECT id_siswa FROM tb_siswa WHERE id_siswa = '$id'");
   $tb_siswa = mysqli_fetch_assoc($result);
   if (hash('sha256', $tb_siswa['id_siswa']) == $absensi_siswa) {
      $_SESSION['siswa'] = $tb_siswa['id_siswa'];
   }
}

if (isset($_SESSION['siswa'])) {
   header('location: ../../absen');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login Siswa <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   <style>
      html,
      body {
         background-image: linear-gradient(to right, #4086EF, #26B0E8);
         background-size: cover;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="row vh-100 d-flex justify-content-center align-items-center">
         <div class="col-md-7 col-lg-5">
            <div class="auth px-4 pt-4 pb-5">
               <div class="logo">
                  <span>Absensi</span> Login
               </div>
               <p class="text-center f-size-16px">Silakan login ke dalam akun kamu</p>
               <?php if (isset($_SESSION['daftar_berhasil'])) { ?>
                  <div class="alert alert-success">
                     <?= $_SESSION['daftar_berhasil'] ?>
                  </div>
               <?php unset($_SESSION['daftar_berhasil']);
               }  ?>
               <form id="formLoginSiswa">
                  <div class="form-group">
                     <input type="text" name="nis" id="nis" class="form-control form-control2" placeholder="NIS kamu">
                  </div>
                  <div class="form-group">
                     <input type="password" name="password" id="password" class="form-control form-control2" placeholder="Password">
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-6 pr-2">
                           <a href="daftar" class="btn btn-outline-linear-primary btn-block waves-effect waves-dark daftar">
                              Daftar
                           </a>
                        </div>
                        <div class="col-6 pl-2">
                           <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light masuk" id="btn-login">
                              Login
                           </button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- <div class="pesan-cookie shadow-sm transition-all-300ms-ease">
      <div class="row">
         <div class="col-9 my-auto">
            Privasi & Cookie: Situs ini menggunakan cookie. <br>
            Untuk mengetahui lebih lanjut termasuk cara mengontrol cookie, lihat di sini: <a href="../kebijakan-cookie">Kebijakan Cookie</a>
         </div>
         <div class="col-3 my-auto">
            <div class="close">
               <button type="button" class="btn waves-effect waves-" id="tutup-dan-terima-cookie">Tutup dan Terima</button>
            </div>
         </div>
      </div>
   </div> -->
   <div class="modal fade animated bounceIn" id="modalIkutiTelegram" tabindex="-1" role="dialog" aria-labelledby="modalIkutiTelegramLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-body text-center overflow-x-hidden" style="color: #1e3056">
               <div class="row d-flex justify-content-center">
                  <div class="col-6">
                     <img src="<?= base_url() ?>/assets/img/undraw_forgot_password_gi2d.svg" alt="gambar" class="img-fluid">
                  </div>
               </div>
               <p class="mt-4">Kamu harus bergabung ke telegram grup dari <?= $tb_setelan['nama'] ?> ini. Jika ingin mendapatkan notifikasi ditelegram kamu!</p>
            </div>
            <div class="modal-footer">
               <a href="" target="_blank" class="btn btn-linear-primary btn-lg btn-block waves-effect waves-light" id="btn-telegram">Login</a>
            </div>
         </div>
      </div>
   </div>
   <div id="loader"></div>
   <div class="pesan transition-all-300ms-ease"></div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#btn-telegram').click(function() {
         var nis = $(this).attr('data-nis');
         var password = $(this).attr('data-password');
         var url_telegram_group = $(this).attr('data-url_telegram_group');
         $.ajax({
            type: 'post',
            url: 'aksi-auth?login_get',
            data: {
               nis: nis,
               password: password
            },
            success: function() {
               window.location.href = url_telegram_group;
            }
         })
      });

      $('#formLoginSiswa').submit(function(e) {
         $('#btn-login').attr('disabled', 'disabled');
         $('#btn-login').html('<div class="spinner-border text-white" role="status"></div>');
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-auth?login',
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            success: function(data) {
               if (data.berhasil == true) {
                  window.location.href = '../../absen';
               } else if (data.salah == true) {
                  pesan('NIS atau password salah', 3000);
               } else if (data.modal_telegram == true) {
                  $('#modalIkutiTelegram').modal('show');
                  $('#btn-telegram').attr('data-nis', data.nis);
                  $('#btn-telegram').attr('data-password', data.password);
                  $('#btn-telegram').attr('data-url_telegram_group', data.url_telegram_group);
               }

               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Login');
            }
         });
      });
   </script>
</body>

</html>