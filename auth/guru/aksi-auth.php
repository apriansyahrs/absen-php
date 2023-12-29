<?php
require "../../config.php";
// daftar
if (isset($_GET['daftar'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $password = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);

    $jml_guru = num_rows("SELECT nip FROM tb_guru WHERE nip = '$nip'");
    if ($jml_guru >= 1) {
        echo 'tidak tersedia';
        return false;
    }
    $query = mysqli_query($conn, "INSERT INTO tb_guru (nip,nama,profil,password) VALUES ('$nip','$nama','user.png','$password')");
    if ($query) {
        $tb_guru = query("SELECT id_guru,nip,password FROM tb_guru WHERE nip = '$nip'");
        setcookie('absensi_guru', $password, time() + 31536000, '/');
        $_SESSION['guru'] = $tb_guru['id_guru'];
        echo 'berhasil';
    }
}

if (isset($_GET['login'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $password = htmlspecialchars($_POST['password']);

    $result = mysqli_query($conn, "SELECT id_guru,nip,password FROM tb_guru WHERE nip = '$nip'");
    $tb_guru = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        echo 'salah';
        return false;
    }

    if (password_verify($password, $tb_guru['password'])) {
        unset($_SESSION['siswa']);
        $_SESSION['guru'] = $tb_guru['id_guru'];
        setcookie('absensi_guru', $tb_guru['password'], time() + 31536000, '/');
        echo 'berhasil';
    } else {
        echo 'salah';
    }
}
