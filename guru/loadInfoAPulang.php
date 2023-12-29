<?php
require "../config.php";
if (isset($_GET['token_pulang'])) {
   $id_siswa = $_GET['id_siswa'];
   $token_pulang = $_GET['token_pulang'];
   $tb_siswa = query("SELECT * FROM tb_siswa WHERE id_siswa = '$id_siswa'");
   $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$token_pulang'"); ?>

   <div class="row">
      <div class="col-md-7">
         <table cellpadding="8" cellspacing="0" class="text-uppercase mb-2">
            <tr>
               <td class="text-left">NIS</td>
               <td>:</td>
               <td class="text-left"><?= $tb_siswa['nis'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Nama</td>
               <td>:</td>
               <td class="text-left"><?= $tb_siswa['nama_depan'] . ' ' . $tb_siswa['nama_belakang'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Alasan</td>
               <td>:</td>
               <td class="text-left">PULANG</td>
            </tr>
            <tr>
               <td class="text-left">Pada</td>
               <td>:</td>
               <td class="text-left"><?= hari(date('D', $a_pulangket['p_pada'])) . ', ' . date('H:i', $a_pulangket['p_pada']) ?></td>
            </tr>
            <tr>
               <td class="text-left">Jenis Kelamin</td>
               <td>:</td>
               <td class="text-left"><?= $tb_siswa['jk'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Telegram</td>
               <td>:</td>
               <td class="text-left"><?= $tb_siswa['telegram'] ?></td>
            </tr>
            <tr>
               <td class="text-left">Provinsi</td>
               <td>:</td>
               <td class="text-left">
                  <?php
                     if (!empty($tb_siswa['provinsi'])) {
                        $provinsi = query("SELECT * FROM w_provinces WHERE id = '$tb_siswa[provinsi]'");
                        echo $provinsi['name'];
                     } ?>
               </td>
            </tr>
            <tr>
               <td class="text-left">Kota/Kabupaten</td>
               <td>:</td>
               <td class="text-left">
                  <?php
                     if (!empty($tb_siswa['kota'])) {
                        $kota = query("SELECT * FROM w_regencies WHERE id = '$tb_siswa[kota]'");
                        echo $kota['name'];
                     } ?>
               </td>
            </tr>
            <tr>
               <td class="text-left">Kecamatan</td>
               <td>:</td>
               <td class="text-left">
                  <?php
                     if (!empty($tb_siswa['kecamatan'])) {
                        $kecamatan = query("SELECT * FROM w_districts WHERE id = '$tb_siswa[kecamatan]'");
                        echo $kecamatan['name'];
                     } ?>
               </td>
            </tr>
            <tr>
               <td class="text-left">Kelurahan</td>
               <td>:</td>
               <td class="text-left">
                  <?php
                     if (!empty($tb_siswa['kelurahan'])) {
                        $kelurahan = query("SELECT * FROM w_villages WHERE id = '$tb_siswa[kelurahan]'");
                        echo $kelurahan['name'];
                     } ?>
               </td>
            </tr>
            <tr>
               <td class="text-left">Foto siswa</td>
               <td>:</td>
               <td class="text-left">
                  <img src="<?= base_url() ?>/img/<?= $a_pulangket['p_foto'] ?>" alt="gambar" class="img-thumbnail img-fluid">
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
         var myLating = new google.maps.LatLng('<?= $a_pulangket['latitude'] ?>', '<?= $a_pulangket['longitude'] ?>')
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
            '<p class="mb-0"><?= hari(date('D', $a_pulangket['p_pada'])) . ', ' . date('d', $a_pulangket['p_pada']) . ' ' . bulan(date('m', $a_pulangket['p_pada'])) . ' ' . date('Y', $a_pulangket['p_pada']) . ' ' . date('H:i', $a_pulangket['p_pada']); ?></p>' +
            '<a href="https://maps.google.com/maps?q=<?= $a_pulangket['latitude'] ?>,<?= $a_pulangket['longitude'] ?>&<?= $a_pulangket['latitude'] ?>,<?= $a_pulangket['longitude'] ?>,15z" target="_BLANK">Buka google maps</a>' +
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