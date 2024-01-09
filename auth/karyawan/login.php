<?php require "../../config.php";
if (isset($_COOKIE['absensi_karyawan'])) {
   $absensi_karyawan = $_COOKIE['absensi_karyawan'];
   $result = mysqli_query($conn, "SELECT id_karyawan,token_karyawan FROM tb_karyawan WHERE token_karyawan = '$absensi_karyawan'");
   if (mysqli_num_rows($result) == 1) {
      $tb_karyawan = mysqli_fetch_assoc($result);
      $_SESSION['karyawan'] = $tb_karyawan['id_karyawan'];
   }
}

if (isset($_SESSION['karyawan'])) {
   header('location: ../../karyawan');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login Karyawan <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   <style>
      html,
      body {
         background-image: linear-gradient(to right, #08C3A5, #08ACC1);
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
               <form id="formLoginKaryawan">
                  <div class="form-group">
                     <input type="text" name="nip" id="nip" class="form-control form-control2" placeholder="Username">
                  </div>
                  <div class="form-group">
                     <input type="password" name="password" id="password" class="form-control form-control2" placeholder="Password">
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-linear-success btn-block waves-effect waves-light" id="btn-login">
                        Login
                     </button>
                  </div>
               </form>
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
      $('#formLoginKaryawan').submit(function(e) {
         $('#btn-login').attr('disabled', 'disabled');
         $('#btn-login').html('<div class="spinner-border text-white" role="status"></div>');
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-auth?login',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  window.location.href = '../../karyawan';
               } else {
                  pesan('NIP atau Password salah', 3000);
               }
               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Login');
            }
         });
      });
   </script>
</body>

</html>