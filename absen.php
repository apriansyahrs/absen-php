<?php
require "config.php";
if (!isset($_SESSION['siswa'])) {
   header('location: auth/siswa');
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
   <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
</head>

<body>
   <div class="content siswa">
      <nav class="topbar">
         <div class="row">
            <div class="container">
               <div class="row m-0">
                  <div class="col col-2">
                     <div class="menu">
                        <i class="la la-bars waves-effect waves-light" id="toggle-sidebar"></i>
                     </div>
                  </div>
                  <div class="col col-8">
                     <div class="logo">
                        <?= $tb_setelan['nama'] ?>
                     </div>
                  </div>
                  <div class="col col-2">
                     <div class="notifikasi">
                        <i class="la la-bell waves-effect waves-light active" id="notif-show"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </nav>
      <div class="sidebar-menu overlay-scrollbars transition-all-300ms-ease" id="sidebar-menu">
         <div class="logo d-flex align-items-center justify-content-center">
            <span class="f-size-14px">
               <span class="jam-sekarang f-size-28px"><?= date('H:i:s') ?></span>
               <br>
               <?= waktu_sekarang() ?>
            </span>
         </div>
         <div class="sosmed-developer">
            <i class="la la-facebook waves-effect waves-dark" data-tooltip="tooltip" title="Facebook Developer"></i>
            <i class="la la-instagram waves-effect waves-dark" data-tooltip="tooltip" title="Instagram Developer"></i>
            <i class="la la-twitter waves-effect waves-dark" data-tooltip="tooltip" title="Twitter Developer"></i>
         </div>
         <ul>
            <li class="sidebar-item waves-effect waves-dark" id="click-tema-gelap">
               <i class="la la-adjust"></i>
               <span>Tema Gelap</span>
            </li>
            <li class="sidebar-item waves-effect waves-dark" id="click-tema-terang">
               <i class="la la-adjust"></i>
               <span>Tema Terang</span>
            </li>
         </ul>
      </div>
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
            <ul>
               <!-- <li class="active waves-effect waves-dark">
                  <div class="foto">
                     <i class="la la-user user-red"></i>
                  </div>
                  <div class="notif-info-user">
                     <div class="nama">Muhammad Zulfa</div>
                     <div class="info">Absen pada Rabu, 03 Juni 2020 09:10</div>
                  </div>
               </li>
               <li class="waves-effect waves-dark">
                  <div class="foto">
                     <i class="la la-user user-blue"></i>
                  </div>
                  <div class="notif-info-user">
                     <div class="nama">Ahmad Luthfi Yazidi</div>
                     <div class="info">Absen pada Rabu, 03 Juni 2020 08:30</div>
                  </div>
               </li> -->
               <p class="p-5 text-center">Comming soon</p>
            </ul>
         </div>
      </div>
      <?php
      $masuk_mulai = date('Hi', strtotime($tb_kelas['masuk_mulai']));
      $masuk_akhir = date('Hi', strtotime($tb_kelas['masuk_akhir']));
      if (date('l') == 'Friday') {
         $pulang_mulai = date('Hi', strtotime($tb_kelas['pulang_mulai_jumat']));
         $pulang_akhir = date('Hi', strtotime($tb_kelas['pulang_akhir_jumat']));
      } else {
         $pulang_mulai = date('Hi', strtotime($tb_kelas['pulang_mulai']));
         $pulang_akhir = date('Hi', strtotime($tb_kelas['pulang_akhir']));
      }
      $waktu_sekarang = date('Hi');

      $tanggal = date('d');
      $bulan_tahun = date('m-Y');

      function absenMasuk()
      {
         global $conn;
         global $tanggal;
         global $bulan_tahun;
         $result = mysqli_query($conn, "SELECT * FROM a_masuk WHERE id_siswa = '$_SESSION[siswa]' && m_bulan_tahun = '$bulan_tahun'");
         $a_masuk = mysqli_fetch_assoc($result);
         if ($a_masuk[$tanggal] == '') {
            $row_tgl = true;
         } else {
            $row_tgl = $a_masuk[$tanggal];
         }
         return num_rows("SELECT * FROM a_masuk WHERE `$tanggal` = '$row_tgl'");
      }

      function absenPulang()
      {
         global $conn;
         global $tanggal;
         global $bulan_tahun;
         $result = mysqli_query($conn, "SELECT * FROM a_pulang WHERE id_siswa = '$_SESSION[siswa]' && p_bulan_tahun = '$bulan_tahun'");
         $a_pulang = mysqli_fetch_assoc($result);
         if ($a_pulang[$tanggal] == '') {
            $row_tgl = true;
         } else {
            $row_tgl = $a_pulang[$tanggal];
         }
         return num_rows("SELECT * FROM a_pulang WHERE `$tanggal` = '$row_tgl'");
      } ?>

      <div class="jumbotron jumbotron-fluid menu-utama">
         <div class="container">
            <div class="info-user">
               <div class="foto">
                  <i class="la la-user <?= $tb_siswa['profil'] ?>"></i>
               </div>
               <div class="nama"><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></div>
               <div class="kelas"><?= $tb_kelas['kelas'] ?></div>
               <div class="jam-sekarang"><?= date('H:i:s') ?></div>
               <div class="waktu-sekarang"><?= waktu_sekarang() ?></div>
            </div>
            <div class="text-center my-5">
               <div class="info-ket">
                  <div class="row d-flex- justify-content-center">
                     <div class="col-md-8 col-lg-4">
                        <?php
                        $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

                        if ($jadwal_libur) {
                           echo 'Libur ' . $jadwal_libur['keterangan'];
                        } else {
                           if (date('l') !== "Sunday") {
                              if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
                                 if (absenMasuk() == 0) {
                                    echo 'Sekarang waktunya melakukan absen masuk';
                                 } else {
                                    echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
                                 }
                              } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
                                 if (absenMasuk() == 0) {
                                    echo 'Absen masuk sudah berakhir pada jam ' . $tb_kelas['masuk_akhir'] . ' yang lalu.';
                                 } else {
                                    echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
                                 }
                              } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
                                 if (absenMasuk() == 0) {
                                    echo 'Kamu tidak melakukan absen masuk, maka tidak bisa melakukan absen pulang hari ini';
                                 } elseif (absenPulang() == 0) {
                                    echo 'Sekarang waktunya melakukan absen pulang';
                                 } else {
                                    echo 'Kamu sudah melakukan absen pulang hari ini';
                                 }
                              } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
                                 if (absenPulang() == 0) {
                                    if (date('l') == 'Friday') {
                                       echo 'Absen pulang sudah berakhir pada jam ' . $tb_kelas['pulang_akhir_jumat'] . ' yang lalu';
                                    } else {
                                       echo 'Absen pulang sudah berakhir pada jam ' . $tb_kelas['pulang_akhir'] . ' yang lalu';
                                    }
                                 } else {
                                    echo 'Kamu sudah melakukan absen pulang hari ini';
                                 }
                              } else {
                                 echo 'Belum waktunya melakukan absen masuk';
                              }
                           } else {
                              echo 'Hari ini libur!';
                           }
                        }
                        ?>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row my-5 d-flex justify-content-center">
               <div class="col-4 col-lg-2 mt-4 p-0 text-md-right">
                  <button type="button" class="btn btn-absen transparent waves-effect waves-light click-profil">
                     <i class="la la-user"></i>
                     Profil
                  </button>
               </div>
               <div class="col-4 col-lg-2 p-0">
                  <?php
                  $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

                  if ($jadwal_libur) { ?>
                     <button type="button" class="btn btn-absen danger" disabled="disabled">
                        <i class="la la-calendar"></i>
                     </button>
                     <?php
                  } else {
                     if (date('l') !== "Sunday") {
                        if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
                           if (absenMasuk() == 0) { ?>
                              <button type="button" class="btn btn-absen warning waves-effect waves-warning infinite animated pulse" id="click-absen-masuk">
                                 Masuk
                              </button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                                 <i class="la la-check"></i>
                              </button>
                           <?php }
                        } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
                           if (absenMasuk() == 0) { ?>
                              <button type="button" class="btn btn-absen warning waves-effect waves-warning infinite animated pulse" id="click-absen-masuk-terlambat">
                                 Masuk
                              </button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                                 <i class="la la-check"></i>
                              </button>
                           <?php }
                        } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
                           if (absenMasuk() == 0) { ?>
                              <button type="button" class="btn btn-absen danger" disabled="disabled">
                                 <i class="la la-times"></i>
                              </button>
                           <?php } elseif (absenPulang() == 0) { ?>
                              <button type="button" class="btn btn-absen danger waves-effect waves-danger infinite animated pulse" id="click-absen-pulang">
                                 Pulang
                              </button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-absen danger infinite animated pulse" disabled="disabled">
                                 <i class="la la-check"></i>
                              </button>
                           <?php }
                        } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
                           if (absenPulang() == 0) { ?>
                              <button type="button" class="btn btn-absen danger" disabled="disabled">
                                 <i class="la la-times"></i>
                              </button>
                           <?php } else { ?>
                              <button type="button" class="btn btn-absen danger" disabled="disabled">
                                 <i class="la la-check"></i>
                              </button>
                           <?php }
                        } else { ?>
                           <button type="button" class="btn btn-absen warning" disabled="disabled">
                              Masuk
                           </button>
                        <?php } ?>
                     <?php } else { ?>
                        <button type="button" class="btn btn-absen danger" disabled="disabled">
                           <i class="la la-calendar"></i>
                        </button>
                     <?php } ?>
                  <?php } ?>
               </div>
               <div class="col-4 col-lg-2 mt-4 p-0 text-md-left">
                  <button type="button" class="btn btn-absen transparent waves-effect waves-light click-logout">
                     <i class="la la-sign-out"></i>
                     Logout
                  </button>
               </div>
            </div>
         </div>
      </div>
      <div class="container">
         <div class="row d-flex justify-content-center">
            <div class="col-md-11 col-lg-7 position-absolute">
               <div class="info-panel transition-all-300ms-ease">
                  <div class="row">
                     <div class="col-6 col-md-4">
                        <img src="<?= base_url() ?>/assets/img/icons8-google-groups-64.png" alt="gambar">
                        <h6>Kelas kamu</h6>
                        <span>
                           <?= num_rows("SELECT token_kelas FROM tb_siswa WHERE token_kelas = '$tb_siswa[token_kelas]'") ?>
                           siswa
                        </span>
                     </div>
                     <div class="col-6 col-md-4">
                        <img src="<?= base_url() ?>/assets/img/icons8-teacher-64.png" alt="gambar">
                        <h6>Guru kamu</h6>
                        <span>
                           <?php
                           $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_siswa[id_guru]'");
                           echo $tb_guru['nama']; ?>
                        </span>
                     </div>
                     <div class="col-6 col-md-4">
                        <img src="<?= base_url() ?>/assets/img/icons8-check-file-64.png" alt="gambar">
                        <h6>Masuk hari ini</h6>
                        <span>
                           <?= num_rows("SELECT m_tanggal,m_bulan_tahun,token_kelas FROM a_masuk WHERE m_tanggal = '$tanggal' && m_bulan_tahun = '$bulan_tahun' && token_kelas = '$tb_siswa[token_kelas]'") ?>
                           siswa
                        </span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div style="margin-top: 250px; margin-bottom: 100px;">
         <div class="label-menu">
            Pengumuman
         </div>
         <div class="p-5" style="background: #E0E4F9; border-left: 4px solid #46A4EC;">
            <?php if (num_rows("SELECT token_kelas FROM tb_pengumuman WHERE token_kelas = '$tb_kelas[token_kelas]'") !== 0) { ?>
               <div id="carouselPengumuman" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                     <?php
                     $result = mysqli_query($conn, "SELECT * FROM tb_pengumuman WHERE token_kelas = '$tb_kelas[token_kelas]' ORDER BY ditambahkan ASC");
                     foreach ($result as $tb_pengumuman) { ?>
                        <div class="carousel-item <?= $tb_pengumuman['active'] ?>">
                           <div class="row d-flex justify-content-center">
                              <div class="col-10 text-center mb-5">
                                 <div style="color: #3B567F;">
                                    <p>
                                       <i class="la la-bullhorn la-3x infinite animated headShake"></i>
                                    </p>
                                    <p>
                                       <?= hari(date('D', $tb_pengumuman['ditambahkan'])) . ' ,' . date('d', $tb_pengumuman['ditambahkan']) . ' ' . bulan(date('m', $tb_pengumuman['ditambahkan'])) . ' ' . date('Y', $tb_pengumuman['ditambahkan']) . ' ' . date('H:i', $tb_pengumuman['ditambahkan']) ?>
                                    </p>
                                 </div>
                                 <p class="f-size-16px" style="color: #343336;">
                                    <?php
                                    if (strlen($tb_pengumuman['pengumuman']) > 500) {
                                       echo substr($tb_pengumuman['pengumuman'], 0, 500) . '...';
                                    } else {
                                       echo $tb_pengumuman['pengumuman'];
                                    } ?>
                                 </p>
                                 <a href="pengumuman?id_pengumuman=<?= $tb_pengumuman['id_pengumuman'] ?>&token_kelas=<?= $tb_pengumuman['token_kelas'] ?>" class="btn btn-linear-primary waves-effect waves-light">
                                    Lihat
                                 </a>
                              </div>
                           </div>
                        </div>
                     <?php } ?>
                  </div>
                  <a class="carousel-control-prev" href="#carouselPengumuman" role="button" data-slide="prev">
                     <span><i class="la la-angle-left waves-effect waves-dark ml-n5"></i></span>
                     <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselPengumuman" role="button" data-slide="next">
                     <span><i class="la la-angle-right waves-effect waves-dark mr-n5"></i></span>
                     <span class="sr-only">Next</span>
                  </a>
               </div>
            <?php } else { ?>
               <div class="text-center" style="color: #3B567F;">
                  <p>
                     <i class="la la-bullhorn la-3x infinite animated headShake"></i>
                  </p>
                  <p>Saat ini tidak ada pengumuman</p>
               </div>
            <?php } ?>
         </div>
      </div>
      <div class="container">
         <div class="my-5">
            <div class="label-menu">Jadwal absen</div>
            <div class="info-waktu">
               <div class="row d-flex justify-content-center">
                  <div class="col-12 col-md-6 my-auto">
                     <div class="font-italic f-size-20px my-4">
                        <p style="color: #343336;">"Disiplin adalah jembatan antara cita-cita dan pencapaiannya."</p>
                     </div>
                     <div id="carouselJadwalAbsen" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                           <div class="carousel-item active">
                              <div class="row d-flex justify-content-center mx-1">
                                 <div class="col-md-6">
                                    <div class="card-info-waktu waves-effect waves-light">
                                       <div class="waktu-mulai" data-tooltip="tooltip" title="Absen masuk dilakukan pada saat atau sesudah jam <?= $tb_kelas['masuk_mulai'] ?>">
                                          Masuk Mulai <br> <span><?= $tb_kelas['masuk_mulai'] ?></span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="card-info-waktu waves-effect waves-light">
                                       <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen masuk pada jam <?= $tb_kelas['masuk_akhir'] ?>">
                                          Masuk Akhir <br> <span><?= $tb_kelas['masuk_akhir'] ?></span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="carousel-item">
                              <div class="row d-flex justify-content-center mx-1">
                                 <div class="col-md-6">
                                    <div class="card-info-waktu waves-effect waves-light">
                                       <div class="waktu-mulai" data-tooltip="tooltip" title="Absen pulang dilakukan pada saat atau sesudah jam <?= $tb_kelas['pulang_mulai'] ?>">
                                          Pulang Mulai <br>
                                          <span>
                                             <?php
                                             if (date('l') == 'Friday') {
                                                echo $tb_kelas['pulang_mulai_jumat'];
                                             } else {
                                                echo $tb_kelas['pulang_mulai'];
                                             }
                                             ?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="card-info-waktu waves-effect waves-light">
                                       <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen pulang pada jam <?= $tb_kelas['pulang_akhir'] ?>">
                                          Pulang Akhir <br>
                                          <span>
                                             <?php
                                             if (date('l') == 'Friday') {
                                                echo $tb_kelas['pulang_akhir_jumat'];
                                             } else {
                                                echo $tb_kelas['pulang_akhir'];
                                             }
                                             ?>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselJadwalAbsen" role="button" data-slide="prev">
                           <span><i class="la la-angle-left waves-effect waves-dark ml-n4"></i></span>
                           <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselJadwalAbsen" role="button" data-slide="next">
                           <span><i class="la la-angle-right waves-effect waves-dark mr-n4"></i></span>
                           <span class="sr-only">Next</span>
                        </a>
                     </div>
                  </div>
                  <div class="col-10 col-md-6 my-5">
                     <img src="<?= base_url() ?>/assets/img/undraw_work_chat_erdt.svg" alt="gambar" class="img-fluid">
                  </div>
               </div>
            </div>
         </div>
      </div>
      <?php $jml_hari = jml_hari(date('m'), date('Y')); ?>
      <div class="label-menu">
         Monitoring
      </div>
      <div class="card mt-5 border-0" style="border-radius: 0; margin-bottom: 100px;">
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
                           $nama_hari = date('l', strtotime(date('Y/m') . '/' . $i));

                           if ($nama_hari !== 'Sunday') {
                              echo "<th class='first-next'>$i</th>";
                           } else {
                              echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                           }
                        } ?>
                     </tr>
                     <!-- <tr>
                        
                     </tr> -->
                  </thead>
                  <tbody class="text-center" id="intervalAbsenMasukMonitoring"></tbody>
               </table>
            </div>
            <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars my-3">
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
                           $nama_hari = date('l', strtotime(date('Y/m') . '/' . $i));

                           if ($nama_hari !== 'Sunday') {
                              echo "<th class='first-next'>$i</th>";
                           } else {
                              echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                           }
                        } ?>
                     </tr>
                     <!-- <tr>

                     </tr> -->
                  </thead>
                  <tbody class="text-center" id="intervalAbsenPulangMonitoring"></tbody>
               </table>
            </div>
         </div>
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
   <div class="overlay-998" id="overlay-sidebar"></div>
   <div class="overlay-9998" id="overlay-notifikasi"></div>
   <div class="pesan transition-all-300ms-ease"></div>
   <div id="loader"></div>
   <?php if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) { ?>
      <form id="formAbsenMasuk" enctype="multipart/form-data">
         <div class="modal fade animated zoomIn" id="modalAbsenMasuk" tabindex="-1" role="dialog" aria-labelledby="modalAbsenMasukLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                  <div class="modal-header">
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="la la-times"></i>
                     </button>
                  </div>
                  <div class="modal-body text-center">
                     <input type="hidden" name="id_guru" value="<?= $tb_kelas['id_guru'] ?>">
                     <input type="hidden" name="id_siswa" value="<?= $tb_siswa['id_siswa'] ?>">
                     <input type="hidden" name="token_kelas" value="<?= $tb_kelas['token_kelas'] ?>">
                     <input type="hidden" name="latitude" id="latitude">
                     <input type="hidden" name="longitude" id="longitude">
                     <input type="hidden" name="m_foto" id="m_foto">
                     <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir">
                     <div class="form-group" style="color: #1e3056;">
                        <p class="f-size-28px mb-0">Halo, <?= $tb_siswa['nama_depan'] ?></p>
                        <p>Sudah siap absen masuk hari ini, pilih salah satu alasan dibawah.</p>
                     </div>
                     <div class="form-group">
                        <label class="btn btn-radio active">Hadir
                           <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir" checked="">
                        </label>
                        <label class="btn btn-radio">Izin
                           <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                        </label>
                        <label class="btn btn-radio">Sakit
                           <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                        </label>
                     </div>
                     <div class="form-group">
                        <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                     </div>
                     <div class="form-group">
                        <div id="my_camera"></div>
                     </div>
                     <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                  </div>
                  <div class="modal-footer">
                     <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-masuk">Absen Masuk</button>
                  </div>
               </div>
            </div>
         </div>
      </form>
      <?php }
   if ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
      if (absenMasuk() == 0) { ?>
         <form id="formAbsenMasukTerlambat" enctype="multipart/form-data">
            <div class="modal fade animated zoomIn" id="modalAbsenMasukTerlambat" tabindex="-1" role="dialog" aria-labelledby="modalAbsenMasukTerlambatLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i class="la la-times"></i>
                        </button>
                     </div>
                     <div class="modal-body text-center">
                        <input type="hidden" name="id_guru" value="<?= $tb_kelas['id_guru'] ?>">
                        <input type="hidden" name="id_siswa" value="<?= $tb_siswa['id_siswa'] ?>">
                        <input type="hidden" name="token_kelas" value="<?= $tb_kelas['token_kelas'] ?>">
                        <input type="hidden" name="latitude" id="latitude">
                        <input type="hidden" name="longitude" id="longitude">
                        <input type="hidden" name="m_foto" id="m_foto">
                        <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir"> <!-- biar saja hadir, cuman untuk validasi radius lokasi -->
                        <div class="form-group" style="color: #1e3056;">
                           <p class="f-size-28px mb-0">Halo, <?= $tb_siswa['nama_depan'] ?></p>
                           <p>Anda terlambat hari ini!</p>
                        </div>
                        <div class="form-group">
                           <label class="btn btn-radio active">Terlambat
                              <input type="radio" class="d-none" name="m_alasan" id="" value="terlambat" checked="">
                           </label>
                        </div>
                        <div class="form-group">
                           <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required=""></textarea>
                        </div>
                        <div class="form-group">
                           <div id="my_camera"></div>
                        </div>
                        <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-masuk">Absen Masuk</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      <?php }
   }

   if ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
      if (absenPulang() == 0 && absenMasuk() !== 0) { ?>
         <form id="formAbsenPulang" enctype="multipart/form-data">
            <div class="modal fade animated zoomIn" id="modalAbsenPulang" tabindex="-1" role="dialog" aria-labelledby="modalAbsenPulangLabel" aria-hidden="true">
               <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                  <div class="modal-content">
                     <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <i class="la la-times"></i>
                        </button>
                     </div>
                     <div class="modal-body text-center">
                        <input type="hidden" name="id_guru" value="<?= $tb_kelas['id_guru'] ?>">
                        <input type="hidden" name="id_siswa" value="<?= $tb_siswa['id_siswa'] ?>">
                        <input type="hidden" name="token_kelas" value="<?= $tb_kelas['token_kelas'] ?>">
                        <input type="hidden" name="latitude" id="latitude_pulang">
                        <input type="hidden" name="longitude" id="longitude_pulang">
                        <input type="hidden" name="p_foto" id="p_foto">
                        <div class="form-group" style="color: #1e3056;">
                           <p class="f-size-28px mb-0">Halo, <?= $tb_siswa['nama_depan'] ?></p>
                           <p>Sudah siap absen pulang hari ini.</p>
                        </div>
                        <div class="form-group">
                           <div id="my_camera_pulang"></div>
                        </div>
                        <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                     </div>
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-pulang">Absen Pulang</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
   <?php }
   } ?>
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
   <script src="<?= base_url() ?>/assets/maps/geo-min.js"></script>
   <script src="<?= base_url() ?>/assets/webcam/webcam.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script-siswa.js"></script>
   <script>
      function take_snapshot() {
         Webcam.snap(function(data_uri) {
            $('#result_camera').html('<img src="' + data_uri + '">');
         });
      }

      const date = new Date;

      if (date.getDay() == 5) {
         var masuk_mulai = '<?= $tb_kelas['masuk_mulai'] ?>:00';
         masuk_akhir = '<?= $tb_kelas['masuk_akhir'] ?>:00';
         pulang_mulai = '<?= $tb_kelas['pulang_mulai_jumat'] ?>:00';
         pulang_akhir = '<?= $tb_kelas['pulang_akhir_jumat'] ?>:00';
      } else {
         var masuk_mulai = '<?= $tb_kelas['masuk_mulai'] ?>:00';
         masuk_akhir = '<?= $tb_kelas['masuk_akhir'] ?>:00';
         pulang_mulai = '<?= $tb_kelas['pulang_mulai'] ?>:00';
         pulang_akhir = '<?= $tb_kelas['pulang_akhir'] ?>:00';
      }

      setInterval(function() {
         $.ajax({
            url: 'jam-sekarang',
            success: function(jamSekarang) {
               if (masuk_mulai == jamSekarang) {
                  location.reload();
               } else if (masuk_akhir == jamSekarang) {
                  location.reload();
               } else if (pulang_mulai == jamSekarang) {
                  location.reload();
               } else if (pulang_akhir == jamSekarang) {
                  location.reload();
               }
               $('.jam-sekarang').html(jamSekarang);
            }
         });
      }, 1000);

      setInterval(function() {
         intervalAbsenMasukMonitoring();
         intervalAbsenPulangMonitoring();
      }, 60000);

      intervalAbsenMasukMonitoring();
      intervalAbsenPulangMonitoring();

      function intervalAbsenMasukMonitoring() {
         $.ajax({
            type: 'post',
            url: 'guru/intervalAbsenMasukMonitoring',
            data: {
               token_kelas: '<?= $tb_kelas['token_kelas'] ?>',
               m_bulan_tahun: '<?= $bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenMasukMonitoring').html(data);
            }
         });
      }

      function intervalAbsenPulangMonitoring() {
         $.ajax({
            type: 'post',
            url: 'guru/intervalAbsenPulangMonitoring',
            data: {
               token_kelas: '<?= $tb_kelas['token_kelas'] ?>',
               p_bulan_tahun: '<?= $bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenPulangMonitoring').html(data);
            }
         });
      }
   </script>
</body>

</html>