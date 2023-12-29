<?php require "config.php";
if (!isset($_SESSION['siswa'])) {
   header('location: auth/siswa');
   return false;
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Profil <?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2/css/select2.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2-bootstrap4/select2-bootstrap4.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
</head>

<body>
   <nav class="topbar">
      <div class="row">
         <div class="container">
            <div class="row m-0">
               <div class="col col-2">
                  <div class="menu">
                     <i class="la la-arrow-left waves-effect waves-light" id="kembali"></i>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </nav>

   <div class="container">
      <div class="row" style="margin-top: 75px;">
         <div class="col-md-6">
            <div class="card">
               <div class="card-body">
                  <form id="formEditSiswa">
                     <input type="hidden" name="id_siswa" value="<?= $tb_siswa['id_siswa'] ?>">
                     <input type="hidden" name="profil" id="profil" value="<?= $tb_siswa['profil'] ?>">
                     <div class="profil edit-profil text-center">
                        <?php
                        $result = mysqli_query($conn, "SELECT profil FROM profil");
                        foreach ($result as $profil) {
                           if ($profil['profil'] == $tb_siswa['profil']) { ?>
                              <i class="la la-user <?= $profil['profil'] ?> active" data-profil="<?= $profil['profil'] ?>" data-tooltip="tooltip" title="Profil"></i>
                           <?php } else { ?>
                              <i class="la la-user <?= $profil['profil'] ?>" data-profil="<?= $profil['profil'] ?>" data-tooltip="tooltip" title="Profil"></i>
                        <?php }
                        } ?>
                     </div>
                     <div class="form-group">
                        <label for="nis">NIS <span></span></label>
                        <input type="hidden" name="nis_lama" value="<?= $tb_siswa['nis'] ?>">
                        <input type="text" name="nis" id="nis" class="form-control form-control4" value="<?= $tb_siswa['nis'] ?>" readonly="readonly">
                     </div>
                     <div class="row">
                        <div class="col-md-6 pr-md-2">
                           <div class="form-group">
                              <label for="nama_depan">Nama depan <span></span></label>
                              <input type="text" name="nama_depan" id="nama_depan" class="form-control form-control4" value="<?= $tb_siswa['nama_depan'] ?>" required>
                           </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                           <div class="form-group">
                              <label for="nama_belakang">Nama belakang <span></span></label>
                              <input type="text" name="nama_belakang" id="nama_belakang" class="form-control form-control4" value="<?= $tb_siswa['nama_belakang'] ?>" required>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <?php if ($tb_siswa['jk'] == 'Laki-laki') { ?>
                           <label class="btn btn-radio active">Laki-laki
                              <input type="radio" class="d-none" name="jk" value="Laki-laki" checked="">
                           </label>
                           <label class="btn btn-radio">Perempuan
                              <input type="radio" class="d-none" name="jk" value="Perempuan">
                           </label>
                        <?php } else { ?>
                           <label class="btn btn-radio">Laki-laki
                              <input type="radio" class="d-none" name="jk" value="Laki-laki">
                           </label>
                           <label class="btn btn-radio active">Perempuan
                              <input type="radio" class="d-none" name="jk" value="Perempuan" checked="">
                           </label>
                        <?php } ?>
                     </div>
                     <div class="form-group">
                        <label for="telegram">Telegram <span></span></label>
                        <input type="number" name="telegram" id="telegram" class="form-control form-control4" placeholder="628" value="<?= $tb_siswa['telegram'] ?>" required>
                     </div>
                     <div class="form-group">
                        <label for="provinsi">Provinsi <span></span></label>
                        <select name="provinsi" id="provinsi" class="custom-select" required>
                           <?php
                           $provinsi = query("SELECT * FROM w_provinces WHERE id = '$tb_siswa[provinsi]'");
                           echo "<option value='$provinsi[id]'>$provinsi[name]</option>";
                           $result = mysqli_query($conn, "SELECT * FROM w_provinces ORDER BY name ASC");
                           while ($provinsi = mysqli_fetch_assoc($result)) {
                              echo "<option value='$provinsi[id]'>$provinsi[name]</option>";
                           } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="kota">Kota/Kabupaten <span></span></label>
                        <select name="kota" id="kota" class="custom-select" required>
                           <?php
                           $kota = query("SELECT * FROM w_regencies WHERE id = '$tb_siswa[kota]'");
                           echo "<option value='$kota[id]'>$kota[name]</option>";
                           $result = mysqli_query($conn, "SELECT * FROM w_regencies WHERE province_id = '$tb_siswa[provinsi]' ORDER BY name ASC");
                           while ($kota = mysqli_fetch_assoc($result)) {
                              echo "<option value='$kota[id]'>$kota[name]</option>";
                           } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="kecamatan">Kecamatan <span></span></label>
                        <select name="kecamatan" id="kecamatan" class="custom-select" required>
                           <?php
                           $kecamatan = query("SELECT * FROM w_districts WHERE id = '$tb_siswa[kecamatan]'");
                           echo "<option value='$kecamatan[id]'>$kecamatan[name]</option>";
                           $result = mysqli_query($conn, "SELECT * FROM w_districts WHERE regency_id = '$tb_siswa[kota]' ORDER BY name ASC");
                           while ($kecamatan = mysqli_fetch_assoc($result)) {
                              echo "<option value='$kecamatan[id]'>$kecamatan[name]</option>";
                           } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="kelurahan">Kelurahan <span></span></label>
                        <select name="kelurahan" id="kelurahan" class="custom-select" required>
                           <?php
                           $kelurahan = query("SELECT * FROM w_villages WHERE id = '$tb_siswa[kelurahan]'");
                           echo "<option value='$kelurahan[id]'>$kelurahan[name]</option>";
                           $result = mysqli_query($conn, "SELECT * FROM w_villages WHERE district_id = '$tb_siswa[kecamatan]' ORDER BY name ASC");
                           while ($kelurahan = mysqli_fetch_assoc($result)) {
                              echo "<option value='$kelurahan[id]'>$kelurahan[name]</option>";
                           } ?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label for="nama_ayah">Nama ayah <span></span></label>
                        <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control4" placeholder="Nama Ayah" value="<?= $tb_siswa['nama_ayah'] ?>">
                     </div>
                     <div class="form-group">
                        <label for="pekerjaan_ayah">Pekerjaan ayah <span></span></label>
                        <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control form-control4" placeholder="Pekerjaan Ayah" value="<?= $tb_siswa['pekerjaan_ayah'] ?>">
                     </div>
                     <div class="form-group">
                        <label for="nama_ibu">Nama ibu <span></span></label>
                        <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control4" placeholder="Nama Ibu" value="<?= $tb_siswa['nama_ibu'] ?>">
                     </div>
                     <div class="form-group">
                        <label for="pekerjaan_ibu">Pekerjaan ibu <span></span></label>
                        <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control form-control4" placeholder="Pekerjaan Ibu" value="<?= $tb_siswa['pekerjaan_ibu'] ?>">
                     </div>
                     <div class="form-group">
                        <label for="telepon_rumah">Telepon rumah <span></span></label>
                        <input type="number" name="telepon_rumah" id="telepon_rumah" class="form-control form-control4" placeholder="Telepon rumah" value="<?= $tb_siswa['telepon_rumah'] ?>">
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
               <div class="card-body">
                  <h5>Ubah password</h5>
                  <form id="formUbahPasswordSiswa">
                     <input type="hidden" name="id_siswa" value="<?= $tb_siswa['id_siswa'] ?>">
                     <div class="form-group">
                        <label for="password_lama">Password lama <span></span></label>
                        <input type="password" name="password_lama" id="password_lama" class="form-control form-control4" placeholder="*****" required>
                     </div>
                     <div class="row">
                        <div class="col-md-6 pr-md-2">
                           <div class="form-group">
                              <label for="password1">Password baru <span></span></label>
                              <input type="password" name="password1" id="password1" class="form-control form-control4" placeholder="*****" required>
                           </div>
                        </div>
                        <div class="col-md-6 pl-md-2">
                           <div class="form-group">
                              <label for="password2">Konfirmasi <span></span></label>
                              <input type="password" name="password2" id="password2" class="form-control form-control4" placeholder="*****" required>
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
         </div>
      </div>
   </div>
   <div class="pesan transition-all-300ms-ease"></div>

   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/select2/js/select2.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#formEditSiswa').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'guru/aksi-edit?edit_siswa',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  history.back(-1);
               } else if (data == 'tidak tersedia') {
                  pesan('NIS kamu tidak tersedia', 3000);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('#formUbahPasswordSiswa').submit(function(e) {
         if ($('#password1').val() !== $('#password2').val()) {
            pesan('Konfirmasi password salah', 3000);
            return false;
         }
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'guru/aksi-edit?edit_password_siswa',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  pesan('Data berhasil disimpan', 3000);
                  document.getElementById('formUbahPasswordSiswa').reset();
               } else if (data == 'password lama') {
                  pesan('Password lama salah', 3000);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('.edit-profil .la-user').click(function() {
         var profil = $(this).attr('data-profil');
         $('.edit-profil .active').removeClass('active');
         $(this).addClass('active');
         $('#profil').val(profil);
         $('[data-tooltip="tooltip"]').tooltip('hide');
      });

      function select(id, placeholder) {
         $('#' + id).select2({
            theme: 'bootstrap4',
            placeholder: placeholder
         });
      }

      select('provinsi', 'Pilih Provinsi');
      select('kota', 'Pilih Kota/Kabupaten');
      select('kecamatan', 'Pilih Kecamatan');
      select('kelurahan', 'Pilih Kelurahan');

      $('#provinsi').change(function() {
         var id_provinces = $(this).val();
         $.ajax({
            type: 'post',
            url: 'guru/change-data?jenis=kota',
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
            url: 'guru/change-data?jenis=kecamatan',
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
            url: 'guru/change-data?jenis=kelurahan',
            data: 'id_district=' + id_district,
            dataType: 'html',
            success: function(data) {
               $('select#kelurahan').html(data);
            }
         });
      }

      $('#kembali').click(function() {
         setTimeout(function() {
            history.back(1);
         }, 300)
      })
   </script>
</body>

</html>