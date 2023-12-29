<?php
require "../config.php";
$p_bulan_tahun = $_POST['p_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_pulang_guru ap JOIN tb_guru s ON ap . id_guru = s . id_guru WHERE ap . p_bulan_tahun = '$p_bulan_tahun' ORDER BY s . nama ASC");

$m_bulan = explode('-', $p_bulan_tahun)[0];
$m_tahun = explode('-', $p_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_pulang_guru) { ?>
   <tr class="text-uppercase">
      <!-- <td><?= $no++ ?></td> -->
      <th class="text-left"><?= $a_pulang_guru['nama'] ?></th>

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
               if (!empty($a_pulang_guru[$i])) {
                  $a_pulangket_guru = query("SELECT * FROM a_pulangket_guru WHERE token_pulang = '$a_pulang_guru[$i]'");
                  echo '<td class="cursor-pointer info-pulang" data-token_pulang="' . $a_pulang_guru[$i] . '" data-id_guru="' . $a_pulang_guru['id_guru'] . '">';

                  if ($a_pulangket_guru['p_alasan'] == 'cuti') {
                     echo 'C';
                  } else {
                     echo 'P';
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