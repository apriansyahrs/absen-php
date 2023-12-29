<?php
require "../config.php";

$tgl = date('d');
$bulan_tahun = date('m-Y');
$tahun_bulan_tanggal = date("Y-m-d");
$time = time();

$tb_setelan = query("SELECT * FROM setelan LIMIT 1");

$lat = $tb_setelan["latitude_instansi"];
$lng = $tb_setelan["longitude_instansi"];

//////////////////// guru ////////////////////

$res_cuti_guru = mysqli_query($conn, "SELECT * FROM tb_cuti c JOIN tb_guru g ON c.id_guru = g.id_guru WHERE c.mulai_cuti <= '" . $tahun_bulan_tanggal . "' && c.selesai_cuti >= '" . $tahun_bulan_tanggal . "' && c.id_guru IS NOT NULL");

foreach ($res_cuti_guru as $cuti_guru) {
    $id_guru = $cuti_guru["id_guru"];
    $token = $cuti_guru["nip"] . '-' . generateRandomString();
    $cuti_keterangan = $cuti_guru["keterangan"];
    
    //////////////////// masuk ////////////////////
    
    $res_guru = mysqli_query($conn, "SELECT * FROM a_masuk_guru WHERE id_guru = '" . $id_guru . "' && m_bulan_tahun = '$bulan_tahun'");
    $a_masuk_guru = mysqli_fetch_assoc($res_guru);
    if ($a_masuk_guru[$tgl] == '') {
        $row_tgl = true;
    } else {
        $row_tgl = $a_masuk_guru[$tgl];
    }
    
    if (num_rows("SELECT * FROM a_masuk_guru WHERE `$tgl` = '$row_tgl'") == 0) {
        $masuk_count = num_rows("SELECT id_guru,m_bulan_tahun FROM a_masuk_guru WHERE id_guru = '$id_guru' && m_bulan_tahun = '$bulan_tahun'");
        
        if ($masuk_count == 0) {
            mysqli_query($conn, "INSERT INTO a_masuk_guru (id_guru,`$tgl`,m_tanggal,m_bulan_tahun) VALUES ('$id_guru','$token','$tgl','$bulan_tahun')");
        } else {
            mysqli_query($conn, "UPDATE a_masuk_guru SET `$tgl` = '$token', m_tanggal = '$tgl' WHERE id_guru = '$id_guru' && m_bulan_tahun = '$bulan_tahun'");
        }
        
        mysqli_query($conn, "INSERT INTO a_masukket_guru (m_alasan,m_ket,m_foto,m_pada,latitude,longitude,token_masuk) VALUES ('cuti','$cuti_keterangan','cuti.png','$time','$lat','$lng','$token')");
        
        $masuk_guru = query("SELECT id_guru,m_bulan_tahun,cuti FROM a_masuk_guru WHERE id_guru = '$id_guru' && m_bulan_tahun = '$bulan_tahun'");
        
        $jml_cuti_masuk = $masuk_guru['cuti'] + 1;
        
        mysqli_query($conn, "UPDATE a_masuk_guru SET `cuti` = '$jml_cuti_masuk' WHERE id_guru = '$id_guru' && m_bulan_tahun = '$bulan_tahun'");
    }
    

    //////////////////// pulang ////////////////////
    
    $res_guru = mysqli_query($conn, "SELECT * FROM a_pulang_guru WHERE id_guru = '" . $id_guru . "' && p_bulan_tahun = '$bulan_tahun'");
    $a_pulang_guru = mysqli_fetch_assoc($res_guru);
    if ($a_pulang_guru[$tgl] == '') {
        $row_tgl = true;
    } else {
        $row_tgl = $a_pulang_guru[$tgl];
    }
    
    if (num_rows("SELECT * FROM a_pulang_guru WHERE `$tgl` = '$row_tgl'") == 0) {
        $pulang_count = num_rows("SELECT id_guru,p_bulan_tahun FROM a_pulang_guru WHERE id_guru = '$id_guru' && p_bulan_tahun = '$bulan_tahun'");
        
        if ($pulang_count == 0) {
            mysqli_query($conn, "INSERT INTO a_pulang_guru (id_guru,`$tgl`,p_tanggal,p_bulan_tahun) VALUES ('$id_guru','$token','$tgl','$bulan_tahun')");
        } else {
            mysqli_query($conn, "UPDATE a_pulang_guru SET `$tgl` = '$token', p_tanggal = '$tgl' WHERE id_guru = '$id_guru' && p_bulan_tahun = '$bulan_tahun'");
        }
        
        mysqli_query($conn, "INSERT INTO a_pulangket_guru (p_alasan,p_ket,p_foto,p_pada,latitude,longitude,token_pulang) VALUES ('cuti','$cuti_keterangan','cuti.png','$time','$lat','$lng','$token')");
        
        $pulang_guru = query("SELECT id_guru,p_bulan_tahun,cuti FROM a_pulang_guru WHERE id_guru = '$id_guru' && p_bulan_tahun = '$bulan_tahun'");
        
        $jml_cuti_pulang = $pulang_guru['cuti'] + 1;
        
        mysqli_query($conn, "UPDATE a_pulang_guru SET `cuti` = '$jml_cuti_pulang' WHERE id_guru = '$id_guru' && p_bulan_tahun = '$bulan_tahun'");
    }
    
}

//////////////////// karyawan ////////////////////

$res_cuti_karyawan = mysqli_query($conn, "SELECT * FROM tb_cuti c JOIN tb_karyawan k ON c.id_karyawan = k.id_karyawan WHERE c.mulai_cuti <= '" . $tahun_bulan_tanggal . "' && c.selesai_cuti >= '" . $tahun_bulan_tanggal . "' && c.id_karyawan IS NOT NULL");

foreach ($res_cuti_karyawan as $cuti_karyawan) {
    $id_karyawan = $cuti_karyawan["id_karyawan"];
    $token = $cuti_karyawan["nip"] . '-' . generateRandomString();
    $cuti_keterangan = $cuti_karyawan["keterangan"];
    
    //////////////////// masuk ////////////////////
    
    $res_karyawan = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan WHERE id_karyawan = '" . $id_karyawan . "' && m_bulan_tahun = '$bulan_tahun'");
    $a_masuk_karyawan = mysqli_fetch_assoc($res_karyawan);
    if ($a_masuk_karyawan[$tgl] == '') {
        $row_tgl = true;
    } else {
        $row_tgl = $a_masuk_karyawan[$tgl];
    }
    
    if (num_rows("SELECT * FROM a_masuk_karyawan WHERE `$tgl` = '$row_tgl'") == 0) {
        $masuk_count = num_rows("SELECT id_karyawan,m_bulan_tahun FROM a_masuk_karyawan WHERE id_karyawan = '$id_karyawan' && m_bulan_tahun = '$bulan_tahun'");
        
        if ($masuk_count == 0) {
            mysqli_query($conn, "INSERT INTO a_masuk_karyawan (id_karyawan,`$tgl`,m_tanggal,m_bulan_tahun) VALUES ('$id_karyawan','$token','$tgl','$bulan_tahun')");
        } else {
            mysqli_query($conn, "UPDATE a_masuk_karyawan SET `$tgl` = '$token', m_tanggal = '$tgl' WHERE id_karyawan = '$id_karyawan' && m_bulan_tahun = '$bulan_tahun'");
        }
        
        mysqli_query($conn, "INSERT INTO a_masukket_karyawan (m_alasan,m_ket,m_foto,m_pada,latitude,longitude,token_masuk) VALUES ('cuti','$cuti_keterangan','cuti.png','$time','$lat','$lng','$token')");
        
        $masuk_karyawan = query("SELECT id_karyawan,m_bulan_tahun,cuti FROM a_masuk_karyawan WHERE id_karyawan = '$id_karyawan' && m_bulan_tahun = '$bulan_tahun'");
        
        $jml_cuti_masuk = $masuk_karyawan['cuti'] + 1;
        
        mysqli_query($conn, "UPDATE a_masuk_karyawan SET `cuti` = '$jml_cuti_masuk' WHERE id_karyawan = '$id_karyawan' && m_bulan_tahun = '$bulan_tahun'");
    }
    

    //////////////////// pulang ////////////////////
    
    $res_karyawan = mysqli_query($conn, "SELECT * FROM a_pulang_karyawan WHERE id_karyawan = '" . $id_karyawan . "' && p_bulan_tahun = '$bulan_tahun'");
    $a_pulang_karyawan = mysqli_fetch_assoc($res_karyawan);
    if ($a_pulang_karyawan[$tgl] == '') {
        $row_tgl = true;
    } else {
        $row_tgl = $a_pulang_karyawan[$tgl];
    }
    
    if (num_rows("SELECT * FROM a_pulang_karyawan WHERE `$tgl` = '$row_tgl'") == 0) {
        $pulang_count = num_rows("SELECT id_karyawan,p_bulan_tahun FROM a_pulang_karyawan WHERE id_karyawan = '$id_karyawan' && p_bulan_tahun = '$bulan_tahun'");
        
        if ($pulang_count == 0) {
            mysqli_query($conn, "INSERT INTO a_pulang_karyawan (id_karyawan,`$tgl`,p_tanggal,p_bulan_tahun) VALUES ('$id_karyawan','$token','$tgl','$bulan_tahun')");
        } else {
            mysqli_query($conn, "UPDATE a_pulang_karyawan SET `$tgl` = '$token', p_tanggal = '$tgl' WHERE id_karyawan = '$id_karyawan' && p_bulan_tahun = '$bulan_tahun'");
        }
        
        mysqli_query($conn, "INSERT INTO a_pulangket_karyawan (p_alasan,p_ket,p_foto,p_pada,latitude,longitude,token_pulang) VALUES ('cuti','$cuti_keterangan','cuti.png','$time','$lat','$lng','$token')");
        
        $pulang_karyawan = query("SELECT id_karyawan,p_bulan_tahun,cuti FROM a_pulang_karyawan WHERE id_karyawan = '$id_karyawan' && p_bulan_tahun = '$bulan_tahun'");
        
        $jml_cuti_pulang = $pulang_karyawan['cuti'] + 1;
        
        mysqli_query($conn, "UPDATE a_pulang_karyawan SET `cuti` = '$jml_cuti_pulang' WHERE id_karyawan = '$id_karyawan' && p_bulan_tahun = '$bulan_tahun'");
    }
}