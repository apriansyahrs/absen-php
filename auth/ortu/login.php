<?php require "../../config.php";
if (isset($_COOKIE['id_ortu'], $_COOKIE['absensi_ortu'])) {
   $id = $_COOKIE['id_ortu'];
   $absensi_ortu = $_COOKIE['absensi_ortu'];
   $result = mysqli_query($conn, "SELECT id_siswa FROM tb_siswa WHERE id_siswa = '$id'");
   $tb_siswa = mysqli_fetch_assoc($result);
   if (hash('sha256', $tb_siswa['id_siswa']) == $absensi_ortu) {
      $_SESSION['ortu'] = $tb_siswa['id_siswa'];
   }
}

if (isset($_SESSION['ortu'])) {
   header('location: ../../monitoring');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login Guru <?= $tb_setelan['nama'] ?></title>
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
               <form id="formLoginOrtu">
                  <div class="form-group">
                     <input type="text" name="username_ortu" id="username_ortu" class="form-control form-control2" placeholder="Username orang tua">
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
      $('#formLoginOrtu').submit(function(e) {
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
                  window.location.href = '../../monitoring';
               } else if (data == 'salah') {
                  pesan('Username kamu salah', 3000);
               }
               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Login');
            }
         });
      });
   </script>
</body>

</html>