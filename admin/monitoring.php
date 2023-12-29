<?php require "../config.php";
$result_a_masuk_siswa = mysqli_query($conn, "SELECT * FROM a_masuk");
$result_a_masuk_guru = mysqli_query($conn, "SELECT * FROM a_masuk_guru");
$result_a_masuk_karyawan = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan");
if (mysqli_num_rows($result_a_masuk_siswa) == 0 && mysqli_num_rows($result_a_masuk_guru) == 0 && mysqli_num_rows($result_a_masuk_karyawan) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
      </div>
   </div>
<?php } else { ?>
   <div class="card">
      <div class="p-3">
         <form id="formFilterMonitoring">
            <div class="row">
               <div class="col-12 col-md-3 col-lg-3 my-2">
                  <select name="what_monitoring" id="what_monitoring" class="custom-select" required>
                     <option value=""></option>
                     <option>Siswa</option>
                     <option>Guru</option>
                     <option>Karyawan</option>
                  </select>
               </div>
               <div class="col-12 col-md-3 col-lg-3 my-2">
                  <select name="token_kelas" id="token_kelas" class="custom-select" required disabled="disabled">
                     <option value=""></option>
                  </select>
               </div>
               <div class="col-12 col-md-3 col-lg-3 my-2">
                  <select name="m_bulan_tahun" id="m_bulan_tahun" class="custom-select" required disabled="disabled">
                     <option value=""></option>
                  </select>
               </div>
               <div class="col-12 col-md-3 col-lg-3 my-2">
                  <button type="submit" class="btn btn-primary btn-lg btn-block">
                     <i class="fa fa-filter fa-fw"></i> Filter
                  </button>
               </div>
            </div>
         </form>
         <div id="cont-rekap-absen">
            <div class="row d-flex justify-content-center text-center">
               <div class="col-md-4 my-5">
                  <img src="<?= base_url() ?>/assets/img/undraw_filter_4kje.svg" alt="gambar" class="img-fluid">
                  <p class="my-3" style="color: #27385D;">Filter data yang akan ditampilkan!</p>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script>
      $('#formFilterMonitoring').submit(function(e) {
         $('#cont-rekap-absen').html('<div class="text-center my-5"><div class="spinner-border spinner-border-lg text-primary" role="status"></div><p class="my-2" style="color: #27385D;">Tunggu sebentar</p></div>');
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'loadDataMonitoring',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               $('#cont-rekap-absen').html(data);
            }
         })
      });

      $('.overlay-scrollbars').overlayScrollbars({
         className: "os-theme-dark",
         scrollbars: {
            autoHide: 'l',
            autoHideDelay: 0
         }
      });

      $('#token_kelas').change(function() {
         token_kelas = $(this).val();
         $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
         $.ajax({
            type: 'post',
            url: '../guru/change-data',
            data: {
               change_rekap: true,
               token_kelas: token_kelas
            },
            success: function(data) {
               if (data !== '') {
                  $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
                  $('#m_bulan_tahun').html(data);
               }
            }
         })
      });

      $('#what_monitoring').change(function() {
         var val = $(this).val();
         if (val == 'Siswa') {
            $('#token_kelas').removeAttr('disabled', 'disabled');
            $('#m_bulan_tahun').attr('disabled', 'disabled');

            $.ajax({
               type: 'post',
               url: '../guru/change-data',
               data: {
                  what_rekap: val,
               },
               success: function(data) {
                  if (data !== '') {
                     $('#token_kelas').removeAttr('disabled', 'disabled');
                     $('#token_kelas').html(data);
                  }
               }
            })
         } else {
            $('#token_kelas').attr('disabled', 'disabled');
            $('#token_kelas').html('<option val=""></option>');
            $('#m_bulan_tahun').removeAttr('disabled', 'disabled');

            $.ajax({
               type: 'post',
               url: '../guru/change-data',
               data: {
                  what_rekap: val,
               },
               success: function(data) {
                  if (data !== '') {
                     $('#m_bulan_tahun').removeAttr('disabled', 'disabled');
                     $('#m_bulan_tahun').html(data);
                  }
               }
            })
         }
      })

      $('#what_monitoring').select2({
         theme: 'bootstrap4',
         placeholder: '-- pilih --'
      });

      $('#token_kelas').select2({
         theme: 'bootstrap4',
         placeholder: '-- pilih --'
      });

      $('#m_bulan_tahun').select2({
         theme: 'bootstrap4',
         placeholder: '-- pilih --'
      });
   </script>

<?php } ?>