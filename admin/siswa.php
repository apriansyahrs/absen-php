<?php require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM tb_siswa ts JOIN tb_kelas tk ON ts . token_kelas = tk . token_kelas"); ?>
<div class="row">
   <div class="col-md-6">
      <h4 class="mb-3">Siswa keseluruhan</h4>
   </div>
   <div class="col-md-6 text-right mb-3">
      <div class="btn-group">
         <button type="button" class="btn btn-primary waves-effect waves-light" id="click-import-siswa">
            <i class="fa fa-file"></i>
         </button>
         <button type="button" class="btn btn-primary waves-effect waves-light" id="click-tambah-siswa">
            <i class="fa fa-plus"></i>
         </button>
      </div>
   </div>
</div>
<?php if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-8 col-md-6 col-lg-4 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
      </div>
   </div>
<?php } else { ?>
   <form id="formHapusCeklis">
      <div class="card">
         <div class="py-2">
            <div class="row px-4 py-2">
               <div class="col-md-6 col-lg-8">
                  <button type="submit" class="btn btn-danger waves-effect waves-light">
                     <i class="fa fa-trash"></i>
                  </button>
               </div>
               <div class="col-md-6 col-lg-4 text-right">
                  <input type="text" name="" id="search" class="form-control form-control2" placeholder="Pencarian...">
               </div>
            </div>
         </div>
         <div class="table-responsive overlay-scrollbars">
            <table class="table table-hover">
               <thead>
                  <th class="text-center" width="5%" style="min-width: 75px">
                     <label class="checkbox-custom">
                        <input type="checkbox" id="ceklis-semua">
                        <span class="checkmark mt-n2"></span>
                     </label>
                  </th>
                  <th width="5%" class="text-center">No</th>
                  <th width="10%" class="text-center">Profil</th>
                  <th width="15%">Nama</th>
                  <th width="15%" class="text-center">Password</th>
                  <th width="15%" class="text-center">Kelas</th>
                  <th width="10%" class="text-center">Kelamin</th>
                  <th width="15%" class="text-center">Wali kelas</th>
                  <th width="10%" class="text-center">Aksi</th>
               </thead>
               <tbody>
                  <?php
                     $no = 1;
                     foreach ($result as $tb_siswa) {
                        $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_siswa[id_guru]'"); ?>
                     <tr class="contsearch">
                        <td class="text-center">
                           <label class="checkbox-custom">
                              <input type="checkbox" name="id_siswa[]" value="<?= $tb_siswa['id_siswa'] ?>">
                              <span class="checkmark"></span>
                           </label>
                        </td>
                        <td class="text-center"><?= $no++ ?></td>
                        <td class="text-center">
                           <div class="profil">
                              <i class="la la-user <?= $tb_siswa['profil'] ?>"></i>
                           </div>
                        </td>
                        <td>
                           <p class="f-size-18px mb-0 gsearch"><?= $tb_siswa['nis'] ?></p>
                           <span class="gsearch"><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></span>
                        </td>
                        <td class="text-center f-size-16px"><?= $tb_siswa['password'] ?></td>
                        <td class="text-center f-size-16px gsearch"><?= $tb_siswa['kelas'] ?></td>
                        <td class="text-center gsearch"><?= $tb_siswa['jk'] ?></td>
                        <td class="text-center gsearch"><?= $tb_guru['nama'] ?></td>
                        <td class="text-center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-light border-0 waves-effect lihat" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>">
                                 <i class="fa fa-eye"></i>
                              </button>
                              <button type="button" class="btn btn-light border-0 waves-effect edit" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>">
                                 <i class="fa fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>">
                                 <i class="fa fa-trash"></i>
                              </button>
                           </div>
                        </td>
                     </tr>
                  <?php }
                     if (mysqli_num_rows($result) == 0) { ?>
                     <tr>
                        <td class="text-center" colspan="7">tidak ada data yang ditampilkan</td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
            <div id="localSearchSimple"></div>
         </div>
      </div>
      </div>
   </form>
   <div id="loadEditSiswa"></div>

   <script>
      $('.edit').click(function() {
         var id_siswa = $(this).attr('data-id_siswa');
         $('#loadEditSiswa').load('loadEditSiswa?id_siswa=' + id_siswa);
      })

      $('.hapus').click(function() {
         var id_siswa = $(this).attr('data-id_siswa');
         Swal.fire({
            title: 'Konfirmasi?',
            text: 'Data yang dipilih akan dihapus, termasuk pengumuman, data siswa dan data absen keseluruhan!',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: 'post',
                  url: '../guru/aksi-hapus?hapus_siswa',
                  data: {
                     id_siswa: id_siswa
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Data berhasil dihapus', 3000);
                        $('#content').load('siswa');
                     } else {
                        pesan('Terdapat kesalahan pada sistem!', 3000);
                     }
                  }
               });
            }
         });
      });

      $('.overlay-scrollbars').overlayScrollbars({
         className: "os-theme-dark",
         scrollbars: {
            autoHide: 'l',
            autoHideDelay: 0
         }
      });

      $('#localSearchSimple').jsLocalSearch({
         'searchinput': '#search',
         'mark_text': 'mark_text'
      });
   </script>

<?php } ?>

<form id="formImport" enctype="multipart/form-data">
   <div class="modal fade animated zoomIn" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-body overflow-x-hidden">
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
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <select name="token_kelas" id="token_kelas" class="custom-select" required></select>
                     </div>
                  </div>
               </div>
               <div class="form-group text-center">
                  <input type="file" name="file_import" id="file_import" hidden="hidden">
                  <label for="file_import" class="btn-upload waves-effect waves-dark">
                     <img src="<?= base_url() ?>/assets/img/undraw_going_up_ttm5.svg" alt="gambar" class="img-fluid"> <br>
                     <p>Import data menggunakan format <b>csv, ods atau xlsx</b>. <i class="la la-question-circle" data-tooltip="tooltip" title="upload file maksimal 3 mb"></i></p>
                     <a href="#">Pelajari selengkapnya</a>
                  </label>
               </div>
               <div class="form-group">
                  <div class="d-none" id="preview-import">
                     <table class="table">
                        <thead>
                           <tr>
                              <th>Nama file</th>
                              <th>Aksi</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td class="nama-file"></td>
                              <td>
                                 <button type="button" class="btn btn-light btn-sm border-0 waves-effect hapus-preview-import" style="width: 33px; height: 33px;">
                                    <i class="fa fa-trash"></i>
                                 </button>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal">Batal</button>
               <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Import</button>
            </div>
         </div>
      </div>
   </div>
</form>

<script>
   $('#click-tambah-siswa').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Tambah siswa', 'Tambah siswa', '?menu=tambah-siswa');
      $('#content').load('tambah-siswa');
   });

   $('#click-import-siswa').click(function() {
      $('#modalImport').modal('show');
   });

   function select(id, placeholder) {
      $('#' + id).select2({
         theme: 'bootstrap4',
         placeholder: placeholder
      });
   }

   select('id_guru', 'Pilih Guru');
   select('token_kelas', 'Pilih Kelas');

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

   $('#formImport').submit(function(e) {
      $('#modalImport button[type="submit"]').attr('disabled', 'disabled');
      $('#modalImport button[type="submit"]').html('Mengimport...');
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?import_siswa',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               pesan('Data berhasil di import', 3000);
               $('[data-dismiss=modal]').trigger({
                  type: 'click'
               });
               setTimeout(function() {
                  $('#content').load('siswa');
               }, 300);
            } else if (data == 'ekstensi file') {
               pesan('Ekstensi file harus csv, ods atau xlsx', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
            $('#modalImport button[type="submit"]').removeAttr('disabled', 'disabled');
            $('#modalImport button[type="submit"]').html('Import');
         }
      });
   });

   $('#file_import').change(function() {
      var file = this.files[0];
      file_name = file.name;
      file_size = file.size;
      if (file_size > 3000000) {
         pesan('Upload file maksimal 3 MB!', 5000);
         $(this).val('');
         return false;
      } else {
         $('.btn-upload').addClass('d-none');
         $('#preview-import').addClass('d-block');
         $('.nama-file').html(file_name);
      }
   });

   $('.hapus-preview-import').click(function() {
      setTimeout(function() {
         $('#file_import').val('');
         $('.btn-upload').removeClass('d-none');
         $('#preview-import').removeClass('d-block');
      }, 300);
   });

   $('#ceklis-semua').click(function() {
      if ($(this).is(':checked') == true) {
         $('input[type="checkbox"]').prop('checked', true);
      } else {
         $('input[type="checkbox"]').prop('checked', false);
      }
   });

   $('#formHapusCeklis').submit(function(e) {
      tooltipHide();
      e.preventDefault();
      Swal.fire({
         title: 'Konfirmasi?',
         text: 'Data yang dipilih akan dihapus!',
         showCancelButton: true,
         confirmButtonColor: '#4086EF',
         confirmButtonText: 'Hapus',
         cancelButtonText: 'Batal'
      }).then((result) => {
         if (result.value) {
            $.ajax({
               type: 'post',
               url: '../guru/aksi-hapus?hapus_ceklis_siswa',
               data: new FormData(this),
               contentType: false,
               processData: false,
               cache: false,
               success: function(data) {
                  tooltipHide();
                  if (data == 'berhasil') {
                     pesan('Data berhasil dihapus', 3000);
                     $('#content').load('siswa');
                  } else if (data == 'tidak ada') {
                     pesan('Tidak ada data yang diceklis', 3000);
                  } else {
                     pesan('Terdapat kesalahan pada sistem!', 3000);
                  }
               }
            });
         }
      });
   });

   $('.lihat').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      var id_siswa = $(this).attr('data-id_siswa');
      $('#content').load('loadLihatSiswa?id_siswa=' + id_siswa);
   });
</script>