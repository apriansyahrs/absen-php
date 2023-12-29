<?php require "../config.php"; ?>
<h4 class="mb-3">Buat kelas</h4>
<div class="row d-flex justify-content-center">
   <div class="col-lg-6">
      <div class="card">
         <div class="card-header">
            <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
               <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
            </button>
         </div>
         <form id="formBuatKelas">
            <div class="card-body">
               <div class="form-group">
                  <label for="id_guru">Pilih guru <span></span></label>
                  <select name="id_guru" id="id_guru" class="custom-select" required>
                     <option value=""></option>
                     <?php
                     $result = mysqli_query($conn, "SELECT id_guru,nip,nama FROM tb_guru");
                     foreach ($result as $tb_guru) {
                        echo '<option value="' . $tb_guru['id_guru'] . '">' . $tb_guru['nip'] . ' - ' . $tb_guru['nama'] . '</option>';
                     } ?>
                  </select>
               </div>
               <div class="form-group">
                  <label for="kelompok_kelas">Kelompok kelas <span></span></label>
                  <input type="text" name="kelompok_kelas" id="kelompok_kelas" class="form-control form-control4" placeholder="Contoh: X" required>
               </div>
               <div class="form-group">
                  <label for="kelas">Nama kelas <span></span></label>
                  <input type="text" name="kelas" id="kelas" class="form-control form-control4" placeholder="Contoh: X TKJ" required>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="masuk_mulai">Masuk mulai</label>
                        <input type="time" name="masuk_mulai" id="masuk_mulai" class="form-control form-control4" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="masuk_akhir">Masuk akhir</label>
                        <input type="time" name="masuk_akhir" id="masuk_akhir" class="form-control form-control4" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="pulang_mulai">Pulang mulai</label>
                        <input type="time" name="pulang_mulai" id="pulang_mulai" class="form-control form-control4" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="pulang_akhir">Pulang akhir</label>
                        <input type="time" name="pulang_akhir" id="pulang_akhir" class="form-control form-control4" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="pulang_mulai_jumat">Pulang mulai (Jumat)</label>
                        <input type="time" name="pulang_mulai_jumat" id="pulang_mulai_jumat" class="form-control form-control4" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="pulang_akhir_jumat">Pulang akhir (Jumat)</label>
                        <input type="time" name="pulang_akhir_jumat" id="pulang_akhir_jumat" class="form-control form-control4" required>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-footer text-right">
               <button type="submit" class="btn btn-linear-primary waves-effect waves-light">
                  Simpan
               </button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   $('#formBuatKelas').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?tambah_kelas',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               history.pushState('Kelas', 'Kelas', '?menu=kelas');
               $('#content').load('kelas');
               $('html, body').animate({
                  scrollTop: '0'
               }, 200);
               pesan('Data berhasil disimpan', 3000);
            } else if (data == 'tidak tersedia') {
               pesan('Kelas kamu tidak tersedia', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('.kembali').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Kelas', 'Kelas', '?menu=kelas');
      $('#content').load('kelas');
   });

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

   $('#id_guru').select2({
      theme: 'bootstrap4',
      placeholder: 'Pilih guru'
   });
</script>