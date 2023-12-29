<?php
require "../config.php";
$id_guru = $_GET['id_guru'];
$tb_guru = query("SELECT * FROM tb_guru WHERE id_guru = '$id_guru'");
?>

<h4 class="mb-3">Edit guru</h4>
<div class="row">
   <div class="col-md-6">
      <div class="card">
         <div class="card-header">
            <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
               <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
            </button>
         </div>
         <form id="formEditGuru">
            <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
            <input type="hidden" name="nip_lama" value="<?= $tb_guru['nip'] ?>">
            <div class="card-body">
               <div class="form-group">
                  <label for="nip">NIP guru <span></span></label>
                  <input type="text" name="nip" id="nip" class="form-control form-control4" placeholder="NIP Guru" value="<?= $tb_guru['nip'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="nama">Nama guru <span></span></label>
                  <input type="text" name="nama" id="nama" class="form-control form-control4" placeholder="Nama lengkap" value="<?= $tb_guru['nama'] ?>" required>
               </div>
               <div class="form-group">
                  <label for="telegram">Telegram</label>
                  <input type="number" name="telegram" id="telegram" class="form-control form-control4" placeholder="Telegram (628)" value="<?= $tb_guru['telegram'] ?>">
               </div>
            </div>
            <div class="card-footer mt-n4">
               <button type="submit" class="btn btn-linear-primary waves-effect waves-light btn-block" id="btn-edit">
                  Simpan
               </button>
            </div>
         </form>
      </div>
   </div>
   <div class="col-md-6">
      <div class="card">
         <div class="card-body">
            <h5 class="mb-4">Edit profil</h5>
            <form id="formEditProfil" enctype="multipart/form-data">
               <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
               <div class="form-group d-flex justify-content-center pb-5">
                  <div class="position-relative w-25 h-25">
                     <img src="<?= base_url() ?>/img/guru/<?= $tb_guru['profil'] ?>" alt="profil" class="img-fluid b-radius-50deg" id="preview-profil" style="width: 125px; height: 125px;">
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
            <h5 class="mb-4">Edit password</h5>
            <form id="formEditPassword">
               <input type="hidden" name="id_guru" value="<?= $tb_guru['id_guru'] ?>">
               <div class="form-group">
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
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<script>
   $('.kembali').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Guru', 'Guru', '?menu=guru');
      $('#content').load('guru');
   });

   $('#formEditGuru').submit(function(e) {
      if ($('#password1').val() !== $('#password2').val()) {
         pesan('Konfirmasi password salah', 3000);
         return false;
      }
      $('#btn-edit').attr('disabled', 'disabled');
      $('#btn-edit').html('<div class="spinner-border text-white" role="status"></div>');
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_guru',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Akun guru berhasil diedit', 3000);
               $('#content').load('guru');
            } else if (data == 'tidak tersedia') {
               pesan('NIP tidak tersedia', 3000);
            } else {
               pesan(data, 3000);
            }
            $('#btn-edit').removeAttr('disabled', 'disabled');
            $('#btn-edit').html('Daftarkan');
         }
      })
   });

   $('#formEditProfil').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_profil',
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
         $('#preview-profil').attr('src', '../img/guru/<?= $tb_guru['profil'] ?>');
      }, 300);
   })

   $('#formEditPassword').submit(function(e) {
      if ($('#password1').val() !== $('#password2').val()) {
         pesan('Konfirmasi password salah', 3000);
         return false;
      }
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_password',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil disimpan', 3000);
               $('#content').load('guru');
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });
</script>