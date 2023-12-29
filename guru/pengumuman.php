<?php
require "../config.php";
$result = mysqli_query($conn, "SELECT id_guru FROM tb_kelas WHERE id_guru = '$_SESSION[guru]' ORDER BY kelas ASC");
if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
      </div>
   </div>
<?php } else { ?>

   <div class="content-title">Pengumuman</div>
   <div class="card">
      <div class="card-header p-4 border-0">
         <button type="button" class="btn btn-linear-primary waves-effect waves-light" data-toggle="modal" data-target="#modalBuatPengumuman">
            <i class="fa fa-plus fa-fw"></i> Pengumuman
         </button>
      </div>
      <div class="py-2">
         <div class="table-responsive">
            <table class="table table-hover">
               <thead>
                  <tr>
                     <th width="10%" class="text-center">No</th>
                     <th width="20%">Kelas</th>
                     <th width="60%">Pengumuman</th>
                     <th width="10%" class="text-center">Aksi</th>
                  </tr>
               </thead>
               <tbody>
                  <?php
                     $no = 1;
                     $result = mysqli_query($conn, "SELECT * FROM tb_pengumuman WHERE id_guru = '$_SESSION[guru]' ORDER BY ditambahkan DESC");
                     foreach ($result as $tb_pengumuman) {
                        $tb_kelas = query("SELECT kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$tb_pengumuman[token_kelas]'"); ?>
                     <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                           <span class="f-size-16px"><?= $tb_kelas['kelas'] ?></span>
                        </td>
                        <td>
                           <?php
                                 if (strlen($tb_pengumuman['pengumuman']) > 200) {
                                    echo substr($tb_pengumuman['pengumuman'], 0, 200) . '...';
                                 } else {
                                    echo $tb_pengumuman['pengumuman'];
                                 } ?>
                           <p class="text-black-50 f-size-12px mb-0">
                              <?= hari(date('D', $tb_pengumuman['ditambahkan'])) . ', ' . date('d', $tb_pengumuman['ditambahkan']) . ' ' . bulan(date('m', $tb_pengumuman['ditambahkan'])) . ' ' . date('Y', $tb_pengumuman['ditambahkan']) . ' ' . date('H:i', $tb_pengumuman['ditambahkan']) ?>
                              <i class="far fa-comment-alt mx-2"></i>(<?= num_rows("SELECT id_pengumuman FROM tb_tanggapan WHERE id_pengumuman = '$tb_pengumuman[id_pengumuman]'") ?>)
                           </p>
                        </td>
                        <td class="text-center">
                           <button type="button" class="btn btn-light btn-sm border-0 waves-effect click-edit" style="width: 33px; height: 33px;" data-id_pengumuman="<?= $tb_pengumuman['id_pengumuman'] ?>" data-pengumuman="<?= $tb_pengumuman['pengumuman'] ?>">
                              <i class="fa fa-pen"></i>
                           </button>
                           <button type="button" class="btn btn-light btn-sm border-0 waves-effect click-hapus" style="width: 33px; height: 33px;" data-id_pengumuman="<?= $tb_pengumuman['id_pengumuman'] ?>">
                              <i class="fa fa-trash"></i>
                           </button>
                        </td>
                     </tr>
                  <?php }
                     if (mysqli_num_rows($result) == 0) { ?>
                     <tr>
                        <td colspan="4" class="text-center">
                           tidak ada data yang ditampilkan
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <form id="formBuatPengumuman">
      <div class="modal fade animated zoomIn" id="modalBuatPengumuman" tabindex="-1" role="dialog" aria-labelledby="modalBuatPengumumanLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Buat pengumuman</h5>
               </div>
               <div class="modal-body overflow-x-hidden">
                  <div class="form-group">
                     <textarea name="pengumuman" id="pengumuman" rows="5" class="form-control form-control2" placeholder="Pengumuman" required></textarea>
                  </div>
                  <div class="form-group">
                     <select name="token_kelas" id="token_kelas" class="custom-select custom-select2" required>
                        <option value=""></option>
                        <?php
                           $result = mysqli_query($conn, "SELECT kelas,token_kelas FROM tb_kelas WHERE id_guru = '$_SESSION[guru]' ORDER BY kelas ASC");
                           foreach ($result as $tb_kelas) {
                              echo "<option value='$tb_kelas[token_kelas]'>$tb_kelas[kelas]</option>";
                           } ?>
                     </select>
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

   <form id="formEditPengumuman">
      <div class="modal fade animated zoomIn" id="modalEditPengumuman" tabindex="-1" role="dialog" aria-labelledby="modalEditPengumumanLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Edit pengumuman</h5>
               </div>
               <div class="modal-body text-center overflow-x-hidden">
                  <input type="hidden" name="id_pengumuman" id="id_pengumumanEdit">
                  <div class="form-group">
                     <textarea name="pengumuman" id="pengumumanEdit" rows="5" class="form-control form-control2" placeholder="Pengumuman" required></textarea>
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
      $('.click-edit').click(function() {
         $('#modalEditPengumuman').modal('show');

         var id_pengumuman = $(this).attr('data-id_pengumuman');
         pengumuman = $(this).attr('data-pengumuman');
         $('#id_pengumumanEdit').val(id_pengumuman);
         $('#pengumumanEdit').val(pengumuman);
      });

      $('#formEditPengumuman').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-edit?edit_pengumuman',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  pesan('Data berhasil disimpan', 3000);
                  $('[data-dismiss=modal]').trigger({
                     type: 'click'
                  });
                  setTimeout(function() {
                     $('#content').load('pengumuman.php');
                  }, 300);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('#formBuatPengumuman').submit(function(e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'aksi-tambah?tambah_pengumuman',
            data: new FormData(this),
            contentType: false,
            processData: false,
            cache: false,
            success: function(data) {
               if (data == 'berhasil') {
                  pesan('Data berhasil disimpan', 3000);
                  $('[data-dismiss=modal]').trigger({
                     type: 'click'
                  });
                  setTimeout(function() {
                     $('#content').load('pengumuman');
                  }, 300);
               } else {
                  pesan('Terdapat kesalahan pada sistem!', 3000);
               }
            }
         });
      });

      $('.click-hapus').click(function() {
         var id_pengumuman = $(this).attr('data-id_pengumuman');
         Swal.fire({
            title: 'Konfirmasi?',
            text: 'Data yang dipilih akan dihapus',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: 'post',
                  url: 'aksi-hapus?hapus_pengumuman',
                  data: {
                     id_pengumuman: id_pengumuman
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Data berhasil dihapus', 3000);
                        $('#content').load('pengumuman.php');
                     } else {
                        pesan('Terdapat kesalahan pada sistem', 3000);
                     }
                  }
               });
            }
         });
      });

      $('#token_kelas').select2({
         theme: 'bootstrap4',
         placeholder: 'Untuk kelas'
      });
   </script>

<?php } ?>