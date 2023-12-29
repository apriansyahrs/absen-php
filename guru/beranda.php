<div class="content-title">Beranda</div>
<div class="row beranda">
   <div class="col-md-6 col-lg-3">
      <div class="card" style="background: #57A4FF;">
         <div class="py-3 px-4">
            <p class="title">Kelas kamu</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-building"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     require "../config.php";
                     $id_guru = $tb_guru['id_guru'];
                     $jml_kelas = num_rows("SELECT id_guru FROM tb_kelas WHERE id_guru = '$id_guru'");
                     if ($jml_kelas < 10 && $jml_kelas !== 0) {
                        echo '0' . $jml_kelas;
                     } else {
                        echo $jml_kelas;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="card" style="background: #41DBBC;">
         <div class="py-3 px-4">
            <p class="title">Siswa kamu</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-user"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $jml_siswa = num_rows("SELECT id_guru FROM tb_siswa WHERE id_guru = '$id_guru'");
                     if ($jml_siswa < 10 && $jml_siswa !== 0) {
                        echo '0' . $jml_siswa;
                     } else {
                        echo $jml_siswa;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="card" style="background: #FFC36E;">
         <div class="py-3 px-4">
            <p class="title">Absen masuk hari ini</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-calendar-check"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $m_tanggal = date('d');
                     $m_bulan_tahun = date('m-Y');
                     $jml_masuk = num_rows("SELECT id_guru,m_tanggal,m_bulan_tahun FROM a_masuk WHERE id_guru = '$id_guru' && m_tanggal = '$m_tanggal' && m_bulan_tahun = '$m_bulan_tahun'");
                     if ($jml_masuk < 10 && $jml_masuk !== 0) {
                        echo '0' . $jml_masuk;
                     } else {
                        echo $jml_masuk;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-3">
      <div class="card" style="background: #FF6881;">
         <div class="py-3 px-4">
            <p class="title">Absen pulang hari ini</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-calendar-times"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $jml_pulang = num_rows("SELECT id_guru,p_tanggal,p_bulan_tahun FROM a_pulang WHERE id_guru = '$id_guru' && p_tanggal = '$m_tanggal' && p_bulan_tahun = '$m_bulan_tahun'");
                     if ($jml_pulang < 10 && $jml_pulang !== 0) {
                        echo '0' . $jml_pulang;
                     } else {
                        echo $jml_pulang;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="row">
   <div class="col-md-12 mt-2">
      <div class="card">
         <div class="card-body">
            <div id="calendar" style="color: #1e3056"></div>
         </div>
      </div>
   </div>
</div>

<?php if (isset($_GET['welcome'])) { ?>
   <script>
      pesan('Selamat datang <?= $tb_guru['nama'] ?>', 3000);
   </script>
<?php } ?>


<script>
   $(function() {
      var Calendar = FullCalendar.Calendar;
      calendarEl = document.getElementById('calendar');
      calendar = new Calendar(calendarEl, {
         plugins: ['dayGrid'],
         header: {
            left: 'prev',
            center: 'title',
            right: 'next'
         }
      });
      calendar.render();
   });
</script>