<?php
require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM tb_jabatan"); ?>
<div class="row">
   <div class="col-md-6 my-auto">
      <h4 class="mb-4">Master jabatan</h4>
   </div>
   <div class="col-md-6">
      <div class="text-md-right mb-4 mb-md-0">
         <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#modalTambahJabatan">
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
   <div class="card">
      <div class="card-body">
         <div class="table-reponsive">
            <table class="table">
               <tr>
                  <th width="15%">ID JABATAN</th>
                  <th width="65%">JABATAN</th>
                  <th width="20%" class="text-center">AKSI</th>
               </tr>
               <?php foreach ($result as $tb_jabatan) { ?>
                  <tr>
                     <td><?= $tb_jabatan['id_jabatan'] ?></td>
                     <td><?= $tb_jabatan['jabatan'] ?></td>
                     <td class="text-center">
                        <div class="btn-group">
                           <button type="button" class="btn btn-light border-0 waves-effect edit" data-id_jabatan="<?= $tb_jabatan['id_jabatan'] ?>" data-jabatan="<?= $tb_jabatan['jabatan'] ?>">
                              <i class="fa fa-pen"></i>
                           </button>
                           <button type="button" class="btn btn-light border-0 waves-effect hapus" data-id_jabatan="<?= $tb_jabatan['id_jabatan'] ?>">
                              <i class="fa fa-trash"></i>
                           </button>
                        </div>
                     </td>
                  </tr>
               <?php } ?>
            </table>
         </div>
      </div>
   </div>
<?php } ?>


<form id="formTambahJabatan" enctype="multipart/form-data">
   <div class="modal fade animated zoomIn" id="modalTambahJabatan" tabindex="-1" role="dialog" aria-labelledby="modalTambahJabatanLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">Tambah master jabatan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden">
               <div class="form-group">
                  <label for="jabatan">Jabatan <span></span></label>
                  <input type="text" name="jabatan" id="jabatan" class="form-control form-control4" required="">
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

<form id="formEditJabatan" enctype="multipart/form-data">
   <div class="modal fade animated zoomIn" id="modalEditJabatan" tabindex="-1" role="dialog" aria-labelledby="modalEditJabatanLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="card-title">Edit master jabatan</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <i class="la la-times"></i>
               </button>
            </div>
            <div class="modal-body overflow-x-hidden">
               <input type="hidden" name="id_jabatan_edit" id="id_jabatan_edit">
               <div class="form-group">
                  <label for="jabatan_edit">Jabatan <span></span></label>
                  <input type="text" name="jabatan_edit" id="jabatan_edit" class="form-control form-control4" required="">
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

<script>
   $('#formTambahJabatan').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?tambah_jabatan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               $('[data-dismiss=modal]').trigger({
                  type: 'click'
               });
               setTimeout(function() {
                  $('#content').load('master-jabatan');
               }, 300);

               pesan('Data berhasil disimpan', 3000);
            } else {
               pesan(data, 3000);
            }
         }
      });
   });

   $('.edit').click(function() {
      var id_jabatan = $(this).attr('data-id_jabatan');
      var jabatan = $(this).attr('data-jabatan');
      $('#modalEditJabatan').modal('show');
      $('#id_jabatan_edit').val(id_jabatan);
      $('#jabatan_edit').val(jabatan);
   });

   $('#formEditJabatan').submit(function(e) {
      e.preventDefault();
      $.ajax({
         type: 'post',
         url: 'aksi?edit_jabatan',
         data: new FormData(this),
         contentType: false,
         processData: false,
         cache: false,
         success: function(data) {
            if (data == 'berhasil') {
               $('[data-dismiss=modal]').trigger({
                  type: 'click'
               });
               setTimeout(function() {
                  $('#content').load('master-jabatan');
               }, 300);

               pesan('Data berhasil disimpan', 3000);
            } else {
               pesan(data, 3000);
            }
         }
      });
   });


   $('.hapus').click(function() {
      var id_jabatan = $(this).attr('data-id_jabatan');
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
               url: 'aksi?hapus_jabatan',
               data: {
                  id_jabatan: id_jabatan
               },
               success: function(data) {
                  if (data == 'berhasil') {
                     pesan('Data berhasil dihapus', 3000);
                     $('#content').load('master-jabatan');
                  } else {
                     pesan(data, 3000);
                  }
               }
            });
         }
      });
   });
</script>