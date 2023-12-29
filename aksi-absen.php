<?php
require "config.php";
if (isset($_SESSION['siswa'])) {
   // $ref_angkatan_id = getIdAngkatanSekarang();
   // if (!$ref_angkatan_id) {
   //    echo 'err_01';
   //    return false;
   // }

   // absen masuk
   if (isset($_GET['absen_masuk'])) {
      $id_guru = $_POST['id_guru'];
      $id_siswa = $_POST['id_siswa'];
      $m_tanggal = date('d');
      $m_bulan_tahun = date('m-Y');
      $token_kelas = $_POST['token_kelas'];

      $m_alasan = $_POST['m_alasan'];
      $m_ket = htmlspecialchars($_POST['m_ket']);
      $m_pada = time();
      $latitude = htmlspecialchars($_POST['latitude']);
      $longitude = htmlspecialchars($_POST['longitude']);
      $token_masuk = $tb_siswa['nis'] . '-' . time();

      $img = $_POST['m_foto'];
      $folderPath = "img/";

      $image_parts = explode(";base64,", $img);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];

      $image_base64 = base64_decode($image_parts[1]);
      $fileNama =  $tb_siswa['nis'] . '-' . time() . '.png';

      $file = $folderPath . $fileNama;
      file_put_contents($file, $image_base64);

      $jml_masuk = num_rows("SELECT id_siswa,m_bulan_tahun FROM a_masuk WHERE id_siswa = '$id_siswa' && m_bulan_tahun = '$m_bulan_tahun'");

      if ($jml_masuk == 0) {
         $query1 = mysqli_query($conn, "INSERT INTO a_masuk (id_guru,id_siswa,`$m_tanggal`,m_tanggal,m_bulan_tahun,token_kelas) VALUES ('$id_guru','$id_siswa','$token_masuk','$m_tanggal','$m_bulan_tahun','$token_kelas')");
      } else {
         $query1 = mysqli_query($conn, "UPDATE a_masuk SET `$m_tanggal` = '$token_masuk', m_tanggal = '$m_tanggal' WHERE id_siswa = '$id_siswa' && m_bulan_tahun = '$m_bulan_tahun' && token_kelas = '$token_kelas'");
      }

      if ($m_alasan == 'terlambat') {

         $jadwal = $tb_kelas['masuk_akhir'] . ':00';
         $jam_sekarang = date('H:i:s');
         $sekarang_jam = date('H', strtotime($jam_sekarang));
         $akhir_jam = date('H', strtotime($jadwal));
         $terlambat_jam = $sekarang_jam - $akhir_jam;

         $sekarang_menit = date('i', strtotime($jam_sekarang));
         $akhir_menit = date('i', strtotime($jadwal));

         if ($sekarang_menit < $akhir_menit) {
            $terlambat_jam = $terlambat_jam - 1;
            $terlambat_menit = 60 - $akhir_menit + $sekarang_menit;
         } else {
            $terlambat_menit = $sekarang_menit - $akhir_menit;
         }

         $sekarang_detik = date('s', strtotime($jam_sekarang));
         $akhir_detik = date('s', strtotime($jadwal));

         $terlambat_detik = $sekarang_detik - $akhir_detik;

         $jam_ke_detik = $terlambat_jam * 3600;
         $menit_ke_detik = $terlambat_menit * 60;
         $terlambat = $jam_ke_detik + $menit_ke_detik + $terlambat_detik;

         $query2 = mysqli_query($conn, "INSERT INTO a_masukket (m_alasan,m_ket,terlambat,m_foto,m_pada,latitude,longitude,token_masuk,token_kelas) VALUES ('$m_alasan','$m_ket','$terlambat','$fileNama','$m_pada','$latitude','$longitude','$token_masuk','$token_kelas')");
      } else {
         $query2 = mysqli_query($conn, "INSERT INTO a_masukket (m_alasan,m_ket,m_foto,m_pada,latitude,longitude,token_masuk,token_kelas) VALUES ('$m_alasan','$m_ket','$fileNama','$m_pada','$latitude','$longitude','$token_masuk','$token_kelas')");
      }

      $a_masuk = query("SELECT id_siswa,m_bulan_tahun,token_kelas,hadir,izin,sakit,terlambat FROM a_masuk WHERE id_siswa = '$id_siswa' && m_bulan_tahun = '$m_bulan_tahun' && token_kelas = '$token_kelas'");

      if ($m_alasan == 'hadir') {
         $jml_alasan = $a_masuk['hadir'] + 1;
      } elseif ($m_alasan == 'izin') {
         $jml_alasan = $a_masuk['izin'] + 1;
      } elseif ($m_alasan == 'sakit') {
         $jml_alasan = $a_masuk['sakit'] + 1;
      } elseif ($m_alasan == 'terlambat') {
         $jml_alasan = $a_masuk['terlambat'] + 1;
      }

      $query3 = mysqli_query($conn, "UPDATE a_masuk SET `$m_alasan` = '$jml_alasan' WHERE id_siswa = '$id_siswa' && m_bulan_tahun = '$m_bulan_tahun' && token_kelas = '$token_kelas'");


      if ($query1 && $query2 && $query3) {
         $tb_kelas = query("SELECT id_guru,kelas,notif_absen_telegram,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
         if ($tb_kelas['notif_absen_telegram'] == 'Y') {

            $kelas = $tb_kelas['kelas'];
            $pada = hari(date('D')) . ', ' . date('d') . ' ' . bulan(date('m')) . ' ' . date('Y');

            $isi_pesan = "<b>Absen masuk kelas $kelas pada $pada</b>\n\n";

            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM a_masuk am JOIN tb_siswa s ON am . id_siswa = s . id_siswa WHERE am . m_tanggal = '$m_tanggal' && am . m_bulan_tahun = '$m_bulan_tahun' && am . token_kelas = '$token_kelas'");

            foreach ($result as $a_masuk) {
               $a_masukket = query("SELECT * FROM a_masukket WHERE token_masuk = '$a_masuk[$m_tanggal]'");

               $isi_pesan .= $no++ . '. ' . $a_masuk['nama_depan'] . ' ' . $a_masuk['nama_belakang'] . ' - ' . date('H:i', $a_masukket['m_pada']) . " ($a_masukket[m_alasan])" . "\n";
            }

            $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");
            $isi_pesan .= "\n" . $tb_guru['nama'];

            $chat_id = $tb_setelan['chat_id_group'];
            $token_bot = $tb_setelan['token_bot'];
            sendMessageTelegram($chat_id, $isi_pesan, $token_bot);
         }
         sendBroadcastMasuk($tb_siswa['nis']);
         $_SESSION['absen'] = 'masuk';
         echo 'berhasil';
      } else {
         echo 'gagal';
      }
   }
   // absen pulang
   if (isset($_GET['absen_pulang'])) {
      $id_guru = $_POST['id_guru'];
      $id_siswa = $_POST['id_siswa'];
      $p_tanggal = date('d');
      $p_bulan_tahun = date('m-Y');
      $token_kelas = $_POST['token_kelas'];

      $p_pada = time();
      $latitude = htmlspecialchars($_POST['latitude']);
      $longitude = htmlspecialchars($_POST['longitude']);
      $token_pulang =  $tb_siswa['nis'] . '-' . time();

      $img = $_POST['p_foto'];
      $folderPath = "img/";

      $image_parts = explode(";base64,", $img);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];

      $image_base64 = base64_decode($image_parts[1]);
      $fileNama =  $tb_siswa['nis'] . '-' . time() . '.png';

      $file = $folderPath . $fileNama;
      file_put_contents($file, $image_base64);

      $jml_pulang = num_rows("SELECT id_siswa,p_bulan_tahun FROM a_pulang WHERE id_siswa = '$id_siswa' && p_bulan_tahun = '$p_bulan_tahun'");

      if ($jml_pulang == 0) {
         $query = mysqli_query($conn, "INSERT INTO a_pulang (id_guru,id_siswa,`$p_tanggal`,p_tanggal,p_bulan_tahun,token_kelas) VALUES ('$id_guru','$id_siswa','$token_pulang','$p_tanggal','$p_bulan_tahun','$token_kelas')");
      } else {
         $query = mysqli_query($conn, "UPDATE a_pulang SET `$p_tanggal` = '$token_pulang', p_tanggal = '$p_tanggal' WHERE id_siswa = '$id_siswa' && p_bulan_tahun = '$p_bulan_tahun' && token_kelas = '$token_kelas'");
      }

      $query2 = mysqli_query($conn, "INSERT INTO a_pulangket (p_foto,p_pada,latitude,longitude,token_pulang,token_kelas) VALUES ('$fileNama','$p_pada','$latitude','$longitude','$token_pulang','$token_kelas')");

      $a_pulang = query("SELECT id_siswa,p_bulan_tahun,token_kelas,pulang FROM a_pulang WHERE id_siswa = '$id_siswa' && p_bulan_tahun = '$p_bulan_tahun' && token_kelas = '$token_kelas'");

      $jml_alasan = $a_pulang['pulang'] + 1;

      $query3 = mysqli_query($conn, "UPDATE a_pulang SET pulang = '$jml_alasan' WHERE id_siswa = '$id_siswa' && p_bulan_tahun = '$p_bulan_tahun' && token_kelas = '$token_kelas'");

      if ($query && $query2 && $query3) {
         $tb_kelas = query("SELECT id_guru,kelas,notif_absen_telegram,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
         if ($tb_kelas['notif_absen_telegram'] == 'Y') {

            $kelas = $tb_kelas['kelas'];
            $pada = hari(date('D')) . ', ' . date('d') . ' ' . bulan(date('m')) . ' ' . date('Y');

            $isi_pesan = "<b>Absen pulang kelas $kelas pada $pada</b>\n\n";

            $no = 1;
            $result = mysqli_query($conn, "SELECT * FROM a_pulang ap JOIN tb_siswa s ON ap . id_siswa = s . id_siswa WHERE ap . p_tanggal = '$p_tanggal' && ap . p_bulan_tahun = '$p_bulan_tahun' && ap . token_kelas = '$token_kelas'");

            foreach ($result as $a_pulang) {
               $a_pulangket = query("SELECT * FROM a_pulangket WHERE token_pulang = '$a_pulang[$p_tanggal]'");

               $isi_pesan .= $no++ . '. ' . $a_pulang['nama_depan'] . ' ' . $a_pulang['nama_belakang'] . ' - ' . date('H:i', $a_pulangket['p_pada']) . "\n";
            }

            $tb_guru = query("SELECT id_guru,nama FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");
            $isi_pesan .= "\n" . $tb_guru['nama'];

            $chat_id = $tb_setelan['chat_id_group'];
            $token_bot = $tb_setelan['token_bot'];
            sendMessageTelegram($chat_id, $isi_pesan, $token_bot);
         }
         $_SESSION['absen'] = 'pulang';
         sendBroadcastPulang($tb_siswa['nis']);
         echo 'berhasil';
      } else {
         echo 'gagal';
      }
   }
}
