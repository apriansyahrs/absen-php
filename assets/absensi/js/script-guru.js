setInterval(function () {
    if (navigator.onLine == false) {
        $('.modal').modal('hide');
        $('#modalNavigatorOnline').modal('show');
    } else {
        $('#modalNavigatorOnline').modal('hide');
    }
}, 10000);

$(function () {
    $('.overlay-scrollbars').overlayScrollbars({
        className: "os-theme-dark",
        scrollbars: {
            autoHide: 'l',
            autoHideDelay: 0
        }
    });
});

function menu(menu) {
    content_loader();
    $('#content').load(menu);
    history.pushState(menu, menu, '?menu=' + menu);
}

$('[data-tooltip="tooltip"]').tooltip();

$('#click-beranda').addClass('active');

$('#click-beranda').click(function () {
    menu('beranda');
});

$('#click-absen-guru').click(function () {
    menu('absen-guru');
});

$('#click-kegiatan-guru').click(function () {
    menu('kegiatan-guru');
});

$('#click-buat-kelas').click(function () {
    menu('buat-kelas');
});

$('#click-pengumuman').click(function () {
    menu('pengumuman');
});

$('#click-daftar-kelas').click(function () {
    menu('daftar-kelas');
    $('#notif-absen-baru').attr('hidden', 'hidden');
});

$('#click-daftar-siswa').click(function () {
    menu('daftar-siswa');
});

$('#click-monitoring').click(function () {
    menu('monitoring');
});

$('#click-rekap-absen').click(function () {
    menu('rekap-absen');
});

$('#click-setelan').click(function () {
    menu('setelan');
});

$('#click-logout').click(function () {
    setTimeout(function () {
        window.location.href = '../logout';
    }, 300);
});