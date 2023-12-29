<?php
$month = $_GET["month"];
// koneksi kedatabase
require('../config.php');
// memanggil library FPDF
// require('../assets/fpdf/fpdf.php');

require('../assets/fpdf184/pdf_mc_table.php');

// intance object dan memberikan pengaturan halaman PDF
$pdf = new PDF_MC_TABLE();
// membuat halaman baru
$pdf->AddPage("L");

$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(280, 5, 'LAPORAN KEGIATAN GURU', 0, 0, 'C');
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(280, 7, 'SMA NEGERI 1 TUAL', 0, 0, 'C');
$pdf->Cell(10, 7, '', 0, 1);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(280, 7, bulan(date("m", strtotime($month))) . ' ' . date("Y", strtotime($month)), 0, 0, 'C');

$pdf->SetLineWidth(1);
$pdf->Line(10, 41, 285, 41);
$pdf->SetLineWidth(0);
$pdf->Line(10, 42, 285, 42);

$pdf->Cell(10, 25, '', 0, 1);

$pdf->SetFont('Arial', 'B', 11);


$pdf->SetWidths(Array(8,28,63,116,60));

$pdf->SetLineHeight(5);

$pdf->SetAligns(Array(
    "C",
    "C",
    "C",
    "C",
    "C",
    "C"
));

$pdf->Row(Array(
        "NO",
        "TGL",
        "NAMA",
        "JUDUL KEGIATAN",
        "LAMA KEGIATAN",
    ));
    
$pdf->SetAligns(Array(
    "C",
    "C",
    "L",
    "L",
    "C",
    "C"
));

$pdf->SetFont('Arial', '', 11);

$result = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru kg JOIN tb_guru g ON kg.id_guru = g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . $month . "%' ORDER BY kg.tanggal_kegiatan ASC, g.nama ASC");
$nomor = 1;
foreach ($result as $tb_kegiatan) {

    $pdf->Row(Array(
        $nomor,
        $tb_kegiatan["tanggal_kegiatan"],
        $tb_kegiatan['nama'],
        $tb_kegiatan['nama_kegiatan'],
        $tb_kegiatan['lama_kegiatan_menit'] . ' menit',
    ));


    $nomor++;
}

$pdf->Cell(10, 7, '', 0, 1);
$pdf->Cell(280, 5, 'Kalkulasi kegiatan guru:', 0, 1, 'L');
$pdf->Cell(10, 1, '', 0, 1);

$result = mysqli_query($conn, "SELECT g.nama, Count(*) as total, g.id_guru FROM tb_kegiatan_guru kg JOIN tb_guru g ON kg.id_guru = g.id_guru WHERE kg.tanggal_kegiatan LIKE '" . $month . "%' GROUP BY g.nama, g.id_guru");

$pdf->SetFont('Arial', '', 11);

$pdf->SetWidths(Array(8,75,50,50));

$pdf->SetAligns(Array(
    "C",
    "C",
    "C",
    "C"
));

$pdf->Row(Array(
    "NO",
    "NAMA",
    "JUMLAH KEGIATAN",
    "LAMA KEGIATAN",
));

$pdf->SetFont('Arial', '', 11);

$pdf->SetAligns(Array(
    "C",
    "L",
    "C",
    "C"
));

$nomor = 1;
foreach ($result as $data) {

    $id_guru = $data['id_guru'];

    $q = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru WHERE tanggal_kegiatan LIKE '" . $month . "%' && id_guru = " . $id_guru . "");

    $lama_kegiatan = 0;
    foreach($q as $d) {
        $lama_kegiatan += $d['lama_kegiatan_menit'];
    }
 
    $pdf->Row(Array(
        $nomor++,
        $data['nama'],
        $data['total'],
        $lama_kegiatan . ' menit',
    ));
}

$pdf->Output();