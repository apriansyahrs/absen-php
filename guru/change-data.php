<?php
require "../config.php";

if (isset($_GET['jenis'])) {
   switch ($_GET['jenis']) {
         // kota/kabupaten
      case 'kota':
         $id_provinces = $_POST['id_provinces'];
         if ($id_provinces == '') {
            exit;
         } else {
            $result = mysqli_query($conn, "SELECT * FROM w_regencies WHERE province_id ='$id_provinces' ORDER BY name ASC") or die('Query Gagal');
            echo "<option value=''></option>";
            while ($data = mysqli_fetch_array($result)) {
               echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
            }
            exit;
         }
         break;

         // kecamatan
      case 'kecamatan':
         $id_regencies = $_POST['id_regencies'];
         if ($id_regencies == '') {
            exit;
         } else {
            $result = mysqli_query($conn, "SELECT * FROM w_districts WHERE regency_id ='$id_regencies' ORDER BY name ASC") or die('Query Gagal');
            echo "<option value=''></option>";
            while ($data = mysqli_fetch_array($result)) {
               echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
            }
            exit;
         }
         break;


         // kelurahan
      case 'kelurahan':
         $id_district = $_POST['id_district'];
         if ($id_district == '') {
            exit;
         } else {
            $resultind = mysqli_query($conn, "SELECT  * FROM w_villages WHERE district_id ='$id_district' ORDER BY name ASC") or die('Query Gagal');
            echo "<option value=''></option>";
            while ($data = mysqli_fetch_array($resultind)) {
               echo '<option value="' . $data['id'] . '">' . $data['name'] . '</option>';
            }
            exit;
         }
         break;
   }
}

if (isset($_POST['change_rekap'])) {
   echo "<option value=''></option>";

   $token_kelas = $_POST['token_kelas'];

   if (count(explode(',', $token_kelas)) > 1) {
      // Memecah string menjadi array dengan koma sebagai pemisah
      $array_values = explode(",", $token_kelas);

      // Menggabungkan elemen-elemen array dalam tanda kutip tunggal
      $output_string = "'" . implode("','", $array_values) . "'";

      // Ambil bulan tahun
      $result = mysqli_query($conn, "SELECT DISTINCT m_bulan_tahun FROM a_masuk WHERE token_kelas IN ($output_string)");

      foreach ($result as $a_masuk) {
         $m_bulan = bulan(explode('-', $a_masuk['m_bulan_tahun'])[0]);
         $m_tahun = explode('-', $a_masuk['m_bulan_tahun'])[1];
         $m_bulan_tahun = $m_bulan . ' ' . $m_tahun;
         echo "<option value='$a_masuk[m_bulan_tahun]'>$m_bulan_tahun</option>";
      }
      return;
   }

   $result = mysqli_query($conn, "SELECT DISTINCT m_bulan_tahun,token_kelas FROM a_masuk WHERE token_kelas = '$token_kelas'");
   foreach ($result as $a_masuk) {
      $m_bulan = bulan(explode('-', $a_masuk['m_bulan_tahun'])[0]);
      $m_tahun = explode('-', $a_masuk['m_bulan_tahun'])[1];
      $m_bulan_tahun = $m_bulan . ' ' . $m_tahun;
      echo "<option value='$a_masuk[m_bulan_tahun]'>$m_bulan_tahun</option>";
   }
}

if (isset($_POST['what_rekap'])) {
   $what_rekap = $_POST['what_rekap'];
   if ($what_rekap == 'Guru') {
      $result = mysqli_query($conn, "SELECT DISTINCT m_bulan_tahun FROM a_masuk_guru");
      echo "<option value=''></option>";
      foreach ($result as $a_masuk) {
         $m_bulan = bulan(explode('-', $a_masuk['m_bulan_tahun'])[0]);
         $m_tahun = explode('-', $a_masuk['m_bulan_tahun'])[1];
         $m_bulan_tahun = $m_bulan . ' ' . $m_tahun;
         echo "<option value='$a_masuk[m_bulan_tahun]'>$m_bulan_tahun</option>";
      }
   } elseif ($what_rekap == 'Karyawan') {
      $result = mysqli_query($conn, "SELECT DISTINCT m_bulan_tahun FROM a_masuk_karyawan");
      echo "<option value=''></option>";
      foreach ($result as $a_masuk) {
         $m_bulan = bulan(explode('-', $a_masuk['m_bulan_tahun'])[0]);
         $m_tahun = explode('-', $a_masuk['m_bulan_tahun'])[1];
         $m_bulan_tahun = $m_bulan . ' ' . $m_tahun;
         echo "<option value='$a_masuk[m_bulan_tahun]'>$m_bulan_tahun</option>";
      }
   } elseif ($what_rekap == 'Siswa') {
      $result = mysqli_query($conn, "SELECT kelas,token_kelas FROM tb_kelas");
      echo "<option value=''></option>";

      if (isset($_POST['show_kelompok'])) {
         $result_kelompok = mysqli_query($conn, 'SELECT DISTINCT(kelompok_kelas) FROM tb_kelas');

         foreach ($result_kelompok as $kel) {
            $kelompok_kelas   = $kel['kelompok_kelas'];
            $query            = mysqli_query($conn, "SELECT token_kelas FROM tb_kelas WHERE kelompok_kelas = '$kelompok_kelas'");
            $data             = mysqli_fetch_all($query, MYSQLI_ASSOC);

            // Mengubah hasil menjadi array
            $token_kelas_array = array_column($data, 'token_kelas');

            echo "<option value='" . implode(',', $token_kelas_array) . "'>Kelompok kelas: $kel[kelompok_kelas]</option>";
         }
      }

      foreach ($result as $tb_kelas) {
         echo "<option value='$tb_kelas[token_kelas]'>Kelas: $tb_kelas[kelas]</option>";
      }
   }
}

if (isset($_GET['change_token_kelas_admin'])) {
   $id_guru = $_POST['id_guru'];
   $result = mysqli_query($conn, "SELECT id_guru,kelas,token_kelas FROM tb_kelas WHERE id_guru = '$id_guru'");
   echo "<option value=''></option>";
   foreach ($result as $tb_kelas) {
      echo "<option value='$tb_kelas[token_kelas]'>$tb_kelas[kelas]</option>";
   }
}
