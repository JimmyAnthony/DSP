<?php
	require_once BASEPATH . 'fpdf/fpdf.php';
	//require_once ROOT.'/includes/inc.php';


	//phpinfo();
	//require_once 'libs/fpdf/fpdf.php';
	//require 'conexion.php';
	include 'barcode.php';
	
	//$sql = "SELECT codigo_barras FROM productos";
	//$resultado = $mysqli->query($sql);

	//$type = $_SERVER['REQUEST_METHOD'];
	
	
	$code = $_POST['code']; 

	
	$pdf = new FPDF('L','cm',array(10,5));
	$pdf->AddPage();
	$pdf->SetAutoPageBreak(true, 20);
	$x = $pdf->GetX();
	$y = $pdf->GetY();
	
	//while ($row = $resultado->fetch_assoc()){
		
		//$code = 'ric' ;
		//$row['codigo_barras'];
		
		barcode('codigos/'.$code.'.png', $code,100, 'horizontal', 'code128', true);
		
		$pdf->Image('codigos/'.$code.'.png',$x,$y,0,0,'PNG');
		
	//	$y = $y+15;
	//}
	//$pdf->Output();			
	$pdf->Output('F','codigos/'.$code.'.pdf');	
	
?>