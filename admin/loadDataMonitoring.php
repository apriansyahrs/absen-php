<?php
require "../config.php";
if ($_POST['what_monitoring'] == 'Siswa') {
   $token_kelas = $_POST['token_kelas'];
   $m_bulan_tahun = $_POST['m_bulan_tahun'];
   $tb_kelas = query("SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
   $tb_guru = query("SELECT nama,id_guru FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>

   <style>
      th,
      td {
         text-align: center;
      }
   </style>

   <div class="label-menu my-4">
      absen masuk siswa
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }

                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

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
         <tbody id="intervalAbsenMasukMonitoring"></tbody>
      </table>
   </div>
   <div class="label-menu my-5">
      absen pulang siswa
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }
                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

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
         <tbody id="intervalAbsenPulangMonitoring"></tbody>
      </table>
   </div>

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


   <script>
      intervalAbsenMasukMonitoring();
      intervalAbsenPulangMonitoring();

      setInterval(function() {
         intervalAbsenMasukMonitoring();
         intervalAbsenPulangMonitoring();
      }, 60000);

      function intervalAbsenMasukMonitoring() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenMasukMonitoring',
            data: {
               token_kelas: '<?= $token_kelas ?>',
               m_bulan_tahun: '<?= $m_bulan_tahun ?>'
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
               token_kelas: '<?= $token_kelas ?>',
               p_bulan_tahun: '<?= $m_bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenPulangMonitoring').html(data);
            }
         });
      }
   </script>
<?php } elseif ($_POST['what_monitoring'] == 'Guru') {

   $m_bulan_tahun = $_POST['m_bulan_tahun'];

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>

   <style>
      th,
      td {
         text-align: center;
      }
   </style>

   <div class="label-menu my-4">
      absen masuk guru
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }
                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

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
         <tbody id="intervalAbsenMasukMonitoringGuru"></tbody>
      </table>
   </div>
   <div class="label-menu my-5">
      absen pulang guru
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }
                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

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
         <tbody id="intervalAbsenPulangMonitoringGuru"></tbody>
      </table>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoAMasukGuru" tabindex="-1" role="dialog" aria-labelledby="modalInfoAMasukGuruLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN MASUK</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoAMasukGuru"></div>
         </div>
      </div>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoPulangGuru" tabindex="-1" role="dialog" aria-labelledby="modalInfoPulangGuruLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN PULANG</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoPulangGuru"></div>
         </div>
      </div>
   </div>


   <script>
      intervalAbsenMasukMonitoringGuru();
      intervalAbsenPulangMonitoringGuru();

      setInterval(function() {
         intervalAbsenMasukMonitoringGuru();
         intervalAbsenPulangMonitoringGuru();
      }, 60000);

      function intervalAbsenMasukMonitoringGuru() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenMasukMonitoringGuru',
            data: {
               m_bulan_tahun: '<?= $m_bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenMasukMonitoringGuru').html(data);
            }
         });
      }

      function intervalAbsenPulangMonitoringGuru() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenPulangMonitoringGuru',
            data: {
               p_bulan_tahun: '<?= $m_bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenPulangMonitoringGuru').html(data);
            }
         });
      }
   </script>


<?php } elseif ($_POST['what_monitoring'] == 'Karyawan') {
   $m_bulan_tahun = $_POST['m_bulan_tahun'];

   $m_bulan = explode('-', $m_bulan_tahun)[0];
   $m_tahun = explode('-', $m_bulan_tahun)[1];
   $jml_hari = jml_hari($m_bulan, $m_tahun); ?>

   <style>
      th,
      td {
         text-align: center;
      }
   </style>

   <div class="label-menu my-4">
      absen masuk karyawan
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <th rowspan="2" class="text-left first">Jabatan</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }
                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

                  echo "<th class='first-next'>$i</th>";

                //   if ($nama_hari !== 'Sunday') {
                //      echo "<th class='first-next'>$i</th>";
                //   } else {
                //      echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                //   }
               } ?>
            </tr>
            <!-- <tr>
            </tr> -->
         </thead>
         <tbody id="intervalAbsenMasukMonitoringKaryawan"></tbody>
      </table>
   </div>
   <div class="label-menu my-5">
      absen pulang karyawan
   </div>
   <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars mt-3">
      <table class="table table-bordered table-hover sticky-first-column">
         <thead>
            <tr>
               <!-- <th rowspan="2">No</th> -->
               <th rowspan="2" class="text-left first">Nama</th>
               <th rowspan="2" class="text-left first">Jabatan</th>
               <!-- <th colspan="<?= $jml_hari ?>">Tanggal</th> -->
               <?php
               for ($i = 1; $i <= $jml_hari; $i++) {
                  if ($i < 10) {
                     $i = 0 . $i;
                  }
                  $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

                  echo "<th class='first-next'>$i</th>";
                //   if ($nama_hari !== 'Sunday') {
                //      echo "<th class='first-next'>$i</th>";
                //   } else {
                //      echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                //   }
               } ?>
            </tr>
            <!-- <tr>
            </tr> -->
         </thead>
         <tbody id="intervalAbsenPulangMonitoringKaryawan"></tbody>
      </table>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoAMasukKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalInfoAMasukKaryawanLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN MASUK</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoAMasukKaryawan"></div>
         </div>
      </div>
   </div>

   <div class="modal fade animated zoomIn" id="modalInfoPulangKaryawan" tabindex="-1" role="dialog" aria-labelledby="modalInfoPulangKaryawanLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">INFO ABSEN PULANG</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden" id="loadInfoPulangKaryawan"></div>
         </div>
      </div>
   </div>


   <script>
      intervalAbsenMasukMonitoringKaryawan();
      intervalAbsenPulangMonitoringKaryawan();

      setInterval(function() {
         intervalAbsenMasukMonitoringKaryawan();
         intervalAbsenPulangMonitoringKaryawan();
      }, 60000);

      function intervalAbsenMasukMonitoringKaryawan() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenMasukMonitoringKaryawan',
            data: {
               m_bulan_tahun: '<?= $m_bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenMasukMonitoringKaryawan').html(data);
            }
         });
      }

      function intervalAbsenPulangMonitoringKaryawan() {
         $.ajax({
            type: 'post',
            url: 'intervalAbsenPulangMonitoringKaryawan',
            data: {
               p_bulan_tahun: '<?= $m_bulan_tahun ?>'
            },
            success: function(data) {
               $('#intervalAbsenPulangMonitoringKaryawan').html(data);
            }
         });
      }
   </script>

<?php } ?>

<script>
   $('[data-tooltip="tooltip"]').tooltip();

   $('.overlay-scrollbars').overlayScrollbars({
      className: "os-theme-dark",
      scrollbars: {
         autoHide: 'l',
         autoHideDelay: 0
      }
   });
</script>
