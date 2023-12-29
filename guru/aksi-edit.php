<?php
require "../config.php";
if (isset($_SESSION['guru']) or isset($_SESSION['admin']) or isset($_SESSION['siswa'])) {
   // edit pengumuman
   if (isset($_GET['edit_pengumuman'])) {
      $id_pengumuman = $_POST['id_pengumuman'];
      $pengumuman = htmlspecialchars($_POST['pengumuman']);
      $query = mysqli_query($conn, "UPDATE tb_pengumuman SET pengumuman = '$pengumuman' WHERE id_pengumuman = '$id_pengumuman'");
      if ($query) {
         echo 'berhasil';
      }
   }
   // edit kelas
   if (isset($_POST['token_kelas'])) {
      $kelas_lama = htmlspecialchars($_POST['kelas_lama']);
      $kelompok_kelas = htmlspecialchars($_POST['kelompok_kelas']);
      $kelas = htmlspecialchars($_POST['kelas']);
      $masuk_mulai = $_POST['masuk_mulai'];
      $masuk_akhir = $_POST['masuk_akhir'];
      $pulang_mulai = $_POST['pulang_mulai'];
      $pulang_akhir = $_POST['pulang_akhir'];
      $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'];
      $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'];

      $notif_absen_telegram = $_POST['notif_absen_telegram'];
      $token_kelas = $_POST['token_kelas'];


      if ($kelas_lama !== $kelas) {
         $jml_kelas = num_rows("SELECT kelas FROM tb_kelas WHERE kelas = '$kelas'");
         if ($jml_kelas >= 1) {
            echo 'tidak tersedia';
            return false;
         }
      }

      $query = mysqli_query($conn, "UPDATE tb_kelas SET kelompok_kelas = '$kelompok_kelas', kelas = '$kelas', masuk_mulai = '$masuk_mulai', masuk_akhir =
      '$masuk_akhir', pulang_mulai = '$pulang_mulai', pulang_akhir = '$pulang_akhir', notif_absen_telegram =
      '$notif_absen_telegram', pulang_mulai_jumat = '$pulang_mulai_jumat', pulang_akhir_jumat = '$pulang_akhir_jumat' WHERE token_kelas =
      '$token_kelas'");

      if ($query) {
         echo 'berhasil';
      }
   }
   // edit siswa
   if (isset($_GET['edit_siswa'])) {
      $id_siswa = $_POST['id_siswa'];
      $profil = $_POST['profil'];
      $nis_lama = htmlspecialchars($_POST['nis_lama']);
      $nis = htmlspecialchars($_POST['nis']);
      $nama_depan = htmlspecialchars($_POST['nama_depan']);
      $nama_belakang = htmlspecialchars($_POST['nama_belakang']);
      $jk = $_POST['jk'];
      $telegram = htmlspecialchars($_POST['telegram']);
      $provinsi = htmlspecialchars($_POST['provinsi']);
      $kota = htmlspecialchars($_POST['kota']);
      $kecamatan = htmlspecialchars($_POST['kecamatan']);
      $kelurahan = htmlspecialchars($_POST['kelurahan']);

      $nama_ayah = htmlspecialchars($_POST['nama_ayah']);
      $pekerjaan_ayah = htmlspecialchars($_POST['pekerjaan_ayah']);
      $nama_ibu = htmlspecialchars($_POST['nama_ibu']);
      $pekerjaan_ibu = htmlspecialchars($_POST['pekerjaan_ibu']);
      $telepon_rumah = htmlspecialchars($_POST['telepon_rumah']);

      if ($nis_lama !== $nis) {
         $jml_siswa = num_rows("SELECT nis FROM tb_siswa WHERE nis = '$nis'");
         if ($jml_siswa >= 1) {
            echo 'tidak tersedia';
            return false;
         }
      }

      $query = mysqli_query($conn, "UPDATE tb_siswa SET nis = '$nis', nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', jk = '$jk', provinsi = '$provinsi', kota = '$kota', kecamatan = '$kecamatan', kelurahan = '$kelurahan', telegram = '$telegram', profil = '$profil', nama_ayah = '$nama_ayah', pekerjaan_ayah = '$pekerjaan_ayah', nama_ibu = '$nama_ibu', pekerjaan_ibu = '$pekerjaan_ibu', telepon_rumah = '$telepon_rumah' WHERE id_siswa = '$id_siswa'");
      if ($query) {
         echo 'berhasil';
      }
   }
   // edit akun
   if (isset($_GET['edit_akun'])) {
      $nip_lama = htmlspecialchars($_POST['nip_lama']);
      $nip = htmlspecialchars($_POST['nip']);
      $nama = htmlspecialchars($_POST['nama']);
      $telegram = htmlspecialchars($_POST['telegram']);

      if ($nip_lama !== $nip) {
         $jml_nip = num_rows("SELECT nip FROM tb_guru WHERE nip = '$nip'");
         if ($jml_nip >= 1) {
            echo 'tidak tersedia';
            return false;
         }
      }

      $query = mysqli_query($conn, "UPDATE tb_guru SET nip = '$nip', nama = '$nama', telegram = '$telegram' WHERE id_guru = '$tb_guru[id_guru]'");
      if ($query) {
         echo 'berhasil';
      }
   }
   // edit profil
   if (isset($_GET['edit_profil'])) {
      $profil = $_FILES['profil']['name'];
      $ekstensi = strtolower($profil);
      $ekstensi = explode('.', $ekstensi);
      $ekstensi = end($ekstensi);
      $namafiks = substr(hash('sha256', time()), 0, 10) . '_' . time();
      $tujuan_upload = '../img/guru/' . $namafiks . '.' . $ekstensi;
      $profil = $namafiks . '.' . $ekstensi;
      $file_tmp = $_FILES['profil']['tmp_name'];

      if ($tb_guru['profil'] !== 'user.png') {
         unlink('../img/guru/' . $tb_guru['profil']);
      }

      $query = mysqli_query($conn, "UPDATE tb_guru SET profil = '$profil' WHERE id_guru = '$tb_guru[id_guru]'");
      if (move_uploaded_file($file_tmp, $tujuan_upload)) {
         if ($query) {
            echo 'berhasil';
         }
      }
   }
   // edit password
   if (isset($_GET['edit_password'])) {
      $password_lama = htmlspecialchars($_POST['password_lama']);
      $password = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);

      if (password_verify($password_lama, $tb_guru['password'])) {
         $query = mysqli_query($conn, "UPDATE tb_guru SET password = '$password' WHERE id_guru = '$tb_guru[id_guru]'");
         if ($query) {
            echo 'berhasil';
         }
      } else {
         echo 'password lama';
      }
   }
   // edit setelan
   if (isset($_GET['edit_setelan'])) {
      $nama = htmlspecialchars($_POST['nama']);
      $base_url = htmlspecialchars($_POST['base_url']);
      $chat_id_group = htmlspecialchars($_POST['chat_id_group']);
      $token_bot = htmlspecialchars($_POST['token_bot']);
      $url_telegram_group = htmlspecialchars($_POST['url_telegram_group']);
      $api_maps = htmlspecialchars($_POST['api_maps']);
      $latitude_instansi = htmlspecialchars($_POST['latitude_instansi']);
      $longitude_instansi = htmlspecialchars($_POST['longitude_instansi']);
      $radius_meter = htmlspecialchars($_POST['radius_meter']);
      $hadir_radius = htmlspecialchars($_POST['hadir_radius']);
      $izin_radius = htmlspecialchars($_POST['izin_radius']);
      $sakit_radius = htmlspecialchars($_POST['sakit_radius']);

      $query = mysqli_query($conn, "UPDATE setelan SET nama = '$nama', base_url = '$base_url', chat_id_group = '$chat_id_group', token_bot = '$token_bot', url_telegram_group = '$url_telegram_group', api_maps = '$api_maps', latitude_instansi = '$latitude_instansi', longitude_instansi = '$longitude_instansi', radius_meter = '$radius_meter', hadir_radius = '$hadir_radius', izin_radius = '$izin_radius', sakit_radius = '$sakit_radius'");
      if ($query) {
         echo 'berhasil';
      }
   }
   // edit admin
   if (isset($_GET['edit_admin'])) {
      $username = htmlspecialchars($_POST['username']);
      $password_lama = htmlspecialchars($_POST['password_lama']);
      $password = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);

      $tb_admin = query("SELECT * FROM tb_admin");
      if (password_verify($password_lama, $tb_admin['password'])) {
         $query = mysqli_query($conn, "UPDATE tb_admin SET username = '$username', password = '$password'");
         if ($query) {
            echo 'berhasil';
         }
      } else {
         echo 'password lama';
      }
   }
   // edit password siswa
   if (isset($_GET['edit_password_siswa'])) {
      $id_siswa = $_POST['id_siswa'];
      $password_lama = htmlspecialchars($_POST['password_lama']);
      $password = htmlspecialchars($_POST['password2']);

      if ($password_lama == $tb_siswa['password']) {
         $query = mysqli_query($conn, "UPDATE tb_siswa SET password = '$password' WHERE id_siswa = '$id_siswa'");
         if ($query) {
            echo 'berhasil';
         }
      } else {
         echo 'password lama';
      }
   }
}
