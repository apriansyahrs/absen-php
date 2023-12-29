<?php
// local
$hostname = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'absensi_v4';

ob_start();
session_start();
require "timezone.php";
$conn = mysqli_connect($hostname, $username, $password, $database);
if (mysqli_connect_errno()) {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   return false;
}


function query($query)
{
   global $conn;
   $result = mysqli_query($conn, $query);
   $rows = [];
   while ($row = mysqli_fetch_assoc($result)) {
      $rows = $row;
   }
   return $rows;
}

function num_rows($query)
{
   global $conn;
   $result = mysqli_query($conn, $query);
   return mysqli_num_rows($result);
}

$tb_setelan = query("SELECT * FROM setelan ORDER BY id_setelan ASC");

if (isset($_SESSION['siswa'])) {
   $tb_siswa = query("SELECT * FROM tb_siswa WHERE id_siswa = '$_SESSION[siswa]'");
   $tb_kelas = query("SELECT * FROM tb_kelas WHERE token_kelas = '$tb_siswa[token_kelas]'");

   $num_rows_siswa = num_rows("SELECT id_siswa FROM tb_siswa WHERE id_siswa = '$_SESSION[siswa]'");
   if ($num_rows_siswa == 0) {
      session_destroy();
      header('location: auth/siswa');
   }
} elseif (isset($_SESSION['guru'])) {
   $num_rows_guru = num_rows("SELECT id_guru FROM tb_guru WHERE id_guru = '$_SESSION[guru]'");
   if ($num_rows_guru == 0) {
      session_destroy();
      header('location: ../auth/guru');
   }

   $tb_guru = query("SELECT * FROM tb_guru WHERE id_guru = '$_SESSION[guru]'");
} elseif (isset($_SESSION['admin'])) {
   $tb_admin = query("SELECT * FROM tb_admin WHERE id_admin = '$_SESSION[admin]'");
} elseif (isset($_SESSION['ortu'])) {
   $tb_siswa = query("SELECT * FROM tb_siswa WHERE id_siswa = '$_SESSION[ortu]'");
   $tb_kelas = query("SELECT * FROM tb_kelas WHERE token_kelas = '$tb_siswa[token_kelas]'");
   $tb_guru = query("SELECT * FROM tb_guru WHERE id_guru = '$tb_kelas[id_guru]'");
} elseif (isset($_SESSION['karyawan'])) {
   $tb_karyawan = query("SELECT * FROM tb_karyawan tk JOIN tb_jabatan tj ON tk . id_jabatan = tj . id_jabatan WHERE tk . id_karyawan = '$_SESSION[karyawan]'");
}

function base_url()
{
   global $tb_setelan;
   $base_url = $tb_setelan['base_url'];
   return $base_url;
}

function hari($hari)
{
   if ($hari == 'Sun') {
      return 'Minggu';
   } elseif ($hari == 'Mon') {
      return 'Senin';
   } elseif ($hari == 'Tue') {
      return 'Selasa';
   } elseif ($hari == 'Wed') {
      return 'Rabu';
   } elseif ($hari == 'Thu') {
      return 'Kamis';
   } elseif ($hari == 'Fri') {
      return 'Jumat';
   } elseif ($hari == 'Sat') {
      return 'Sabtu';
   }
}

function bulan($bulan)
{
   if ($bulan == '01') {
      return 'Januari';
   } elseif ($bulan == '02') {
      return 'Februari';
   } elseif ($bulan == '03') {
      return 'Maret';
   } elseif ($bulan == '04') {
      return 'April';
   } elseif ($bulan == '05') {
      return 'Mei';
   } elseif ($bulan == '06') {
      return 'Juni';
   } elseif ($bulan == '07') {
      return 'Juli';
   } elseif ($bulan == '08') {
      return 'Agustus';
   } elseif ($bulan == '09') {
      return 'September';
   } elseif ($bulan == '10') {
      return 'Oktober';
   } elseif ($bulan == '11') {
      return 'November';
   } elseif ($bulan == '12') {
      return 'Desember';
   }
}

function waktu_sekarang()
{
   return hari(date('D')) . ', ' . date('d ') . bulan(date('m')) . date(' Y');
}

function jml_hari($month, $year)
{
   $jml = date('t', mktime(0, 0, 0, $month, 1, $year));
   return $jml;
}

function sendMessageTelegram($telegram_id, $message_text, $secret_token)
{

   $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=html&chat_id=" . $telegram_id;
   $url = $url . "&text=" . urlencode($message_text);
   $ch = curl_init();
   $optArray = array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true
   );
   curl_setopt_array($ch, $optArray);
   $result = curl_exec($ch);
   curl_close($ch);
}

function sendBroadcastMasuk($nis)
{
   $dateTime = new DateTime();
   $day = $dateTime->format('d');

   $data = array(
      'nis' => $nis,
      'tanggal' => $day,
   );
   $payload = json_encode($data);

   $url = 'https://3fccc39276d1.ngrok.io/api/send-notify/masuk';
   $ch = curl_init(); // Initialize cURL
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
   $response = curl_exec($ch);

   curl_close(($ch));
}

function sendBroadcastPulang($nis)
{
   $dateTime = new DateTime();
   $day = $dateTime->format('d');

   $data = array(
      'nis' => $nis,
      'tanggal' => $day,
   );
   $payload = json_encode($data);

   $url = 'https://3fccc39276d1.ngrok.io/api/send-notify/pulang';
   $ch = curl_init(); // Initialize cURL
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
   curl_setopt($ch, CURLOPT_POST, 1);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
   $response = curl_exec($ch);

   curl_close(($ch));
}

function generateRandomString($length = 10)
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
}

function getTaAjaranSekarang()
{
   $tanggal_sekarang    = date("Y-m-d");
   $data                = query("SELECT tahun_ajaran FROM ref_angkatan WHERE '$tanggal_sekarang' BETWEEN tgl_mulai AND tgl_selesai");

   if (!$data) $data = 'Tahun ajaran belum dimulai';

   return $data['tahun_ajaran'];
}

function getIdAngkatanSekarang()
{
   $tanggal_sekarang    = date("Y-m-d");
   $data                = query("SELECT id FROM ref_angkatan WHERE '$tanggal_sekarang' BETWEEN tgl_mulai AND tgl_selesai");

   if (!$data) $data = null;

   return $data['id'];
}
