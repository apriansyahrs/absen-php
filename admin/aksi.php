<?php
require "../config.php";
if (isset($_GET['tambah_kelas'])) {
    $id_guru = $_POST['id_guru'];
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

if (isset($_GET['edit_kelas'])) {
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
    // $password = substr(str_shuffle(time() . time()), 0, 4); // password acak 4 digit number
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

    $target_dir = '../guru/import/' . basename($file_name);
    move_uploaded_file($tmp_name, $target_dir);


    $id_guru = $_POST['id_guru'];
    $token_kelas = $_POST['token_kelas'];

    $reader = new SpreadsheetReader($target_dir);
    foreach ($reader as $key => $row) {
        if ($key < 1) continue;

        $profil_arr = ['user-red', 'user-yellow', 'user-green', 'user-blue', 'user-purple', 'user-dark'];
        shuffle($profil_arr);
        $profil = array_shift($profil_arr);
        // $password = substr(str_shuffle(time() . $key), 0, 4); // password acak 4 digit number
        $password = $row[0];
        $username_ortu = substr(str_shuffle(time() . time()), 0, 8);

        $query = mysqli_query($conn, "INSERT INTO tb_siswa (id_guru,nis,nama_depan,nama_belakang,jk,telegram_bot,profil,password,token_kelas,username_ortu) VALUES ('$id_guru','" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','N','$profil','$password','$token_kelas','$username_ortu')");
    }
    if ($query) {
        echo 'berhasil';
    }
}

if (isset($_GET['tambah_guru'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $telegram = htmlspecialchars($_POST['telegram']);
    $id_jabatan = htmlspecialchars($_POST['id_jabatan']);
    $password = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);

    if (num_rows("SELECT nip FROM tb_guru WHERE nip = '$nip'") >= 1) {
        echo 'tidak tersedia';
        return false;
    }

    $query = mysqli_query($conn, "INSERT INTO tb_guru (nip,nama,telegram,profil,password, id_jabatan) VALUES ('$nip','$nama','$telegram','user.png','$password', '$id_jabatan)");

    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}

if (isset($_GET['edit_guru'])) {
    $id_guru = htmlspecialchars($_POST['id_guru']);
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

    $query = mysqli_query($conn, "UPDATE tb_guru SET nip = '$nip', nama = '$nama', telegram = '$telegram' WHERE id_guru = '$id_guru'");
    if ($query) {
        echo 'berhasil';
    }
}

if (isset($_GET['edit_profil'])) {
    $id_guru = $_POST['id_guru'];
    $profil = $_FILES['profil']['name'];
    $ekstensi = strtolower($profil);
    $ekstensi = explode('.', $ekstensi);
    $ekstensi = end($ekstensi);
    $namafiks = substr(hash('sha256', time()), 0, 10) . '_' . time();
    $tujuan_upload = '../img/guru/' . $namafiks . '.' . $ekstensi;
    $profil = $namafiks . '.' . $ekstensi;
    $file_tmp = $_FILES['profil']['tmp_name'];

    $tb_guru = query("SELECT id_guru,profil FROM tb_guru WHERE id_guru = '$id_guru'");

    if ($tb_guru['profil'] !== 'user.png') {
        unlink('../img/guru/' . $tb_guru['profil']);
    }

    $query = mysqli_query($conn, "UPDATE tb_guru SET profil = '$profil' WHERE id_guru = '$id_guru'");
    if (move_uploaded_file($file_tmp, $tujuan_upload)) {
        if ($query) {
            echo 'berhasil';
        }
    }
}

if (isset($_GET['edit_password'])) {
    $id_guru = $_POST['id_guru'];
    $password = password_hash(htmlspecialchars($_POST['password2']), PASSWORD_DEFAULT);

    $query = mysqli_query($conn, "UPDATE tb_guru SET password = '$password' WHERE id_guru = '$id_guru'");
    if ($query) {
        echo 'berhasil';
    }
}

if (isset($_GET['import_guru'])) {
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

    $target_dir = '../guru/import/' . basename($file_name);
    move_uploaded_file($tmp_name, $target_dir);

    $reader = new SpreadsheetReader($target_dir);
    foreach ($reader as $key => $row) {
        if ($key < 1) continue;

        $password = password_hash($row[2], PASSWORD_DEFAULT);

        $query = mysqli_query($conn, "INSERT INTO tb_guru (nip,nama,profil,password) VALUES ('" . $row[0] . "','" . $row[1] . "','user.png', '" . $password . "')");
    }
    if ($query) {
        echo 'berhasil';
    }
}
if (isset($_GET['tambah_karyawan'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
    $jk = htmlspecialchars($_POST['jk']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $id_jabatan = htmlspecialchars($_POST['id_jabatan']);
    $password = htmlspecialchars($_POST['password2']);
    $token_karyawan = hash('sha256', time());

    if (num_rows("SELECT nip FROM tb_karyawan WHERE nip = '$nip'") == 1) {
        echo 'tidak tersedia';
        return false;
    }

    $query = mysqli_query($conn, "INSERT INTO tb_karyawan (nip,nama,tempat_lahir,tanggal_lahir,jk,alamat,id_jabatan,profil,password,token_karyawan) VALUES ('$nip','$nama','$tempat_lahir','$tanggal_lahir','$jk','$alamat','$id_jabatan','user.png','$password','$token_karyawan')");

    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['edit_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $nip_lama = htmlspecialchars($_POST['nip_lama']);
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $tempat_lahir = htmlspecialchars($_POST['tempat_lahir']);
    $tanggal_lahir = htmlspecialchars($_POST['tanggal_lahir']);
    $jk = htmlspecialchars($_POST['jk']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $id_jabatan = htmlspecialchars($_POST['id_jabatan']);

    if ($nip_lama !== $nip) {
        $jml_nip = num_rows("SELECT nip FROM tb_karyawan WHERE nip = '$nip'");
        if ($jml_nip >= 1) {
            echo 'tidak tersedia';
            return false;
        }
    }

    $query = mysqli_query($conn, "UPDATE tb_karyawan SET nip = '$nip', nama = '$nama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', jk = '$jk', alamat = '$alamat', id_jabatan = '$id_jabatan' WHERE id_karyawan = '$id_karyawan'");

    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['hapus_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $query = mysqli_query($conn, "DELETE FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'");

    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['import_karyawan'])) {
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

    $target_dir = '../guru/import/' . basename($file_name);
    move_uploaded_file($tmp_name, $target_dir);

    $reader = new SpreadsheetReader($target_dir);
    foreach ($reader as $key => $row) {
        if ($key < 1) continue;

        $token_karyawan = hash('sha256', $row[0]);

        $query = mysqli_query($conn, "INSERT INTO tb_karyawan (nip,nama,jk,alamat,id_jabatan,profil,password,token_karyawan) VALUES ('" . $row[0] . "','" . $row[1] . "','" . $row[2] . "','" . $row[3] . "','" . $row[4] . "','user.png', '" . $row[5] . "','" . $token_karyawan . "')");
    }
    if ($query) {
        echo 'berhasil';
    }
}



if (isset($_GET['edit_jadwal_absen_karyawan'])) {
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "UPDATE j_karyawan SET
   senin = '$senin', masuk_mulai_senin = '$masuk_mulai_senin', masuk_akhir_senin = '$masuk_akhir_senin', pulang_mulai_senin = '$pulang_mulai_senin', pulang_akhir_senin = '$pulang_akhir_senin',
   selasa = '$selasa', masuk_mulai_selasa = '$masuk_mulai_selasa', masuk_akhir_selasa = '$masuk_akhir_selasa', pulang_mulai_selasa = '$pulang_mulai_selasa', pulang_akhir_selasa = '$pulang_akhir_selasa',
   rabu = '$rabu', masuk_mulai_rabu = '$masuk_mulai_rabu', masuk_akhir_rabu = '$masuk_akhir_rabu', pulang_mulai_rabu = '$pulang_mulai_rabu', pulang_akhir_rabu = '$pulang_akhir_rabu',
   kamis = '$kamis', masuk_mulai_kamis = '$masuk_mulai_kamis', masuk_akhir_kamis = '$masuk_akhir_kamis', pulang_mulai_kamis = '$pulang_mulai_kamis', pulang_akhir_kamis = '$pulang_akhir_kamis',
   jumat = '$jumat', masuk_mulai_jumat = '$masuk_mulai_jumat', masuk_akhir_jumat = '$masuk_akhir_jumat', pulang_mulai_jumat = '$pulang_mulai_jumat', pulang_akhir_jumat = '$pulang_akhir_jumat',
   sabtu = '$sabtu', masuk_mulai_sabtu = '$masuk_mulai_sabtu', masuk_akhir_sabtu = '$masuk_akhir_sabtu', pulang_mulai_sabtu = '$pulang_mulai_sabtu', pulang_akhir_sabtu = '$pulang_akhir_sabtu',
   minggu = '$minggu', masuk_mulai_minggu = '$masuk_mulai_minggu', masuk_akhir_minggu = '$masuk_akhir_minggu', pulang_mulai_minggu = '$pulang_mulai_minggu', pulang_akhir_minggu = '$pulang_akhir_minggu'
    ");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['custom_jadwal_absen_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "INSERT INTO j_karyawan (senin, masuk_mulai_senin, masuk_akhir_senin, pulang_mulai_senin, pulang_akhir_senin, selasa, masuk_mulai_selasa, masuk_akhir_selasa, pulang_mulai_selasa, pulang_akhir_selasa, rabu, masuk_mulai_rabu, masuk_akhir_rabu, pulang_mulai_rabu, pulang_akhir_rabu, kamis, masuk_mulai_kamis, masuk_akhir_kamis, pulang_mulai_kamis, pulang_akhir_kamis, jumat, masuk_mulai_jumat, masuk_akhir_jumat, pulang_mulai_jumat, pulang_akhir_jumat, sabtu, masuk_mulai_sabtu, masuk_akhir_sabtu, pulang_mulai_sabtu, pulang_akhir_sabtu, minggu, masuk_mulai_minggu, masuk_akhir_minggu, pulang_mulai_minggu, pulang_akhir_minggu, id_karyawan)
    VALUES ('$senin', '$masuk_mulai_senin', '$masuk_akhir_senin', '$pulang_mulai_senin', '$pulang_akhir_senin',
    '$selasa', '$masuk_mulai_selasa', '$masuk_akhir_selasa', '$pulang_mulai_selasa', '$pulang_akhir_selasa',
    '$rabu', '$masuk_mulai_rabu', '$masuk_akhir_rabu', '$pulang_mulai_rabu', '$pulang_akhir_rabu',
    '$kamis', '$masuk_mulai_kamis', '$masuk_akhir_kamis', '$pulang_mulai_kamis', '$pulang_akhir_kamis',
    '$jumat', '$masuk_mulai_jumat', '$masuk_akhir_jumat', '$pulang_mulai_jumat', '$pulang_akhir_jumat',
    '$sabtu', '$masuk_mulai_sabtu', '$masuk_akhir_sabtu', '$pulang_mulai_sabtu', '$pulang_akhir_sabtu',
    '$minggu', '$masuk_mulai_minggu', '$masuk_akhir_minggu', '$pulang_mulai_minggu', '$pulang_akhir_minggu', '$id_karyawan')");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['edit_custom_jadwal_absen_karyawan'])) {
    $id_j_karyawan = $_POST['id_j_karyawan'];
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "UPDATE j_karyawan SET
   senin = '$senin', masuk_mulai_senin = '$masuk_mulai_senin', masuk_akhir_senin = '$masuk_akhir_senin', pulang_mulai_senin = '$pulang_mulai_senin', pulang_akhir_senin = '$pulang_akhir_senin',
   selasa = '$selasa', masuk_mulai_selasa = '$masuk_mulai_selasa', masuk_akhir_selasa = '$masuk_akhir_selasa', pulang_mulai_selasa = '$pulang_mulai_selasa', pulang_akhir_selasa = '$pulang_akhir_selasa',
   rabu = '$rabu', masuk_mulai_rabu = '$masuk_mulai_rabu', masuk_akhir_rabu = '$masuk_akhir_rabu', pulang_mulai_rabu = '$pulang_mulai_rabu', pulang_akhir_rabu = '$pulang_akhir_rabu',
   kamis = '$kamis', masuk_mulai_kamis = '$masuk_mulai_kamis', masuk_akhir_kamis = '$masuk_akhir_kamis', pulang_mulai_kamis = '$pulang_mulai_kamis', pulang_akhir_kamis = '$pulang_akhir_kamis',
   jumat = '$jumat', masuk_mulai_jumat = '$masuk_mulai_jumat', masuk_akhir_jumat = '$masuk_akhir_jumat', pulang_mulai_jumat = '$pulang_mulai_jumat', pulang_akhir_jumat = '$pulang_akhir_jumat',
   sabtu = '$sabtu', masuk_mulai_sabtu = '$masuk_mulai_sabtu', masuk_akhir_sabtu = '$masuk_akhir_sabtu', pulang_mulai_sabtu = '$pulang_mulai_sabtu', pulang_akhir_sabtu = '$pulang_akhir_sabtu',
   minggu = '$minggu', masuk_mulai_minggu = '$masuk_mulai_minggu', masuk_akhir_minggu = '$masuk_akhir_minggu', pulang_mulai_minggu = '$pulang_mulai_minggu', pulang_akhir_minggu = '$pulang_akhir_minggu' WHERE id_j_karyawan = '$id_j_karyawan'
    ");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['hapus_custom_jadwal_absen_karyawan'])) {
    $id_j_karyawan = $_POST['id_$id_j_karyawan'];
    $query = mysqli_query($conn, "DELETE FROM j_karyawan WHERE id_j_karyawan = '$id_j_karyawan'");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}


if (isset($_GET['edit_jadwal_absen_guru'])) {
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "UPDATE j_guru SET
   senin = '$senin', masuk_mulai_senin = '$masuk_mulai_senin', masuk_akhir_senin = '$masuk_akhir_senin', pulang_mulai_senin = '$pulang_mulai_senin', pulang_akhir_senin = '$pulang_akhir_senin',
   selasa = '$selasa', masuk_mulai_selasa = '$masuk_mulai_selasa', masuk_akhir_selasa = '$masuk_akhir_selasa', pulang_mulai_selasa = '$pulang_mulai_selasa', pulang_akhir_selasa = '$pulang_akhir_selasa',
   rabu = '$rabu', masuk_mulai_rabu = '$masuk_mulai_rabu', masuk_akhir_rabu = '$masuk_akhir_rabu', pulang_mulai_rabu = '$pulang_mulai_rabu', pulang_akhir_rabu = '$pulang_akhir_rabu',
   kamis = '$kamis', masuk_mulai_kamis = '$masuk_mulai_kamis', masuk_akhir_kamis = '$masuk_akhir_kamis', pulang_mulai_kamis = '$pulang_mulai_kamis', pulang_akhir_kamis = '$pulang_akhir_kamis',
   jumat = '$jumat', masuk_mulai_jumat = '$masuk_mulai_jumat', masuk_akhir_jumat = '$masuk_akhir_jumat', pulang_mulai_jumat = '$pulang_mulai_jumat', pulang_akhir_jumat = '$pulang_akhir_jumat',
   sabtu = '$sabtu', masuk_mulai_sabtu = '$masuk_mulai_sabtu', masuk_akhir_sabtu = '$masuk_akhir_sabtu', pulang_mulai_sabtu = '$pulang_mulai_sabtu', pulang_akhir_sabtu = '$pulang_akhir_sabtu',
   minggu = '$minggu', masuk_mulai_minggu = '$masuk_mulai_minggu', masuk_akhir_minggu = '$masuk_akhir_minggu', pulang_mulai_minggu = '$pulang_mulai_minggu', pulang_akhir_minggu = '$pulang_akhir_minggu'
    ");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['custom_jadwal_absen_guru'])) {
    $id_guru = $_POST['id_guru'];
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "INSERT INTO j_guru
    (senin, masuk_mulai_senin, masuk_akhir_senin, pulang_mulai_senin, pulang_akhir_senin, selasa, masuk_mulai_selasa, masuk_akhir_selasa, pulang_mulai_selasa, pulang_akhir_selasa, rabu, masuk_mulai_rabu, masuk_akhir_rabu, pulang_mulai_rabu, pulang_akhir_rabu, kamis, masuk_mulai_kamis, masuk_akhir_kamis, pulang_mulai_kamis, pulang_akhir_kamis, jumat, masuk_mulai_jumat, masuk_akhir_jumat, pulang_mulai_jumat, pulang_akhir_jumat, sabtu, masuk_mulai_sabtu, masuk_akhir_sabtu, pulang_mulai_sabtu, pulang_akhir_sabtu, minggu, masuk_mulai_minggu, masuk_akhir_minggu, pulang_mulai_minggu, pulang_akhir_minggu, id_guru)
    VALUES
    ('$senin', '$masuk_mulai_senin', '$masuk_akhir_senin', '$pulang_mulai_senin', '$pulang_akhir_senin',
    '$selasa', '$masuk_mulai_selasa', '$masuk_akhir_selasa', '$pulang_mulai_selasa', '$pulang_akhir_selasa',
    '$rabu', '$masuk_mulai_rabu', '$masuk_akhir_rabu', '$pulang_mulai_rabu', '$pulang_akhir_rabu',
    '$kamis', '$masuk_mulai_kamis', '$masuk_akhir_kamis', '$pulang_mulai_kamis', '$pulang_akhir_kamis',
    '$jumat', '$masuk_mulai_jumat', '$masuk_akhir_jumat', '$pulang_mulai_jumat', '$pulang_akhir_jumat',
    '$sabtu', '$masuk_mulai_sabtu', '$masuk_akhir_sabtu', '$pulang_mulai_sabtu', '$pulang_akhir_sabtu',
    '$minggu', '$masuk_mulai_minggu', '$masuk_akhir_minggu', '$pulang_mulai_minggu', '$pulang_akhir_minggu', '$id_guru')");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['edit_custom_jadwal_absen_guru'])) {
    $id_j_guru = $_POST['id_j_guru'];
    $senin = $_POST['senin'];
    $masuk_mulai_senin = $_POST['masuk_mulai_senin'] ?? null;
    $masuk_akhir_senin = $_POST['masuk_akhir_senin'] ?? null;
    $pulang_mulai_senin = $_POST['pulang_mulai_senin'] ?? null;
    $pulang_akhir_senin = $_POST['pulang_akhir_senin'] ?? null;
    $selasa = $_POST['selasa'];
    $masuk_mulai_selasa = $_POST['masuk_mulai_selasa'] ?? null;
    $masuk_akhir_selasa = $_POST['masuk_akhir_selasa'] ?? null;
    $pulang_mulai_selasa = $_POST['pulang_mulai_selasa'] ?? null;
    $pulang_akhir_selasa = $_POST['pulang_akhir_selasa'] ?? null;
    $rabu = $_POST['rabu'];
    $masuk_mulai_rabu = $_POST['masuk_mulai_rabu'] ?? null;
    $masuk_akhir_rabu = $_POST['masuk_akhir_rabu'] ?? null;
    $pulang_mulai_rabu = $_POST['pulang_mulai_rabu'] ?? null;
    $pulang_akhir_rabu = $_POST['pulang_akhir_rabu'] ?? null;
    $kamis = $_POST['kamis'];
    $masuk_mulai_kamis = $_POST['masuk_mulai_kamis'] ?? null;
    $masuk_akhir_kamis = $_POST['masuk_akhir_kamis'] ?? null;
    $pulang_mulai_kamis = $_POST['pulang_mulai_kamis'] ?? null;
    $pulang_akhir_kamis = $_POST['pulang_akhir_kamis'] ?? null;
    $jumat = $_POST['jumat'];
    $masuk_mulai_jumat = $_POST['masuk_mulai_jumat'] ?? null;
    $masuk_akhir_jumat = $_POST['masuk_akhir_jumat'] ?? null;
    $pulang_mulai_jumat = $_POST['pulang_mulai_jumat'] ?? null;
    $pulang_akhir_jumat = $_POST['pulang_akhir_jumat'] ?? null;
    $sabtu = $_POST['sabtu'];
    $masuk_mulai_sabtu = $_POST['masuk_mulai_sabtu'] ?? null;
    $masuk_akhir_sabtu = $_POST['masuk_akhir_sabtu'] ?? null;
    $pulang_mulai_sabtu = $_POST['pulang_mulai_sabtu'] ?? null;
    $pulang_akhir_sabtu = $_POST['pulang_akhir_sabtu'] ?? null;
    $minggu = $_POST['minggu'];
    $masuk_mulai_minggu = $_POST['masuk_mulai_minggu'] ?? null;
    $masuk_akhir_minggu = $_POST['masuk_akhir_minggu'] ?? null;
    $pulang_mulai_minggu = $_POST['pulang_mulai_minggu'] ?? null;
    $pulang_akhir_minggu = $_POST['pulang_akhir_minggu'] ?? null;

    $query = mysqli_query($conn, "UPDATE j_guru SET
   senin = '$senin', masuk_mulai_senin = '$masuk_mulai_senin', masuk_akhir_senin = '$masuk_akhir_senin', pulang_mulai_senin = '$pulang_mulai_senin', pulang_akhir_senin = '$pulang_akhir_senin',
   selasa = '$selasa', masuk_mulai_selasa = '$masuk_mulai_selasa', masuk_akhir_selasa = '$masuk_akhir_selasa', pulang_mulai_selasa = '$pulang_mulai_selasa', pulang_akhir_selasa = '$pulang_akhir_selasa',
   rabu = '$rabu', masuk_mulai_rabu = '$masuk_mulai_rabu', masuk_akhir_rabu = '$masuk_akhir_rabu', pulang_mulai_rabu = '$pulang_mulai_rabu', pulang_akhir_rabu = '$pulang_akhir_rabu',
   kamis = '$kamis', masuk_mulai_kamis = '$masuk_mulai_kamis', masuk_akhir_kamis = '$masuk_akhir_kamis', pulang_mulai_kamis = '$pulang_mulai_kamis', pulang_akhir_kamis = '$pulang_akhir_kamis',
   jumat = '$jumat', masuk_mulai_jumat = '$masuk_mulai_jumat', masuk_akhir_jumat = '$masuk_akhir_jumat', pulang_mulai_jumat = '$pulang_mulai_jumat', pulang_akhir_jumat = '$pulang_akhir_jumat',
   sabtu = '$sabtu', masuk_mulai_sabtu = '$masuk_mulai_sabtu', masuk_akhir_sabtu = '$masuk_akhir_sabtu', pulang_mulai_sabtu = '$pulang_mulai_sabtu', pulang_akhir_sabtu = '$pulang_akhir_sabtu',
   minggu = '$minggu', masuk_mulai_minggu = '$masuk_mulai_minggu', masuk_akhir_minggu = '$masuk_akhir_minggu', pulang_mulai_minggu = '$pulang_mulai_minggu', pulang_akhir_minggu = '$pulang_akhir_minggu' WHERE id_j_guru = '$id_j_guru'
    ");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['hapus_custom_jadwal_absen_guru'])) {
    $id_j_guru = $_POST['id_j_guru'];
    $query = mysqli_query($conn, "DELETE FROM j_guru WHERE id_j_guru = '$id_j_guru'");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}



if (isset($_GET['edit_profil_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $profil = $_FILES['profil']['name'];
    $ekstensi = strtolower($profil);
    $ekstensi = explode('.', $ekstensi);
    $ekstensi = end($ekstensi);
    $namafiks = substr(hash('sha256', time()), 0, 10) . '_' . time();
    $tujuan_upload = '../img/karyawan/' . $namafiks . '.' . $ekstensi;
    $profil = $namafiks . '.' . $ekstensi;
    $file_tmp = $_FILES['profil']['tmp_name'];

    $tb_karyawan = query("SELECT id_karyawan,profil FROM tb_karyawan WHERE id_karyawan = '$id_karyawan'");

    if ($tb_karyawan['profil'] !== 'user.png') {
        unlink('../img/karyawan/' . $tb_karyawan['profil']);
    }

    $query = mysqli_query($conn, "UPDATE tb_karyawan SET profil = '$profil' WHERE id_karyawan = '$id_karyawan'");
    if (move_uploaded_file($file_tmp, $tujuan_upload)) {
        if ($query) {
            echo 'berhasil';
        }
    }
}
if (isset($_GET['tambah_jabatan'])) {
    $jabatan = htmlspecialchars($_POST['jabatan']);

    $query = mysqli_query($conn, "INSERT INTO tb_jabatan (jabatan) VALUES ('$jabatan')");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['edit_jabatan'])) {
    $id_jabatan = $_POST['id_jabatan_edit'];
    $jabatan = htmlspecialchars($_POST['jabatan_edit']);

    $query = mysqli_query($conn, "UPDATE tb_jabatan SET jabatan = '$jabatan' WHERE id_jabatan = '$id_jabatan'");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['hapus_jabatan'])) {
    $id_jabatan = $_POST['id_jabatan'];

    $query = mysqli_query($conn, "DELETE FROM tb_jabatan WHERE id_jabatan = '$id_jabatan'");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
if (isset($_GET['tambah_cuti_guru'])) {
    $id_guru = $_POST['id_guru'];
    $keterangan = htmlspecialchars($_POST['keterangan_guru']);
    $mulai_cuti = htmlspecialchars($_POST['mulai_cuti_guru']);
    $selesai_cuti = htmlspecialchars($_POST['selesai_cuti_guru']);
    if ($id_guru == 'all') {
        $tb_guru = mysqli_query($conn, "SELECT id_guru FROM tb_guru");
        foreach ($tb_guru as $data) {
            $id_guru = $data['id_guru'];
            $rows = mysqli_query($conn, "SELECT * FROM `tb_cuti` WHERE id_guru = " . $id_guru . " && selesai_cuti >= '" . $mulai_cuti . "'");
            $count = mysqli_num_rows($rows);
            if ($count == 0) {
                $query = mysqli_query($conn, "INSERT INTO tb_cuti (id_guru,keterangan,mulai_cuti,selesai_cuti) VALUES ('$id_guru','$keterangan','$mulai_cuti','$selesai_cuti')");
            } else {
                echo 'sudah terdaftar';
                return false;
            }
        }
        echo 'berhasil';
    } else {
        $rows = mysqli_query($conn, "SELECT * FROM `tb_cuti` WHERE id_guru = " . $id_guru . " && selesai_cuti >= '" . $mulai_cuti . "'");
        $count = mysqli_num_rows($rows);

        if ($count == 0) {
            $query = mysqli_query($conn, "INSERT INTO tb_cuti (id_guru,keterangan,mulai_cuti,selesai_cuti) VALUES ('$id_guru','$keterangan','$mulai_cuti','$selesai_cuti')");
            if ($query) {
                echo 'berhasil';
            } else {
                echo 'Terdapat kesalahan pada sistem';
            }
        } else {
            echo 'sudah terdaftar';
        }
    }
}

if (isset($_GET['tambah_cuti_karyawan'])) {
    $id_karyawan = $_POST['id_karyawan'];
    $keterangan = htmlspecialchars($_POST['keterangan_karyawan']);
    $mulai_cuti = htmlspecialchars($_POST['mulai_cuti_karyawan']);
    $selesai_cuti = htmlspecialchars($_POST['selesai_cuti_karyawan']);
    if ($id_karyawan == 'all') {
        $tb_karyawan = mysqli_query($conn, "SELECT id_karyawan FROM tb_karyawan");
        foreach ($tb_karyawan as $data) {
            $id_karyawan = $data['id_karyawan'];
            $rows = mysqli_query($conn, "SELECT * FROM `tb_cuti` WHERE id_karyawan = " . $id_karyawan . " && selesai_cuti >= '" . $mulai_cuti . "'");
            $count = mysqli_num_rows($rows);
            if ($count == 0) {
                $query = mysqli_query($conn, "INSERT INTO tb_cuti (id_karyawan,keterangan,mulai_cuti,selesai_cuti) VALUES ('$id_karyawan','$keterangan','$mulai_cuti','$selesai_cuti')");
            } else {
                echo 'sudah terdaftar';
                return false;
            }
        }
        echo 'berhasil';
    } else {
        $rows = mysqli_query($conn, "SELECT * FROM `tb_cuti` WHERE id_karyawan = " . $id_karyawan . " && selesai_cuti >= '" . $mulai_cuti . "'");
        $count = mysqli_num_rows($rows);

        if ($count == 0) {
            $query = mysqli_query($conn, "INSERT INTO tb_cuti (id_karyawan,keterangan,mulai_cuti,selesai_cuti) VALUES ('$id_karyawan','$keterangan','$mulai_cuti','$selesai_cuti')");
            if ($query) {
                echo 'berhasil';
            } else {
                echo 'Terdapat kesalahan pada sistem';
            }
        } else {
            echo 'sudah terdaftar';
        }
    }
}

if (isset($_GET['hapus_cuti'])) {
    $id = $_POST['id'];

    $query = mysqli_query($conn, "DELETE FROM tb_cuti WHERE id = " . $id . "");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}

if (isset($_GET['edit_cuti'])) {
    $id = $_POST['id'];
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $mulai_cuti = htmlspecialchars($_POST['mulai_cuti']);
    $selesai_cuti = htmlspecialchars($_POST['selesai_cuti']);

    $query = mysqli_query($conn, "UPDATE tb_cuti SET keterangan = '$keterangan',mulai_cuti = '$mulai_cuti',selesai_cuti = '$selesai_cuti' WHERE id = '$id'");
    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}

if (isset($_GET['tambah_libur'])) {
    $keterangan = htmlspecialchars($_POST['keterangan']);
    $tanggal_awal = new DateTime($_POST['tanggal_awal']);
    $tanggal_akhir = new DateTime($_POST['tanggal_akhir']);
    $range_tgl = $tanggal_akhir->diff($tanggal_awal)->format("%a") + 1;

    for ($i = 0; $i < $range_tgl; $i++) {
        $tanggal = date('Y-m-d', strtotime('+' . $i . ' days', strtotime($_POST['tanggal_awal'])));

        $validate = num_rows("SELECT * FROM jadwal_libur WHERE tanggal = '$tanggal'");
        if ($validate >= 1) {
            echo 'Tanggal ' . $tanggal .  ' sudah ada di database';
            return false;
        }
    }

    for ($i = 0; $i < $range_tgl; $i++) {
        $tanggal = date('Y-m-d', strtotime('+' . $i . ' days', strtotime($_POST['tanggal_awal'])));

        $query = mysqli_query($conn, "INSERT INTO jadwal_libur (tanggal,keterangan) VALUES ('$tanggal','$keterangan')");
    }

    echo 'berhasil';
}

if (isset($_GET['hapus_libur'])) {
    $id = $_POST['id'];
    $query = mysqli_query($conn, "DELETE FROM jadwal_libur WHERE id = '$id'");

    if ($query) {
        echo 'berhasil';
    } else {
        echo 'Terdapat kesalahan pada sistem';
    }
}
