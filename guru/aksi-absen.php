<?php
require "../config.php";
if (isset($_SESSION['guru'])) {
   // absen masuk
   if (isset($_GET['absen_masuk'])) {
      $id_guru = $_POST['id_guru'];
      $m_tanggal = date('d');
      $m_bulan_tahun = date('m-Y');

      $m_alasan = $_POST['m_alasan'];
      $m_ket = htmlspecialchars($_POST['m_ket']);
      $m_pada = time();
      $latitude = htmlspecialchars($_POST['latitude']);
      $longitude = htmlspecialchars($_POST['longitude']);
      $token_masuk = $tb_guru['nip'] . '-' . time();

      $img = $_POST['m_foto'];
      $folderPath = "../img/";

      $image_parts = explode(";base64,", $img);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];

      $image_base64 = base64_decode($image_parts[1]);
      $fileNama =  $tb_guru['nip'] . '-' . time() . '.png';

      $file = $folderPath . $fileNama;
      file_put_contents($file, $image_base64);

      $jml_masuk = num_rows("SELECT id_guru,m_bulan_tahun FROM a_masuk_guru WHERE id_guru = '$id_guru' && m_bulan_tahun = '$m_bulan_tahun'");

      if ($jml_masuk == 0) {
         $query1 = mysqli_query($conn, "INSERT INTO a_masuk_guru (id_guru,`$m_tanggal`,m_tanggal,m_bulan_tahun) VALUES ('$id_guru','$token_masuk','$m_tanggal','$m_bulan_tahun')");
      } else {
         $query1 = mysqli_query($conn, "UPDATE a_masuk_guru SET `$m_tanggal` = '$token_masuk', m_tanggal = '$m_tanggal' WHERE id_guru = '$id_guru' && m_bulan_tahun = '$m_bulan_tahun'");
      }
      
      if ($m_alasan == 'terlambat') {
          $j_guru = query("SELECT * FROM j_guru LIMIT 1");
          
          $jadwal = $j_guru['masuk_akhir'] . ':00';
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
          
          $query2 = mysqli_query($conn, "INSERT INTO a_masukket_guru (m_alasan,m_ket,terlambat,m_foto,m_pada,latitude,longitude,token_masuk) VALUES ('$m_alasan','$m_ket','$terlambat','$fileNama','$m_pada','$latitude','$longitude','$token_masuk')");
      } else {
          $query2 = mysqli_query($conn, "INSERT INTO a_masukket_guru (m_alasan,m_ket,m_foto,m_pada,latitude,longitude,token_masuk) VALUES ('$m_alasan','$m_ket','$fileNama','$m_pada','$latitude','$longitude','$token_masuk')");
      }
      

      $a_masuk_guru = query("SELECT id_guru,m_bulan_tahun,hadir,izin,sakit,terlambat FROM a_masuk_guru WHERE id_guru = '$id_guru' && m_bulan_tahun = '$m_bulan_tahun'");

      if ($m_alasan == 'hadir') {
         $jml_alasan = $a_masuk_guru['hadir'] + 1;
      } elseif ($m_alasan == 'izin') {
         $jml_alasan = $a_masuk_guru['izin'] + 1;
      } elseif ($m_alasan == 'sakit') {
         $jml_alasan = $a_masuk_guru['sakit'] + 1;
      } elseif ($m_alasan == 'terlambat') {
         $jml_alasan = $a_masuk_guru['terlambat'] + 1;
      }

      $query3 = mysqli_query($conn, "UPDATE a_masuk_guru SET `$m_alasan` = '$jml_alasan' WHERE id_guru = '$id_guru' && m_bulan_tahun = '$m_bulan_tahun'");


      if ($query1 && $query2 && $query3) {
         $_SESSION['absen'] = 'masuk';
         echo 'berhasil';
      } else {
         echo 'gagal';
      }
   }
   // absen pulang
   if (isset($_GET['absen_pulang'])) {
      $id_guru = $_POST['id_guru'];
      $p_tanggal = date('d');
      $p_bulan_tahun = date('m-Y');

      $p_pada = time();
      $latitude = htmlspecialchars($_POST['latitude']);
      $longitude = htmlspecialchars($_POST['longitude']);
      $token_pulang =  $tb_guru['nip'] . '-' . time();

      $img = $_POST['p_foto'];
      $folderPath = "../img/";

      $image_parts = explode(";base64,", $img);
      $image_type_aux = explode("image/", $image_parts[0]);
      $image_type = $image_type_aux[1];

      $image_base64 = base64_decode($image_parts[1]);
      $fileNama =  $tb_guru['nip'] . '-' . time() . '.png';

      $file = $folderPath . $fileNama;
      file_put_contents($file, $image_base64);

      $jml_pulang = num_rows("SELECT id_guru,p_bulan_tahun FROM a_pulang_guru WHERE id_guru = '$id_guru' && p_bulan_tahun = '$p_bulan_tahun'");

      if ($jml_pulang == 0) {
         $query = mysqli_query($conn, "INSERT INTO a_pulang_guru (id_guru,`$p_tanggal`,p_tanggal,p_bulan_tahun) VALUES ('$id_guru','$token_pulang','$p_tanggal','$p_bulan_tahun')");
      } else {
         $query = mysqli_query($conn, "UPDATE a_pulang_guru SET `$p_tanggal` = '$token_pulang', p_tanggal = '$p_tanggal' WHERE id_guru = '$id_guru' && p_bulan_tahun = '$p_bulan_tahun'");
      }

      $query2 = mysqli_query($conn, "INSERT INTO a_pulangket_guru (p_foto,p_pada,latitude,longitude,token_pulang) VALUES ('$fileNama','$p_pada','$latitude','$longitude','$token_pulang')");

      $a_pulang_guru = query("SELECT id_guru,p_bulan_tahun,pulang FROM a_pulang_guru WHERE id_guru = '$id_guru' && p_bulan_tahun = '$p_bulan_tahun'");

      $jml_alasan = $a_pulang_guru['pulang'] + 1;

      $query3 = mysqli_query($conn, "UPDATE a_pulang_guru SET pulang = '$jml_alasan' WHERE id_guru = '$id_guru' && p_bulan_tahun = '$p_bulan_tahun'");

      if ($query && $query2 && $query3) {
         $_SESSION['absen'] = 'pulang';
         echo 'berhasil';
      } else {
         echo 'gagal';
      }
   }
}
