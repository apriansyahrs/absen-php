<?php require "../config.php"; ?>
<h4 class="mb-3">Tambah siswa</h4>
<div class="card">
   <div class="card-header">
      <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
         <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
      </button>
   </div>
   <form id="formTambahSiswa">
      <div class="card-body">
         <div class="row">
            <div class="col-md-6">
               <div class="form-group">
                  <select name="id_guru" id="id_guru" class="custom-select" required>
                     <option value=""></option>
                     <?php
                     $result = mysqli_query($conn, "SELECT id_guru,nip,nama FROM tb_guru");
                     foreach ($result as $tb_guru) {
                        echo "<option value='$tb_guru[id_guru]'>$tb_guru[nip] - $tb_guru[nama]</option>";
                     } ?>
                  </select>
               </div>
               <div class="form-group">
                  <select name="token_kelas" id="token_kelas" class="custom-select" required></select>
               </div>
               <div class="form-group">
                  <input type="number" name="nis" id="nis" class="form-control form-control4" placeholder="NIS siswa" required>
               </div>
               <div class="form-group">
                  <input type="text" name="nama_depan" id="nama_depan" class="form-control form-control4" placeholder="Nama Depan" required>
               </div>
               <div class="form-group">
                  <input type="text" name="nama_belakang" id="nama_belakang" class="form-control form-control4" placeholder="Nama Belakang">
               </div>
               <div class="form-group">
                  <input type="number" name="telegram" id="telegram" class="form-control form-control4" placeholder="Telegram (628)">
               </div>
               <div class="form-group">
                  <label class="btn btn-radio active">Laki-laki
                     <input type="radio" class="d-none" name="jk" value="Laki-laki" checked="checked">
                  </label>
                  <label class="btn btn-radio">Perempuan
                     <input type="radio" class="d-none" name="jk" value="Perempuan">
                  </label>
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <select name="provinsi" id="provinsi" class="custom-select">
                     <option value=""></option>
                     <?php
                     $result = mysqli_query($conn, "SELECT * FROM w_provinces ORDER BY name ASC");
                     while ($w_provinsi = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $w_provinsi['id'] . '">' . $w_provinsi['name'] . '</option>';
                     } ?>
                  </select>
               </div>
               <div class="form-group">
                  <select name="kota" id="kota" class="custom-select">
                     <option value=""></option>
                  </select>
               </div>
               <div class="form-group">
                  <select name="kecamatan" id="kecamatan" class="custom-select">
                     <option value=""></option>
                  </select>
               </div>
               <div class="form-group">
                  <select name="kelurahan" id="kelurahan" class="custom-select">
                     <option value=""></option>
                  </select>
               </div>
            </div>
            <div class="col-md-12">
               <h5>Orang tua</h5>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <?php
                  $username_ortu = substr(str_shuffle(time() . time()), 0, 8);
                  if (num_rows("SELECT username_ortu FROM tb_siswa WHERE username_ortu = '$username_ortu'") >= 1) {
                     $username_ortu = substr(str_shuffle(time() . time()), 0, 8);
                  } ?>
                  <input type="text" name="username_ortu" id="username_ortu" class="form-control form-control4" value="<?= $username_ortu ?>" readonly>
               </div>
               <div class="form-group">
                  <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control4" placeholder="Nama Ayah">
               </div>
               <div class="form-group">
                  <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control form-control4" placeholder="Pekerjaan Ayah">
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control4" placeholder="Nama Ibu">
               </div>
               <div class="form-group">
                  <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control form-control4" placeholder="Pekerjaan Ibu">
               </div>
               <div class="form-group">
                  <input type="number" name="telepon_rumah" id="telepon_rumah" class="form-control form-control4" placeholder="Telepon rumah">
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

<script>
   $('.kembali').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Siswa', 'Siswa', '?menu=siswa');
      $('#content').load('siswa');
   });

   $('#formTambahSiswa').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?tambah_siswa',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               document.getElementById('formTambahSiswa').reset();
            } else if (data == 'tidak tersedia') {
               pesan('NIS tidak tersedia!', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('.btn-radio').click(function() {
      $('.btn-radio.active').removeClass('active');
      $(this).addClass('active');
   });

   function select(id, placeholder) {
      $('#' + id).select2({
         theme: 'bootstrap4',
         placeholder: placeholder
      });
   }

   select('id_guru', 'Pilih Guru');
   select('token_kelas', 'Pilih Kelas');
   select('provinsi', 'Pilih Provinsi');
   select('kota', 'Pilih Kota/Kabupaten');
   select('kecamatan', 'Pilih Kecamatan');
   select('kelurahan', 'Pilih Kelurahan');

   $('#id_guru').change(function() {
      var id_guru = $(this).val();
      $.ajax({
         type: 'post',
         url: '../guru/change-data?change_token_kelas_admin',
         data: 'id_guru=' + id_guru,
         dataType: 'html',
         success: function(data) {
            $('select#token_kelas').html(data);
         }
      });
   });

   $('#provinsi').change(function() {
      var id_provinces = $(this).val();
      $.ajax({
         type: 'post',
         url: '../guru/change-data?jenis=kota',
         data: 'id_provinces=' + id_provinces,
         dataType: 'html',
         success: function(data) {
            $('select#kota').html(data);
            ajaxKota();
         }
      });
   });

   $('#kota').change(ajaxKota);

   function ajaxKota() {
      var id_regencies = $('#kota').val();
      $.ajax({
         type: 'post',
         url: '../guru/change-data?jenis=kecamatan',
         data: 'id_regencies=' + id_regencies,
         dataType: 'html',
         success: function(data) {
            $('select#kecamatan').html(data);
            ajaxKecamatan();
         }
      });
   }

   $('#kecamatan').change(ajaxKecamatan);

   function ajaxKecamatan() {
      var id_district = $('#kecamatan').val();
      $.ajax({
         type: 'post',
         url: '../guru/change-data?jenis=kelurahan',
         data: 'id_district=' + id_district,
         dataType: 'html',
         success: function(data) {
            $('select#kelurahan').html(data);
         }
      });
   }
</script>