<?php require "../../config.php";
if (isset($_COOKIE['id'], $_COOKIE['absensi_siswa'])) {
   $id = $_COOKIE['id'];
   $absensi_siswa = $_COOKIE['absensi_siswa'];
   $result = mysqli_query($conn, "SELECT id_siswa FROM tb_siswa WHERE id_siswa = '$id'");
   $tb_siswa = mysqli_fetch_assoc($result);
   if (hash('sha256', $tb_siswa['id_siswa']) == $absensi_siswa) {
      $_SESSION['siswa'] = $tb_siswa['id_siswa'];
   }
}

if (isset($_SESSION['siswa'])) {
   header('location: ../../absen');
   return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Daftar Akun Siswa <?= $tb_setelan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2/css/select2.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/select2-bootstrap4/select2-bootstrap4.min.css">
   <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
   <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
   <style>
      html,
      body {
         background-image: linear-gradient(to right, #4086EF, #26B0E8);
         background-size: cover;
      }
   </style>
</head>

<body>
   <div class="container">
      <div class="row vh-100 d-flex justify-content-center align-items-center my-5">
         <div class="col-md-7 col-lg-5">
            <div class="auth px-4 pt-4 pb-5">
               <div class="logo">
                  <span>Absensi</span> Daftar
               </div>
               <p class="text-center f-size-16px">Mendaftar akun siswa di <?= $tb_setelan['nama'] ?></p>
               <form id="formDaftarSiswa">
                  <input type="hidden" name="id_guru" id="id_guru">
                  <div class="form-group">
                     <label for="token_kelas">Mintalah token kelas kepada guru pengajar kamu <span></span></label>
                     <input type="text" name="token_kelas" id="token_kelas" class="form-control form-control4" placeholder="TOKEN KELAS" required>
                     <div class="text-danger" id="pesanTokenKelas"></div>
                  </div>
                  <div class="row" id="kelas_nama_guru">
                     <div class="col-md-6 pr-md-2">
                        <div class="form-group">
                           <input type="text" name="kelas" id="kelas" class="form-control form-control4" readonly="readonly">
                        </div>
                     </div>
                     <div class="col-md-6 pl-md-2">
                        <div class="form-group">
                           <input type="text" name="nama_guru" id="nama_guru" class="form-control form-control4" readonly="readonly">
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <input type="number" name="nis" id="nis" class="form-control form-control4" placeholder="NIS kamu" required>
                  </div>
                  <div class="row">
                     <div class="col-md-6 pr-md-2">
                        <div class="form-group">
                           <input type="text" name="nama_depan" id="nama_depan" class="form-control form-control4" placeholder="Nama depan" required>
                        </div>
                     </div>
                     <div class="col-md-6 pl-md-2">
                        <div class="form-group">
                           <input type="text" name="nama_belakang" id="nama_belakang" class="form-control form-control4" placeholder="Nama belakang" required>
                        </div>
                     </div>
                     <div class="col-6 pr-2">
                        <div class="form-group">
                           <label class="btn btn-radio btn-block">Laki-laki
                              <input type="radio" class="d-none" name="jk" value="Laki-laki" required>
                           </label>
                        </div>
                     </div>
                     <div class="col-6 pl-2">
                        <div class="form-group">
                           <label class="btn btn-radio btn-block">Perempuan
                              <input type="radio" class="d-none" name="jk" value="Perempuan" required>
                           </label>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <?php
                     $username_ortu = substr(str_shuffle(time() . time()), 0, 8);
                     if (num_rows("SELECT username_ortu FROM tb_siswa WHERE username_ortu = '$username_ortu'") >= 1) {
                        $username_ortu = substr(str_shuffle(time() . time()), 0, 8);
                     } ?>
                     <input type="text" name="username_ortu" id="username_ortu" class="form-control form-control4" value="<?= $username_ortu ?>" readonly>
                     <p>*berikan username ini kepada orang tuamu</p>
                  </div>
                  <div class="form-group">
                     <input type="text" name="nama_ayah" id="nama_ayah" class="form-control form-control4" placeholder="Nama Ayah">
                  </div>
                  <div class="form-group">
                     <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" class="form-control form-control4" placeholder="Pekerjaan Ayah">
                  </div>
                  <div class="form-group">
                     <input type="text" name="nama_ibu" id="nama_ibu" class="form-control form-control4" placeholder="Nama Ibu">
                  </div>
                  <div class="form-group">
                     <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" class="form-control form-control4" placeholder="Pekerjaan Ibu">
                  </div>
                  <div class="form-group">
                     <input type="number" name="telepon_rumah" id="telepon_rumah" class="form-control form-control4" placeholder="Telepon rumah">
                  </div>
                  <div class="form-group">
                     <select name="provinsi" id="provinsi" class="custom-select" required>
                        <option value=""></option>
                        <?php
                        $result = mysqli_query($conn, "SELECT * FROM w_provinces ORDER BY name ASC");
                        while ($w_provinsi = mysqli_fetch_assoc($result)) {
                           echo '<option value="' . $w_provinsi['id'] . '">' . $w_provinsi['name'] . '</option>';
                        } ?>
                     </select>
                  </div>
                  <div class="form-group">
                     <select name="kota" id="kota" class="custom-select" required>
                        <option value=""></option>
                     </select>
                  </div>
                  <div class="form-group">
                     <select name="kecamatan" id="kecamatan" class="custom-select" required>
                        <option value=""></option>
                     </select>
                  </div>
                  <div class="form-group">
                     <select name="kelurahan" id="kelurahan" class="custom-select" required>
                        <option value=""></option>
                     </select>
                  </div>
                  <div class="row">
                     <div class="col-md-6 pr-md-2">
                        <div class="form-group">
                           <input type="password" name="password1" id="password1" class="form-control form-control4" placeholder="Password" required>
                        </div>
                     </div>
                     <div class="col-md-6 pl-md-2">
                        <div class="form-group">
                           <input type="password" name="password2" id="password2" class="form-control form-control4" placeholder="Konfirmasi password" required>
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     <button type="submit" class="btn btn-linear-primary btn-block waves-effect waves-light" id="btn-login">
                        Daftar
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div id="loader"></div>
   <div class="pesan transition-all-300ms-ease"></div>
   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/select2/js/select2.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#formDaftarSiswa').submit(function(e) {
         e.preventDefault();
         if ($('#password1').val() !== $('#password2').val()) {
            pesan('Konfirmasi password tidak sama', 5000);
            return false;
         }
         $('#btn-login').attr('disabled', 'disabled');
         $('#btn-login').html('<div class="spinner-border text-white" role="status"></div>');
         $.ajax({
            type: 'post',
            url: 'aksi-auth?daftar',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  window.location.href = 'login';
               } else if (data == 'tidak tersedia') {
                  pesan('NIS kamu tidak tersedia', 3000);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
               $('#btn-login').removeAttr('disabled', 'disabled');
               $('#btn-login').html('Daftar');
            }
         });
      });
      $('#kelas_nama_guru').hide();
      $('#token_kelas').keyup(function() {
         var token_kelas = $(this).val();
         $.ajax({
            type: 'post',
            url: 'aksi-auth?cek_token',
            data: {
               token_kelas: token_kelas
            },
            dataType: 'json',
            success: function(data) {
               if (data.status == 'berhasil') {
                  $('#kelas_nama_guru').show();
                  $('#id_guru').val(data.id_guru);
                  $('#kelas').val(data.kelas);
                  $('#nama_guru').val(data.nama_guru);
                  $('#pesanTokenKelas').html('');
                  $('#btn-login').removeAttr('disabled', 'disabled');
               } else if (data.status == 'gagal') {
                  $('#kelas_nama_guru').hide();
                  $('#id_guru').val('');
                  $('#kelas').val('');
                  $('#nama_guru').val('');
                  $('#pesanTokenKelas').html('Kelas tidak ditemukan');
                  $('#btn-login').attr('disabled', 'disabled');
               }
            }
         })
      });
      $('#token_kelas').focusout(function() {
         var token_kelas = $(this).val();
         $.ajax({
            type: 'post',
            url: 'aksi-auth?cek_token',
            data: {
               token_kelas: token_kelas
            },
            dataType: 'json',
            success: function(data) {
               if (data.status == 'berhasil') {
                  $('#kelas_nama_guru').show();
                  $('#id_guru').val(data.id_guru);
                  $('#kelas').val(data.kelas);
                  $('#nama_guru').val(data.nama_guru);
                  $('#pesanTokenKelas').html('');
                  $('#btn-login').removeAttr('disabled', 'disabled');
               } else if (data.status == 'gagal') {
                  $('#kelas_nama_guru').hide();
                  $('#id_guru').val('');
                  $('#kelas').val('');
                  $('#nama_guru').val('');
                  $('#pesanTokenKelas').html('Kelas tidak ditemukan');
                  $('#btn-login').attr('disabled', 'disabled');
               }
            }
         })
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
            url: '../../guru/change-data?jenis=kota',
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
            url: '../../guru/change-data?jenis=kecamatan',
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
            url: '../../guru/change-data?jenis=kelurahan',
            data: 'id_district=' + id_district,
            dataType: 'html',
            success: function(data) {
               $('select#kelurahan').html(data);
            }
         });
      }
   </script>
</body>

</html>