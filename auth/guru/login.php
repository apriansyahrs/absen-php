<?php require "../../config.php";
if (isset($_COOKIE['absensi_guru'])) {
   $absensi_guru = $_COOKIE['absensi_guru'];
   $result = mysqli_query($conn, "SELECT id_guru,password FROM tb_guru WHERE password = '$absensi_guru'");
   if (mysqli_num_rows($result) == 1) {
      $tb_guru = mysqli_fetch_assoc($result);
      $_SESSION['guru'] = $tb_guru['id_guru'];
   }
}

if (isset($_SESSION['guru'])) {
   header('location: ../../guru?menu=beranda');
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
         background: #1b1b2f;
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
               <form id="formLoginGuru">
                  <div class="form-group">
                     <input type="text" name="nip" id="nip" class="form-control form-control2" placeholder="Username">
                  </div>
                  <div class="form-group">
                     <input type="password" name="password" id="password" class="form-control form-control2" placeholder="Password">
                  </div>
                  <div class="form-group">
                     <div class="row">
                        <div class="col-6 pr-2">
                           <a href="daftar" class="btn btn-outline-linear-primary btn-block waves-effect waves-dark">
                              Daftar
                           </a>
                        </div>
                        <div class="col-6 pl-2">
                           <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light" id="btn-login">
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
   <div id="loader"></div>
   <div class="pesan transition-all-300ms-ease"></div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#formLoginGuru').submit(function(e) {
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
                  window.location.href = '../../guru?menu=beranda&welcome=true';
               } else if (data == 'salah') {
                  pesan('NIP atau password salah', 3000);
               }
               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Login');
            }
         });
      });
   </script>
</body>

</html>