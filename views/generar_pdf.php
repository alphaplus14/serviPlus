<?php
// views/generar_pdf.php

require_once '../libs/fpdf/fpdf.php';

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Listado de Empleados', 0, 1, 'C');

        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Fecha del reporte: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }
}

$pdf = new PDF('L');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);


$pdf->Cell(50, 10, 'Nombre', 1);
$pdf->Cell(35, 10, 'Documento', 1);
$pdf->Cell(35, 10, 'Cargo', 1);
$pdf->Cell(45, 10, 'Departamento', 1);
$pdf->Cell(25, 10, 'Salario', 1);
$pdf->Cell(30, 10, 'F. Ingreso', 1);
$pdf->Cell(30, 10, 'Estado', 1);
$pdf->Ln();


$pdf->SetFont('Arial', '', 12);
foreach ($consulta as $emp) {
    $pdf->Cell(50, 10, $emp['nombre'], 1);
    $pdf->Cell(35, 10, $emp['numDocumento'], 1);
    $pdf->Cell(35, 10, utf8_decode($emp['cargo']), 1);
    $pdf->Cell(45, 10, $emp['departamento'], 1);
    $pdf->Cell(25, 10, $emp['salarioBase'], 1);
    $pdf->Cell(30, 10, $emp['fechaIngreso'], 1);
    $pdf->Cell(30, 10, $emp['estado'], 1);
    $pdf->Ln();
}


// Se puede visualizar en el navegador o descargar:
// 'I' = Inline (mostrar), 'D' = Download
$pdf->Output('I', 'Listado_Empleados.pdf');
// $pdf->Output('D', 'Listado_Empleados.pdf'); // ← para forzar descarga
