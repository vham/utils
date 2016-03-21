<?php
App::uses('PDF', 'Lib/Pdf');

class BasePdf{
	
	function __construct(){
	}

	function box($x, $y ,$w ,$h, $style = "", $fill = null){
		if(!is_null($fill)){
			$this->pdf->SetFillColor($fill['r'], $fill['g'], $fill['b']);	
		}
		$this->pdf->Rect($x, $y, $w, $h, $style);
	} 

	function text($string, $x, $y, $font = null, $align = 'L', $width = 0){
		if(is_null($font)){ $font = $this->defaultFont; }
		$this->pdf->SetFont($font['font'],$font['style'],$font['size']);
		$this->pdf->SetXY($x, $y); 
		if(!isset($font['interline'])){
			$font['interline'] = $font['size']-3.5;
		}
		$this->pdf->MultiCell($width, $font['interline'], utf8_decode($string), 0, $align);
	}

	function textInsideRect($x, $y, $width, $height, $text, $font=null, $margin=0){
		if(empty($font)){
			$font = array(
				'font'=>'helvetica', 
				'size'=>$height*2, 
				'style'=>'B', 
				'interline'=>$font['size'-3]);
		}
		$this->pdf->SetFont($font['font'], $font['style'], $font['size']);
		$this->pdf->Rect($x, $y, $width, $height);
		$this->text($text, $x+$margin, $y, $font);
	}

	function twoTextsInsideRect($x, $y, $width, $height, $text1, $text2, $font1, $font2, $marginText1=0, $marginText2=0){
		$this->pdf->Rect($x, $y, $width, $height);
		$this->text($text1, $x+$marginText1, $y, $font1);
		$ySecondText = $y+($font1['size']-$font1['interline']);
		$this->text($text2, $x+$marginText2, $ySecondText, $font2);
	}
} 
