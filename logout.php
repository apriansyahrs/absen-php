<?php
ob_start();
session_start();
setcookie('id', '', time() - 1, '/');
setcookie('absensi_siswa', '', time() - 1, '/');
setcookie('absensi_guru', '', time() - 1, '/');
setcookie('absensi_admin', '', time() - 1, '/');
setcookie('absensi_ortu', '', time() - 1, '/');
setcookie('absensi_karyawan', '', time() - 1, '/');
setcookie('id_ortu', '', time() - 1, '/');
session_destroy();
$_SESSION = [];
header('location: index');
