<?php require "../config.php"; ?>
<h4 class="mb-3">Beranda</h4>
<div class="row beranda">
   <div class="col-md-6 col-lg-4">
      <div class="card" style="background: #57A4FF;">
         <div class="py-3 px-4">
            <p class="title">Kelas keseluruhan</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-building"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $jml_kelas = num_rows("SELECT id_kelas FROM tb_kelas");
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
   <div class="col-md-6 col-lg-4">
      <div class="card" style="background: #41DBBC;">
         <div class="py-3 px-4">
            <p class="title">Siswa keseluruhan</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="far fa-user"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $jml_siswa = num_rows("SELECT id_siswa FROM tb_siswa");
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
   <div class="col-md-6 col-lg-4">
      <div class="card" style="background: #FFC36E;">
         <div class="py-3 px-4">
            <p class="title">Guru keseluruhan</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="fa fa-chalkboard-teacher"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $jml_guru = num_rows("SELECT id_guru FROM tb_guru");
                     if ($jml_guru < 10 && $jml_guru !== 0) {
                        echo '0' . $jml_guru;
                     } else {
                        echo $jml_guru;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-4">
      <div class="card" style="background: #57A4FF;">
         <div class="py-3 px-4">
            <p class="title">Karyawan keseluruhan</p>
            <div class="row">
               <div class="col-5 my-auto">
                  <div class="icon">
                     <i class="fa fa-users"></i>
                  </div>
               </div>
               <div class="col-7 my-auto">
                  <div class="total">
                     <?php
                     $m_tanggal = date('d');
                     $m_bulan_tahun = date('m-Y');
                     $jml_karyawan = num_rows("SELECT id_karyawan FROM tb_karyawan");
                     if ($jml_karyawan < 10 && $jml_karyawan !== 0) {
                        echo '0' . $jml_karyawan;
                     } else {
                        echo $jml_karyawan;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-4">
      <div class="card" style="background: #41DBBC;">
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
                     $jml_masuk_siswa = num_rows("SELECT m_tanggal,m_bulan_tahun FROM a_masuk WHERE m_tanggal = '$m_tanggal' && m_bulan_tahun = '$m_bulan_tahun'");
                     $jml_masuk_guru = num_rows("SELECT m_tanggal,m_bulan_tahun FROM a_masuk_guru WHERE m_tanggal = '$m_tanggal' && m_bulan_tahun = '$m_bulan_tahun'");
                     $jml_masuk_karyawan = num_rows("SELECT m_tanggal,m_bulan_tahun FROM a_masuk_karyawan WHERE m_tanggal = '$m_tanggal' && m_bulan_tahun = '$m_bulan_tahun'");
                     $jml = $jml_masuk_siswa + $jml_masuk_guru + $jml_masuk_karyawan;
                     if ($jml < 10 && $jml !== 0) {
                        echo '0' . $jml;
                     } else {
                        echo $jml;
                     } ?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="col-md-6 col-lg-4">
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
                     $p_tanggal = date('d');
                     $p_bulan_tahun = date('m-Y');
                     $jml_pulang_siswa = num_rows("SELECT p_tanggal,p_bulan_tahun FROM a_pulang WHERE p_tanggal = '$p_tanggal' && p_bulan_tahun = '$p_bulan_tahun'");
                     $jml_pulang_guru = num_rows("SELECT p_tanggal,p_bulan_tahun FROM a_pulang_guru WHERE p_tanggal = '$p_tanggal' && p_bulan_tahun = '$p_bulan_tahun'");
                     $jml_pulang_karyawan = num_rows("SELECT p_tanggal,p_bulan_tahun FROM a_pulang_karyawan WHERE p_tanggal = '$p_tanggal' && p_bulan_tahun = '$p_bulan_tahun'");
                     $jml = $jml_pulang_siswa + $jml_pulang_guru + $jml_pulang_karyawan;
                     if ($jml < 10 && $jml !== 0) {
                        echo '0' . $jml;
                     } else {
                        echo $jml;
                     } ?>
                  </div>
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