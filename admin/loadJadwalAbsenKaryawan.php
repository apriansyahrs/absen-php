<?php
require "../config.php";
$j_karyawan = query("SELECT * FROM j_karyawan LIMIT 1");
$masuk_mulai = $j_karyawan['masuk_mulai'];
$masuk_akhir = $j_karyawan['masuk_akhir'];
$pulang_mulai = $j_karyawan['pulang_mulai'];
$pulang_akhir = $j_karyawan['pulang_akhir'];
$pulang_mulai_jumat = $j_karyawan['pulang_mulai_jumat'];
$pulang_akhir_jumat = $j_karyawan['pulang_akhir_jumat'];
?>

<div class="row">
   <div class="col-md-6">
      <div class="form-group">
         <label for="masuk_mulai">Masuk mulai</label>
         <input type="time" name="masuk_mulai" id="masuk_mulai" class="form-control form-control4"
            value="<?= $masuk_mulai ?>" required>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label for="masuk_akhir">Masuk akhir</label>
         <input type="time" name="masuk_akhir" id="masuk_akhir" class="form-control form-control4"
            value="<?= $masuk_akhir ?>" required>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label for="pulang_mulai">Pulang mulai</label>
         <input type="time" name="pulang_mulai" id="pulang_mulai" class="form-control form-control4"
            value="<?= $pulang_mulai ?>" required>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label for="pulang_akhir">Pulang akhir</label>
         <input type="time" name="pulang_akhir" id="pulang_akhir" class="form-control form-control4"
            value="<?= $pulang_akhir ?>" required>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label for="pulang_mulai_jumat">Pulang mulai (Jumat)</label>
         <input type="time" name="pulang_mulai_jumat" id="pulang_mulai_jumat" class="form-control form-control4"
            value="<?= $pulang_mulai_jumat ?>" required>
      </div>
   </div>
   <div class="col-md-6">
      <div class="form-group">
         <label for="pulang_akhir_jumat">Pulang akhir (Jumat)</label>
         <input type="time" name="pulang_akhir_jumat" id="pulang_akhir_jumat" class="form-control form-control4"
            value="<?= $pulang_akhir_jumat ?>" required>
      </div>
   </div>
</div>

<script>
   $('.menit').html('<option value="">Menit</option>');
   for (i = 0; i <= 59; i++) {
      var i = i < 10 ? '0' + i : i;
      $('.menit').append('<option>' + i + '</option>');
   }


   $('#masuk_mulai_jam').change(function() {
      var data = $(this).val();
      $('#data_masuk_mulai_jam').html(data);

      $('#masuk_akhir_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#masuk_akhir_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_masuk_akhir_jam').html('--');
      $('#data_pulang_mulai_jam').html('--');
      $('#data_pulang_akhir_jam').html('--');
      $('#pulang_mulai_jam').html('<option value="">Jam</option>');
      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
   });

   $('#masuk_mulai_menit').change(function() {
      var data = $('#data_masuk_mulai_menit').html($(this).val());
   });

   $('#masuk_akhir_jam').change(function() {
      var data = $(this).val();
      $('#data_masuk_akhir_jam').html(data);

      $('#pulang_mulai_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#pulang_mulai_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_pulang_akhir_jam').html('--');
      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
   });

   $('#masuk_akhir_menit').change(function() {
      var data = $('#data_masuk_akhir_menit').html($(this).val());
   });


   $('#pulang_mulai_jam').change(function() {
      var data = $(this).val();
      $('#data_pulang_mulai_jam').html(data);

      $('#pulang_akhir_jam').html('<option value="">Jam</option>');
      for (i = 0; i <= 23; i++) {
         var i = i < 10 ? '0' + i : i;
         if (data <= i) {
            $('#pulang_akhir_jam').append('<option>' + i + '</option>');
         }
      }
      $('#data_pulang_akhir_jam').html('--');
   });

   $('#pulang_mulai_menit').change(function() {
      var data = $('#data_pulang_mulai_menit').html($(this).val());
   });

   $('#pulang_akhir_jam').change(function() {
      var data = $('#data_pulang_akhir_jam').html($(this).val());
   });

   $('#pulang_akhir_menit').change(function() {
      var data = $('#data_pulang_akhir_menit').html($(this).val());
   });
</script>