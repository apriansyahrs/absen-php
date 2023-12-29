<?php
require "../config.php";
if (isset($_GET['token_masuk'])) {
   $id_karyawan = $_GET['id_karyawan'];
   $token_masuk = $_GET['token_masuk'];
   $tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE id_karyawan = '$id_karyawan'");
   $a_masukket_karyawan = query("SELECT * FROM a_masukket_karyawan WHERE token_masuk = '$token_masuk'");
   
   if ($a_masukket_karyawan['m_alasan'] == 'terlambat') {
        $terlambat = $a_masukket_karyawan['terlambat'];
        $jam = gmdate('H', $terlambat);
        $menit = gmdate('i', $terlambat);
        $detik = gmdate('s', $terlambat);
        
        if ($detik === '00') {
            if ($menit === '00') {
                $terlambat = $jam . ' jam';
            } elseif ($jam === '00') {
                $terlambat = $menit . ' menit';
            } else {
                $terlambat = $jam . ' jam ' . $menit . ' menit';
            }
        } elseif ($menit === '00') {
            if ($jam === '00') {
                $terlambat = $detik . ' detik';
            } else {
                $terlambat = $jam . ' jam ' . $detik . ' detik';
            }
        } elseif ($jam === '00') {
            $terlambat = $menit . ' menit ' . $detik . ' detik';
        } else {
            $terlambat = $jam . ' jam ' . $menit . ' menit ' . $detik . ' detik';
        }
   }
   
   ?>

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
                  <?= $a_masukket_karyawan['m_alasan'] ?>
               </td>
            </tr>
            <tr>
               <td class="text-left">Keterangan</td>
               <td>:</td>
               <td class="text-left">
                  <?= $a_masukket_karyawan['m_ket'] ?>
               </td>
            </tr>
            <?php if ($a_masukket_karyawan['m_alasan'] == 'terlambat') { ?>
            <tr>
               <td class="text-left">Terlambat</td>
               <td>:</td>
               <td class="text-left">
                  <?= $terlambat ?>
               </td>
            </tr>
            <?php } ?>
            <tr>
               <td class="text-left">Pada</td>
               <td>:</td>
               <td class="text-left"><?= hari(date('D', $a_masukket_karyawan['m_pada'])) . ', ' . date('H:i', $a_masukket_karyawan['m_pada']) ?></td>
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
                  <img src="<?= base_url() ?>/img/<?= $a_masukket_karyawan['m_foto'] ?>" alt="gambar" class="img-thumbnail img-fluid">
               </td>
            </tr>
         </table>
      </div>
      <div class="col-md-5 text-center">
         <div id="map_masuk" style="width: 100%; height: 300px;"></div>
      </div>
   </div>
   </div>

   <script src="https://maps.googleapis.com/maps/api/js?key=<?= $tb_setelan['api_maps'] ?>&callback=initialize" async defer></script>
   <script>
      function initialize() {
         var myLating = new google.maps.LatLng('<?= $a_masukket_karyawan['latitude'] ?>', '<?= $a_masukket_karyawan['longitude'] ?>')
         var propertiPeta = {
            center: myLating,
            zoom: 15,
            mapTypeId: google.maps.MapTypeId.ROADMAP
         };

         var peta = new google.maps.Map(document.getElementById("map_masuk"), propertiPeta);

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
            '<h6 class="text-uppercase"><?= $a_masukket_karyawan['m_alasan'] ?></h6>' +
            '<p class="mb-0"><?= hari(date('D', $a_masukket_karyawan['m_pada'])) . ', ' . date('d', $a_masukket_karyawan['m_pada']) . ' ' . bulan(date('m', $a_masukket_karyawan['m_pada'])) . ' ' . date('Y', $a_masukket_karyawan['m_pada']) . ' ' . date('H:i', $a_masukket_karyawan['m_pada']); ?></p>' +
            '<a href="https://maps.google.com/maps?q=<?= $a_masukket_karyawan['latitude'] ?>,<?= $a_masukket_karyawan['longitude'] ?>&<?= $a_masukket_karyawan['latitude'] ?>,<?= $a_masukket_karyawan['longitude'] ?>,15z" target="_BLANK">Buka google maps</a>' +
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