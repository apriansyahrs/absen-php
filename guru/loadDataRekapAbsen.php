<?php
require "../config.php";
$token_kelas = $_POST['token_kelas'];
$m_bulan_tahun = $_POST['m_bulan_tahun'];
$result_a_masuk = mysqli_query($conn, "SELECT * FROM a_masuk am JOIN tb_siswa s ON am . id_siswa = s . id_siswa WHERE am . m_bulan_tahun = '$m_bulan_tahun' && am . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");
$result_a_pulang = mysqli_query($conn, "SELECT * FROM a_pulang ap JOIN tb_siswa s ON ap . id_siswa = s . id_siswa WHERE ap . p_bulan_tahun = '$m_bulan_tahun' && ap . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");

$tb_kelas = query("SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
$tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");

$m_bulan = explode('-', $m_bulan_tahun)[0];
$m_tahun = explode('-', $m_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun); ?>
<style>
   td,
   th {
      text-align: center;
      text-transform: uppercase;
   }
</style>
<div class="text-center my-4">
   <button type="button" class="btn btn-excel btn-lg border-0 waves-effect waves-light" id="click-export-excel" data-file_name="<?= 'REKAP ABSEN KELAS ' . $tb_kelas['kelas'] . ' BULAN ' . bulan($m_bulan) . ' ' . $m_tahun ?>">
      <i class="fa fa-file-excel fa-fw"></i> Export Absen
   </button>
</div>
<div class="label-menu">
   absen masuk
</div>
<div class="table-responsive mt-4 overlay-scrollbars">
   <table class="table table-bordered table-hover">
      <thead>
         <tr>
            <th rowspan="2">No</th>
            <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
            <th colspan="<?= $jml_hari ?>">Tanggal</th>
            <th rowspan="2">Hadir</th>
            <th rowspan="2">Izin</th>
            <th rowspan="2">Sakit</th>
            <th rowspan="2">Terlambat</th>
         </tr>
         <tr>
            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }
               $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

               if ($nama_hari !== 'Sunday') {
                  echo "<th>$i</th>";
               } else {
                  echo "<th style='background-color: #E5E7EB;'>$i</th>";
               }
            } ?>
         </tr>
      </thead>
      <tbody>
         <?php
         $no = 1;
         if (mysqli_num_rows($result_a_masuk) !== 0) {
            foreach ($result_a_masuk as $a_masuk) { ?>
               <tr class="text-uppercase">
                  <td><?= $no++ ?></td>
                  <td class="text-left"><?= $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] ?></td>
                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }

                     $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

                     $tanggal = $m_tahun . '-' . $m_bulan . '-' . $i;
                     $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . $tanggal . "'");

                     if ($jadwal_libur) {
                        echo '<td style="background-color: #E5E7EB;">L</td>';
                     } else {
                        if ($nama_hari !== 'Sunday') {
                           if (!empty($a_masuk[$i])) {
                              $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$i]'");
                              if ($a_masukket['m_alasan'] == 'hadir') {
                                 echo '<td>H</td>';
                              } elseif ($a_masukket['m_alasan'] == 'izin') {
                                 echo '<td>I</td>';
                              } elseif ($a_masukket['m_alasan'] == 'sakit') {
                                 echo '<td>S</td>';
                              } elseif ($a_masukket['m_alasan'] == 'terlambat') {
                                 echo '<td>T</td>';
                              }
                           } else {
                              echo '<td></td>';
                           }
                        } else {
                           echo "<td style='background-color: #E5E7EB;'></td>";
                        }
                     }
                  } ?>
                  <?php if ($a_masuk['hadir']) { ?>
                     <td><?= $a_masuk['hadir'] ?></td>
                  <?php } else { ?>
                     <td>0</td>
                  <?php } ?>

                  <?php if ($a_masuk['izin']) { ?>
                     <td><?= $a_masuk['izin'] ?></td>
                  <?php } else { ?>
                     <td>0</td>
                  <?php } ?>

                  <?php if ($a_masuk['sakit']) { ?>
                     <td><?= $a_masuk['sakit'] ?></td>
                  <?php } else { ?>
                     <td>0</td>
                  <?php } ?>

                  <?php if ($a_masuk['terlambat']) { ?>
                     <td><?= $a_masuk['terlambat'] ?></td>
                  <?php } else { ?>
                     <td>0</td>
                  <?php } ?>
               </tr>
            <?php }
         } else { ?>
            <tr>
               <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
</div>

<div class="label-menu mt-5">
   absen pulang
</div>
<div class="table-responsive mt-4 overlay-scrollbars">
   <table class="table table-bordered table-hover">
      <thead>
         <tr>
            <th rowspan="2">No</th>
            <th rowspan="2" class="text-left" style="min-width: 350px;">Nama</th>
            <th colspan="<?= $jml_hari ?>">Tanggal</th>
            <th rowspan="2">Pulang</th>
         </tr>
         <tr>
            <?php
            for ($i = 1; $i <= $jml_hari; $i++) {
               if ($i < 10) {
                  $i = 0 . $i;
               }
               $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

               if ($nama_hari !== 'Sunday') {
                  echo "<th>$i</th>";
               } else {
                  echo "<th style='background-color: #E5E7EB;'>$i</th>";
               }
            } ?>
         </tr>
      </thead>
      <tbody>
         <?php
         $no = 1;
         if (mysqli_num_rows($result_a_pulang) !== 0) {
            foreach ($result_a_pulang as $a_pulang) { ?>
               <tr class="text-uppercase">
                  <td><?= $no++ ?></td>
                  <td class="text-left"><?= $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] ?></td>

                  <?php
                  for ($i = 1; $i <= $jml_hari; $i++) {
                     if ($i < 10) {
                        $i = 0 . $i;
                     }

                     $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

                     $tanggal = $m_tahun . '-' . $m_bulan . '-' . $i;
                     $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . $tanggal . "'");

                     if ($jadwal_libur) {
                        echo '<td style="background-color: #E5E7EB;">L</td>';
                     } else {
                        if ($nama_hari !== 'Sunday') {
                           if (!empty($a_pulang[$i])) {
                              $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$a_pulang[$i]'");
                              echo '<td>P</td>';
                           } else {
                              echo '<td></td>';
                           }
                        } else {
                           echo "<td style='background-color: #E5E7EB;'></td>";
                        }
                     }
                  } ?>
                  <?php if ($a_pulang['pulang']) { ?>
                     <td><?= $a_pulang['pulang'] ?></td>
                  <?php } else { ?>
                     <td>0</td>
                  <?php } ?>
               </tr>
            <?php }
         } else { ?>
            <tr>
               <td class="text-lowercase" colspan="<?= $jml_hari + 2 ?>">tidak ada data yang ditampilkan</td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
</div>

<table class="table2excel d-none" border="1">
   <tr>
      <th rowspan="2">No</th>
      <th rowspan="2">Nama</th>
      <th colspan="<?= $jml_hari ?>">Tanggal</th>
      <th rowspan="2">Hadir</th>
      <th rowspan="2">Izin</th>
      <th rowspan="2">Sakit</th>
      <th rowspan="2">Terlambat</th>
   </tr>
   <tr>
      <?php
      for ($i = 1; $i <= $jml_hari; $i++) {
         if ($i < 10) {
            $i = 0 . $i;
         }
         $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

         if ($nama_hari !== 'Sunday') {
            echo "<th>$i</th>";
         } else {
            echo "<th style='background-color: #E5E7EB;'>$i</th>";
         }
      } ?>
   </tr>
   <?php
   $no = 1;
   foreach ($result_a_masuk as $a_masuk) { ?>
      <tr>
         <td><?= $no++ ?></td>
         <td><?= $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] ?></td>
         <?php
         for ($i = 1; $i <= $jml_hari; $i++) {
            if ($i < 10) {
               $i = 0 . $i;
            }

            $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

            $tanggal = $m_tahun . '-' . $m_bulan . '-' . $i;
            $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . $tanggal . "'");

            if ($jadwal_libur) {
               echo '<td style="background-color: #E5E7EB;">L</td>';
            } else {
               if ($nama_hari !== 'Sunday') {
                  if (!empty($a_masuk[$i])) {
                     $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$i]'");
                     if ($a_masukket['m_alasan'] == 'hadir') {
                        echo '<td>H</td>';
                     } elseif ($a_masukket['m_alasan'] == 'izin') {
                        echo '<td>I</td>';
                     } elseif ($a_masukket['m_alasan'] == 'sakit') {
                        echo '<td>S</td>';
                     } elseif ($a_masukket['m_alasan'] == 'terlambat') {
                        echo '<td>T</td>';
                     }
                     echo '</td>';
                  } else {
                     echo '<td></td>';
                  }
               } else {
                  echo "<td style='background-color: #E5E7EB;'></td>";
               }
            }
         } ?>
         <?php if ($a_masuk['hadir']) { ?>
            <td><?= $a_masuk['hadir'] ?></td>
         <?php } else { ?>
            <td>0</td>
         <?php } ?>

         <?php if ($a_masuk['izin']) { ?>
            <td><?= $a_masuk['izin'] ?></td>
         <?php } else { ?>
            <td>0</td>
         <?php } ?>

         <?php if ($a_masuk['sakit']) { ?>
            <td><?= $a_masuk['sakit'] ?></td>
         <?php } else { ?>
            <td>0</td>
         <?php } ?>

         <?php if ($a_masuk['terlambat']) { ?>
            <td><?= $a_masuk['terlambat'] ?></td>
         <?php } else { ?>
            <td>0</td>
         <?php } ?>
      </tr>
   <?php } ?>
   <tr>
      <td></td>
   </tr>
   <tr>
      <th rowspan="2">No</th>
      <th rowspan="2">Nama</th>
      <th colspan="<?= $jml_hari ?>">Tanggal</th>
      <th rowspan="2">Pulang</th>
   </tr>
   <tr>
      <?php
      for ($i = 1; $i <= $jml_hari; $i++) {
         if ($i < 10) {
            $i = 0 . $i;
         }
         $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

         if ($nama_hari !== 'Sunday') {
            echo "<th>$i</th>";
         } else {
            echo "<th style='background-color: #E5E7EB;'>$i</th>";
         }
      } ?>
   </tr>
   <?php
   $no = 1;
   foreach ($result_a_pulang as $a_pulang) { ?>
      <tr>
         <td><?= $no++ ?></td>
         <td><?= $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] ?></td>

         <?php
         for ($i = 1; $i <= $jml_hari; $i++) {
            if ($i < 10) {
               $i = 0 . $i;
            }

            $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

            $tanggal = $m_tahun . '-' . $m_bulan . '-' . $i;
            $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . $tanggal . "'");

            if ($jadwal_libur) {
               echo '<td style="background-color: #E5E7EB;">L</td>';
            } else {
               if ($nama_hari !== 'Sunday') {
                  if (!empty($a_pulang[$i])) {
                     $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$a_pulang[$i]'");
                     echo '<td>P</td>';
                  } else {
                     echo '<td></td>';
                  }
               } else {
                  echo "<td style='background-color: #E5E7EB;'></td>";
               }
            }
         } ?>
         <?php if ($a_pulang['pulang']) { ?>
            <td><?= $a_pulang['pulang'] ?></td>
         <?php } else { ?>
            <td>0</td>
         <?php } ?>
      </tr>
   <?php } ?>
</table>

<script>
   $(function() {
      $('#click-export-excel').click(function() {
         var file_name = $(this).attr('data-file_name');
         $(".table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: file_name,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
         });
      });
   });

   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
</script>