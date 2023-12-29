<?php require "../../config.php";
if (isset($_COOKIE['absensi_admin'])) {
   $absensi_admin = $_COOKIE['absensi_admin'];
   $result = mysqli_query($conn, "SELECT id_admin,password FROM tb_admin WHERE password = '$absensi_admin'");
   if (mysqli_num_rows($result) == 1) {
      $tb_admin = mysqli_fetch_assoc($result);
      $_SESSION['admin'] = $tb_admin['id_admin'];
   }
}

if (isset($_SESSION['admin'])) {
   header('location: ../../admin/?menu=beranda');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Login Administrator <?= $tb_setelan['nama'] ?></title>
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
   <h1 class="text-center text-white my-5">
      Administrator
   </h1>
   <form id="formLoginAdmin">
      <div class="modal fade animated bounceIn" id="modalLogin" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modalLoginLabel" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header bg-linear-primary text-white">
                  <h5 class="modal-title">Administrator login</h5>
               </div>
               <div class="modal-body overflow-x-hidden">
                  <div class="form-group">
                     <input type="text" name="username" id="username" class="form-control form-control2" placeholder="Username" required>
                  </div>
                  <div class="form-group mb-0">
                     <input type="password" name="password" id="password" class="form-control form-control2" placeholder="Password" required>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light" id="btn-login">
                     Login
                  </button>
               </div>
            </div>
         </div>
      </div>
   </form>
   <div class="pesan transition-all-300ms-ease"></div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $(function() {
         $('#modalLogin').modal('show');
      });
      $('#formLoginAdmin').submit(function(e) {
         $('#btn-login').attr('disabled', 'disabled');
         $('#btn-login').html('<div class="spinner-border text-white" role="status"></div>');
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-auth',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  window.location.href = '../../admin/?menu=beranda';
               } else {
                  pesan('Username atau Password salah', 3000);
               }
               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Login');
            }
         });
      });
   </script>
</body>

</html>