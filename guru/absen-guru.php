<?php
require "../config.php";
$j_guru = query("SELECT * FROM j_guru LIMIT 1");

$masuk_mulai = date('Hi', strtotime($j_guru['masuk_mulai']));
$masuk_akhir = date('Hi', strtotime($j_guru['masuk_akhir']));
if (date('l') == 'Friday') {
   $pulang_mulai = date('Hi', strtotime($j_guru['pulang_mulai_jumat']));
   $pulang_akhir = date('Hi', strtotime($j_guru['pulang_akhir_jumat']));
} else {
   $pulang_mulai = date('Hi', strtotime($j_guru['pulang_mulai']));
   $pulang_akhir = date('Hi', strtotime($j_guru['pulang_akhir']));
}
$waktu_sekarang = date('Hi');
$tgl_sekarang = date("Y-m-d");

$tanggal = date('d');
$bulan_tahun = date('m-Y');

$jml_hari = jml_hari(date('m'), date('Y'));
function absenMasuk()
{
   global $conn;
   global $tanggal;
   global $bulan_tahun;
   $result = mysqli_query($conn, "SELECT * FROM a_masuk_guru WHERE id_guru = '$_SESSION[guru]' && m_bulan_tahun = '$bulan_tahun'");
   $a_masuk_guru = mysqli_fetch_assoc($result);
   if ($a_masuk_guru[$tanggal] == '') {
      $row_tgl = true;
   } else {
      $row_tgl = $a_masuk_guru[$tanggal];
   }
   return num_rows("SELECT * FROM a_masuk_guru WHERE `$tanggal` = '$row_tgl'");
}

function absenPulang()
{
   global $conn;
   global $tanggal;
   global $bulan_tahun;
   $result = mysqli_query($conn, "SELECT * FROM a_pulang_guru WHERE id_guru = '$_SESSION[guru]' && p_bulan_tahun = '$bulan_tahun'");
   $a_pulang_guru = mysqli_fetch_assoc($result);
   if ($a_pulang_guru[$tanggal] == '') {
      $row_tgl = true;
   } else {
      $row_tgl = $a_pulang_guru[$tanggal];
   }
   return num_rows("SELECT * FROM a_pulang_guru WHERE `$tanggal` = '$row_tgl'");
} ?>

<div class="content-title">
   Absen guru
</div>
<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-body text-center py-5">
            <div class="py-4 px-3" style="background: #E1E4F9; border-radius: 10px;">
               <div class="mb-3">
                  <img src="<?= base_url() ?>/img/guru/<?= $tb_guru['profil'] ?>" alt="<?= $tb_guru['profil'] ?>" class="img-fluid rounded-circle" height="60" width="60" style="background-size: cover">
               </div>
               <h5><?= $tb_guru['nama'] ?></h5>
               <p><?= 'NIP:' . $tb_guru['nip'] ?></p>
               <span class="f-size-14px">
                  <span class="jam-sekarang f-size-28px"><?= date('H:i:s') ?></span>
                  <br>
                  <?= waktu_sekarang() ?>
               </span>
            </div>
            <div class="mt-5">
               <?php
               $cuti_count = num_rows("SELECT * FROM tb_cuti WHERE id_guru = '" . $_SESSION['guru'] . "' && mulai_cuti <= '" . $tgl_sekarang . "' && selesai_cuti >= '" . $tgl_sekarang . "'");
               $tb_cuti = query("SELECT * FROM tb_cuti WHERE id_guru = '" . $_SESSION['guru'] . "' && mulai_cuti <= '" . $tgl_sekarang . "' && selesai_cuti >= '" . $tgl_sekarang . "'");
               $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

               if ($jadwal_libur) { ?>
                  <button type="button" class="btn btn-absen danger" disabled="disabled">
                     <i class="la la-calendar"></i>
                  </button>
                  <?php
               } else {
                  if ($cuti_count >= 1) { ?>
                     <button type="button" class="btn btn-absen warning" disabled="disabled">
                        Cuti
                     </button>
                  <?php } else { ?>
                     <?php
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
                        <?php }
                     } else { ?>
                        <button type="button" class="btn btn-absen danger" disabled="disabled">
                           <i class="la la-calendar"></i>
                        </button>
                     <?php } ?>
                  <?php } ?>
               <?php } ?>


            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 my-auto text-center info-waktu">
      <div class="font-italic f-size-20px my-4">
         <p style="color: #343336;">

            <?php
            $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

            if ($jadwal_libur) {
               echo 'Libur ' . $jadwal_libur['keterangan'];
            } else {
               if ($cuti_count >= 1) {
                  if ($tb_cuti['keterangan']) {
                     echo $tb_cuti['keterangan'];
                  } else {
                     echo 'Anda sedang dalam masa Cuti';
                  }
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
                           echo 'Absen masuk sudah berakhir pada jam ' . $j_guru['masuk_akhir'] . ' yang lalu';
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
                              echo 'Absen pulang sudah berakhir pada jam ' . $j_guru['pulang_akhir_jumat'] . ' yang lalu';
                           } else {
                              echo 'Absen pulang sudah berakhir pada jam ' . $j_guru['pulang_akhir'] . ' yang lalu';
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
            }
            ?>
         </p>
      </div>
      <div id="carouselJadwalAbsen" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <?php if ($cuti_count >= 1) { ?>
               <div class="carousel-item active">
                  <div class="row d-flex justify-content-center mx-1">
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-mulai">
                              Mulai Cuti <br> <span><?= $tb_cuti['mulai_cuti'] ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-akhir">
                              Selesai Cuti <br> <span><?= $tb_cuti['selesai_cuti'] ?></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } else { ?>
               <div class="carousel-item active">
                  <div class="row d-flex justify-content-center mx-1">
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-mulai" data-tooltip="tooltip" title="Absen masuk dilakukan pada saat atau sesudah jam <?= $j_guru['masuk_mulai'] ?>">
                              Masuk Mulai <br> <span><?= $j_guru['masuk_mulai'] ?></span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen masuk pada jam <?= $j_guru['masuk_akhir'] ?>">
                              Masuk Akhir <br> <span><?= $j_guru['masuk_akhir'] ?></span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="carousel-item">
                  <div class="row d-flex justify-content-center mx-1">
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-mulai" data-tooltip="tooltip" title="Absen pulang dilakukan pada saat atau sesudah jam <?= $j_guru['pulang_mulai'] ?>">
                              Pulang Mulai <br>
                              <span>
                                 <?php
                                 if (date('l') == 'Friday') {
                                    echo $j_guru['pulang_mulai_jumat'];
                                 } else {
                                    echo $j_guru['pulang_mulai'];
                                 }
                                 ?>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="card-info-waktu waves-effect waves-light">
                           <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen pulang pada jam <?= $j_guru['pulang_akhir'] ?>">
                              Pulang Akhir <br>
                              <span>
                                 <?php
                                 if (date('l') == 'Friday') {
                                    echo $j_guru['pulang_akhir_jumat'];
                                 } else {
                                    echo $j_guru['pulang_akhir'];
                                 }
                                 ?>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } ?>
         </div>
         <?php if ($cuti_count == 0) { ?>
            <a class="carousel-control-prev" href="#carouselJadwalAbsen" role="button" data-slide="prev">
               <span><i class="la la-angle-left waves-effect waves-dark ml-n4"></i></span>
               <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselJadwalAbsen" role="button" data-slide="next">
               <span><i class="la la-angle-right waves-effect waves-dark mr-n4"></i></span>
               <span class="sr-only">Next</span>
            </a>
         <?php } ?>
      </div>
   </div>
</div>


<div class="card my-4">
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
                  <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
                  <input type="hidden" name="latitude" id="latitude">
                  <input type="hidden" name="longitude" id="longitude">
                  <input type="hidden" name="m_foto" id="m_foto">
                  <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir">
                  <div class="form-group" style="color: #1e3056;">
                     <p class="f-size-28px mb-0">Halo, <?= $tb_guru['nama'] ?></p>
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
<?php } ?>
<?php
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
                     <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
                     <input type="hidden" name="latitude" id="latitude_pulang">
                     <input type="hidden" name="longitude" id="longitude_pulang">
                     <input type="hidden" name="p_foto" id="p_foto">
                     <div class="form-group" style="color: #1e3056;">
                        <p class="f-size-28px mb-0">Halo, <?= $tb_guru['nama'] ?></p>
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
}

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
                     <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
                     <input type="hidden" name="latitude" id="latitude">
                     <input type="hidden" name="longitude" id="longitude">
                     <input type="hidden" name="m_foto" id="m_foto">
                     <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir"> <!-- biar saja hadir, cuman untuk validasi radius lokasi -->
                     <div class="form-group" style="color: #1e3056;">
                        <p class="f-size-28px mb-0">Halo, <?= $tb_guru['nama'] ?></p>
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
} ?>

<script>
   function take_snapshot() {
      Webcam.snap(function(data_uri) {
         $('#result_camera').html('<img src="' + data_uri + '">');
      });
   }

   const date = new Date;

   if (date.getDay() == 5) {
      var masuk_mulai = '<?= $j_guru['masuk_mulai'] ?>:00';
      masuk_akhir = '<?= $j_guru['masuk_akhir'] ?>:00';
      pulang_mulai = '<?= $j_guru['pulang_mulai_jumat'] ?>:00';
      pulang_akhir = '<?= $j_guru['pulang_akhir_jumat'] ?>:00';
   } else {
      var masuk_mulai = '<?= $j_guru['masuk_mulai'] ?>:00';
      masuk_akhir = '<?= $j_guru['masuk_akhir'] ?>:00';
      pulang_mulai = '<?= $j_guru['pulang_mulai'] ?>:00';
      pulang_akhir = '<?= $j_guru['pulang_akhir'] ?>:00';
   }

   setInterval(function() {
      $.ajax({
         url: '../jam-sekarang',
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
      $.ajax({
         url: '../jam-sekarang',
         success: function(jamSekarang) {
            $('.jam-sekarang').html(jamSekarang);
         }
      });
   }, 1000);

   $('#click-absen-masuk, #click-absen-masuk-terlambat').click(function() {
      Webcam.set({
         width: 184,
         height: 230,
         image_format: 'jpeg',
         jpeg_quality: 90
      });
      Webcam.attach('#my_camera');

      if (geo_position_js.init()) {
         geo_position_js.getCurrentPosition(success_callback, error_callback, {
            enableHighAccuracy: true
         });
      } else {
         pesan('Tidak ada fungsi geolocation', 3000);
         return false;
      }

      function success_callback(p) {
         latitude = p.coords.latitude;
         longitude = p.coords.longitude;
         $('#latitude').val(latitude);
         $('#longitude').val(longitude);

         $('#modalAbsenMasuk').modal('show');
         $('#modalAbsenMasukTerlambat').modal('show');
      }

      function error_callback(p) {
         pesan('error = ' + p.message, 3000);
         return false;
      }
   })

   $('#formAbsenMasuk, #formAbsenMasukTerlambat').submit(function(e) {
      e.preventDefault();

      Webcam.snap(function(data_uri) {
         $('#m_foto').val(data_uri);
      });

      let dataa = new FormData(this);

      // get data settings
      let allText = "";

      var rawFile = new XMLHttpRequest();
      rawFile.open("GET", "../../../baseUrl.txt", false);
      rawFile.onreadystatechange = function() {
         if (rawFile.readyState === 4) {
            if (rawFile.status === 200 || rawFile.status == 0) {
               allText = rawFile.responseText;
            }
         }
      }
      rawFile.send(null);

      const url = allText + "/api/settings";

      fetch(url)
         .then((resp) => resp.json())
         .then(function(data) {
            let databanget = data.data;

            Number.prototype.toRad = function() {
               return this * Math.PI / 180;
            }

            // default sistem
            var lat2 = parseFloat(databanget.latitude_instansi);
            var lon2 = parseFloat(databanget.longitude_instansi);

            // user location
            var lat1 = latitude;
            var lon1 = longitude;

            var R = 6371; // km 
            //has a problem with the .toRad() method below.
            var x1 = lat2 - lat1;
            var dLat = x1.toRad();
            var x2 = lon2 - lon1;
            var dLon = x2.toRad();
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
               Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
               Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var d = R * c;
            var e = d / 0.0010000;

            var meter = e.toString().split('.')[0];

            if ($("#m_alasan_text").val() == "hadir" && databanget.hadir_radius == 1) {
               if (meter > parseInt(databanget.radius_meter)) {
                  pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                  return false;
               }
            }

            if ($("#m_alasan_text").val() == "izin" && databanget.izin_radius == 1) {
               if (meter > parseInt(databanget.radius_meter)) {
                  pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                  return false;
               }
            }

            if ($("#m_alasan_text").val() == "sakit" && databanget.sakit_radius == 1) {
               if (meter > parseInt(databanget.radius_meter)) {
                  pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
                  return false;
               }
            }


            $('#btn-absen-masuk').attr('disabled', 'disabled');
            $('#btn-absen-masuk').html('<div class="spinner-border text-white" role="status"></div>');

            $.ajax({
               type: 'post',
               url: 'aksi-absen?absen_masuk',
               data: dataa,
               contentType: false,
               processData: false,
               cache: false,
               success: function(data) {
                  if (data == 'berhasil') {
                     window.location.href = 'terimakasih';
                  }

                  if (data == 'gagal') {
                     pesan('Terdapat kesalahan pada sistem!', 3000);
                     $('#btn-absen-masuk').removeAttr('disabled', 'disabled');
                     $('#btn-absen-masuk').html('Masuk');
                  }
               }
            });

         })
         .catch(function(error) {
            pesan(error, 3000);
         });
   });

   $('#click-absen-pulang').click(function() {
      Webcam.set({
         width: 184,
         height: 230,
         image_format: 'jpeg',
         jpeg_quality: 90
      });
      Webcam.attach('#my_camera_pulang');

      if (geo_position_js.init()) {
         geo_position_js.getCurrentPosition(success_callback, error_callback, {
            enableHighAccuracy: true
         });
      } else {
         pesan('Tidak ada fungsi geolocation', 3000);
         return false;
      }

      function success_callback(p) {
         latitude = p.coords.latitude;
         longitude = p.coords.longitude;
         $('#latitude_pulang').val(latitude);
         $('#longitude_pulang').val(longitude);

         // get data settings
         let allText = "";

         var rawFile = new XMLHttpRequest();
         rawFile.open("GET", "../../../baseUrl.txt", false);
         rawFile.onreadystatechange = function() {
            if (rawFile.readyState === 4) {
               if (rawFile.status === 200 || rawFile.status == 0) {
                  allText = rawFile.responseText;
               }
            }
         }
         rawFile.send(null);

         const url = allText + "/api/settings";

         fetch(url)
            .then((resp) => resp.json())
            .then(function(data) {
               let databanget = data.data;

               Number.prototype.toRad = function() {
                  return this * Math.PI / 180;
               }

               // default sistem
               var lat2 = parseFloat(databanget.latitude_instansi);
               var lon2 = parseFloat(databanget.longitude_instansi);

               // user location
               var lat1 = latitude;
               var lon1 = longitude;

               var R = 6371; // km 
               //has a problem with the .toRad() method below.
               var x1 = lat2 - lat1;
               var dLat = x1.toRad();
               var x2 = lon2 - lon1;
               var dLon = x2.toRad();
               var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
               var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
               var d = R * c;
               var e = d / 0.0010000;

               var meter = e.toString().split('.')[0];

               if (meter > parseInt(databanget.radius_meter)) {
                  pesan("Anda berada di " + meter + " meter dari jangkauan", 3000);
               } else {
                  $('#modalAbsenPulang').modal('show');
               }
            })
            .catch(function(error) {
               pesan(error, 3000);
            });
      }

      function error_callback(p) {
         pesan('error = ' + p.message, 3000);
         return false;
      }
   });

   $('#formAbsenPulang').submit(function(e) {
      Webcam.snap(function(data_uri) {
         $('#p_foto').val(data_uri);
      });


      $('#btn-absen-pulang').attr('disabled', 'disabled');
      $('#btn-absen-pulang').html('<div class="spinner-border text-white" role="status"></div>');

      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-absen?absen_pulang',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               window.location.href = 'terimakasih';
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
               $('#click-absen-pulang').removeAttr('disabled', 'disabled');
               $('#click-absen-pulang').html('Pulang');
            }
         }
      });
   });

   setInterval(function() {
      intervalAbsenMasukMonitoring();
      intervalAbsenPulangMonitoring();
   }, 60000);

   intervalAbsenMasukMonitoring();
   intervalAbsenPulangMonitoring();

   function intervalAbsenMasukMonitoring() {
      $.ajax({
         type: 'post',
         url: 'intervalAbsenMasukMonitoringGuru',
         data: {
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
         url: 'intervalAbsenPulangMonitoringGuru',
         data: {
            p_bulan_tahun: '<?= $bulan_tahun ?>'
         },
         success: function(data) {
            $('#intervalAbsenPulangMonitoring').html(data);
         }
      });
   }

   $('#btn-radio-hadir').click(function() {
      $('#m_alasan_text').val('hadir');
      $('#m_ket').val('Hadir');
   });

   $('#btn-radio-izin').click(function() {
      $('#m_alasan_text').val('izin');
      $('#m_ket').val("");
   });

   $('#btn-radio-sakit').click(function() {
      $('#m_alasan_text').val('sakit');
      $('#m_ket').val("");
   });

   $('.btn-radio').click(function() {
      $('.btn-radio.active').removeClass('active');
      $(this).addClass('active');
   });

   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
</script>