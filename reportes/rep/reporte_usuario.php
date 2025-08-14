<?php
require "fpdf.php";

class PDF extends FPDF {
    // helpers para tabla adaptable
    protected $widths;
    protected $aligns;
    protected $tableHeader;
    protected $headerPrinted = false; // Marca si el encabezado ya fue impreso

    function SetWidths($w){ $this->widths = $w; }
    function SetAligns($a){ $this->aligns = $a; }

    function CheckPageBreak($h){
        if($this->GetY() + $h > $this->PageBreakTrigger){
            $this->AddPage($this->CurOrientation);
        }
    }

    // calcula cuantas lineas consumira un texto en un ancho dado
    function NbLines($w, $txt){
        $cw = &$this->CurrentFont['cw'];
        if($w==0) $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2*$this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n") $nb--;
        $sep = -1; $i = 0; $j = 0; $l = 0; $nl = 1;
        while($i<$nb){
            $c = $s[$i];
            if($c=="\n"){ $i++; $sep = -1; $j = $i; $l = 0; $nl++; continue; }
            if($c==' ') $sep = $i;
            $l += $cw[$c] ?? 0;
            if($l > $wmax){
                if($sep==-1){
                    if($i==$j) $i++;
                }else{
                    $i = $sep + 1;
                }
                $sep = -1; $j = $i; $l = 0; $nl++;
            }else{
                $i++;
            }
        }
        return $nl;
    }

    // dibuja una fila completa usando MultiCell, igualando alturas
    function Row($data){
        $nb = 0;
        for($i=0; $i<count($data); $i++){
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 6 * $nb; // alto base 6 mm por linea
        $this->CheckPageBreak($h);

        for($i=0; $i<count($data); $i++){
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            // borde de celda
            $this->Rect($x, $y, $w, $h);
            // contenido
            $this->MultiCell($w, 6, $data[$i], 0, $a);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    // Header de pagina
    function Header() {
        if (!$this->headerPrinted) {  // Verifica si el encabezado ya fue impreso
            $this->Image('logo.png', 10, 10, 20);
            $this->Image('logo.png', 185, 10, 20);
            $this->SetFont('Arial', 'B', 14);
            $this->Cell(0, 10, 'ArrendaOco', 0, 1, 'C');
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 5, 'Lista de Usuarios', 0, 1, 'C');
            $this->Ln(6);
            if(isset($this->tableHeader)) $this->PrintTableHeader($this->tableHeader);
            $this->headerPrinted = true; // Marca que el encabezado ha sido impreso
        }
    }

    // Footer de pagina
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pg ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Encabezado de la tabla (se reimprime en salto de pagina)
    function PrintTableHeader($header){
        $this->SetFillColor(230, 230, 230);
        $this->SetTextColor(0);
        $this->SetDrawColor(180, 180, 180);
        $this->SetLineWidth(.3);
        $this->SetFont('', 'B', 10);

        $w = array(25, 15, 40, 40, 30,50);         // anchos
        $this->SetWidths($w);
        $this->SetAligns(array('C','L','C','C','L','L')); // alineaciones

        for ($i = 0; $i < count($header); $i++) {
            $this->Cell($w[$i], 8, $header[$i], 1, 0, 'C', true);
        }
        $this->Ln();
        $this->SetFont('', '', 9);
    }

    // API principal para tabla
    function FancyTable($header, $data) {
        $this->tableHeader = $header;
        $this->PrintTableHeader($header);

        foreach ($data as $row) {
            $this->Row(array(
                utf8_decode($row['user']),
                utf8_decode($row['pass']),
                utf8_decode($row['nombre']),
                utf8_decode($row['direccion']),
                utf8_decode($row['tel']),
                utf8_decode($row['correo'])
            ));
        }
        $this->Ln(4);
    }
}

// sesion
session_start();
if (!isset($_SESSION['validada']) || $_SESSION['validada'] != 1) {
    header("location:../index.html");
    exit();
}

// conexion a BD
$con = mysqli_connect("localhost", "root", "", "arrendaoco");
if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

// datos
$consulta = "SELECT user, pass, nombre, direccion, tel, correo FROM usuarios ORDER BY id_user";
$result = mysqli_query($con, $consulta);
$data = [];
while ($row = mysqli_fetch_assoc($result)) { $data[] = $row; }
mysqli_close($con);

// PDF
$pdf = new PDF('P', 'mm', 'Letter');
$pdf->setMargins(8, 18);
$pdf->AliasNbPages();
$pdf->AddPage();

// encabezados (sin acentos en el script)
$header = array(
    utf8_encode('Usuario'),
    utf8_encode('Cont'),
    utf8_encode('Nombre'),
    utf8_encode('Direccion'),
    utf8_encode('Telefono'),
    utf8_encode('Correo')
);

// render
$pdf->FancyTable($header, $data);
$pdf->Output();
?>