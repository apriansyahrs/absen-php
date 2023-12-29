<?php
require "../config.php";
if (!isset($_SESSION['guru'])) {
   header('location: ../auth/guru');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/overlayscrollbars/css/overlay-scrollbars.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/timeentry/jquery.timeentry.css">
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
   <nav class="topbar guru">
      <div class="row">
         <div class="container">
            <div class="row m-0">
               <div class="col col-2">
                  <div class="menu">
                     <i class="la la-bars waves-effect" id="toggle-sidebar"></i>
                  </div>
               </div>
               <div class="col col-8">
                  <div class="logo">
                     <?= $tb_setelan['nama'] ?>
                  </div>
               </div>
               <div class="col col-2">
                  <div class="notifikasi">
                     <i class="la la-bell waves-effect" id="notif-show"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>
   <div class="sidebar-menu guru overlay-scrollbars transition-all-300ms-ease" id="sidebar-menu">
      <div class="logo d-flex align-items-center justify-content-center">
         <span class="f-size-14px">
            <span class="jam-sekarang f-size-28px"><?= date('H:i:s') ?></span>
            <br>
            <?= waktu_sekarang() ?>
         </span>
      </div>
      <div class="sosmed-developer">
         <i class="la la-facebook waves-effect" data-tooltip="tooltip" title="Facebook Developer"></i>
         <i class="la la-instagram waves-effect" data-tooltip="tooltip" title="Instagram Developer"></i>
         <i class="la la-twitter waves-effect" data-tooltip="tooltip" title="Twitter Developer"></i>
      </div>
      <ul>
         <li class="sidebar-item waves-effect" id="click-beranda">
            <i class="la la-home"></i>
            <span>Beranda</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-absen-guru">
            <i class="la la-calendar-check"></i>
            <span>Absen guru</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-kegiatan-guru">
            <i class="las la-chalkboard"></i>
            <span>Kegiatan guru</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-buat-kelas">
            <i class="la la-plus"></i>
            <span>Buat kelas</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-pengumuman">
            <i class="la la-bullhorn"></i>
            <span>Pengumuman</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-daftar-kelas">
            <i class="la la-building"></i>
            <span>Daftar kelas <div class="badge badge-danger infinite animated swing" id="notif-absen-baru" hidden="hidden">BARU</div></span>
         </li>
         <li class="sidebar-item waves-effect" id="click-daftar-siswa">
            <i class="la la-user-check"></i>
            <span>Daftar siswa</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-monitoring">
            <i class="la la-tv"></i>
            <span>Monitoring</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-rekap-absen">
            <i class="la la-book"></i>
            <span>Rekap absen</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-setelan">
            <i class="la la-cog"></i>
            <span>Setelan</span>
         </li>
         <li class="sidebar-item waves-effect" id="click-logout">
            <i class="la la-sign-out"></i>
            <span>Logout</span>
         </li>
      </ul>
   </div>

   <!-- Notifikasi menu -->
   <div class="notifikasi-menu overlay-scrollbars transition-all-300ms-ease" id="notifikasi-menu">
      <div class="notifikasi-header">
         <div class="row m-0">
            <div class="col-10 my-auto">
               Notifikasi
            </div>
            <div class="col-2 my-auto">
               <div class="notifikasi-close">
                  <i class="la la-times waves-effect waves-light" id="notif-close"></i>
               </div>
            </div>
         </div>
      </div>
      <div class="notifikasi-body">
         <!-- <ul>
            <li class="active waves-effect">
               <div class="foto">
                  <i class="la la-user user-red"></i>
               </div>
               <div class="notif-info-user">
                  <div class="nama">Muhammad Zulfa</div>
                  <div class="info">Absen pada Rabu, 03 Juni 2020 09:10</div>
               </div>
            </li>
            <li class="waves-effect">
               <div class="foto">
                  <i class="la la-user user-blue"></i>
               </div>
               <div class="notif-info-user">
                  <div class="nama">Ahmad Luthfi Yazidi</div>
                  <div class="info">Absen pada Rabu, 03 Juni 2020 08:30</div>
               </div>
            </li>
         </ul> -->
         <p class="p-5 text-center">Comming soon</p>
      </div>
   </div>
   <div class="container-fluid">
      <div class="content guru transition-all-300ms-ease" id="content"></div>
   </div>
   <div class="scrolltop">
      <i class="la la-angle-up waves-effect waves-light"></i>
   </div>
   <div class="overlay-998" id="overlay-sidebar"></div>
   <div class="overlay-9998" id="overlay-notifikasi"></div>
   <div class="overlay-9998" id="overlay-form-select"></div>
   <div class="pesan transition-all-300ms-ease"></div>
   <div class="modal fade animated zoomIn" id="modalNavigatorOnline" tabindex="-1" role="dialog" aria-labelledby="modalNavigatorOnlineLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-body text-center b-radius-10px overflow-x-hidden" style="color: #1e3056">
               <div class="row d-flex justify-content-center">
                  <div class="col-4">
                     <img src="<?= base_url() ?>/assets/img/undraw_broadcast_jhwx.svg" alt="gambar" class="img-fluid">
                  </div>
               </div>
               <p class="mt-4 f-size-18px">Hubungkan ke jaringan!</p>
               <p>Pengguna <?= $tb_setelan['nama'] ?>, hidupkan data seluler atau hubungkan wifi.</p>
            </div>
         </div>
      </div>
   </div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/overlayscrollbars/js/jquery-overlay-scrollbars.min.js"></script>
   <script src="<?= base_url() ?>/assets/overlayscrollbars/js/overlay-scrollbars.min.js"></script>
   <script src="<?= base_url() ?>/assets/timeentry/jquery.plugin.js"></script>
   <script src="<?= base_url() ?>/assets/timeentry/jquery.timeentry.js"></script>
   <script src="<?= base_url() ?>/assets/jslocalsearch/JsLocalSearch.js"></script>
   <script src="<?= base_url() ?>/assets/sweetalert2/sweetalert2.min.js"></script>
   <script src="<?= base_url() ?>/assets/calendar/fullcalendar/main.min.js"></script>
   <script src="<?= base_url() ?>/assets/calendar/fullcalendar-daygrid/main.min.js"></script>
   <script src="<?= base_url() ?>/assets/table2excel/jquery.table2excel.js"></script>
   <script src="<?= base_url() ?>/assets/maps/geo-min.js"></script>
   <script src="<?= base_url() ?>/assets/webcam/webcam.min.js"></script>
   <script src="<?= base_url() ?>/assets/select2/js/select2.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script-guru.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      setInterval(function() {
         $.ajax({
            url: '../jam-sekarang',
            success: function(jamSekarang) {
               $('.jam-sekarang').html(jamSekarang);
            }
         });
      }, 1000);
   </script>
   <?php if (isset($_GET['menu'])) { ?>
      <script>
         $('.sidebar-item.active').removeClass('waves-light active');
         $('#click-<?= $_GET['menu'] ?>').addClass('active waves-light');
         $('#content').load('<?= $_GET['menu'] ?>');
      </script>
      <?php if (isset($_GET['welcome'])) { ?>
         <script>
            $('#content').load('<?= $_GET['menu'] ?>?welcome=true');
         </script>
      <?php } ?>
      <?php if (isset($_GET['token_kelas'])) { ?>
         <script>
            $('#content').load('<?= $_GET['menu'] ?>?token_kelas=<?= $_GET['token_kelas'] ?>');
         </script>
         <?php if (isset($_GET['m_bulan_tahun'])) { ?>
            <script>
               $('#content').load('<?= $_GET['menu'] ?>?token_kelas=<?= $_GET['token_kelas'] ?>&m_bulan_tahun=<?= $_GET['m_bulan_tahun'] ?>');
            </script>
         <?php } ?>
   <?php }
   } ?>
</body>

</html>