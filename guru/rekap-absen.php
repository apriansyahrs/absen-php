<?php require "../config.php"; ?>
<div class="content-title">
   Rekap absen
</div>
<div class="card">
   <div class="card-body">
      <form id="formFilterRekap">
         <div class="row">
            <div class="col-12 col-md-4 col-lg-4 my-2">
               <select name="token_kelas" id="token_kelas" class="custom-select" required>
                  <option value=""></option>
                  <?php
                  $result = mysqli_query($conn, "SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE id_guru = '$_SESSION[guru]'");
                  foreach ($result as $tb_kelas) {
                     echo "<option value='$tb_kelas[token_kelas]'>$tb_kelas[kelas]</option>";
                  } ?>
               </select>
            </div>
            <div class="col-12 col-md-4 col-lg-4 my-2">
               <select name="m_bulan_tahun" id="m_bulan_tahun" class="custom-select" required>
                  <option value=""></option>
               </select>
            </div>
            <div class="col-12 col-md-4 col-lg-4 my-2">
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
               <p class="my-3" style="color: #27385D;">Filter kelas dan bulan yang akan ditampilkan!</p>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $('#formFilterRekap').submit(function(e) {
      $('#cont-rekap-absen').html('<div class="text-center my-5"><div class="spinner-border spinner-border-lg text-primary" role="status"></div><p class="my-2" style="color: #27385D;">Tunggu sebentar</p></div>');
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'loadDataRekapAbsen.php',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            $('#cont-rekap-absen').html(data);
         }
      })
   })

   $('#token_kelas').change(function() {
      token_kelas = $(this).val();
      $.ajax({
         type: 'post',
         url: 'change-data',
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

   $('#token_kelas').select2({
      theme: 'bootstrap4',
      placeholder: 'Pilih kelas'
   });

   $('#m_bulan_tahun').select2({
      theme: 'bootstrap4',
      placeholder: 'Pilih bulan'
   });
</script>