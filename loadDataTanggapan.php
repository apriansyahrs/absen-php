<?php
require "config.php";
if (isset($_GET['id_pengumuman'])) {
   $id_pengumuman = $_GET['id_pengumuman'];
   $result = mysqli_query($conn, "SELECT * FROM tb_tanggapan tt JOIN tb_siswa ts ON tt . id_siswa = ts . id_siswa WHERE id_pengumuman = '$id_pengumuman' ORDER BY tt . id_tanggapan DESC");
   $jml_tanggapan = num_rows("SELECT id_pengumuman FROM tb_tanggapan WHERE id_pengumuman = '$id_pengumuman'");
   if ($jml_tanggapan !== 0) { ?>
      <h5 class="mb-5" style="color: #1e3056;">Tanggapan terbaru (<?= $jml_tanggapan ?>)</h5>
   <?php } ?>
   <?php foreach ($result as $tb_tanggapan) { ?>
      <div class="card-tanggapan">
         <div class="profil">
            <i class="la la-user <?= $tb_tanggapan['profil'] ?>"></i>
         </div>
         <div class="info">
            <div class="nama">
               <?= $tb_tanggapan['nama_depan'] . ' ' . $tb_tanggapan['nama_belakang'] ?>
            </div>
            <div class="tanggapan-user">
               <?= $tb_tanggapan['tanggapan'] ?>
            </div>
            <div class="pada">
               <?= hari(date('D', $tb_tanggapan['pada'])) . ', ' . date('d', $tb_tanggapan['pada']) . ' ' . bulan(date('m', $tb_tanggapan['pada'])) . ' ' . date('Y', $tb_tanggapan['pada']) . ' ' . date('H:i', $tb_tanggapan['pada']); ?>
            </div>
         </div>
      </div>
<?php }
} ?>