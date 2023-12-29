<?php
$id_guru = $_GET["id_guru"];
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

$r = mysqli_query($conn, "SELECT * FROM tb_guru WHERE id_guru = " . $id_guru . "");
$nama_guru = mysqli_fetch_assoc($r)['nama'];

$pdf->SetFont('Arial', '', 12);

$pdf->Cell(280, 5, 'Nama Guru: ' . $nama_guru, 0, 1, 'L');
$pdf->Cell(10, 1, '', 0, 1);

$pdf->SetFont('Arial', 'B', 11);


$pdf->SetWidths(Array(8,28,116 + 63,60));

$pdf->SetLineHeight(5);

$pdf->SetAligns(Array(
    "C",
    "C",
    "C",
    "C",
    "C"
));

$pdf->Row(Array(
        "NO",
        "TGL",
        "JUDUL KEGIATAN",
        "LAMA KEGIATAN",
    ));
    
$pdf->SetAligns(Array(
    "C",
    "C",
    "L",
    "C",
    "C"
));

$pdf->SetFont('Arial', '', 11);

$result = mysqli_query($conn, "SELECT * FROM tb_kegiatan_guru kg JOIN tb_guru g ON kg.id_guru = g.id_guru WHERE kg.id_guru = '$id_guru' && kg.tanggal_kegiatan LIKE '" . $month . "%' ORDER BY g.nama ASC");
$nomor = 1;
$lama_kegiatan_total = 0;
foreach ($result as $tb_kegiatan) {
    
    $pdf->Row(Array(
        $nomor,
        $tb_kegiatan["tanggal_kegiatan"],
        $tb_kegiatan['nama_kegiatan'],
        $tb_kegiatan['lama_kegiatan_menit'] . ' menit',
    ));

    $lama_kegiatan_total += $tb_kegiatan['lama_kegiatan_menit'];

    $nomor++;
}

$pdf->Cell(215, 5, "Total lama kegiatan", 1, 0, 'C');
$pdf->Cell(60, 5, $lama_kegiatan_total . ' menit', 1, 0, 'C');

$pdf->Output();
