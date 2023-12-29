<?php
require "../config.php";
$result = mysqli_query($conn, "SELECT * FROM tb_kelas WHERE id_guru = '$_SESSION[guru]' ORDER BY kelas ASC");
if (mysqli_num_rows($result) == 0) { ?>
   <div class="row d-flex justify-content-center text-center">
      <div class="col-9 col-md-7 col-lg-5 my-5">
         <img src="<?= base_url() ?>/assets/img/undraw_secure_data_0rwp.svg" alt="gambar" class="img-fluid">
         <p class="f-size-22px mt-3 mb-0">Maaf, saat ini data tidak ditemukan!</p>
      </div>
   </div>
<?php } else { ?>
   <div class="content-title">Daftar siswa</div>
   <div class="card">
      <div class="card-header text-center">
         Pilih kelas
      </div>
      <div class="card-body data-list text-uppercase">
         <ul>
            <?php foreach ($result as $tb_kelas) {
                  $jml_siswa = num_rows("SELECT token_kelas FROM tb_siswa WHERE token_kelas = '$tb_kelas[token_kelas]'"); ?>
               <li class="kelas-item waves-effect" data-token_kelas="<?= $tb_kelas['token_kelas'] ?>">
                  Kelas <?= $tb_kelas['kelas'] ?>
                  <span class="float-right f-size-14px font-italic"><?= $jml_siswa . ' siswa' ?></span>
               </li>
            <?php } ?>
         </ul>
      </div>
   </div>

   <script>
      $('.kelas-item').click(function() {
         content_loader();
         var token_kelas = $(this).attr('data-token_kelas');
         $('#content').load('loadDataSiswa?token_kelas=' + token_kelas);
         history.pushState('history.pushtate', 'history.pushtate', '?menu=daftar-siswa&token_kelas=' + token_kelas);
      });
   </script>

   <?php if (isset($_GET['token_kelas'])) { ?>
      <script>
         $('#content').load('loadDataSiswa?token_kelas=<?= $_GET['token_kelas'] ?>');
      </script>
   <?php } ?>

<?php } ?>