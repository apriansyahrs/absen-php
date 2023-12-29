<?php require "../config.php";
$id_karyawan = $_GET['id_karyawan'];
$tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE tk . id_karyawan = '$id_karyawan'"); ?>
<h4 class="mb-3">Edit karyawan</h4>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
               <i class="la la-angle-left f-size-18px mr-2"></i>Kembali
            </button>
         </div>
         <form id="formEditKaryawan">
            <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
            <input type="hidden" name="nip_lama" value="<?= $tb_karyawan['nip'] ?>">
            <div class="card-body">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="nip">NIP karyawan <span></span></label>
                        <input type="number" name="nip" id="nip" class="form-control form-control4" value="<?= $tb_karyawan['nip'] ?>" required="">
                     </div>
                     <div class="form-group">
                        <label for="nama">Nama karyawan <span></span></label>
                        <input type="text" name="nama" id="nama" class="form-control form-control4" value="<?= $tb_karyawan['nama'] ?>" required="">
                     </div>
                     <div class="form-group">
                        <label for="tempat_lahir">Tempat lahir <span></span></label>
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control form-control4" value="<?= $tb_karyawan['tempat_lahir'] ?>" required="">
                     </div>
                     <div class="form-group">
                        <label for="tanggal_lahir">Tanggal lahir <span></span></label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control form-control4" value="<?= $tb_karyawan['tanggal_lahir'] ?>" required="">
                     </div>
                     <div class="form-group">
                        <label for="">Jenis kelamin <span></span></label> <br>
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
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label for="alamat">Alamat lengkap <span></span></label>
                        <textarea name="alamat" id="alamat" rows="5" class="form-control form-control4" required=""><?= $tb_karyawan['alamat'] ?></textarea>
                     </div>
                     <div class="form-group">
                        <label for="jabatan">Jabatan karyawan <span></span></label>
                        <select name="id_jabatan" id="id_jabatan" class="custom-select custom-select2" required="">
                           <?php
                           $result = mysqli_query($conn, "SELECT * FROM tb_jabatan");
                           foreach ($result as $tb_jabatan) {
                              if ($tb_karyawan['id_jabatan'] == $tb_jabatan['id_jabatan']) {
                                 echo "<option selected='' value='$tb_jabatan[id_jabatan]'>$tb_jabatan[jabatan]</option>";
                              } else {
                                 echo "<option value='$tb_jabatan[id_jabatan]'>$tb_jabatan[jabatan]</option>";
                              }
                           } ?>
                        </select>
                     </div>
                  </div>
               </div>
            </div>
            <div class="card-footer mt-n4 text-right">
               <button type="submit" class="btn btn-linear-primary waves-effect waves-light" id="btn-simpan">
                  Simpan
               </button>
            </div>
         </form>
      </div>
   </div>
   <div class="col-md-5">
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
</div>

<script>
   $('.kembali').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('karyawan', 'karyawan', '?menu=karyawan');
      $('#content').load('karyawan');
   });

   $('#formEditKaryawan').submit(function(e) {
      $('#btn-simpan').attr('disabled', 'disabled');
      $('#btn-simpan').html('<div class="spinner-border text-white" role="status"></div>');
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_karyawan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               $('html, body').animate({
                  scrollTop: '0'
               }, 200);
               pesan('Data karyawan berhasil disimpan', 3000);
               history.pushState('karyawan', 'karyawan', '?menu=karyawan');
               $('#content').load('karyawan');
            } else if (data == 'tidak tersedia') {
               pesan('NIP tidak tersedia', 3000);
            } else {
               pesan(data, 3000);
            }
            $('#btn-simpan').removeAttr('disabled', 'disabled');
            $('#btn-simpan').html('Simpan');
         }
      })
   });

   $('.btn-radio').click(function() {
      $('.btn-radio.active').removeClass('active');
      $(this).addClass('active');
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
         url: 'aksi?edit_profil_karyawan',
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
</script>