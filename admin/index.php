<?php require "../config.php";
if (!isset($_SESSION['admin'])) {
   header('location: ../auth/admin');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Administrator <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/overlayscrollbars/css/overlay-scrollbars.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/sweetalert2/sweetalert2.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/calendar/fullcalendar/main.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/calendar/fullcalendar-daygrid/main.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2/css/select2.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2-bootstrap4/select2-bootstrap4.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
</head>

<body>

   <div class="content siswa">
      <nav class="navbar navbar-admin navbar-expand-lg navbar-dark p-md-0 fixed-top">
         <div class="container-fluid">
            <a class="navbar-brand" href="#"><?= $tb_setelan['nama'] ?></a>
            <button class="navbar-toggler outline-0" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
               <ul class="navbar-nav ml-auto">
                  <li class="nav-item waves-effect waves-light" id="click-beranda">
                     <span class="nav-link">Beranda</span>
                  </li>
                  <!--<li class="nav-item waves-effect waves-light" id="click-master-jabatan">-->
                  <!--   <span class="nav-link">Master jabatan</span>-->
                  <!--</li>-->
                  <li class="nav-item waves-effect waves-light" id="click-karyawan">
                     <span class="nav-link">Karyawan</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-guru">
                     <span class="nav-link">Guru</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-kelas">
                     <span class="nav-link">Kelas</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-siswa">
                     <span class="nav-link">Siswa</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-cuti">
                     <span class="nav-link">Cuti</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-libur">
                     <span class="nav-link">Libur</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-monitoring">
                     <span class="nav-link">Monitoring</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-rekap-absen">
                     <span class="nav-link">Laporan</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-setelan">
                     <span class="nav-link">Setelan</span>
                  </li>
                  <li class="nav-item waves-effect waves-light" id="click-beranda">
                     <a href="../logout" class="nav-link">Logout</a>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <div class="container-fluid" style="margin-top: 80px;">
         <div class="my-4" id="content"></div>
      </div>
   </div>
   <div class="copyright">
      <div class="container">
         <img src="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" alt="Logo">
         <p>
            &copy; Copyright 2020 <?= $tb_setelan['nama'] ?>
         </p>
      </div>
   </div>
   <div class="scrolltop">
      <i class="la la-angle-up waves-effect waves-light"></i>
   </div>
   <div class="pesan transition-all-300ms-ease"></div>


   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/overlayscrollbars/js/jquery-overlay-scrollbars.min.js"></script>
   <script src="<?= base_url() ?>/assets/overlayscrollbars/js/overlay-scrollbars.min.js"></script>
   <script src="<?= base_url() ?>/assets/jslocalsearch/JsLocalSearch.js"></script>
   <script src="<?= base_url() ?>/assets/sweetalert2/sweetalert2.min.js"></script>
   <script src="<?= base_url() ?>/assets/calendar/fullcalendar/main.min.js"></script>
   <script src="<?= base_url() ?>/assets/calendar/fullcalendar-daygrid/main.min.js"></script>
   <script src="<?= base_url() ?>/assets/table2excel/jquery.table2excel.js"></script>
   <script src="<?= base_url() ?>/assets/select2/js/select2.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $(function() {
         $('.overlay-scrollbars').overlayScrollbars({
            className: "os-theme-dark",
            scrollbars: {
               autoHide: 'l',
               autoHideDelay: 0
            }
         });
      });

      $('.nav-item').click(function() {
         $('.nav-item').removeClass('active');
         $(this).addClass('active');
      });

      function clickMenu(id, file) {
         $('#' + id).click(function() {
            content_loader();
            $('#content').load(file);
            history.pushState(file, file, '?menu=' + file);
            $('html, body').animate({
               scrollTop: '0'
            }, 200);
         });
      }

      clickMenu('click-beranda', 'beranda');
      clickMenu('click-master-jabatan', 'master-jabatan');
      clickMenu('click-karyawan', 'karyawan');
      clickMenu('click-kelas', 'kelas');
      clickMenu('click-siswa', 'siswa');
      clickMenu('click-guru', 'guru');
      clickMenu('click-monitoring', 'monitoring');
      clickMenu('click-rekap-absen', 'rekap-absen');
      clickMenu('click-setelan', 'setelan');
      clickMenu('click-cuti', 'cuti');
      clickMenu('click-libur', 'libur');
   </script>
   <?php if (isset($_GET['menu'])) { ?>
      <script>
         $('#click-<?= $_GET['menu'] ?>').addClass('active');
         $('#content').load('<?= $_GET['menu'] ?>');
      </script>
   <?php } else { ?>
      <script>
         $('#content').load('beranda');
         history.pushState('beranda', 'beranda', '?menu=beranda');
      </script>
   <?php } ?>
</body>

</html>