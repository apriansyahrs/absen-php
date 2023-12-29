<?php require "../config.php"; ?>

<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h5 class="text-center">Setelan</h5>
         </div>
         <div class="card-body">
            <form id="formSetelan">
               <div class="form-group">
                  <label for="nama">Nama aplikasi <span></span></label>
                  <input type="text" name="nama" id="nama" class="form-control form-control2" value="<?= $tb_setelan['nama'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="base_url">Base URL <span></span></label>
                  <input type="text" name="base_url" id="base_url" class="form-control form-control2" value="<?= base_url() ?>" required>
               </div>
               <div class="form-group">
                  <label for="chat_id_group">Chat ID Group <span></span></label>
                  <input type="text" name="chat_id_group" id="chat_id_group" class="form-control form-control2" value="<?= $tb_setelan['chat_id_group'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="token_bot">Token Bot <span></span></label>
                  <input type="text" name="token_bot" id="token_bot" class="form-control form-control2" value="<?= $tb_setelan['token_bot'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="url_telegram_group">URL Telegram Group <span></span></label>
                  <input type="text" name="url_telegram_group" id="url_telegram_group" class="form-control form-control2" value="<?= $tb_setelan['url_telegram_group'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="api_maps">API Google Maps <span></span></label>
                  <input type="text" name="api_maps" id="api_maps" class="form-control form-control2" value="<?= $tb_setelan['api_maps'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="latitude_instansi">Latitude Instansi <span></span></label>
                  <input type="text" name="latitude_instansi" id="latitude_instansi" class="form-control form-control2" value="<?= $tb_setelan['latitude_instansi'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="longitude_instansi">Longitude Instansi <span></span></label>
                  <input type="text" name="longitude_instansi" id="longitude_instansi" class="form-control form-control2" value="<?= $tb_setelan['longitude_instansi'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="radius_meter">Radius (meter) <span></span></label>
                  <input type="number" name="radius_meter" id="radius_meter" class="form-control form-control2" value="<?= $tb_setelan['radius_meter'] ?>" required>
               </div>
               <div class="form-group">
                  <div class="custom-control custom-switch">
                     <input type="hidden" name="hadir_radius" id="hadir_radius" value="<?= $tb_setelan['hadir_radius'] ?>">
                     <input type="checkbox" class="custom-control-input" id="checkbox_hadir_radius" <?php if ($tb_setelan['hadir_radius'] == 1) {
                                                                                                               echo 'checked';
                                                                                                            } ?>>
                     <label class="custom-control-label" for="checkbox_hadir_radius">Aktifkan validasi radius lokasi jika absen Hadir</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="custom-control custom-switch">
                     <input type="hidden" name="izin_radius" id="izin_radius" value="<?= $tb_setelan['izin_radius'] ?>">
                     <input type="checkbox" class="custom-control-input" id="checkbox_izin_radius" <?php if ($tb_setelan['izin_radius'] == 1) {
                                                                                                               echo 'checked';
                                                                                                            } ?>>
                     <label class="custom-control-label" for="checkbox_izin_radius">Aktifkan validasi radius lokasi jika absen Izin</label>
                  </div>
               </div>
               <div class="form-group">
                  <div class="custom-control custom-switch">
                     <input type="hidden" name="sakit_radius" id="sakit_radius" value="<?= $tb_setelan['sakit_radius'] ?>">
                     <input type="checkbox" class="custom-control-input" id="checkbox_sakit_radius" <?php if ($tb_setelan['sakit_radius'] == 1) {
                                                                                                               echo 'checked';
                                                                                                            } ?>>
                     <label class="custom-control-label" for="checkbox_sakit_radius">Aktifkan validasi radius lokasi jika absen Sakit</label>
                  </div>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                     Simpan
                  </button>
               </div>
            </form>
         </div>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <h5 class="text-center">Ubah password</h5>
         </div>
         <div class="card-body">
            <form id="formAdmin">
               <div class="form-group">
                  <label for="username">Username <span></span></label>
                  <input type="text" name="username" id="username" class="form-control form-control2" value="<?= $tb_admin['username'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="password_lama">Password lama <span></span></label>
                  <input type="password" name="password_lama" id="password_lama" class="form-control form-control2" placeholder="*****" required>
               </div>
               <div class="row">
                  <div class="col-md-6 pr-md-2">
                     <div class="form-group">
                        <label for="password1">Password baru <span></span></label>
                        <input type="password" name="password1" id="password1" class="form-control form-control2" placeholder="*****" required>
                     </div>
                  </div>
                  <div class="col-md-6 pl-md-2">
                     <div class="form-group">
                        <label for="password2">Konfirmasi <span></span></label>
                        <input type="password" name="password2" id="password2" class="form-control form-control2" placeholder="*****" required>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light">
                     Simpan
                  </button>
               </div>
            </form>
         </div>
      </div>
      
      <button type="button" class="btn btn-linear-primary waves-effect waves-light mb-3" id="hapus-data-absen-siswa">Hapus Data Absen Siswa</button>
      <button type="button" class="btn btn-linear-primary waves-effect waves-light mb-3" id="hapus-data-absen-guru">Hapus Data Absen Guru</button>
      <button type="button" class="btn btn-linear-primary waves-effect waves-light mb-3" id="hapus-data-absen-karyawan">Hapus Data Absen Karyawan</button>
      <button type="button" class="btn btn-linear-primary waves-effect waves-light mb-3" id="hapus-data-kegiatan-guru">Hapus Data Kegiatan Guru</button>
      <button type="button" class="btn btn-linear-primary waves-effect waves-light mb-3" id="hapus-semua-data">Hapus Semua Data</button>
      
   </div>
</div>

<script>
    $('#checkbox_hadir_radius').click(function() {
      if ($(this).prop("checked") == true) {
         $('#hadir_radius').val('1');
      } else if ($(this).prop("checked") == false) {
         $('#hadir_radius').val('0');
      }
   });
   
   $('#checkbox_izin_radius').click(function() {
      if ($(this).prop("checked") == true) {
         $('#izin_radius').val('1');
      } else if ($(this).prop("checked") == false) {
         $('#izin_radius').val('0');
      }
   });
   
   $('#checkbox_sakit_radius').click(function() {
      if ($(this).prop("checked") == true) {
         $('#sakit_radius').val('1');
      } else if ($(this).prop("checked") == false) {
         $('#sakit_radius').val('0');
      }
   });
   
   $('#formSetelan').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: '../guru/aksi-edit?edit_setelan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('setelan');
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('#formAdmin').submit(function(e) {
      if ($('#password1').val() !== $('#password2').val()) {
         pesan('Konfirmasi password salah', 3000);
         return false;
      }
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: '../guru/aksi-edit?edit_admin',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('setelan');
            } else if (data == 'password lama') {
               pesan('Password lama salah', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });
   
   $('#hapus-data-absen-siswa').click(function() {
     Swal.fire({
        title: 'Konfirmasi?',
        text: 'Semua data absen siswa akan dihapus!',
        showCancelButton: true,
        confirmButtonColor: '#4086EF',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
     }).then((result) => {
        if (result.value) {
           $.ajax({
              type: 'post',
              url: '../guru/aksi-hapus?hapus_semua_data_absen_siswa',
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
  
  $('#hapus-data-absen-guru').click(function() {
     Swal.fire({
        title: 'Konfirmasi?',
        text: 'Semua data absen guru akan dihapus!',
        showCancelButton: true,
        confirmButtonColor: '#4086EF',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
     }).then((result) => {
        if (result.value) {
           $.ajax({
              type: 'post',
              url: '../guru/aksi-hapus?hapus_semua_data_absen_guru',
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
  
  $('#hapus-data-absen-karyawan').click(function() {
     Swal.fire({
        title: 'Konfirmasi?',
        text: 'Semua data absen karyawan akan dihapus!',
        showCancelButton: true,
        confirmButtonColor: '#4086EF',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
     }).then((result) => {
        if (result.value) {
           $.ajax({
              type: 'post',
              url: '../guru/aksi-hapus?hapus_semua_data_absen_karyawan',
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
  
  $('#hapus-data-kegiatan-guru').click(function() {
     Swal.fire({
        title: 'Konfirmasi?',
        text: 'Semua data kegiatan guru akan dihapus!',
        showCancelButton: true,
        confirmButtonColor: '#4086EF',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
     }).then((result) => {
        if (result.value) {
           $.ajax({
              type: 'post',
              url: '../guru/aksi-hapus?hapus_semua_data_kegiatan_guru',
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
  
  $('#hapus-semua-data').click(function() {
     Swal.fire({
        title: 'Konfirmasi?',
        text: 'Semua data akan dihapus termasuk data siswa, guru, karyawan, dll!',
        showCancelButton: true,
        confirmButtonColor: '#4086EF',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
     }).then((result) => {
        if (result.value) {
           $.ajax({
              type: 'post',
              url: '../guru/aksi-hapus?hapus_semua_data',
              success: function(data) {
                 if (data == 'berhasil') {
                    pesan('Data berhasil dihapus', 3000);
                 } else {
                    pesan('Terdapat kesalahan pada sistem!', 3000);
                 }
              }
           });
        }
     });
  });
</script>