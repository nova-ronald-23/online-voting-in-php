<?php
require('pdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Logo
        $this->Image('../image/logo.png', 80, 10, 50);  // Adjust the position and size accordingly

        // St. Joseph's Name
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'St. Joseph\'s College', 0, 1, 'C');  // Centered and line break

        // Title
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 10, 'Election result', 0, 1, 'C');  // Centered and line break

        // Line break
        $this->Ln(10);  // Adjust this value based on your design
    }

    // Rest of the code remains unchanged...
}

$pdf = new PDF();

// Column headings
$header = array('Country', 'Capital', 'Area (sq km)', 'Pop. (thousands)');

// Data loading (Replace with your actual data loading)
$data = array(
    array('Country1', 'Capital1', '10000', '1000000'),
    array('Country2', 'Capital2', '15000', '2000000'),
    array('Country3', 'Capital3', '20000', '3000000')
);

$pdf->SetFont('Arial', '', 14);
$pdf->AddPage(); // You can use any table style you want
$pdf->Output();
?>
