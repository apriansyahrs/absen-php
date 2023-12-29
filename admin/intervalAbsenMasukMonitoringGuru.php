<?php
require "../config.php";
$m_bulan_tahun = $_POST['m_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_masuk_guru am JOIN tb_guru s ON am . id_guru = s . id_guru WHERE am . m_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");

$m_bulan = explode('-', $m_bulan_tahun)[0];
$m_tahun = explode('-', $m_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_masuk_guru) { ?>
   <tr class="text-uppercase">
      <!-- <td><?= $no++ ?></td> -->
      <th class="text-left"><?= $a_masuk_guru['nama'] ?></th>

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
               if (!empty($a_masuk_guru[$i])) {
                  $a_masukket_guru = query("SELECT * FROM a_masukket_guru WHERE token_masuk = '$a_masuk_guru[$i]'");
                  echo '<td class="cursor-pointer info-masuk" data-token_masuk="' . $a_masuk_guru[$i] . '" data-id_guru="' . $a_masuk_guru['id_guru'] . '">';
                  if ($a_masukket_guru['m_alasan'] == 'hadir') {
                     echo 'H';
                  } elseif ($a_masukket_guru['m_alasan'] == 'izin') {
                     echo 'I';
                  } elseif ($a_masukket_guru['m_alasan'] == 'sakit') {
                     echo 'S';
                  } elseif ($a_masukket_guru['m_alasan'] == 'terlambat') {
                     echo 'T';
                  } elseif ($a_masukket_guru['m_alasan'] == 'cuti') {
                     echo 'C';
                  }
                  echo '</td>';
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
      $('#modalInfoAMasukGuru').modal('show');
      var id_guru = $(this).attr('data-id_guru');
      token_masuk = $(this).attr('data-token_masuk');
      $('#loadInfoAMasukGuru').load('loadInfoAMasukGuru?id_guru=' + id_guru + '&token_masuk=' + token_masuk);
   });
</script>