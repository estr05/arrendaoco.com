<?php
require "fpdf.php";
//AL MOMENTO DE USAN UNA UNCION PARA DISEÑO EL $pdf CAMBIA A: $this
class PDF extends FPDF {
  // FUNCION PARA DISEÑO DEL LOGO
    function Header() {
        
        $this->Image('logo.png', 10, 10, 20);
        
        $this->Image('logo.png', 185, 10, 20);

        // TITULO
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'ArrendaOco', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 5, 'Lista de Comentarios', 0, 1, 'C');
        $this->Ln(10); // Add a little space after the header
    }

   // PAGINACION (ABAJO)
    function Footer() {
        
        $this->SetY(-15);
        
        $this->SetFont('Arial', 'I', 8);
       
        $this->Cell(0, 10, 'Pg ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // FUNCION DE TABLA
    function FancyTable($header, $data) {
        // COLORES Y DISEÑO DE TABLA
        $this->SetFillColor(230, 230, 230);
        $this->SetTextColor(0);
        $this->SetDrawColor(180, 180, 180);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', 10);

       // ENCABEZADO DE LA TABLA
        $w = array(25, 140, 35);
        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 7, utf8_decode($header[$i]), 1, 0, 'C', true);
        }
        $this->Ln();

       
        $this->SetFillColor(245, 245, 245);
        $this->SetTextColor(0);
        $this->SetFont('', '', 9);
        $fill = false;

       
        foreach ($data as $row) {
            $this->Cell($w[0], 6, utf8_decode($row['id_inmueble']), 'LR', 0, 'C', $fill);
            $this->Cell($w[1], 6, utf8_decode($row['comentario']), 'LR', 0, 'C', $fill);
            $this->Cell($w[2], 6, utf8_decode($row['fecha']), 'LR', 0, 'C', $fill);
            $this->Ln();
            $fill = !$fill;
        }

        
        $this->Cell(array_sum($w), 0, '', 'T');
        $this->Ln(10);
    }
}

//TODOS ESTOS DATOS ESTABAN ARRIBA, SE BAJAN PARA NO MEZCLARSLOS CON LAS FUNCIONES
session_start();


if (!isset($_SESSION['validada']) || $_SESSION['validada'] != 1) {
    header("location:../index.html");
    exit();
}


$con = mysqli_connect("localhost", "root", "", "arrendaoco");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}


$consulta = "SELECT id_inmueble, comentario, fecha FROM comentarios";
$result = mysqli_query($con, $consulta);
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
mysqli_close($con);


$pdf = new PDF('P', 'mm', 'Letter');
$pdf->setMargins(8, 18);
$pdf->AliasNbPages();
$pdf->AddPage();


$header = array('Id_inmueble', 'Comentario', 'Fecha');

// LLAMA LOS DATOS DE LA TABLA CON ESTILO
$pdf->FancyTable($header, $data);


$pdf->Output();
?>