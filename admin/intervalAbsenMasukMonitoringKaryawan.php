<?php
require "../config.php";
$m_bulan_tahun = $_POST['m_bulan_tahun'];
$result = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan am JOIN tb_karyawan s ON am . id_karyawan = s . id_karyawan JOIN tb_jabatan tj ON s . id_jabatan = tj . id_jabatan WHERE am . m_bulan_tahun = '$m_bulan_tahun' ORDER BY s . nama ASC");

$m_bulan = explode('-', $m_bulan_tahun)[0];
$m_tahun = explode('-', $m_bulan_tahun)[1];
$jml_hari = jml_hari($m_bulan, $m_tahun);

$no = 1;
foreach ($result as $a_masuk_karyawan) { ?>
   <tr class="text-uppercase">
      <!-- <td><?= $no++ ?></td> -->
      <th class="text-left"><?= $a_masuk_karyawan['nama'] ?></th>
      <td class="text-left"><?= $a_masuk_karyawan['jabatan'] ?></td>

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
            //    if (!empty($a_masuk_karyawan[$i])) {
            //       $a_masukket_karyawan = query("SELECT * FROM a_masukket_karyawan WHERE token_masuk = '$a_masuk_karyawan[$i]'");
            //       echo '<td class="cursor-pointer info-masuk" data-token_masuk="' . $a_masuk_karyawan[$i] . '" data-id_karyawan="' . $a_masuk_karyawan['id_karyawan'] . '">';
            //       if ($a_masukket_karyawan['m_alasan'] == 'hadir') {
            //          echo 'H';
            //       } elseif ($a_masukket_karyawan['m_alasan'] == 'izin') {
            //          echo 'I';
            //       } elseif ($a_masukket_karyawan['m_alasan'] == 'sakit') {
            //          echo 'S';
            //       } elseif ($a_masukket_karyawan['m_alasan'] == 'terlambat') {
            //          echo 'T';
            //       } elseif ($a_masukket_karyawan['m_alasan'] == 'cuti') {
            //          echo 'C';
            //       }
            //       echo '</td>';
            //    } else {
            //       echo '<td></td>';
            //    }
            //    // Hari Minggu
            // } else {
            //    echo "<td style='background-color: #E5E7EB;'></td>";
            // }
            if (!empty($a_masuk_karyawan[$i])) {
                $a_masukket_karyawan = query("SELECT * FROM a_masukket_karyawan WHERE token_masuk = '$a_masuk_karyawan[$i]'");
                echo '<td class="cursor-pointer info-masuk" data-token_masuk="' . $a_masuk_karyawan[$i] . '" data-id_karyawan="' . $a_masuk_karyawan['id_karyawan'] . '">';
                if ($a_masukket_karyawan['m_alasan'] == 'hadir') {
                   echo 'H';
                } elseif ($a_masukket_karyawan['m_alasan'] == 'izin') {
                   echo 'I';
                } elseif ($a_masukket_karyawan['m_alasan'] == 'sakit') {
                   echo 'S';
                } elseif ($a_masukket_karyawan['m_alasan'] == 'terlambat') {
                   echo 'T';
                } elseif ($a_masukket_karyawan['m_alasan'] == 'cuti') {
                   echo 'C';
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
   $('.info-masuk').click(function() {
      $('#modalInfoAMasukKaryawan').modal('show');
      var id_karyawan = $(this).attr('data-id_karyawan');
      token_masuk = $(this).attr('data-token_masuk');
      $('#loadInfoAMasukKaryawan').load('loadInfoAMasukKaryawan?id_karyawan=' + id_karyawan + '&token_masuk=' + token_masuk);
   });
</script>
