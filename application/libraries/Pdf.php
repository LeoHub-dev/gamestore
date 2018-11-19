<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";
 
    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF 
    {
      public $title;

      public function setReportTitle($title)
      {
        $this->title = $title;
      }
      public function __construct() {
        parent::__construct();
      }
      // El encabezado del PDF
      public function Header(){
        $ci =& get_instance();
        // Select Arial bold 15
        $this->AddFont('Futura-Medium');
        $this->SetFont('Futura-Medium','',16);
        // Move to the right
        //$this->Cell(80);
        // Framed title
        // Logo
        $this->Image(asset_url() . "images/logo.png",11,5,0,20);
        $this->Ln(15);
        $this->Cell(0,10,"GetYourGames",0,1,'L');
        $this->SetFont('Futura-Medium','',12);
        $this->Cell(0,10,site_url(),0,1,"L");
        $this->Ln(5);
        $this->SetFont('Futura-Medium','',18);
        $this->Cell(0,10,utf8_decode($this->title),0,1,'C');
        // Line break
        $this->Ln(10);
        $this->SetFont('Futura-Medium','',11);
        $this->Cell(15,10,utf8_decode('#'),'B',0,'C');
        $this->Cell(100,10,utf8_decode($ci->lang->line('table_product')),'B',0,'L');
        $this->Cell(30,10,utf8_decode($ci->lang->line('table_qty')),'B',0,'L');
        $this->Cell(40,10,utf8_decode($ci->lang->line('table_subtotal')),'B',1,'L');

        $this->Ln(2);
      }
      // El pie del pdf
      public function Footer(){
         // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->AddFont('Futura-Medium');
        $this->SetFont('Futura-Medium','',10);
        $this->SetTextColor(50,50,50);
        // Número de págin
        $this->Cell(3);
        $this->Cell(0,3,utf8_decode('Generado por GetYourGames'),0,0,"R");
        $this->Ln(4);
        $this->Cell(3);
        $this->Cell(0,3,utf8_decode(date("d-m-Y g:i a").' - Página ').$this->PageNo(),0,0,"R");

      }
    }
?>