<?php
require_once "../../config/server.php";
require_once("../../assets/fpdf/fpdf.php");  // Include FPDF 


$pdf  = new FPDF();
$pdf->SetMargins(6, 4, 6);
$pdf->SetAutoPageBreak(true, 2);
$pdf->SetTitle('Kartu Pelajar');
$pdf->AddPage('P', [200, 300]);

$pdf->Cell(88,56, '', 1, 0);
$pdf->Cell(12);
$pdf->Cell(88,56, '', 'T', 1);




$pdf->SetDisplayMode('real');  // Menampilkan ukuran asli (bukan fit to page)
$pdf->Output();
