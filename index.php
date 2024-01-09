<?php require "config.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $tb_setelan['nama'] ?></title>

    <meta name="theme-color" content="#0d0072"/>

    <link rel="manifest" href="<?= base_url() ?>/assets/js/web.webmanifest">
    <link rel="apple-touch-icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png">
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/img/icons8-checkmark-48.png" type="image/x-icon">

    <link rel="stylesheet" href="<?= base_url() ?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/animate/animate.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>/assets/absensi/css/style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    <style>
        html,
        body {
            background: #F1F7FF;
        }
    </style>
</head>

<nav class="navbar navbar-landing-page navbar-expand-lg navbar-light fixed-top py-4">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>"><?= $tb_setelan['nama'] ?></a>
        <button class="navbar-toggler outline-0" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="https://smaialazhar5.sch.id">Beranda</a>
                <a class="nav-item nav-link" href="https://smaialazhar5.sch.id">Kontak</a>
            </div>
        </div>
    </div>
</nav>

<div class="landing-page" id="beranda">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class=" col-12 col-lg-6 my-auto">
                <h1>
                    <?= $tb_setelan['nama'] ?>
                    <span>- lebih mudah & cepat</span>
                </h1>
                <p>adalah sebuah kegiatan pengambilan data guna mengetahui jumlah kehadiran pada suatu acara. Setiap kegiatan yang membutuhkan informasi mengenai peserta tentu akan melakukan absensi.</p>
                <a href="<?= base_url() ?>/auth/siswa" class="btn btn-outline-linear-primary waves-effect my-2">
                    Login Siswa
                </a>
                <a href="<?= base_url() ?>/auth/guru" class="btn btn-outline-linear-primary waves-effect my-2">
                    Login Guru
                </a>
                <br>
                <a href="<?= base_url() ?>/auth/ortu" class="btn btn-outline-linear-success waves-effect my-2">
                    Login Ortu
                </a>
                <a href="<?= base_url() ?>/auth/karyawan" class="btn btn-outline-linear-success waves-effect my-2">
                    Login Karyawan
                </a>
            </div>
            <div class="col-10 col-lg-6 my-5 img">
                <img src="<?= base_url() ?>/assets/img/undraw_work_chat_erdt.svg" alt="gambar" class="img-fluid">
            </div>
        </div>
    </div>
</div>


<body>
    <script src="<?= base_url() ?>/assets/jquery/jquery.min.js"></script>
    <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url() ?>/assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>/assets/absensi/js/script.js"></script>
</body>

</html>
