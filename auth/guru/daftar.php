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
   <title>Daftar Akun Guru <?= $tb_setelan['nama'] ?></title>
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
                  <span>Absensi</span> Daftar
               </div>
               <p class="text-center f-size-16px">Mendaftar akun guru di <?= $tb_setelan['nama'] ?></p>
               <form id="formDaftarGuru">
                  <div class="form-group">
                     <input type="text" name="nip" id="nip" class="form-control form-control2" placeholder="NIP kamu" required>
                  </div>
                  <div class="form-group">
                     <input type="text" name="nama" id="nama" class="form-control form-control2" placeholder="Nama lengkap" required>
                  </div>
                  <div class="form-group">
                     <input type="password" name="password1" id="password1" class="form-control form-control2" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                     <input type="password" name="password2" id="password2" class="form-control form-control2" placeholder="Konfirmasi password" required>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light" id="btn-daftar">
                        Daftar
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
      $('#formDaftarGuru').submit(function(e) {
         e.preventDefault();
         if ($('#password1').val() !== $('#password2').val()) {
            pesan('Konfirmasi password tidak sama', 5000);
            return false;
         }
         $('#btn-daftar').attr('disabled', 'disabled');
         $('#btn-daftar').html('<div class="spinner-border text-white" role="status"></div>');
         $.ajax({
            type: 'post',
            url: 'aksi-auth?daftar',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  window.location.href = '../../guru/?menu=beranda&welcome=true';
               } else if (data == 'tidak tersedia') {
                  pesan('NIP kamu tidak tersedia', 3000);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
               $('#btn-daftar').removeAttr('disabled', 'disabled');
               $('#btn-daftar').html('Daftar');
            }
         });
      });
   </script>
</body>

</html>