<?php
require "../../config.php";
// login
if (isset($_GET['login'])) {
    $nis = htmlspecialchars($_POST['nis']);
    $password = htmlspecialchars($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '$nis'");
    $tb_siswa = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        $data['salah'] = true;
        echo json_encode($data);
        return false;
    }

    if ($password == $tb_siswa['password']) {
        unset($_SESSION['guru']);
        if ($tb_siswa['telegram_bot'] == 'Y') {
            setcookie('id', $tb_siswa['id_siswa'], time() + 31536000, '/');
            setcookie('absensi_siswa', hash('sha256', $tb_siswa['id_siswa']), time() + 31536000, '/');
            $_SESSION['siswa'] = $tb_siswa['id_siswa'];
            $data['berhasil'] = true;
        } elseif ($tb_siswa['telegram_bot'] == 'N') {
            $data['url_telegram_group'] = $tb_setelan['url_telegram_group'];
            $data['nis'] = $nis;
            $data['password'] = $password;
            $data['modal_telegram'] = true;
        }
    } else {
        $data['salah'] = true;
    }

    echo json_encode($data);
}
if (isset($_GET['cek_token'])) {
    $token_kelas = htmlspecialchars($_POST['token_kelas']);
    $jml_kelas = num_rows("SELECT token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
    if ($jml_kelas == 1) {
        $tb_kelas = query("SELECT * FROM tb_kelas tk JOIN tb_guru tg ON tk . id_guru = tg . id_guru WHERE tk . token_kelas = '$token_kelas'");
        $data['id_guru'] = $tb_kelas['id_guru'];
        $data['nama_guru'] = $tb_kelas['nama'];
        $data['kelas'] = $tb_kelas['kelas'];
        $data['status'] = 'berhasil';
    } else {
        $data['status'] = 'gagal';
    }
    echo json_encode($data);
}
// login get telegram
if (isset($_GET['login_get'])) {
    $nis = htmlspecialchars($_POST['nis']);
    $password = htmlspecialchars($_POST['password']);

    $result = mysqli_query($conn, "SELECT * FROM tb_siswa WHERE nis = '$nis'");
    $tb_siswa = mysqli_fetch_assoc($result);

    mysqli_query($conn, "UPDATE tb_siswa SET telegram_bot = 'Y' WHERE id_siswa = '$tb_siswa[id_siswa]'");

    if (mysqli_num_rows($result) == 0) {
        echo 'NIS atau password salah';
        return false;
    }

    if ($password == $tb_siswa['password']) {
        unset($_SESSION['guru']);
        setcookie('id', $tb_siswa['id_siswa'], time() + 31536000, '/');
        setcookie('absensi_siswa', hash('sha256', $tb_siswa['id_siswa']), time() + 31536000, '/');
        $_SESSION['siswa'] = $tb_siswa['id_siswa'];
    } else {
        echo 'NIS atau password salah';
    }
}
// daftar
if (isset($_GET['daftar'])) {
    $id_guru = $_POST['id_guru'];
    $nis = htmlspecialchars($_POST['nis']);
    $nama_depan = htmlspecialchars($_POST['nama_depan']);
    $nama_belakang = htmlspecialchars($_POST['nama_belakang']);
    $jk = $_POST['jk'];
    $provinsi = htmlspecialchars($_POST['provinsi']);
    $kota = htmlspecialchars($_POST['kota']);
    $kecamatan = htmlspecialchars($_POST['kecamatan']);
    $kelurahan = htmlspecialchars($_POST['kelurahan']);
    $password = htmlspecialchars($_POST['password2']);
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

    $query = mysqli_query($conn, "INSERT INTO tb_siswa (id_guru,nis,nama_depan,nama_belakang,jk,provinsi,kota,kecamatan,kelurahan,telegram_bot,profil,password,token_kelas,username_ortu,nama_ayah,pekerjaan_ayah,nama_ibu,pekerjaan_ibu,telepon_rumah) VALUES ('$id_guru','$nis','$nama_depan','$nama_belakang','$jk','$provinsi','$kota','$kecamatan','$kelurahan','N','$profil','$password','$token_kelas','$username_ortu','$nama_ayah','$pekerjaan_ayah','$nama_ibu','$pekerjaan_ibu','$telepon_rumah')");
    if ($query) {
        $_SESSION['daftar_berhasil'] = 'Selamat! Kamu berhasil mendaftar akun. Silakan login kembali.';
        echo 'berhasil';
    }
}
