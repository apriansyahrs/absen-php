<?php
require "../config.php";
if (isset($_SESSION['guru'])) {
    // tambah pengumuman
    if (isset($_GET['tambah_pengumuman'])) {
        $id_guru = $_SESSION['guru'];
        $pengumuman = htmlspecialchars($_POST['pengumuman']);
        $ditambahkan = time();
        $token_kelas = $_POST['token_kelas'];

        $query = mysqli_query($conn, "UPDATE tb_pengumuman SET active = 'deactivate' WHERE token_kelas = '$token_kelas'");
        $query2 = mysqli_query($conn, "INSERT INTO tb_pengumuman VALUES (null,'$id_guru','$pengumuman','$ditambahkan','active','$token_kelas')");

        if ($query && $query) {
            echo 'berhasil';
        }
    }
    // tambah kelas
    if (isset($_GET['tambah_kelas'])) {
        $id_guru = $_SESSION['guru'];
        $kelompok_kelas = htmlspecialchars($_POST['kelompok_kelas']);
        $kelas = htmlspecialchars($_POST['kelas']);

        $masuk_mulai = $_POST['masuk_mulai'];
        $masuk_akhir = $_POST['masuk_akhir'];
        $pulang_mulai = $_POST['pulang_mulai'];
        $pulang_akhir = $_POST['pulang_akhir'];
        $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'];
        $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'];

        $ditambahkan = time();
        $token_kelas = substr(hash('sha256', time()), 0, 32);

        $jml_kelas = num_rows("SELECT kelas FROM tb_kelas WHERE kelas = '$kelas'");
        if ($jml_kelas >= 1) {
            echo 'tidak tersedia';
            return false;
        }

        $query = mysqli_query($conn, "INSERT INTO tb_kelas
        (id_guru,kelompok_kelas,kelas,masuk_mulai,masuk_akhir,pulang_mulai,pulang_akhir,ditambahkan,notif_absen_telegram,token_kelas,pulang_mulai_jumat,pulang_akhir_jumat)
        VALUES
        ('$id_guru','$kelompok_kelas','$kelas','$masuk_mulai','$masuk_akhir','$pulang_mulai','$pulang_akhir','$ditambahkan','N','$token_kelas','$pulang_mulai_jumat','$pulang_akhir_jumat')");

        if ($query) {
            echo 'berhasil';
        }
    }
    // tambah kegiatan
    if (isset($_GET['tambah_kegiatan'])) {
        $id_guru = $_SESSION['guru'];
        $nama_kegiatan = htmlspecialchars($_POST['nama_kegiatan']);
        $tanggal_kegiatan = date("Y-m-d");

        $bukti_kegiatan = $_FILES['bukti_kegiatan']['name'];
        $ekstensi = strtolower($bukti_kegiatan);
        $ekstensi = explode('.', $ekstensi);
        $ekstensi = end($ekstensi);
        $namafiks = substr(hash('sha256', time()), 0, 10) . '_' . time();
        $tujuan_upload = '../img/guru/kegiatan/' . $namafiks . '.' . $ekstensi;
        $bukti_kegiatan = $namafiks . '.' . $ekstensi;
        $file_tmp = $_FILES['bukti_kegiatan']['tmp_name'];

        $lama_kegiatan_menit = htmlspecialchars($_POST['lama_kegiatan_menit']);

        $query = mysqli_query($conn, "INSERT INTO tb_kegiatan_guru (id_guru,nama_kegiatan,bukti_kegiatan,tanggal_kegiatan,lama_kegiatan_menit) VALUES ('$id_guru','$nama_kegiatan','$bukti_kegiatan','$tanggal_kegiatan','$lama_kegiatan_menit')");

        if (move_uploaded_file($file_tmp, $tujuan_upload)) {
            if ($query) {
                echo 'berhasil';
            }
        }
    }
    // tambah siswa
    if (isset($_GET['tambah_siswa'])) {
        $id_guru = $_POST['id_guru'];
        $nis = htmlspecialchars($_POST['nis']);
        $nama_depan = htmlspecialchars($_POST['nama_depan']);
        $nama_belakang = htmlspecialchars($_POST['nama_belakang']);
        $jk = $_POST['jk'];
        $telegram = htmlspecialchars($_POST['telegram']);
        $provinsi = htmlspecialchars($_POST['provinsi']);
        $kota = htmlspecialchars($_POST['kota']);
        $kecamatan = htmlspecialchars($_POST['kecamatan']);
        $kelurahan = htmlspecialchars($_POST['kelurahan']);
        // $password = substr(str_shuffle(time() . time()), 0, 4);
        $password = $nis;
        $profil_arr = ['user-red', 'user-yellow', 'user-green', 'user-blue', 'user-purple', 'user-dark'];
        shuffle($profil_arr);
        $profil = array_shift($profil_arr);
        $token_kelas = $_POST['token_kelas'];


        $username_ortu = htmlspecialchars($_POST['username_ortu']);
        $nama_ayah = htmlspecialchars($_POST['nama_ayah']);
        $pekerjaan_ayah = htmlspecialchars($_POST['pekerjaan_ayah']);
        $nama_ibu = htmlspecialchars($_POST['nama_ibu']);
        $pekerjaan_ibu = htmlspecialchars($_POST['pekerjaan_ibu']);
        $telepon_rumah = htmlspecialchars($_POST['telepon_rumah']);

        $jml_siswa = num_rows("SELECT nis FROM tb_siswa WHERE nis = '$nis'");
        if ($jml_siswa >= 1) {
            echo 'tidak tersedia';
            return false;
        }

        $query = mysqli_query($conn, "INSERT INTO tb_siswa (id_guru,nis,nama_depan,nama_belakang,jk,provinsi,kota,kecamatan,kelurahan,telegram,telegram_bot,profil,password,token_kelas,username_ortu,nama_ayah,pekerjaan_ayah,nama_ibu,pekerjaan_ibu,telepon_rumah) VALUES ('$id_guru','$nis','$nama_depan','$nama_belakang','$jk','$provinsi','$kota','$kecamatan','$kelurahan','$telegram','N','$profil','$password','$token_kelas','$username_ortu','$nama_ayah','$pekerjaan_ayah','$nama_ibu','$pekerjaan_ibu','$telepon_rumah')");
        if ($query) {
            echo 'berhasil';
        }
    }
    // import siswa csv, ods atau xlsx
    if (isset($_GET['import_siswa'])) {
        $tmp_name = $_FILES['file_import']['tmp_name'];
        $file_name = $_FILES['file_import']['name'];

        $ext = explode('.', $file_name);
        $ext = end($ext);
        $ext = strtolower($ext);
        $ext_boleh = ['csv', 'ods', 'xlsx'];

        if ($ext !== $ext_boleh[0] && $ext !== $ext_boleh[1] && $ext !== $ext_boleh[2]) {
            echo 'esktensi file';
            return false;
        }

        require('../assets/SpreadsheetReader/php-excel-reader/excel_reader2.php');
        require('../assets/SpreadsheetReader/SpreadsheetReader.php');

        $target_dir = 'import/' . basename($file_name);
        move_uploaded_file($tmp_name, $target_dir);


        $id_guru = $_POST['id_guru'];
        $token_kelas = $_POST['token_kelas'];

        $reader = new SpreadsheetReader($target_dir);
        foreach ($reader as $key => $row) {
            if ($key < 1) continue;

            $profil_arr = ['user-red', 'user-yellow', 'user-green', 'user-blue', 'user-purple', 'user-dark'];
            shuffle($profil_arr);
            $profil = array_shift($profil_arr);
            $password = substr(str_shuffle(time() . $key), 0, 4);
            $username_ortu = substr(str_shuffle(time() . time()), 0, 8);

            $query = mysqli_query($conn, "INSERT INTO tb_siswa (id_guru,nis,nama_depan,nama_belakang,jk,telegram_bot,profil,password,token_kelas,username_ortu) VALUES ('$id_guru','" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','N','$profil','$password','$token_kelas','$username_ortu')");
        }
        if ($query) {
            echo 'berhasil';
        }
    }
}
