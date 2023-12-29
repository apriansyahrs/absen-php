<?php
require "../config.php";
$no = 1;
$result = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE id_guru = '$_SESSION[guru]' ORDER BY kelas ASC");
if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
      </div>
   </div>
<?php } else { ?>
   <div class="content-title">Daftar kelas</div>
   <div class="card">
      <div class="card-header p-4 border-0">
         <button type="button" class="btn btn-linear-primary waves-effect waves-light click-buat-kelas">
            <i class="fa fa-plus fa-fw"></i> Buat kelas
         </button>
      </div>
      <div class="py-2">
         <div class="table-responsive">
            <table class="table table-hover">
               <thead>
                  <th width="10%" class="text-center">No</th>
                  <th width="20%">Kelas</th>
                  <th width="15%" class="text-center">Masuk</th>
                  <th width="15%" class="text-center">Pulang</th>
                  <th width="15%" class="text-center">Pulang (Jumat)</th>
                  <th width="10%" class="text-center">Jumlah</th>
                  <th width="20%" class="text-center">Aksi</th>
               </thead>
               <tbody>
                  <?php foreach ($result as $tb_kelas) {
                        $jml_siswa = num_rows("SELECT token_kelas FROM tb_siswa WHERE token_kelas = '$tb_kelas[token_kelas]'"); ?>
                     <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td>
                           <span class="f-size-16px">
                              <?= $tb_kelas['kelas'] ?>
                           </span>
                        </td>
                        <td class="text-center"><?= $tb_kelas['masuk_mulai'], '-' . $tb_kelas['masuk_akhir'] ?></td>
                        <td class="text-center"><?= $tb_kelas['pulang_mulai'], '-' . $tb_kelas['pulang_akhir'] ?></td>
                        <td class="text-center">
                           <?= $tb_kelas['pulang_mulai_jumat'], '-' . $tb_kelas['pulang_akhir_jumat'] ?></td>
                        <td class="text-center">
                           <span class="font-italic">
                              <?= $jml_siswa . ' siswa' ?>
                           </span>
                        </td>
                        <td class="text-center">
                           <div class="btn-group">
                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect lihat-token" style="width: 33px; height: 33px;" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
                                 <i class="fa fa-key"></i>
                              </button>
                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect edit" style="width: 33px; height: 33px;" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
                                 <i class="fa fa-pen"></i>
                              </button>
                              <button type="button" class="btn btn-light btn-sm border-0 waves-effect hapus" style="width: 33px; height: 33px;" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
                                 <i class="fa fa-trash"></i>
                              </button>
                           </div>
                        </td>
                     </tr>
                  <?php } ?>
               </tbody>
            </table>
         </div>
      </div>
   </div>

   <div class="modal fade animated zoomIn" id="modalLihatTokenKelas" tabindex="-1" role="dialog" aria-labelledby="modalLihatTokenKelasLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Token kelas</h5>
            </div>
            <div class="modal-body overflow-x-hidden">
               <div class="form-group">
                  <p>Berikan token ini kepada siswa, jika siswa ingin bergabung dikelas ini.</p>
               </div>
               <div class="input-group mb-3">
                  <input type="text" id="token_kelas" class="form-control form-control3 form-control-lg" readonly>
                  <div class="input-group-append">
                     <button type="button" class="btn btn-primary btn-lg border-0 waves-effect waves-light" onclick="copyText()">
                        <i class="far fa-copy"></i>
                     </button>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-modal-false waves-effect" data-dismiss="modal">Tutup</button>
            </div>
         </div>
      </div>
   </div>


   <script>
      $('.lihat-token').click(function() {
         $('#modalLihatTokenKelas').modal('show');
         var token_kelas = $(this).attr('data-token_kelas');
         $('#token_kelas').val(token_kelas)
      });

      $('.edit').click(function() {
         var token_kelas = $(this).attr('data-token_kelas');
         $('#content').load('loadEditKelas.php?token_kelas=' + token_kelas);
      });

      $('.hapus').click(function() {
         var token_kelas = $(this).attr('data-token_kelas');
         Swal.fire({
            title: 'Konfirmasi?',
            text: 'Data yang dipilih akan dihapus, termasuk data siswa dan data absen keseluruhan!',
            showCancelButton: true,
            confirmButtonColor: '#4086EF',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.value) {
               $.ajax({
                  type: 'post',
                  url: 'aksi-hapus?hapus_kelas',
                  data: {
                     token_kelas: token_kelas
                  },
                  success: function(data) {
                     if (data == 'berhasil') {
                        pesan('Data berhasil dihapus', 3000);
                        $('#content').load('daftar-kelas.php');
                     } else {
                        pesan('Terdapat kesalahan pada sistem!', 3000);
                     }
                  }
               });
            }
         });
      });

      $('.click-buat-kelas').click(function() {
         $('.sidebar-item').removeClass('active');
         $('#click-buat-kelas').addClass('active');
         $('#content').load('buat-kelas');
         history.pushState('buat-kelas', 'buat-kelas', '?menu=buat-kelas');
      });

      function copyText() {
         var copyText = document.getElementById("token_kelas");
         copyText.select();
         copyText.setSelectionRange(0, 99999);
         document.execCommand("copy");
         pesan('Teks disalin', 3000);
      }
   </script>

<?php } ?>