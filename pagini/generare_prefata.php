<?php
require('../fpdf186/fpdf.php');
// require('../vendor/autoload.php'); // Autoload pentru librăria endroid/qr-code

// use Endroid\QrCode\Builder\Builder;
// use Endroid\QrCode\Writer\PngWriter;
// use Endroid\QrCode\Encoding\Encoding;
// use Endroid\QrCode\ErrorCorrectionLevel;
// use Endroid\QrCode\Color\Color;
// use Endroid\QrCode\RoundBlockSizeMode;


// Conectare la baza de date
$link = mysqli_connect("localhost", "rrgb3601_manolovsky", "00\$QU6wgbPjt", "rrgb3601_manolovsky");

mysqli_set_charset($link, "utf8mb4");

if (!$link) {
    die("Eroare la conectare: " . mysqli_connect_error());
}

// Preia ID-ul revistei din request
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Selectează datele revistei
$query = "SELECT titlu, autor, imagine FROM reviste WHERE id = $id";
$result = mysqli_query($link, $query);
$revista = mysqli_fetch_assoc($result);

if (!$revista) {
    die("Revista nu a fost găsită.");
}

// Extrage datele revistei
$titlu = $revista['titlu'];
$autor = $revista['autor'];
$imagine = $revista['imagine']; // Calea imaginii în baza de date

// // 🔥 Generare QR Code folosind noul Builder
// $qrData = "Revista: $titlu\nAutor: $autor";

// $builder = new Builder(
//     writer: new PngWriter(),
//     writerOptions: [],
//     validateResult: false,
//     data: $qrData,
//     encoding: new Encoding('UTF-8'),
//     errorCorrectionLevel: ErrorCorrectionLevel::High,
//     size: 150,
//     margin: 10,
//     roundBlockSizeMode: RoundBlockSizeMode::Margin,
//     foregroundColor: new Color(0, 0, 0),
//     backgroundColor: new Color(255, 255, 255)
// );

// // Construim QR Code-ul
// $result = $builder->build();

// // Salvare QR Code ca fișier PNG
// $qrPath = 'qrcode.png';
// file_put_contents($qrPath, $result->getString());

// Creare PDF în orientare landscape
$pdf = new FPDF('L', 'mm', array(120, 240));
$pdf->AddPage();
$pdf->AddFont('Arial_Unicode_MS', '', 'Arial_Unicode_MS.php');
$pdf->SetFont('Arial_Unicode_MS', '', 12);

// Titlu
$pdf->Cell(0, 10, "Revista: $titlu", 0, 1, 'C');
$pdf->Cell(0, 10, "Autor: $autor", 0, 1, 'C');

// Adaugă imaginea revistei dacă există
if (!empty($imagine) && file_exists($imagine)) {
    $pdf->Image($imagine, 30, 40, 100, 0);
} else {
    $pdf->Cell(0, 10, "Imagine indisponibilă", 0, 1, 'C');
}

// 🔥 Adaugă QR Code-ul în PDF
// $pdf->Image($qrPath, 150, 40, 50, 50);
// $pdf->Cell(330, 20, "Scaneaza pentru a cumpara cartea", 0, 1, 'C');

// Output PDF
$pdf->Output('I', 'revista.pdf');

// Șterge fișierul QR Code generat
unlink($qrPath);
?>