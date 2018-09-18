<?php

set_time_limit(0);
ini_set("memory_limit", "-1");

require_once PATH . 'libs/tcpdf/config/lang/spa.php';
require_once PATH . 'libs/tcpdf/tcpdf.php';

define('PATH_FONTS', PATH . 'libs/tcpdf/fonts/');
define('PATH_IMG', 'scanning');

//============================================================+
// File name   : example_051.php
// Begin       : 2009-04-16
// Last Update : 2013-05-14
//
// Description : Example 051 for TCPDF class
//               Full page background
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Full page background
 * @author Nicola Asuni
 * @since 2009-04-16
 */

// Include the main TCPDF library (search for installation path).
//require_once('tcpdf_include.php');


// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function __construct(){
		parent::__construct();
		$this->width_page = $this->getPageWidth();
		$this->height_page = $this->getPageHeight();
		$this->LOTE=0;
	    $this->style_barra = array(
			'position' => '',
			'align' => 'C',
			'stretch' => false,
			'fitwidth' => true,
			'cellfitalign' => '',
			'border' => false,
			'hpadding' => 'auto',
			'vpadding' => 'auto',
			'fgcolor' => array(0,0,0),
			'bgcolor' => false, //array(255,255,255),
			'text' => true,
			'font' => 'calibri',
			'fontsize' => 10,
			'stretchtext' => 4
		);
		$this->addTTFfont(PATH_FONTS.'cour.ttf');
		// $this->addTTFfont('courbd.ttf');
		// $this->addTTFfont('courbi.ttf');
		// $this->addTTFfont('couri.ttf');

		$this->addTTFfont(PATH_FONTS.'calibri.ttf');
		$this->addTTFfont(PATH_FONTS.'calibrib.ttf');
		$this->addTTFfont(PATH_FONTS.'calibrii.ttf');
		$this->addTTFfont(PATH_FONTS.'calibriz.ttf');

		//$this->addTTFfont(PATH_FONTS.'ariblk.ttf');
	}
    public function Header() {
        
        $bMargin = $this->getBreakMargin();
        
        $auto_page_break = $this->AutoPageBreak;
        
        $this->SetAutoPageBreak(false, 0);
        
        //$img_file = PATH_IMG.'/1/1/1-page.jpg';
        //$this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        $W=50;
        $H=40;
        $X=($this->width_page/2)-($W/2);
		$Y=($this->height_page/2)-($H/2);

        $this->SetFont('calibrib', '', 16);
		$this->SetXY($X-($W+14), $Y-4);
		$this->MultiCell(0, 3, 'LOTE ', 0, 'C');

        $this->write1DBarcode(str_pad($this->LOTE, 10 ,'0',STR_PAD_LEFT), 'C128B', $X, $Y, $W, $H, 0.3, $this->style_barra, 'N');
        
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        
        $this->setPageMark();
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('DSP');
$pdf->SetTitle('DOCUMENT SCAN PRO');
$pdf->SetSubject('FILE SCAN');
$pdf->SetKeywords('PDF,DSP');

$pdf->LOTE=$p['vp_id_lote'];

$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->setPrintFooter(false);

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

$pdf->setLanguageArray($l);

$pdf->SetFont('times', '', 48);


$pdf->AddPage();

$pdf->setPrintHeader(false);

$rs = $this->objDatos->get_load_page($p);
foreach ($rs as $index => $value){
        /*$value_['id_pag'] = intval($value['id_pag']);
        $value_['id_det'] = intval($value['id_det']);
        $value_['id_lote'] = intval($value['id_lote']);
        $value_['path'] = utf8_encode(trim($value['path']));
        $value_['file'] = utf8_encode(trim($value['img']));
        $value_['imgorigen'] = utf8_encode(trim($value['imgorigen']));
        $value_['lado'] = utf8_encode(trim($value['lado']));
        $value_['orden'] = intval($value['orden']);
        $value_['estado'] = utf8_encode(trim($value['estado']));
        $value_['include'] ='Y';*/
        //INIT
		$pdf->AddPage();


		$bMargin = $pdf->getBreakMargin();

		$auto_page_break = $pdf->getAutoPageBreak();

		$pdf->SetAutoPageBreak(false, 0);
		$pdf->Image(substr(trim($value['path']).trim($value['img']), 1), 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

		$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
		$pdf->setPageMark();

		//END
}






// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('PDF.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+