<?php
require "../config.php";
$token_kelas = $_POST['token_kelas'];
$m_bulan_tahun = $_POST['m_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_masuk am JOIN tb_siswa s ON am . id_siswa = s . id_siswa WHERE am . m_bulan_tahun = '$m_bulan_tahun' && am . token_kelas = '$token_kelas' ORDER BY s . nama_depan,nama_belakang ASC");

$m_bulan = explode('-', $m_bulan_tahun)[0];
$m_tahun = explode('-', $m_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_masuk) { ?>
   <tr class="text-uppercase">
      <!-- <td><?= $no++ ?></td> -->
      <th class="text-left"><?= $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] ?></th>

      <?php
      for ($i = 1; $i <= $jml_hari; $i++) {
         if ($i < 10) {
            $i = 0 . $i;
         }

         $nama_hari = date('l', strtotime($m_tahun . '/' . $m_bulan . '/' . $i));

         $tanggal = $m_tahun . '-' . $m_bulan . '-' . $i;
         $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . $tanggal . "'");

         if ($jadwal_libur) {
            echo '<td style="background-color: #E5E7EB;" title="' . $jadwal_libur['keterangan'] . '">L</td>';
         } else {
            if ($nama_hari !== 'Sunday') {
               if (!empty($a_masuk[$i])) {
                  $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$i]'");
                  echo '<td class="cursor-pointer info-masuk" data-token_masuk="' . $a_masuk[$i] . '" data-id_siswa="' . $a_masuk['id_siswa'] . '">';
                  if ($a_masukket['m_alasan'] == 'hadir') {
                     echo 'H' . "<div style='white-space: nowrap;'>" . date('H.i', $a_masukket['m_pada']) . '</div>';
                  } elseif ($a_masukket['m_alasan'] == 'izin') {
                     echo 'I' . "<div style='white-space: nowrap;'>" . date('H.i', $a_masukket['m_pada']) . '</div>';
                  } elseif ($a_masukket['m_alasan'] == 'sakit') {
                     echo 'S' . "<div style='white-space: nowrap;'>" . date('H.i', $a_masukket['m_pada']) . '</div>';
                  } elseif ($a_masukket['m_alasan'] == 'terlambat') {
                     echo 'T' . "<div style='white-space: nowrap;'>" . date('H.i', $a_masukket['m_pada']) . '</div>';
                  }
               } else {
                  echo '<td></td>';
               }
            } else {
               echo "<td style='background-color: #E5E7EB;'></td>";
            }
         }
      } ?>
   </tr>
<?php }
if (mysqli_num_rows($result) == 0) { ?>
   <tr>
      <th></th>
      <td colspan="<?= $jml_hari + 2 ?>" class="text-center">
         tidak ada data yang ditampilkan
      </td>
   </tr>
<?php } ?>

<script>
   $('.info-masuk').click(function() {
      $('#modalInfoAMasuk').modal('show');
      var id_siswa = $(this).attr('data-id_siswa');
      token_masuk = $(this).attr('data-token_masuk');
      $('#loadInfoAMasuk').load('loadInfoAMasuk?id_siswa=' + id_siswa + '&token_masuk=' + token_masuk);
   });
</script>