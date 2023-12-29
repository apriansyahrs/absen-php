<?php
require "../config.php";
if (!isset($_SESSION['karyawan'])) {
    header('location: auth/karyawan');
    return false;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $tb_setelan['nama'] ?></title>
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/overlayscrollbars/css/overlay-scrollbars.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <style>
        .topbar,
        .menu-utama,
        .copyright {
            background-image: linear-gradient(to right, #08C3A5, #08ACC1);
        }

        .card-info-waktu {
            background: #41DBBC !important;
        }
    </style>
</head>

<body>
    <div class="content siswa">
        <nav class="topbar">
            <div class="row">
                <div class="container">
                    <div class="row m-0">
                        <div class="col col-2">
                            <div class="menu">
                                <i class="la la-bars waves-effect waves-light" id="toggle-sidebar"></i>
                            </div>
                        </div>
                        <div class="col col-8">
                            <div class="logo">
                                <?= $tb_setelan['nama'] ?>
                            </div>
                        </div>
                        <div class="col col-2">
                            <div class="notifikasi">
                                <i class="la la-bell waves-effect waves-light active" id="notif-show"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div class="sidebar-menu overlay-scrollbars transition-all-300ms-ease" id="sidebar-menu">
            <div class="logo d-flex align-items-center justify-content-center">
                <span class="f-size-14px">
                    <span class="jam-sekarang f-size-28px"><?= date('H:i:s') ?></span>
                    <br>
                    <?= waktu_sekarang() ?>
                </span>
            </div>
            <div class="sosmed-developer">
                <i class="la la-facebook waves-effect waves-dark" data-tooltip="tooltip" title="Facebook Developer"></i>
                <i class="la la-instagram waves-effect waves-dark" data-tooltip="tooltip" title="Instagram Developer"></i>
                <i class="la la-twitter waves-effect waves-dark" data-tooltip="tooltip" title="Twitter Developer"></i>
            </div>
            <ul>
                <li class="sidebar-item waves-effect waves-dark" id="click-tema-gelap">
                    <i class="la la-adjust"></i>
                    <span>Tema Gelap</span>
                </li>
                <li class="sidebar-item waves-effect waves-dark" id="click-tema-terang">
                    <i class="la la-adjust"></i>
                    <span>Tema Terang</span>
                </li>
            </ul>
        </div>
        <div class="notifikasi-menu overlay-scrollbars transition-all-300ms-ease" id="notifikasi-menu">
            <div class="notifikasi-header">
                <div class="row m-0">
                    <div class="col-10 my-auto">
                        Notifikasi
                    </div>
                    <div class="col-2 my-auto">
                        <div class="notifikasi-close">
                            <i class="la la-times waves-effect waves-light" id="notif-close"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="notifikasi-body">
                <ul>
                    <p class="p-5 text-center">Comming soon</p>
                </ul>
            </div>
        </div>
        <?php
        $j_karyawan = query("SELECT * FROM j_karyawan WHERE id_karyawan = {$_SESSION['karyawan']} OR id_karyawan = 0 ORDER BY id_j_karyawan DESC LIMIT 1");
        if (date('l') == 'Friday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_jumat']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_jumat']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_jumat']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_jumat']));
        } elseif (date('l') == 'Saturday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_sabtu']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_sabtu']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_sabtu']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_sabtu']));
        } elseif (date('l') == 'Sunday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_minggu']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_minggu']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_minggu']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_minggu']));
        } elseif (date('l') == 'Monday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_senin']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_senin']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_senin']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_senin']));
        } elseif (date('l') == 'Tuesday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_selasa']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_selasa']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_selasa']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_selasa']));
        } elseif (date('l') == 'Wednesday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_rabu']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_rabu']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_rabu']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_rabu']));
        } elseif (date('l') == 'Thursday') {
            $masuk_mulai = date('Hi', strtotime($j_karyawan['masuk_mulai_kamis']));
            $masuk_akhir = date('Hi', strtotime($j_karyawan['masuk_akhir_kamis']));
            $pulang_mulai = date('Hi', strtotime($j_karyawan['pulang_mulai_kamis']));
            $pulang_akhir = date('Hi', strtotime($j_karyawan['pulang_akhir_kamis']));
        }

        $waktu_sekarang = date('Hi');
        $tgl_sekarang = date("Y-m-d");

        $tanggal = date('d');
        $bulan_tahun = date('m-Y');

        function absenMasuk()
        {
            global $conn;
            global $tanggal;
            global $bulan_tahun;
            $result = mysqli_query($conn, "SELECT * FROM a_masuk_karyawan WHERE id_karyawan = '$_SESSION[karyawan]' && m_bulan_tahun = '$bulan_tahun'");
            $a_masuk_karyawan = mysqli_fetch_assoc($result);
            if ($a_masuk_karyawan[$tanggal] == '') {
                $row_tgl = true;
            } else {
                $row_tgl = $a_masuk_karyawan[$tanggal];
            }
            return num_rows("SELECT * FROM a_masuk_karyawan WHERE `$tanggal` = '$row_tgl'");
        }

        function absenPulang()
        {
            global $conn;
            global $tanggal;
            global $bulan_tahun;
            $result = mysqli_query($conn, "SELECT * FROM a_pulang_karyawan WHERE id_karyawan = '$_SESSION[karyawan]' && p_bulan_tahun = '$bulan_tahun'");
            $a_pulang_karyawan = mysqli_fetch_assoc($result);
            if ($a_pulang_karyawan[$tanggal] == '') {
                $row_tgl = true;
            } else {
                $row_tgl = $a_pulang_karyawan[$tanggal];
            }
            return num_rows("SELECT * FROM a_pulang_karyawan WHERE `$tanggal` = '$row_tgl'");
        } ?>

        <div class="jumbotron jumbotron-fluid menu-utama">
            <div class="container">
                <div class="info-user">
                    <img src="<?= base_url() ?>/img/karyawan/<?= $tb_karyawan['profil'] ?>" alt="<?= $tb_karyawan['profil'] ?>" class="img-fluid rounded-circle" width="60" height="60">
                    <div class="nama"><?= $tb_karyawan['nama'] ?></div>
                    <div class="kelas"><?= $tb_karyawan['jabatan'] ?></div>
                    <div class="jam-sekarang"><?= date('H:i:s') ?></div>
                    <div class="waktu-sekarang"><?= waktu_sekarang() ?></div>
                </div>
                <div class="text-center my-5">
                    <div class="info-ket">
                        <div class="row d-flex- justify-content-center">
                            <div class="col-md-8 col-lg-4">
                                <?php
                                $cuti_count = num_rows("SELECT * FROM tb_cuti WHERE id_karyawan = '" . $_SESSION['karyawan'] . "' && mulai_cuti <= '" . $tgl_sekarang . "' && selesai_cuti >= '" . $tgl_sekarang . "'");
                                $tb_cuti = query("SELECT * FROM tb_cuti WHERE id_karyawan = '" . $_SESSION['karyawan'] . "' && mulai_cuti <= '" . $tgl_sekarang . "' && selesai_cuti >= '" . $tgl_sekarang . "'");
                                $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

                                if ($jadwal_libur) {
                                    echo 'Libur ' . $jadwal_libur['keterangan'];
                                } else {
                                    if ($cuti_count >= 1) {
                                        if ($tb_cuti['keterangan']) {
                                            echo $tb_cuti['keterangan'];
                                        } else {
                                            echo 'Anda sedang dalam masa Cuti';
                                        }
                                    } else {
                                        if (date('l') !== "Sunday") {
                                            if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
                                                if (absenMasuk() == 0) {
                                                    echo 'Sekarang waktunya melakukan absen masuk';
                                                } else {
                                                    echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
                                                }
                                            } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
                                                if (absenMasuk() == 0) {
                                                    echo 'Absen masuk sudah berakhir pada jam ' . $j_karyawan['masuk_akhir'] . ' yang lalu';
                                                } else {
                                                    echo 'Kamu sudah melakukan absen masuk hari ini, tunggu absen pulang selanjutnya';
                                                }
                                            } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
                                                if (absenMasuk() == 0) {
                                                    echo 'Kamu tidak melakukan absen masuk, maka tidak bisa melakukan absen pulang hari ini';
                                                } elseif (absenPulang() == 0) {
                                                    echo 'Sekarang waktunya melakukan absen pulang';
                                                } else {
                                                    echo 'Kamu sudah melakukan absen pulang hari ini';
                                                }
                                            } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
                                                if (absenPulang() == 0) {
                                                    if (date('l') == 'Friday') {
                                                        echo 'Absen pulang sudah berakhir pada jam ' . $j_karyawan['pulang_akhir_jumat'] . ' yang lalu';
                                                    } else {
                                                        echo 'Absen pulang sudah berakhir pada jam ' . $j_karyawan['pulang_akhir'] . ' yang lalu';
                                                    }
                                                } else {
                                                    echo 'Kamu sudah melakukan absen pulang hari ini';
                                                }
                                            } else {
                                                echo 'Belum waktunya melakukan absen masuk';
                                            }
                                        } else {
                                            echo 'Hari ini libur!';
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-5 d-flex justify-content-center">
                    <div class="col-4 col-lg-2 mt-4 p-0 text-md-right">
                        <button type="button" class="btn btn-absen transparent waves-effect waves-light click-profil">
                            <i class="la la-user"></i>
                            Profil
                        </button>
                    </div>
                    <div class="col-4 col-lg-2 p-0">
                        <?php
                        $jadwal_libur = query("SELECT * FROM jadwal_libur WHERE tanggal = '" . date('Y-m-d') . "'");

                        if ($jadwal_libur) { ?>
                            <button type="button" class="btn btn-absen danger" disabled="disabled">
                                <i class="la la-calendar"></i>
                            </button>
                            <?php
                        } else {
                            if ($cuti_count >= 1) { ?>
                                <button type="button" class="btn btn-absen warning" disabled="disabled">
                                    Cuti
                                </button>
                                <?php } else {
                                if (date('l') !== "Sunday") {
                                    if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) {
                                        if (absenMasuk() == 0) { ?>
                                            <button type="button" class="btn btn-absen warning waves-effect waves-warning infinite animated pulse" id="click-absen-masuk">
                                                Masuk
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                                                <i class="la la-check"></i>
                                            </button>
                                        <?php }
                                    } elseif ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
                                        if (absenMasuk() == 0) { ?>
                                            <button type="button" class="btn btn-absen warning waves-effect waves-warning infinite animated pulse" id="click-absen-masuk-terlambat">
                                                Masuk
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-absen warning infinite animated pulse" disabled="disabled">
                                                <i class="la la-check"></i>
                                            </button>
                                        <?php }
                                    } elseif ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
                                        if (absenMasuk() == 0) { ?>
                                            <button type="button" class="btn btn-absen danger" disabled="disabled">
                                                <i class="la la-times"></i>
                                            </button>
                                        <?php } elseif (absenPulang() == 0) { ?>
                                            <button type="button" class="btn btn-absen danger waves-effect waves-danger infinite animated pulse" id="click-absen-pulang">
                                                Pulang
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-absen danger infinite animated pulse" disabled="disabled">
                                                <i class="la la-check"></i>
                                            </button>
                                        <?php }
                                    } elseif ($waktu_sekarang >= $pulang_akhir && $waktu_sekarang < '2400') {
                                        if (absenPulang() == 0) { ?>
                                            <button type="button" class="btn btn-absen danger" disabled="disabled">
                                                <i class="la la-times"></i>
                                            </button>
                                        <?php } else { ?>
                                            <button type="button" class="btn btn-absen danger" disabled="disabled">
                                                <i class="la la-check"></i>
                                            </button>
                                        <?php }
                                    } else { ?>
                                        <button type="button" class="btn btn-absen warning" disabled="disabled">
                                            Masuk
                                        </button>
                                    <?php }
                                } else { ?>
                                    <button type="button" class="btn btn-absen danger" disabled="disabled">
                                        <i class="la la-calendar"></i>
                                    </button>
                        <?php }
                            }
                        } ?>
                    </div>
                    <div class="col-4 col-lg-2 mt-4 p-0 text-md-left">
                        <button type="button" class="btn btn-absen transparent waves-effect waves-light click-logout">
                            <i class="la la-sign-out"></i>
                            Logout
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="my-5">
                <div class="label-menu">Jadwal absen</div>
                <div class="info-waktu">
                    <div class="row d-flex justify-content-center">
                        <div class="col-12 col-md-6 my-auto">
                            <div class="font-italic f-size-20px my-4">
                                <p style="color: #343336;">"Disiplin adalah jembatan antara cita-cita dan pencapaiannya."</p>
                            </div>
                            <div id="carouselJadwalAbsen" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <?php if ($cuti_count >= 1) { ?>
                                        <div class="carousel-item active">
                                            <div class="row d-flex justify-content-center mx-1">
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-mulai">
                                                            Mulai Cuti <br> <span><?= $tb_cuti['mulai_cuti'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-akhir">
                                                            Selesai Cuti <br> <span><?= $tb_cuti['selesai_cuti'] ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="carousel-item active">
                                            <div class="row d-flex justify-content-center mx-1">
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-mulai" data-tooltip="tooltip" title="Absen masuk dilakukan pada saat atau sesudah jam <?= $j_karyawan['masuk_mulai'] ?>">
                                                            Masuk Mulai <br> <span>
                                                                <?php
                                                                if (date('l') == 'Friday') {
                                                                    echo $j_karyawan['masuk_mulai_jumat'];
                                                                } elseif (date('l') == 'Saturday') {
                                                                    echo $j_karyawan['masuk_mulai_sabtu'];
                                                                } elseif (date('l') == 'Sunday') {
                                                                    echo $j_karyawan['masuk_mulai_minggu'];
                                                                } elseif (date('l') == 'Monday') {
                                                                    echo $j_karyawan['masuk_mulai_senin'];
                                                                } elseif (date('l') == 'Tuesday') {
                                                                    echo $j_karyawan['masuk_mulai_selasa'];
                                                                } elseif (date('l') == 'Wednesday') {
                                                                    echo $j_karyawan['masuk_mulai_rabu'];
                                                                } elseif (date('l') == 'Thursday') {
                                                                    echo $j_karyawan['masuk_mulai_kamis'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen masuk pada jam <?= $j_karyawan['masuk_akhir'] ?>">
                                                            Masuk Akhir <br> <span>
                                                                <?php
                                                                if (date('l') == 'Friday') {
                                                                    echo $j_karyawan['masuk_akhir_jumat'];
                                                                } elseif (date('l') == 'Saturday') {
                                                                    echo $j_karyawan['masuk_akhir_sabtu'];
                                                                } elseif (date('l') == 'Sunday') {
                                                                    echo $j_karyawan['masuk_akhir_minggu'];
                                                                } elseif (date('l') == 'Monday') {
                                                                    echo $j_karyawan['masuk_akhir_senin'];
                                                                } elseif (date('l') == 'Tuesday') {
                                                                    echo $j_karyawan['masuk_akhir_selasa'];
                                                                } elseif (date('l') == 'Wednesday') {
                                                                    echo $j_karyawan['masuk_akhir_rabu'];
                                                                } elseif (date('l') == 'Thursday') {
                                                                    echo $j_karyawan['masuk_akhir_kamis'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="row d-flex justify-content-center mx-1">
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-mulai" data-tooltip="tooltip" title="Absen pulang dilakukan pada saat atau sesudah jam <?= $j_karyawan['pulang_mulai'] ?>">
                                                            Pulang Mulai <br>
                                                            <span>
                                                                <?php
                                                                if (date('l') == 'Friday') {
                                                                    echo $j_karyawan['pulang_mulai_jumat'];
                                                                } elseif (date('l') == 'Saturday') {
                                                                    echo $j_karyawan['pulang_mulai_sabtu'];
                                                                } elseif (date('l') == 'Sunday') {
                                                                    echo $j_karyawan['pulang_mulai_minggu'];
                                                                } elseif (date('l') == 'Monday') {
                                                                    echo $j_karyawan['pulang_mulai_senin'];
                                                                } elseif (date('l') == 'Tuesday') {
                                                                    echo $j_karyawan['pulang_mulai_selasa'];
                                                                } elseif (date('l') == 'Wednesday') {
                                                                    echo $j_karyawan['pulang_mulai_rabu'];
                                                                } elseif (date('l') == 'Thursday') {
                                                                    echo $j_karyawan['pulang_mulai_kamis'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="card-info-waktu waves-effect waves-light">
                                                        <div class="waktu-akhir" data-tooltip="tooltip" title="Batas waktu melakukan absen pulang pada jam <?= $j_karyawan['pulang_akhir'] ?>">
                                                            Pulang Akhir <br>
                                                            <span>
                                                                <?php
                                                                if (date('l') == 'Friday') {
                                                                    echo $j_karyawan['pulang_akhir_jumat'];
                                                                } elseif (date('l') == 'Saturday') {
                                                                    echo $j_karyawan['pulang_akhir_sabtu'];
                                                                } elseif (date('l') == 'Sunday') {
                                                                    echo $j_karyawan['pulang_akhir_minggu'];
                                                                } elseif (date('l') == 'Monday') {
                                                                    echo $j_karyawan['pulang_akhir_senin'];
                                                                } elseif (date('l') == 'Tuesday') {
                                                                    echo $j_karyawan['pulang_akhir_selasa'];
                                                                } elseif (date('l') == 'Wednesday') {
                                                                    echo $j_karyawan['pulang_akhir_rabu'];
                                                                } elseif (date('l') == 'Thursday') {
                                                                    echo $j_karyawan['pulang_akhir_kamis'];
                                                                }
                                                                ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if ($cuti_count == 0) { ?>
                                    <a class="carousel-control-prev" href="#carouselJadwalAbsen" role="button" data-slide="prev">
                                        <span><i class="la la-angle-left waves-effect waves-dark ml-n4"></i></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselJadwalAbsen" role="button" data-slide="next">
                                        <span><i class="la la-angle-right waves-effect waves-dark mr-n4"></i></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-10 col-md-6 my-5">
                            <img src="<?= base_url() ?>/assets/img/undraw_work_chat_erdt.svg" alt="gambar" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $jml_hari = jml_hari(date('m'), date('Y')); ?>
        <div class="label-menu">
            Monitoring
        </div>
        <div class="card mt-5 border-0" style="border-radius: 0; margin-bottom: 100px;">
            <div class="card-body">
                <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars my-3">
                    <table class="table table-bordered table-hover sticky-first-column">
                        <thead class="text-center">
                            <tr>
                                <!-- <th rowspan="2">No</th> -->
                                <th rowspan="2" class="text-left first">Nama</th>
                                <th rowspan="2" class="text-left first">Jabatan</th>
                                <!-- <th colspan="<?= $jml_hari ?>">absen masuk <?= bulan(date('m')) . ' ' . date('Y'); ?></th> -->
                                <?php
                                for ($i = 1; $i <= $jml_hari; $i++) {
                                    if ($i < 10) {
                                        $i = 0 . $i;
                                    }
                                    $nama_hari = date('l', strtotime(date('Y/m') . '/' . $i));

                                    if ($nama_hari !== 'Sunday') {
                                        echo "<th class='first-next'>$i</th>";
                                    } else {
                                        echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                                    }
                                } ?>
                            </tr>
                            <!-- <tr>

                     </tr> -->
                        </thead>
                        <tbody class="text-center" id="intervalAbsenMasukMonitoring"></tbody>
                    </table>
                </div>
                <div role="region" aria-labelledby="caption" tabindex="0" class="table-responsive overlay-scrollbars my-3">
                    <table class="table table-bordered table-hover sticky-first-column">
                        <thead class="text-center">
                            <tr>
                                <!-- <th rowspan="2">No</th> -->
                                <th rowspan="2" class="text-left first">Nama</th>
                                <th rowspan="2" class="text-left first">Jabatan</th>
                                <!-- <th colspan="<?= $jml_hari ?>">absen pulang <?= bulan(date('m')) . ' ' . date('Y'); ?></th> -->
                                <?php
                                for ($i = 1; $i <= $jml_hari; $i++) {
                                    if ($i < 10) {
                                        $i = 0 . $i;
                                    }
                                    $nama_hari = date('l', strtotime(date('Y/m') . '/' . $i));

                                    if ($nama_hari !== 'Sunday') {
                                        echo "<th class='first-next'>$i</th>";
                                    } else {
                                        echo "<th class='first-next' style='background-color: #E5E7EB;'>$i</th>";
                                    }
                                } ?>
                            </tr>
                            <!-- <tr>
                     </tr> -->
                        </thead>
                        <tbody class="text-center" id="intervalAbsenPulangMonitoring"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="copyright">
        <div class="container">
            <img src="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" alt="Logo">
            <p>
                &copy; Copyright 2020 <?= $tb_setelan['nama'] ?>
            </p>
        </div>
    </div>
    <div class="scrolltop">
        <i class="la la-angle-up waves-effect waves-light"></i>
    </div>
    <div class="overlay-998" id="overlay-sidebar"></div>
    <div class="overlay-9998" id="overlay-notifikasi"></div>
    <div class="pesan transition-all-300ms-ease"></div>
    <div id="loader"></div>
    <?php if ($waktu_sekarang >= $masuk_mulai && $waktu_sekarang < $masuk_akhir) { ?>
        <form id="formAbsenMasuk" enctype="multipart/form-data">
            <div class="modal fade animated zoomIn" id="modalAbsenMasuk" tabindex="-1" role="dialog" aria-labelledby="modalAbsenMasukLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="la la-times"></i>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                            <input type="hidden" name="latitude" id="latitude">
                            <input type="hidden" name="longitude" id="longitude">
                            <input type="hidden" name="m_foto" id="m_foto">
                            <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir">
                            <div class="form-group" style="color: #1e3056;">
                                <p class="f-size-28px mb-0">Halo, <?= $tb_karyawan['nama'] ?></p>
                                <p>Sudah siap absen masuk hari ini, pilih salah satu alasan dibawah.</p>
                            </div>
                            <div class="form-group">
                                <label class="btn btn-radio active">Hadir
                                    <input type="radio" class="d-none" name="m_alasan" id="btn-radio-hadir" value="hadir" checked="">
                                </label>
                                <label class="btn btn-radio">Izin
                                    <input type="radio" class="d-none" name="m_alasan" id="btn-radio-izin" value="izin">
                                </label>
                                <label class="btn btn-radio">Sakit
                                    <input type="radio" class="d-none" name="m_alasan" id="btn-radio-sakit" value="sakit">
                                </label>
                            </div>
                            <div class="form-group">
                                <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required="">Hadir</textarea>
                            </div>
                            <div class="form-group">
                                <div id="my_camera"></div>
                            </div>
                            <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-masuk">Absen Masuk</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php }

    if ($waktu_sekarang >= $masuk_akhir && $waktu_sekarang < $pulang_mulai) {
        if (absenMasuk() == 0) { ?>
            <form id="formAbsenMasukTerlambat" enctype="multipart/form-data">
                <div class="modal fade animated zoomIn" id="modalAbsenMasukTerlambat" tabindex="-1" role="dialog" aria-labelledby="modalAbsenMasukTerlambatLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="la la-times"></i>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <input type="hidden" name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                                <input type="hidden" name="latitude" id="latitude">
                                <input type="hidden" name="longitude" id="longitude">
                                <input type="hidden" name="m_foto" id="m_foto">
                                <input type="hidden" name="m_alasan_text" id="m_alasan_text" value="hadir"> <!-- biar saja hadir, cuman untuk validasi radius lokasi -->
                                <div class="form-group" style="color: #1e3056;">
                                    <p class="f-size-28px mb-0">Halo, <?= $tb_karyawan['nama'] ?></p>
                                    <p>Anda terlambat hari ini!</p>
                                </div>
                                <div class="form-group">
                                    <label class="btn btn-radio active">Terlambat
                                        <input type="radio" class="d-none" name="m_alasan" id="" value="terlambat" checked="">
                                    </label>
                                </div>
                                <div class="form-group">
                                    <textarea name="m_ket" id="m_ket" rows="3" class="form-control form-control2" placeholder="Berikan keterangan..." required=""></textarea>
                                </div>
                                <div class="form-group">
                                    <div id="my_camera"></div>
                                </div>
                                <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-masuk">Absen Masuk</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    <?php }
    } ?>

    <?php
    if ($waktu_sekarang >= $pulang_mulai && $waktu_sekarang < $pulang_akhir) {
        if (absenPulang() == 0 && absenMasuk() !== 0) { ?>
            <form id="formAbsenPulang" enctype="multipart/form-data">
                <div class="modal fade animated zoomIn" id="modalAbsenPulang" tabindex="-1" role="dialog" aria-labelledby="modalAbsenPulangLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="la la-times"></i>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <input type=hidden name="id_karyawan" value="<?= $tb_karyawan['id_karyawan'] ?>">
                                <input type=hidden name="latitude" id="latitude_pulang">
                                <input type=hidden name="longitude" id="longitude_pulang">
                                <input type=hidden name="p_foto" id="p_foto">
                                <div class="form-group" style="color: #1e3056;">
                                    <p class="f-size-28px mb-0">Halo, <?= $tb_karyawan['nama'] ?></p>
                                    <p>Sudah siap absen pulang hari ini.</p>
                                </div>
                                <div class="form-group">
                                    <div id="my_camera_pulang"></div>
                                </div>
                                <p class="text-left font-italic">Posisikan muka kamu di kamera, sampai proses absen selesai dan pastikan GPS kamu dalam keadaan aktif!</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-linear-primary btn-lg btn-user btn-block waves-effect waves-light" id="btn-absen-pulang">Absen Pulang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
    <?php }
    } ?>
    <div class="modal fade animated zoomIn" id="modalNavigatorOnline" tabindex="-1" role="dialog" aria-labelledby="modalNavigatorOnlineLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body text-center b-radius-10px overflow-x-hidden" style="color: #1e3056">
                    <div class="row d-flex justify-content-center">
                        <div class="col-4">
                            <img src="<?= base_url() ?>/assets/img/undraw_broadcast_jhwx.svg" alt="gambar" class="img-fluid">
                        </div>
                    </div>
                    <p class="mt-4 f-size-18px">Hubungkan ke jaringan!</p>
                    <p>Pengguna <?= $tb_setelan['nama'] ?>, hidupkan data seluler atau hubungkan wifi.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/overlayscrollbars/js/jquery-overlay-scrollbars.min.js"></script>
    <script src="<?= base_url() ?>/assets/overlayscrollbars/js/overlay-scrollbars.min.js"></script>
    <script src="<?= base_url() ?>/assets/maps/geo-min.js"></script>
    <script src="<?= base_url() ?>/assets/webcam/webcam.min.js"></script>
    <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
    <script src="<?= base_url() ?>/karyawan/js/script.js"></script>
    <script>
        function take_snapshot() {
            Webcam.snap(function(data_uri) {
                $('#result_camera').html('<img src="' + data_uri + '">');
            });
        }

        const date = new Date;

        if (date.getDay() == 5) {
            var masuk_mulai = '<?= $j_karyawan['masuk_mulai'] ?>:00';
            masuk_akhir = '<?= $j_karyawan['masuk_akhir'] ?>:00';
            pulang_mulai = '<?= $j_karyawan['pulang_mulai_jumat'] ?>:00';
            pulang_akhir = '<?= $j_karyawan['pulang_akhir_jumat'] ?>:00';
        } else {
            var masuk_mulai = '<?= $j_karyawan['masuk_mulai'] ?>:00';
            masuk_akhir = '<?= $j_karyawan['masuk_akhir'] ?>:00';
            pulang_mulai = '<?= $j_karyawan['pulang_mulai'] ?>:00';
            pulang_akhir = '<?= $j_karyawan['pulang_akhir'] ?>:00';
        }

        setInterval(function() {
            $.ajax({
                url: '../jam-sekarang',
                success: function(jamSekarang) {
                    if (masuk_mulai == jamSekarang) {
                        location.reload();
                    } else if (masuk_akhir == jamSekarang) {
                        location.reload();
                    } else if (pulang_mulai == jamSekarang) {
                        location.reload();
                    } else if (pulang_akhir == jamSekarang) {
                        location.reload();
                    }
                    $('.jam-sekarang').html(jamSekarang);
                }
            });
        }, 1000);

        setInterval(function() {
            intervalAbsenMasukMonitoring();
            intervalAbsenPulangMonitoring();
        }, 60000);

        intervalAbsenMasukMonitoring();
        intervalAbsenPulangMonitoring();

        function intervalAbsenMasukMonitoring() {
            $.ajax({
                type: 'post',
                url: 'intervalAbsenMasukMonitoring',
                data: {
                    m_bulan_tahun: '<?= $bulan_tahun ?>'
                },
                success: function(data) {
                    $('#intervalAbsenMasukMonitoring').html(data);
                }
            });
        }

        function intervalAbsenPulangMonitoring() {
            $.ajax({
                type: 'post',
                url: 'intervalAbsenPulangMonitoring',
                data: {
                    p_bulan_tahun: '<?= $bulan_tahun ?>'
                },
                success: function(data) {
                    $('#intervalAbsenPulangMonitoring').html(data);
                }
            });
        }
    </script>
</body>

</html>
