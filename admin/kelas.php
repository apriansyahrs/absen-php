<?php require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM tb_kelas ORDER BY kelas ASC"); ?>
<div class="row">
   <div class="col-md-6 my-auto">
      <h4 class="mb-4">Kelas keseluruhan</h4>
   </div>
   <div class="col-md-6">
      <div class="text-md-right mb-4 mb-md-0">
         <button type="button" class="btn btn-primary waves-effect waves-light" id="click-buat-kelas">
            <i class="fa fa-plus fa-fw"></i>
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
      <div class="py-2">
         <div class="table-responsive overlay-scrollbars">
            <table class="table table-hover">
               <thead>
                  <th width="5%" class="text-center">No</th>
                  <th width="10%">Kelas</th>
                  <th width="10%" class="text-center">Masuk</th>
                  <th width="10%" class="text-center">Pulang</th>
                  <th width="10%" class="text-center">Pulang</th>
                  <th width="8%" class="text-center">Notif TG</th>
                  <th width="18%" class="text-center">Guru</th>
                  <th width="20%" class="text-center">Token kelas</th>
                  <th width="10%" class="text-center">Aksi</th>
               </thead>
               <tbody>
                  <?php
                     $no = 1;
                     foreach ($result as $tb_kelas) {
                        $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'"); ?>
                     <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                           <p class="f-size-18px mb-0"><?= $tb_kelas['kelas'] ?></p>
                        </td>
                        <td class="text-center"><?= $tb_kelas['masuk_mulai'] . '-' . $tb_kelas['masuk_akhir'] ?></td>
                        <td class="text-center"><?= $tb_kelas['pulang_mulai'] . '-' . $tb_kelas['pulang_akhir'] ?></td>
                        <td class="text-center">
                           <?= $tb_kelas['pulang_mulai_jumat'] . '-' . $tb_kelas['pulang_akhir_jumat'] ?></td>
                        <td class="text-center"><?= $tb_kelas['notif_absen_telegram'] ?></td>
                        <td class="text-center"><?= $tb_guru['nama'] ?></td>
                        <td class="text-center"><?= $tb_kelas['token_kelas'] ?></td>
                        <td class="text-center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-light border-0 waves-effect edit" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
                                 <i class="fa fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-light border-0 waves-effect hapus" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
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
         </div>
      </div>
   </div>

   <script>
      $('.edit').click(function() {
         $('html, body').animate({
            scrollTop: '0'
         }, 200);
         var token_kelas = $(this).attr('data-token_kelas');
         history.pushState('Edit kelas', 'Edit kelas', '?menu=kelas&token_kelas=' + token_kelas);
         $('#content').load('edit-kelas?menu=kelas&token_kelas=' + token_kelas);
      })

      $('.hapus').click(function() {
         var token_kelas = $(this).attr('data-token_kelas');
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
                  url: '../guru/aksi-hapus?hapus_kelas',
                  data: {
                     token_kelas: token_kelas
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Data berhasil dihapus', 3000);
                        $('#content').load('kelas');
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
   </script>

<?php } ?>

<script>
   $('#click-buat-kelas').click(function() {
      $('html, body').animate({
         scrollTop: '0'
      }, 200);
      history.pushState('Buat kelas', 'Buat kelas', '?menu=buat-kelas');
      $('#content').load('buat-kelas');
   });
</script>