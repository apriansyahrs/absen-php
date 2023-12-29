<?php
require "../config.php";
$token_kelas = $_GET['token_kelas'];

$tb_kelas = query("SELECT kelas,token_kelas FROM tb_kelas WHERE token_kelas = '$token_kelas'");
$result = mysqli_query($conn, "SELECT DISTINCT id_guru,m_bulan_tahun,token_kelas FROM a_masuk WHERE token_kelas = '$token_kelas'"); ?>

<div class="content-title">Monitoring</div>
<div class="card">
    <div class="card-header">
        <button type="button" class="btn btn-light btn-user waves-effect border-0 f-size-18px kembali">
            <i class="la la-angle-left f-size-18px mr-2"></i>Kelas: <?= $tb_kelas['kelas'] ?>
        </button>
    </div>
    <div class="card-body data-list text-uppercase">
        <ul>
            <?php foreach ($result as $a_masuk) { ?>
                <li class="absen-item waves-effect" data-m_bulan_tahun="<?= $a_masuk['m_bulan_tahun'] ?>" data-token_kelas="<?= $a_masuk['token_kelas'] ?>">
                    Bulan <?= bulan(explode('-', $a_masuk['m_bulan_tahun'])[0]) . ' ' . explode('-', $a_masuk['m_bulan_tahun'])[1] ?>
                </li>
            <?php } ?>
        </ul>
        <?php
        if (mysqli_num_rows($result) == 0) {
            echo '<div class="text-center text-lowercase p-3">saat ini belum ada yang mengabsen</div>';
        } ?>
    </div>
</div>

<script>
    $('.kembali').click(function() {
        $('#content').load('monitoring');
        history.pushState('history.pushState', 'history.pushState', '?menu=monitoring');
    });

    $('.absen-item').click(function() {
        content_loader();
        var m_bulan_tahun = $(this).attr('data-m_bulan_tahun');
        token_kelas = $(this).attr('data-token_kelas');
        $('#content').load('loadDataMonitoring?token_kelas=' + token_kelas + '&m_bulan_tahun=' + m_bulan_tahun);
        history.pushState('history.pushState', 'history.pushState', '?menu=monitoring&token_kelas=' + token_kelas + '&m_bulan_tahun=' + m_bulan_tahun);
    });
</script>