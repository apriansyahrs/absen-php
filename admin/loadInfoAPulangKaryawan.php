<?php
require "../config.php";
if (isset($_GET['token_pulang'])) {
   $id_karyawan = $_GET['id_karyawan'];
   $token_pulang = $_GET['token_pulang'];
   $tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE id_karyawan = '$id_karyawan'");
   $a_pulangket_karyawan = query("SELECT * FROM a_pulangket_karyawan WHERE token_pulang = '$token_pulang'"); ?>

   <div class="row">
      <div class="col-md-7">
         <table cellpadding="8" cellspacing="0" class="text-uppercase mb-2">
            <tr>
               <td class="text-left">nip</td>
               <td>:</td>
               <td class="text-left"><?= $tb_karyawan['nip'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Nama</td>
               <td>:</td>
               <td class="text-left"><?= $tb_karyawan['nama'] ?></td>
            </tr>
            <tr>
               <td class="text-left">jabatan</td>
               <td>:</td>
               <td class="text-left"><?= $tb_karyawan['jabatan'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Alasan</td>
               <td>:</td>
               <td class="text-left">
                <?= $a_pulangket_karyawan['p_alasan'] ?>
               </td>
            </tr>
            <?php if ($a_pulangket_karyawan['p_alasan'] == 'cuti') { ?>
            <tr>
               <td class="text-left">Keterangan</td>
               <td>:</td>
               <td class="text-left">
                  <?= $a_pulangket_karyawan['p_ket'] ?>
               </td>
            </tr>
            <?php } ?>
            <tr>
               <td class="text-left">Pada</td>
               <td>:</td>
               <td class="text-left"><?= hari(date('D', $a_pulangket_karyawan['p_pada'])) . ', ' . date('H:i', $a_pulangket_karyawan['p_pada']) ?></td>
            </tr>
            <tr>
               <td class="text-left">Jenis Kelamin</td>
               <td>:</td>
               <td class="text-left"><?= $tb_karyawan['jk'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Alamat</td>
               <td>:</td>
               <td class="text-left"><?= $tb_karyawan['alamat'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Foto karyawan</td>
               <td>:</td>
               <td class="text-left">
                  <img src="<?= base_url() ?>/img/<?= $a_pulangket_karyawan['p_foto'] ?>" alt="gambar" class="img-thumbnail img-fluid">
               </td>
            </tr>
         </table>
      </div>
      <div class="col-md-5 text-center">
         <div id="map_pulang" style="width: 100%; height: 300px;"></div>
      </div>
   </div>
   </div>

   <script src="https://maps.googleapis.com/maps/api/js?key=<?= $tb_setelan['api_maps'] ?>&callback=initialize" async defer></script>
   <script>
      function initialize() {
         var myLating = new google.maps.LatLng('<?= $a_pulangket_karyawan['latitude'] ?>', '<?= $a_pulangket_karyawan['longitude'] ?>')
         var propertiPeta = {
            center: myLating,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
         };

         var peta = new google.maps.Map(document.getElementById("map_pulang"), propertiPeta);

         var marker = new google.maps.Marker({
            position: myLating,
            map: peta,
            title: 'Info siswa',
            icon: '<?= base_url() ?>/assets/img/icons8-marker-24.png'
         });

         var contentString = '<div id="content" class="text-left">' +
            '<div id="siteNotice">' +
            '</div>' +
            '<div id="bodyContent">' +
            '<h6 class="text-uppercase">PULANG</h6>' +
            '<p class="mb-0"><?= hari(date('D', $a_pulangket_karyawan['p_pada'])) . ', ' . date('d', $a_pulangket_karyawan['p_pada']) . ' ' . bulan(date('m', $a_pulangket_karyawan['p_pada'])) . ' ' . date('Y', $a_pulangket_karyawan['p_pada']) . ' ' . date('H:i', $a_pulangket_karyawan['p_pada']); ?></p>' +
            '<a href="https://maps.google.com/maps?q=<?= $a_pulangket_karyawan['latitude'] ?>,<?= $a_pulangket_karyawan['longitude'] ?>&<?= $a_pulangket_karyawan['latitude'] ?>,<?= $a_pulangket_karyawan['longitude'] ?>,15z" target="_BLANK">Buka google maps</a>' +
            '</div>' +
            '</div>';

         var infowindow = new google.maps.InfoWindow({
            content: contentString
         });

         google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(peta, marker);
         });
      }
   </script>
<?php } ?>