<?php
require "../config.php";
$token_kelas = $_GET['token_kelas'];
$tb_kelas = query("SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'"); ?>

<div class="content-title">Daftar siswa</div>
<div class="card">
   <div class="card-header">
      <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
         <i class="la la-angle-left f-size-18px mr-2"></i>Kelas: <?= $tb_kelas['kelas'] ?>
      </button>
   </div>
   <div class="py-2">
      <form id="formHapusCeklis">
         <div class="row px-4">
            <div class="col-md-7 col-lg-6 my-2">
               <input type="text" name="" id="search" class="form-control form-control2" placeholder="Pencarian...">
            </div>
            <div class="col-md-5 col-lg-6 my-2">
               <div class="btn-group float-right">
                  <button type="submit" class="btn btn-light btn-lg border-0 waves-effect" data-tooltip="tooltip" title="Hapus">
                     <i class="fa fa-trash"></i>
                  </button>
                  <button type="button" class="btn btn-light btn-lg border-0 waves-effect" data-tooltip="tooltip" title="Import" id="click-import">
                     <i class="fa fa-file"></i>
                  </button>
                  <button type="button" class="btn btn-light btn-lg border-0 waves-effect" data-tooltip="tooltip" title="Export" id="click-export-excel" data-file_name="<?= 'DAFTAR SISWA KELAS ' . $tb_kelas['kelas'] ?>">
                     <i class="fa fa-file-excel"></i>
                  </button>
                  <button type="button" class="btn btn-light btn-lg border-0 waves-effect" data-tooltip="tooltip" title="Tambah" id="click-tambah-siswa">
                     <i class="fa fa-plus"></i>
                  </button>
               </div>
            </div>
         </div>
         <div class="table-responsive daftar-siswa mt-3">
            <table class="table table-hover">
               <thead>
                  <th class="text-center" width="8%" style="min-width: 75px">
                     <label class="checkbox-custom">
                        <input type="checkbox" id="ceklis-semua">
                        <span class="checkmark mt-n2"></span>
                     </label>
                  </th>
                  <th class="text-center" width="12%">Profil</th>
                  <th width="60%">Nama</th>
                  <th class="text-center" width="20%">Aksi</th>
               </thead>
               <tbody>
                  <?php
                  $result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE token_kelas = '$token_kelas' ORDER BY nama_depan, nama_belakang ASC");
                  foreach ($result as $tb_siswa) { ?>
                     <tr class="contsearch">
                        <td class="text-center">
                           <label class="checkbox-custom">
                              <input type="checkbox" name="id_siswa[]" value="<?= $tb_siswa['id_siswa'] ?>">
                              <span class="checkmark"></span>
                           </label>
                        </td>
                        <td class="text-center">
                           <div class="profil">
                              <i class="la la-user <?= $tb_siswa['profil'] ?>"></i>
                           </div>
                        </td>
                        <td>
                           <p class="f-size-20px mb-0 gsearch"><?= $tb_siswa['nis'] ?></p>
                           <p class="mb-0 gsearch"><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></p>
                        </td>
                        <td class="text-center">
                           <div class="btn-group">

                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect lihat-siswa" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>" style="width: 33px; height: 33px;">
                                 <i class="fa fa-eye"></i>
                              </button>
                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect edit-siswa" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>" style="width: 33px; height: 33px;">
                                 <i class="fa fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect hapus-siswa" data-id_siswa="<?= $tb_siswa['id_siswa'] ?>" style="width: 33px; height: 33px;">
                                 <i class="fa fa-trash"></i>
                              </button>
                           </div>
                        </td>
                     </tr>
                  <?php } ?>
                  <?php if (mysqli_num_rows($result) == 0) { ?>
                     <tr>
                        <td colspan="4" class="text-center">tidak ada data yang ditampilkan</td>
                     </tr>
                  <?php } ?>
                  <div id="localSearchSimple"></div>
               </tbody>
            </table>
         </div>
      </form>
   </div>
</div>
<div id="loadEditSiswa"></div>

<form id="formImport" enctype="multipart/form-data">
   <div class="modal fade animated zoomIn" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImportLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-body overflow-x-hidden">
               <div class="form-group text-center">
                  <input type="hidden" name="id_guru" value="<?= $tb_kelas['id_guru'] ?>">
                  <input type="hidden" name="token_kelas" value="<?= $tb_kelas['token_kelas'] ?>">
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
               <button type="submit" class="btn btn-modal-true waves-effect waves-ripple">Simpan</button>
            </div>
         </div>
      </div>
   </div>
</form>

<table class="table2excel d-none">
   <tr>
      <th>No</th>
      <th>NIS</th>
      <th>Password</th>
      <th>Username ortu</th>
      <th>Nama</th>
   </tr>
   <?php
   $no = 1;
   $result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE token_kelas = '$token_kelas' ORDER BY nama_depan, nama_belakang ASC");
   foreach ($result as $tb_siswa) { ?>
      <tr>
         <td><?= $no++ ?></td>
         <td><?= $tb_siswa['nis'] ?></td>
         <td><?= $tb_siswa['password'] ?></td>
         <td><?= $tb_siswa['username_ortu'] ?></td>
         <td><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></p>
         </td>
      </tr>
   <?php } ?>
</table>


<script>
   $(function() {
      $('#click-export-excel').click(function() {
         tooltipHide();
         var file_name = $(this).attr('data-file_name');
         $(".table2excel").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: file_name,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
         });
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

   $('#formImport').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi-tambah?import_siswa',
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
                  $('#content').load('loadDataSiswa.php?token_kelas=<?= $token_kelas ?>');
               }, 300);
            } else if (data == 'ekstensi file') {
               pesan('Ekstensi file harus csv, ods atau xlsx', 3000);
            } else {
               pesan('Terdapat kesalahan pada sistem!', 3000);
            }
         }
      });
   });

   $('.hapus-preview-import').click(function() {
      setTimeout(function() {
         $('#file_import').val('');
         $('.btn-upload').removeClass('d-none');
         $('#preview-import').removeClass('d-block');
      }, 300);
   });

   $('.edit-siswa').click(function() {
      var id_siswa = $(this).attr('data-id_siswa');
      $('#loadEditSiswa').load('loadEditSiswa?id_siswa=' + id_siswa);
   })

   $('#click-tambah-siswa').click(function() {
      tooltipHide();
      content_loader();
      $('#content').load('loadTambahSiswa.php?token_kelas=<?= $token_kelas ?>');
      history.pushState('history.pushtate', 'history.pushtate', '?menu=daftar-siswa&token_kelas=<?= $token_kelas ?>');
   });

   $('.lihat-siswa').click(function() {
      content_loader();
      var id_siswa = $(this).attr('data-id_siswa');
      $('#content').load('loadLihatSiswa.php?id_siswa=' + id_siswa);
   });

   $('.kembali').click(function() {
      $('#content').load('daftar-siswa');
      history.pushState('history.pushtate', 'history.pushtate', '?menu=daftar-siswa');
   });

   $('.hapus-siswa').click(function() {
      var id_siswa = $(this).attr('data-id_siswa');
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
               url: 'aksi-hapus?hapus_siswa',
               data: {
                  id_siswa: id_siswa
               },
               success: function(data) {
                  if (data == 'berhasil') {
                     pesan('Data berhasil dihapus', 3000);
                     $('#content').load('loadDataSiswa.php?token_kelas=<?= $token_kelas ?>');
                  } else {
                     pesan('Terdapat kesalahan pada sistem!', 3000);
                  }
               }
            });
         }
      });
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
               url: 'aksi-hapus?hapus_ceklis_siswa',
               data: new FormData(this),
               contentType: false,
               processData: false,
               cache: false,
               success: function(data) {
                  tooltipHide();
                  if (data == 'berhasil') {
                     pesan('Data berhasil dihapus', 3000);
                     $('#content').load('loadDataSiswa.php?token_kelas=<?= $token_kelas ?>');
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

   $('#localSearchSimple').jsLocalSearch({
      'searchinput': '#search',
      'mark_text': 'mark_text'
   });

   $('[data-tooltip="tooltip"]').tooltip();

   function tooltipHide() {
      $('[data-tooltip="tooltip"]').tooltip('hide');
   }

   $('#ceklis-semua').click(function() {
      if ($(this).is(':checked') == true) {
         $('input[type="checkbox"]').prop('checked', true);
      } else {
         $('input[type="checkbox"]').prop('checked', false);
      }
   });

   $('#click-import').click(function() {
      tooltipHide();
      $('#modalImport').modal('show');
   });
</script>