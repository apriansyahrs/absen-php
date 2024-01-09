<?php
require "../config.php";
$p_bulan_tahun = $_POST['p_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_pulang_karyawan ap JOIN tb_karyawan s ON ap . id_karyawan = s . id_karyawan JOIN tb_jabatan tj ON s . id_jabatan = tj . id_jabatan WHERE ap . p_bulan_tahun = '$p_bulan_tahun' ORDER BY s . nama ASC");

$m_bulan = explode('-', $p_bulan_tahun)[0];
$m_tahun = explode('-', $p_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_pulang_karyawan) { ?>
   <tr class="text-uppercase">
      <!-- <td><?= $no++ ?></td> -->
      <th class="text-left"><?= $a_pulang_karyawan['nama'] ?></th>
      <td class="text-left"><?= $a_pulang_karyawan['jabatan'] ?></td>

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
            // if ($nama_hari !== 'Sunday') {
            //    if (!empty($a_pulang_karyawan[$i])) {
            //       $a_pulangket_karyawan = query("SELECT * FROM a_pulangket_karyawan WHERE token_pulang = '$a_pulang_karyawan[$i]'");
            //       echo '<td class="cursor-pointer info-pulang" data-token_pulang="' . $a_pulang_karyawan[$i] . '" data-id_karyawan="' . $a_pulang_karyawan['id_karyawan'] . '">';

            //       if ($a_pulangket_karyawan['p_alasan'] == 'cuti') {
            //          echo 'C';
            //       } else {
            //          echo 'P';
            //       }

            //       echo '</td>';
            //    } else {
            //       echo '<td></td>';
            //    }
            // } else {
            //    echo "<td style='background-color: #E5E7EB;'></td>";
            // }
            if (!empty($a_pulang_karyawan[$i])) {
                $a_pulangket_karyawan = query("SELECT * FROM a_pulangket_karyawan WHERE token_pulang = '$a_pulang_karyawan[$i]'");
                echo '<td class="cursor-pointer info-pulang" data-token_pulang="' . $a_pulang_karyawan[$i] . '" data-id_karyawan="' . $a_pulang_karyawan['id_karyawan'] . '">';

                if ($a_pulangket_karyawan['p_alasan'] == 'cuti') {
                   echo 'C';
                } else {
                   echo 'P';
                }

                echo '</td>';
             } else {
                echo '<td></td>';
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
   $('.info-pulang').click(function() {
      $('#modalInfoPulangKaryawan').modal('show');
      var id_karyawan = $(this).attr('data-id_karyawan');
      token_pulang = $(this).attr('data-token_pulang');
      $('#loadInfoPulangKaryawan').load('loadInfoAPulangKaryawan?id_karyawan=' + id_karyawan + '&token_pulang=' + token_pulang);
   });
</script>
