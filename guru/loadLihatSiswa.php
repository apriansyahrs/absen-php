<?php
require "../config.php";
$id_siswa = $_GET['id_siswa'];
$tb_siswa = query("SELECT * FROM tb_siswa WHERE id_siswa = '$id_siswa'");
$tb_kelas = query("SELECT kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$tb_siswa[token_kelas]'"); ?>

<div class="content-title">Daftar siswa</div>
<div class="card">
   <div class="card-header">
      <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
         <i class="la la-angle-left f-size-18px mr-2"></i>Kelas: <?= $tb_kelas['kelas'] ?>
      </button>
   </div>
   <div class="card-body text-uppercase">
      <div class="float-md-right mb-4">
         <button type="button" class="btn btn-excel btn-lg border-0 waves-effect waves-light" id="click-export-excel-siswa" data-file_name="<?= 'BIODATA ' . $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] . ' KELAS ' . $tb_kelas['kelas'] ?>">
            <i class="fa fa-file-excel"></i></i> Export
         </button>
      </div>
      <table class="data-siswa" cellpadding="10" cellspacing="0">
         <tr>
            <td>NIS</td>
            <td>:</td>
            <td><?= $tb_siswa['nis'] ?></td>
         </tr>
         <tr>
            <td>Password</td>
            <td>:</td>
            <td class="text-lowercase"><?= $tb_siswa['password'] ?></td>
         </tr>
         <tr>
            <td>Nama</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></td>
         </tr>
         <tr>
            <td>Kelas</td>
            <td>:</td>
            <td><?= $tb_kelas['kelas'] ?></td>
         </tr>
         <tr>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?= $tb_siswa['jk'] ?></td>
         </tr>
         <tr>
            <td>Telegram</td>
            <td>:</td>
            <td><?= $tb_siswa['telegram'] ?></td>
         </tr>
         <tr>
            <td>Provinsi</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['provinsi'])) {
                  $provinsi = query("SELECT * FROM w_provinces WHERE id = '$tb_siswa[provinsi]'");
                  echo $provinsi['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kota/Kabupaten</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kota'])) {
                  $kota = query("SELECT * FROM w_regencies WHERE id = '$tb_siswa[kota]'");
                  echo $kota['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kecamatan</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kecamatan'])) {
                  $kecamatan = query("SELECT * FROM w_districts WHERE id = '$tb_siswa[kecamatan]'");
                  echo $kecamatan['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>Kelurahan</td>
            <td>:</td>
            <td>
               <?php
               if (!empty($tb_siswa['kelurahan'])) {
                  $kelurahan = query("SELECT * FROM w_villages WHERE id = '$tb_siswa[kelurahan]'");
                  echo $kelurahan['name'];
               } ?>
            </td>
         </tr>
         <tr>
            <td>username ortu</td>
            <td>:</td>
            <td><?= $tb_siswa['username_ortu'] ?> <i>(*berikan username ini kepada orang tua siswa agar orang tua siswa dapat memantau anaknya)</i></td>
         </tr>
         <tr>
            <td>nama ayah</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_ayah'] ?></td>
         </tr>
         <tr>
            <td>pekerjaan ayah</td>
            <td>:</td>
            <td><?= $tb_siswa['pekerjaan_ayah'] ?></td>
         </tr>
         <tr>
            <td>nama ibu</td>
            <td>:</td>
            <td><?= $tb_siswa['nama_ibu'] ?></td>
         </tr>
         <tr>
            <td>pekerjaan ibu</td>
            <td>:</td>
            <td><?= $tb_siswa['pekerjaan_ibu'] ?></td>
         </tr>
         <tr>
            <td>telepon rumah</td>
            <td>:</td>
            <td><?= $tb_siswa['telepon_rumah'] ?></td>
         </tr>
      </table>
   </div>
</div>


<script>
   $(function() {
      $('#click-export-excel-siswa').click(function() {
         var file_name = $(this).attr('data-file_name');
         $(".data-siswa").table2excel({
            exclude: ".noExl",
            name: "Excel Document Name",
            filename: file_name,
            fileext: ".xls",
            exclude_img: true,
            exclude_links: true,
            exclude_inputs: true
         });
      });

      $('.kembali').click(function() {
         $('#content').load('loadDataSiswa.php?token_kelas=<?= $tb_kelas['token_kelas'] ?>');
         history.pushState('history.pushtate', 'history.pushtate', '?menu=daftar-siswa&token_kelas=<?= $tb_kelas['token_kelas'] ?>');
      });
   });
</script>