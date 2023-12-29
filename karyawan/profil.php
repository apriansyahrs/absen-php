<?php require "../config.php";
if (!isset($_SESSION['karyawan'])) {
   header('location: ../auth/siswa');
   return false;
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title>Profil <?= $tb_karyawan['nama'] ?></title>
   <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
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
                  <form id="formEditKaryawan">
                     <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                     <div class="form-group">
                        <label for="nip">NIP <span></span></label>
                        <input type="hidden" name="nip_lama" value="<?= $tb_karyawan['nip'] ?>">
                        <input type="text" name="nip" id="nip" class="form-control form-control4" value="<?= $tb_karyawan['nip'] ?>" readonly="readonly">
                     </div>
                     <div class="form-group">
                        <label for="nama">Nama <span></span></label>
                        <input type="text" name="nama" id="nama" class="form-control form-control4" value="<?= $tb_karyawan['nama'] ?>" required>
                     </div>
                     <div class="form-group">
                        <?php if ($tb_karyawan['jk'] == 'Laki-laki') { ?>
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
                        <label for="tempat_lahir">Tempat lahir <span></span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control4" placeholder="628" value="<?= $tb_karyawan['tempat_lahir'] ?>" required>
                     </div>
                     <div class="form-group">
                        <label for="tanggal_lahir">Tanggal lahir <span></span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control4" placeholder="Tanggal lahir" value="<?= $tb_karyawan['tanggal_lahir'] ?>">
                     </div>
                     <div class="form-group">
                        <label for="alamat">Alamat <span></span></label>
                        <textarea name="alamat" id="alamat" rows="5" class="form-control form-control4" required=""><?= $tb_karyawan['alamat'] ?></textarea>
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
            <div class="row">
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <h5 class="mb-4">Edit profil</h5>
                        <form id="formEditProfil" enctype="multipart/form-data">
                           <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                           <div class="form-group d-flex justify-content-center pb-5">
                              <div class="position-relative w-25 h-25">
                                 <img src="<?= base_url() ?>/img/karyawan/<?= $tb_karyawan['profil'] ?>" alt="profil" class="img-fluid b-radius-50deg" id="preview-profil" style="width: 125px; height: 125px;">
                                 <input type="file" name="profil" id="profil" hidden>
                                 <label for="profil" class="position-absolute cursor-pointer text-primary" style="right: 8px; bottom: 0;" data-tooltip="tooltip" title="Ukuran maksimum 3 MB dan Ekstensi harus jpg, jpeg atau png! disarankan 512x512">
                                    <i class="fa fa-pen"></i>
                                 </label>
                              </div>
                           </div>
                           <div class="modal fade animated zoomIn" id="modalKonfirmasiEditProfil" tabindex="-1" role="dialog" aria-labelledby="modalKonfirmasiEditProfilLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                 <div class="modal-content">
                                    <div class="modal-header text-center">
                                       <h5 class="modal-title">Konfirmasi?</h5>
                                    </div>
                                    <div class="modal-body overflow-x-hidden">
                                       <h4>Foto profil akan disimpan!</h4>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal" id="batal-simpan">Batal</button>
                                       <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Simpan</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="card">
                     <div class="card-body">
                        <h5>Ubah password</h5>
                        <form id="formEditPassword">
                           <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
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
      </div>
   </div>
   <div class="pesan transition-all-300ms-ease"></div>

   <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
   <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
   <script src="<?= base_url() ?>/assets/select2/js/select2.min.js"></script>
   <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
   <script>
      $('#formEditKaryawan').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-profil?edit_data',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  history.back(-1);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('#profil').change(function() {
         var file = this.files[0];
         file_name = file.name;
         file_type = file.type;
         file_size = file.size;
         match = ['image/jpg', 'image/jpeg', 'image/png'];

         if (!((file_type == match[0]) || (file_type == match[1]) || (file_type == match[2]))) {
            pesan('Ekstensi foto harus jpg, jpeg atau png!', 5000);
            $(this).val('');
            return false;
         }
         if (file_size > 3000000) {
            pesan('Upload foto maksimal 3 MB!', 5000);
            $(this).val('');
            return false;
         } else {
            function imageIsLoaded(e) {
               $('#preview-profil').attr('src', e.target.result);
            }
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
            $('#modalKonfirmasiEditProfil').modal('show');
         }
      });

      $('#batal-simpan').click(function() {
         $('#modalKonfirmasiEditProfil').modal('hide');
         pesan('Menyimpan foto profil dibatalkan', 3000);
         setTimeout(function() {
            $('#preview-profil').attr('src', '../img/karyawan/<?= $tb_karyawan['profil'] ?>');
         }, 300);
      });

      $('#formEditProfil').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-profil?edit_profil',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  pesan('Foto profil berhasil disimpan', 3000);
                  $('#modalKonfirmasiEditProfil').modal('hide');
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('#formEditPassword').submit(function(e) {
         if ($('#password1').val() !== $('#password2').val()) {
            pesan('Konfirmasi password salah', 3000);
            return false;
         }
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-profil?edit_password',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  window.location.href = 'absen';
               } else if (data == 'password lama') {
                  pesan('Password lama salah', 3000);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('#kembali').click(function() {
         setTimeout(function() {
            history.back(1);
         }, 300)
      })
   </script>
</body>

</html>