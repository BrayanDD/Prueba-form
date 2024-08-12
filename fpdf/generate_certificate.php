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
        
        $this->Image('certificado.png', 0, 0, $this->GetPageWidth(), $this->GetPageHeight());
    }

  
    function Footer() {}
}


$pdf = new PDF('P', 'mm', array(180, 170)); 
$pdf->AddPage();
$pdf->Output();
