<?php

App::uses('BasePdf', 'Lib/Pdf');
App::uses('Barcode', 'Lib');

class CorreosChileLabel extends BasePdf{
	# Label dimensions
	const WIDTH = 90;
	const HEIGHT = 73;
	
	# Header dimensions
	const HEADER_HEIGHT = 17;
	const HEADER_XL_ROW_HEIGHT = 9;
	const HEADER_L_ROW_HEIGHT = 8;
	const HEADER_S_ROW_HEIGHT = 3;
	const HEADER_M_ROW_HEIGHT = 5;
	const HEADER_FIRST_COL_WIDTH = 26;
	
	# Body dimensions
	const BODY_HEIGHT = 30;
	const BARCODE_LEFT_MARGIN = 13;
	const BARCODE_TOP_MARGIN = 4;
	const BARCODE_WIDTH = 65;
	const BARCODE_HEIGHT = 21;

	# Footer dimensions
	const FOOTER_HEIGHT = 23;
	const FOOTER_FIRST_ROW_HEIGHT = 5;
	const FOOTER_SECOND_ROW_HEIGHT = 13;
	const FOOTER_THIRD_ROW_HEIGHT = 2;
	const FOOTER_FOURTH_ROW_HEIGHT = 6;
	const FOR_WIDTH = 45;
	const PHONE_WIDTH = 20;
	
	# Footer bottom dimensions
	const FOOTER_FIRST_COLUMN_WIDTH = 11;
	const FOOTER_SECOND_COLUMN_WIDTH = 46;
	const FOOTER_THIRD_COLUMN_WIDTH = 16;
	const FOOTER_FOURTH_COLUMN_WIDTH = 17;

	private $DireccionDestino;
	private $NombreDelegacionDestino;
	private $CodigoEncaminamiento;
	private $ComunaDestino;
	private $AbreviaturaServicio;
	private $SDP;
	private $Cuartel;

	private $numero_referencia;
	private $telefono_contacto_destinatario;

	# Fields that depends on the package
	private $packageFields;

	function __construct($order, $correoResponses=array())
	{
		$this->pdf = new PDF('L', 'mm');
		$this->pdf->SetDisplayMode('fullwidth', 'single');
		$this->pdf->SetAutoPageBreak('false');
		$this->pdf->SetDrawColor(0, 0, 0);
		$this->pdf->SetTextColor(0, 0, 0);
		$this->order = $order;
		$this->correoResponses = $correoResponses;
		$this->setConstantFields();
		$this->setOrderFields();
		$this->setResponsesFields();
	}

	function setFields($order, $correoResponses=array())
	{
		$this->order = $order;
		$this->correoResponses = $correoResponses;
		$this->setConstantFields();
		$this->setOrderFields();
		$this->setResponsesFields();
	}

	private function setConstantFields(){
		$this->telefono_contacto_remitente = '225840601';
	}

	private function setResponsesFields()
	{	
		$this->packageFields = array();
		$firstPackage = $this->correoResponses[0]->admitirEnvioResult;
		$this->DireccionDestino = $firstPackage->DireccionDestino;
		$this->ComunaDestino = $firstPackage->ComunaDestino;
		$this->NombreDelegacionDestino = empty($firstPackage->NombreDelegacionDestino) ? '' : $firstPackage->NombreDelegacionDestino;
		$this->AbreviaturaServicio = empty($firstPackage->AbreviaturaServicio) ? '' : $firstPackage->AbreviaturaServicio;
		$this->SDP = empty($firstPackage->SDP) ? '' : $firstPackage->SDP;
		$this->Cuartel = empty($firstPackage->Cuartel) ? '' : $firstPackage->Cuartel;
				
		for($i=0; $i < count($this->correoResponses); $i++) { 
			$ithPackage = $this->correoResponses[$i]->admitirEnvioResult;
			$numero_referencia = $this->order['Order']['code'].'-pqte'.$this->order['packages'][$i]['Package']['id'];
			$packageField = array(
				'CodigoEncaminamiento' => $ithPackage->CodigoEncaminamiento,
				'NumeroEnvio' => $ithPackage->NumeroEnvio,
				'numero_referencia' => $numero_referencia
			);
			$this->packageFields[] = $packageField;
		}
	}

	private function setOrderFields(){
		$order = $this->order;

		if(empty($order['User']['mobile_number']))
			$this->telefono_contacto_destinatario = '';
		else
			$this->telefono_contacto_destinatario = substr($order['User']['mobile_number'], 0, 10);

		$this->nombre_destinatario = $this->getNombreDestinatario($order);
	}

	private function getNombreDestinatario($order){
		$name = "";
		if(!empty($order['Order']['recipient_name']))
			$name = $order['Order']['recipient_name'];
		elseif(!empty($order['User']['name']))
			$name = $order['User']['name'];
		else
			$name = "Sin Nombre";
		return substr($name, 0, 20);
	}

	function generate(){
		$this->pdf = new PDF('L', 'mm');
		$this->pdf->SetDisplayMode('fullwidth', 'single');
		$this->pdf->SetAutoPageBreak('false');		
		
		$n = 1;
		if(isset($this->order['packages'])){
			$n = count($this->order['packages']);
		}
		for($package = 0; $package < $n; $package++){
			$this->pdf->AddPage('L', array(self::WIDTH, self::HEIGHT));
			$this->pdf->SetMargins(0, 0, 0);
			$this->drawPackageLabel($package);
		}
		$this->pdf->AutoPrint(true);
		$this->pdf->Output();
	}

	function drawPackageLabel($packageIndex){
		$this->box(0, 0, self::WIDTH, self::HEIGHT);
		$this->drawHeader($packageIndex);
		$this->drawBody($packageIndex);
		$this->drawFooter($packageIndex);
	}

	private function drawHeader($packageIndex){
		$this->drawLogo();
		$this->drawFirstHeaderRow();
		$this->drawSecondHeaderRow();
		$this->drawThirdHeaderRow();
		$this->drawProductRect();
		$this->drawFourthHeaderRow($packageIndex);
		$this->drawFifthHeaderRow();
	}

	private function drawLogo(){
		$x = $y = 0;
		$logo_url = 'https://s3-us-west-2.amazonaws.com/babytuto/85235acafd7d5ed1e08d2f0e5f2e9645.jpg';
		$this->pdf->Rect($x, $y, self::HEADER_FIRST_COL_WIDTH, self::HEADER_XL_ROW_HEIGHT);
		$this->pdf->Image($logo_url, $x+1, $y+1, self::HEADER_FIRST_COL_WIDTH-2, self::HEADER_XL_ROW_HEIGHT-2, 'jpg');
	}

	private function drawProductRect(){
		$x = 0;
		$y = self::HEADER_XL_ROW_HEIGHT;
		$columnHeight = self::HEADER_L_ROW_HEIGHT;
		$columnWidth = self::HEADER_FIRST_COL_WIDTH;
		$font1 = array();
		$font1['size'] = 7;
		$font1['style'] = 'B';
		$font1['font'] = 'helvetica';
		$font1['interline'] = 4;
		$font2 = array();
		$font2['size'] = 17;
		$font2['style'] = 'B';
		$font2['font'] = 'helvetica';
		$font2['interline'] = 5;
		
		$this->twoTextsInsideRect($x, $y, 
			$columnWidth, $columnHeight, 
			$this->nowInChile(), $this->AbreviaturaServicio,
			$font1, $font2,
			2, 2);
	}

	private function nowInChile(){
		$now = new DateTime("NOW");
		$now->sub(new DateInterval('PT3H'));
		return $now->format('Y-m-d / H:i');
	}

	function drawFirstHeaderRow(){
		$nColumns = 8;
		$columnWidth = (self::WIDTH - self::HEADER_FIRST_COL_WIDTH)/$nColumns;
		$columnHeight = self::HEADER_S_ROW_HEIGHT;
		$x = self::HEADER_FIRST_COL_WIDTH;
		for ($i=1; $i <= $nColumns; $i++) { 
			$this->textInsideRect($x, 0, $columnWidth, $columnHeight, '');
			$x += $columnWidth;
		}
	}

	private function drawSecondHeaderRow(){
		$x = self::HEADER_FIRST_COL_WIDTH;
		$y = self::HEADER_S_ROW_HEIGHT;
		$columnHeight = self::HEADER_S_ROW_HEIGHT;
		$columnWidth = self::WIDTH - self::HEADER_FIRST_COL_WIDTH;
		$text = "DE: PRODUCTOS BABYTUTO SPA";
		$this->textInsideRect($x, $y, $columnWidth, $columnHeight, $text);
	}

	private function drawThirdHeaderRow(){
		$x = self::HEADER_FIRST_COL_WIDTH;
		$y = self::HEADER_S_ROW_HEIGHT*2;
		$columnHeight = self::HEADER_S_ROW_HEIGHT;
		$columnWidth = self::WIDTH - self::HEADER_FIRST_COL_WIDTH;
		$text = "R.U.T: 76.268.895-6   CTA:525536         Tel.: ";
		$text .= $this->telefono_contacto_remitente;
		$this->textInsideRect($x, $y, $columnWidth, $columnHeight, $text);
	}

	private function drawFourthHeaderRow($packageIndex){
		$x = self::HEADER_FIRST_COL_WIDTH;
		$y = self::HEADER_S_ROW_HEIGHT*3;
		$columnHeight = self::HEADER_S_ROW_HEIGHT;
		$columnWidth = self::WIDTH - self::HEADER_FIRST_COL_WIDTH;
		$text = "Referencia: ".$this->packageFields[$packageIndex]['numero_referencia'];
		$this->textInsideRect($x, $y, $columnWidth, $columnHeight, $text);
	}

	private function drawFifthHeaderRow(){
		$nColumns = 4;
		$columnWidth = (self::WIDTH - self::HEADER_FIRST_COL_WIDTH)/$nColumns;
		$columnHeight = self::HEADER_M_ROW_HEIGHT;
		$x = self::HEADER_FIRST_COL_WIDTH;
		$y = self::HEADER_S_ROW_HEIGHT*4;
		$font = array('size'=>4.5, 'font'=>'helvetica', 'style'=>'B', 'interline'=>2);
		$values = array('Factura CTE. Nº'=>'',
										'REEMBOLSO' => '$0',
										'PAGO EN DESTINO' => '',
										'TARIFA' => '$0');

		$margins = array('Factura CTE. Nº'=>3,
										 'REEMBOLSO' => 4,
										 'PAGO EN DESTINO' => 4,
										 'TARIFA'=>5);
		foreach ($values as $key => $value){
			$this->twoTextsInsideRect($x, $y, 
														 					 $columnWidth, $columnHeight, 
									   									 $key, $value,
																       $font, $font, 0, $margins[$key]);
			$x += $columnWidth;
		}
	}

	private function drawBody($packageIndex){
		$x = 0;
		$y = self::HEADER_HEIGHT;
		$bodyWidth = self::WIDTH;
		$this->pdf->Rect($x, $y, $bodyWidth, self::BODY_HEIGHT);
		$x = self::BARCODE_LEFT_MARGIN;
		$y = self::HEADER_HEIGHT + self::BARCODE_TOP_MARGIN;
		$barcode = $this->barcode($packageIndex);
		$barcodeParams = "f=code128";
		$barcodeParams .= "&bar_width=2";
		$barcodeParams .= "&t=ticket-code";
		$barcodeParams .= "&c=".$barcode;
		$this->pdf->Image('http://qr.babytuto.com/?'.$barcodeParams , $x, $y, self::BARCODE_WIDTH, self::BARCODE_HEIGHT, 'png');
		$textWidth = 18;
		$textHeight = 2;
		$x = self::WIDTH - $textWidth;
		$y = self::HEADER_HEIGHT + self::BODY_HEIGHT - $textHeight;
		$font = array('size'=>5, 'font'=>'helvetica', 'style'=>'B');
		$dummyCode = '0';
		$this->text($dummyCode, $x, $y, $font);
	}

	private function barcode($packageIndex){
		$packageField = $this->packageFields[$packageIndex];
		$barcode = $packageField['CodigoEncaminamiento'];
		$barcode .= $packageField['NumeroEnvio'];
		$barcode .= '001';
		return $barcode;
	}

	private function drawFooter($packageIndex){
		$this->drawFirstFooterRow($packageIndex);
		$this->drawSecondFooterRow();
		$this->drawThirdFooterRow();
		$this->drawFourthFooterRow();
	}

	private function drawFirstFooterRow($packageIndex){
		$fontSmall = array('size'=>4.5, 'font'=>'helvetica', 'style'=>'B', 'interline'=>2);
		$fontMedium = array('size'=>6, 'font'=>'helvetica', 'style'=>'B', 'interline'=>2);
		$fontHuge = array('size'=>15, 'font'=>'helvetica', 'style'=>'B', 'interline'=>6);
		$firstColumnWidth = 23;
		# First column
		$xFirstColumn = 0;
		$y = self::HEADER_HEIGHT + self::BODY_HEIGHT;
		$packageField = $this->packageFields[$packageIndex];
		$encaminamiento = $packageField['CodigoEncaminamiento'];
		$this->twoTextsInsideRect($xFirstColumn, $y, 
															$firstColumnWidth, self::FOOTER_FIRST_ROW_HEIGHT,
															'Encaminamiento:', $encaminamiento,
															$fontSmall, $fontMedium,
															4, 3);
		# Second column
		$xSecondColumn = $xFirstColumn + $firstColumnWidth;
		$secondColumnWidth = 55;
		$this->pdf->Rect($xSecondColumn, $y,
										 $secondColumnWidth, self::FOOTER_FIRST_ROW_HEIGHT);
		$this->text('Nº Envío:', $xSecondColumn, $y, $fontSmall);
		$this->text($packageField['NumeroEnvio'], $xSecondColumn+10, $y, $fontHuge);
		# Third column
		$thirdColumnWidth = self::WIDTH - $secondColumnWidth - $firstColumnWidth;
		$xThirdColumn = $xSecondColumn + $secondColumnWidth;
		$this->twoTextsInsideRect($xThirdColumn, $y, 
															$thirdColumnWidth, self::FOOTER_FIRST_ROW_HEIGHT,
															'Bulto(s):', '001/001',
															$fontSmall, $fontMedium,
															2, 1);
	}

	private function drawSecondFooterRow(){
		$fontSmall = array('size'=>6, 'font'=>'helvetica', 'style'=>'B', 'interline'=>3);
		$fontMedium = array('size'=>9, 'font'=>'helvetica', 'style'=>'B', 'interline'=>5);
		$x = 0;
		$y = self::HEADER_HEIGHT + self::BODY_HEIGHT + self::FOOTER_FIRST_ROW_HEIGHT;
		$this->pdf->Rect($x, $y, self::WIDTH, self::FOOTER_SECOND_ROW_HEIGHT);
		# To
		$to = "A:      ".$this->ComunaDestino;
		$this->text($to, $x, $y, $fontMedium);
		# For
		$for = "Para: ".$this->nombre_destinatario;
		$x = self::WIDTH - self::FOR_WIDTH;
		$this->text($for, $x, $y, $fontSmall);
		# Address
		$address = "Dir.:   ".$this->DireccionDestino;
		$y += 3;
		$x = 0;
		$this->text($address, $x, $y, $fontMedium);
		# Phone
		$x = self::WIDTH - self::PHONE_WIDTH;
		$phone = "Tel.: ".$this->telefono_contacto_destinatario;
		$this->text($phone, $x, $y, $fontSmall);
		# Observations
		$observations = "Obs.:";
		$x = 0;
		$y += 5;
		$this->text($observations, $x, $y, $fontSmall);
	}

	private function drawThirdFooterRow(){
		$columns = array(
		array('text'=>'SDP', 'margin'=>3, 'width'=>self::FOOTER_FIRST_COLUMN_WIDTH),
		array('text'=>'PLANTA DESTINO:', 'margin'=>14, 'width'=>self::FOOTER_SECOND_COLUMN_WIDTH),
		array('text'=>'SUCURSAL:', 'margin'=>3, 'width'=>self::FOOTER_THIRD_COLUMN_WIDTH),
		array('text'=>'CDP / CUARTEL:', 'margin'=>2, 'width'=>self::FOOTER_FOURTH_COLUMN_WIDTH));
		$x = 0;
		$y = self::HEIGHT - (self::FOOTER_FOURTH_ROW_HEIGHT + self::FOOTER_THIRD_ROW_HEIGHT);
		$font = array('size'=>4, 'font'=>'helvetica', 'style'=>'B', 'interline'=>2);
		foreach ($columns as $column) {
			$this->textInsideRect($x, $y, 
														$column['width'], self::FOOTER_THIRD_ROW_HEIGHT, 
												    $column['text'], 
												    $font, $column['margin']);
			$x = $x + $column['width'];
		}
	}

	private function drawFourthFooterRow(){
		$x = 0;
		$y = self::HEIGHT - self::FOOTER_FOURTH_ROW_HEIGHT;
		$fontHuge = array('size'=>15, 'font'=>'helvetica', 'style'=>'B', 'interline'=>6);
		$this->textInsideRect($x, $y,
													self::FOOTER_FIRST_COLUMN_WIDTH, self::FOOTER_FOURTH_ROW_HEIGHT,
													$this->SDP, $fontHuge);
		$x += self::FOOTER_FIRST_COLUMN_WIDTH;
		$this->textInsideRect($x, $y,
													self::FOOTER_SECOND_COLUMN_WIDTH, self::FOOTER_FOURTH_ROW_HEIGHT,
													$this->NombreDelegacionDestino, $fontHuge);
		$x += self::FOOTER_SECOND_COLUMN_WIDTH;
		$fontMedium = array('size'=>6, 'font'=>'helvetica', 'style'=>'B', 'interline'=>3);
		$this->textInsideRect($x, $y,
													self::FOOTER_THIRD_COLUMN_WIDTH, self::FOOTER_FOURTH_ROW_HEIGHT,
													"", $fontMedium);
		$x += self::FOOTER_THIRD_COLUMN_WIDTH;
		$fontLarge = array('size'=>13, 'font'=>'helvetica', 'style'=>'B', 'interline'=>6);
		$this->textInsideRect($x, $y,
													self::FOOTER_FOURTH_COLUMN_WIDTH, self::FOOTER_FOURTH_ROW_HEIGHT,
													$this->Cuartel, $fontLarge);
	}

}