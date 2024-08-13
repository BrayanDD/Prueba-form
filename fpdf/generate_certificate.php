<?php
session_start();
if (!isset($_SESSION["user"])) {
  header("Location: login.php");
  return;
}

require('fpdf.php');

class PDF extends FPDF
{
    function Header()
    {
        // Ajustar la imagen al tamaño de la página personalizada
        $this->Image('certificado.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight());
        
        // Obtener el nombre del usuario de la sesión
        $username = $_SESSION['user']['name'];
        
        // Configurar la fuente (Arial Itálica)
        $this->SetFont('Arial', 'I', 20); // 'I' es para Itálica
        $this->SetTextColor(0, 0, 0); // Color del texto (negro)

        // Calcular las posiciones de texto
        $textWidth = $this->GetStringWidth($username);
        $pdfWidth = $this->GetPageWidth();
        $x = ($pdfWidth - $textWidth) / 2;
        $y = $this->GetPageHeight() * 0.4;

        // Colocar el texto en la posición calculada
        $this->SetXY($x, $y);
        $this->Cell($textWidth, 10, $username, 0, 0, 'C');
    }

    function Footer() {}
}

// Crear el objeto PDF con un tamaño personalizado
$pdf = new PDF('P', 'mm', array(180, 170)); 
$pdf->AddPage();
$pdf->Output();
