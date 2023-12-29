<?php require "config.php";
if (!isset($_SESSION['ortu'])) {
   header('location: auth/ortu/login');
   return false;
}
$jml_hari = jml_hari(date('m'), date('Y'));
$bulan_tahun = date('m-Y'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Monitoring <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/overlayscrollbars/css/overlay-scrollbars.min.css">
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

   <div class="content guru">
      <nav class="topbar">
         <div class="row">
            <div class="container">
               <div class="row mx-2">
                  <div class="col col-8">
                     <div class="logo text-left">
                        <?= $tb_setelan['nama'] ?>
                     </div>
                  </div>
                  <div class="col col-4 text-right">
                     <i class="la la-info-circle waves-effect waves-light" data-tooltip="tooltip" title="Info kelas" data-toggle="modal" data-target="#modalInfoKelas"></i>
                     <i class="la la-sign-out waves-effect waves-light" data-tooltip="tooltip" title="Logout" id="click-logout"></i>
                  </div>
               </div>
            </div>
         </div>
      </nav>
   </div>

   <div class="container-fluid">
      <table class="table table-hover text-uppercase mt-3">
         <tr>
            <td>NIS siswa</td>
            <td>:</td>
            <td><?= $tb_siswa['nis'] ?></td>
         </tr>
         <tr>
            <td>Nama siswa</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></td>
         </tr>
         <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?= $tb_kelas['kelas'] ?></td>
         </tr>
         <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?= $tb_siswa['jk'] ?></td>
         </tr>
         <tr>
            <td>Telegram</td>
            <td>:</td>
            <td><?= $tb_siswa['telegram'] ?></td>
         </tr>
         <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['provinsi'])) {
                  $provinsi = query("SELECT * FROM w_provinces WHERE id = '$tb_siswa[provinsi]'");
                  echo $provinsi['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kota/Kabupaten</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kota'])) {
                  $kota = query("SELECT * FROM w_regencies WHERE id = '$tb_siswa[kota]'");
                  echo $kota['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kecamatan'])) {
                  $kecamatan = query("SELECT * FROM w_districts WHERE id = '$tb_siswa[kecamatan]'");
                  echo $kecamatan['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kelurahan</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kelurahan'])) {
                  $kelurahan = query("SELECT * FROM w_villages WHERE id = '$tb_siswa[kelurahan]'");
                  echo $kelurahan['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>nama ayah</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_ayah'] ?></td>
         </tr>
         <tr>
            <td>pekerjaan ayah</td>
            <td>:</td>
            <td><?= $tb_siswa['pekerjaan_ayah'] ?></td>
         </tr>
         <tr>
            <td>nama ibu</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_ibu'] ?></td>
         </tr>
         <tr>
            <td>pekerjaan ibu</td>
            <td>:</td>
            <td><?= $tb_siswa['pekerjaan_ibu'] ?></td>
         </tr>
         <tr>
            <td>telepon rumah</td>
            <td>:</td>
            <td><?= $tb_siswa['telepon_rumah'] ?></td>
         </tr>
      </table>
   </div>
   <div class="card-body">
      <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars my-3">
         <table class="table table-bordered table-hover sticky-first-column">
            <thead class="text-center">
               <tr>
                  <!-- <th rowspan="2">No</th> -->
                  <th rowspan="2" class="text-left first">Nama</th>
                  <!-- <th colspan="<?= $jml_hari ?>">absen masuk <?= bulan(date('m')) . ' ' . date('Y'); ?></th> -->
                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }
                     echo "<th class='text-center first-next'>$i</th>";
                  } ?>
               </tr>
               <!-- <tr>
               </tr> -->
            </thead>
            <tbody class="text-center" id="intervalAbsenMasukMonitoring"></tbody>
         </table>
      </div>
      <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars my-5">
         <table class="table table-bordered table-hover sticky-first-column">
            <thead class="text-center">
               <tr>
                  <!-- <th rowspan="2">No</th> -->
                  <th rowspan="2" class="text-left first">Nama</th>
                  <!-- <th colspan="<?= $jml_hari ?>">absen pulang <?= bulan(date('m')) . ' ' . date('Y'); ?></th> -->
                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }
                     echo "<th class='text-center first-next'>$i</th>";
                  } ?>
               </tr>
               <!-- <tr>
               </tr> -->
            </thead>
            <tbody class="text-center" id="intervalAbsenPulangMonitoring"></tbody>
         </table>
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
   <div id="loader"></div>

   <div class="modal fade animated zoomIn" id="modalInfoAMasuk" tabindex="-1" role="dialog" aria-labelledby="modalInfoAMasukLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN MASUK</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoAMasuk"></div>
         </div>
      </div>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoPulang" tabindex="-1" role="dialog" aria-labelledby="modalInfoPulangLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN PULANG</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoPulang"></div>
         </div>
      </div>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoKelas" tabindex="-1" role="dialog" aria-labelledby="modalInfoKelasLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO KELAS</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden">
               <table class="table table-hover text-uppercase">
                  <tr>
                     <td width="40%">nama kelas</td>
                     <td width="60%">: <?= $tb_kelas['kelas'] ?></td>
                  </tr>
                  <tr>
                     <td>nip guru</td>
                     <td>: <?= $tb_guru['nip'] ?></td>
                  </tr>
                  <tr>
                     <td>nama guru</td>
                     <td>: <?= $tb_guru['nama'] ?></td>
                  </tr>
                  <tr>
                     <td>telegram guru</td>
                     <td>: <?= $tb_guru['telegram'] ?></td>
                  </tr>
                  <tr>
                     <td>profil guru</td>
                     <td>:
                        <img src="<?= base_url() ?>/img/guru/<?= $tb_guru['profil'] ?>" alt="gambar" class="img-fluid img-thumbnail w-50">
                     </td>
                  </tr>
               </table>
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
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('.overlay-scrollbars').overlayScrollbars({
         className: "os-theme-dark",
         scrollbars: {
            autoHide: 'l',
            autoHideDelay: 0
         }
      });

      function intervalAbsenMasukMonitoring() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenMasukMonitoring',
            data: {
               token_kelas: '<?= $tb_kelas['token_kelas'] ?>',
               m_bulan_tahun: '<?= $bulan_tahun ?>',
               id_siswa: '<?= $tb_siswa['id_siswa'] ?>'
            },
            success: function(data) {
               $('#intervalAbsenMasukMonitoring').html(data);
            }
         });
      }

      function intervalAbsenPulangMonitoring() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenPulangMonitoring',
            data: {
               token_kelas: '<?= $tb_kelas['token_kelas'] ?>',
               p_bulan_tahun: '<?= $bulan_tahun ?>',
               id_siswa: '<?= $tb_siswa['id_siswa'] ?>'
            },
            success: function(data) {
               $('#intervalAbsenPulangMonitoring').html(data);
            }
         });
      }

      intervalAbsenMasukMonitoring();
      intervalAbsenPulangMonitoring();

      setInterval(function() {
         intervalAbsenMasukMonitoring();
         intervalAbsenPulangMonitoring();
      }, 60000);

      $('[data-tooltip="tooltip"]').tooltip();

      $('#click-logout').click(function() {
         loader(500);
         setTimeout(function() {
            window.location.href = 'logout';
         }, 500);
      });
   </script>
</body>

</html>