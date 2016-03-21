<?php

App::uses('FPDF', 'Lib/Pdf');

class PDF extends FPDF{
	// Simple table
	function BasicTable($header, $data)
	{
		// Header
		foreach($header as $col)
			$this->Cell(40,7,$col,1);
		$this->Ln();
		// Data
		foreach($data as $row)
		{
			foreach($row as $col)
				$this->Cell(40,6,$col,1);
			$this->Ln();
		}
	}

	// Better table
	function ImprovedTable($data, $options = array())
	{
		$this->SetY($options['position']['y']);
		$this->SetX($options['position']['x']);
		foreach($options['cols'] as $k=>$v){
			$options['cols'][$k] = array_merge(
				array(
					'align'=>'L'
				),
				$options['cols'][$k]
			);
		}
		$font = $options['font-header'];
		$this->SetFont($font['font'],$font['style'],$font['size']);
		// Header
		for($i=0;$i<count($options['cols']);$i++){
			$this->Cell($options['cols'][$i]['width'],$font['size']-1,utf8_decode($options['cols'][$i]['header']),'B',0,$options['cols'][$i]['align']);
		}
		$this->Ln();
		$this->SetX($options['position']['x']);
		$font = $options['font-body'];
		$this->SetFont($font['font'],$font['style'],$font['size']);
		// Data
		foreach($data as $row)
		{
			foreach($row as $i=>$col){
				if(!isset($options['cols'][$i])){ continue; }
				$this->Cell($options['cols'][$i]['width'],$font['size']-1,utf8_decode($col),'BT', 0, $options['cols'][$i]['align']);
			}
			$this->Ln();
			$this->SetX($options['position']['x']);
		// Data
		}
	}

	// Colored table
	function FancyTable($header, $data)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');
		// Header
		$w = array(40, 35, 40, 45);
		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],7,$header[$i],1,0,'C',true);
		$this->Ln();
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('');
		// Data
		$fill = false;
		foreach($data as $row)
		{
			$this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
			$this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
			$this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
			$this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
			$this->Ln();
			$fill = !$fill;
		}
		// Closing line
		$this->Cell(array_sum($w),0,'','T');
	}
	function SetDash($black=false, $white=false)
	{
			if($black and $white)
					$s=sprintf('[%.3f %.3f] 0 d', $black*$this->k, $white*$this->k);
			else
					$s='[] 0 d';
			$this->_out($s);
	}

	var $javascript;
	var $n_js;

	function IncludeJS($script) {
			$this->javascript=$script;
	}

	function _putjavascript() {
			$this->_newobj();
			$this->n_js=$this->n;
			$this->_out('<<');
			$this->_out('/Names [(EmbeddedJS) '.($this->n+1).' 0 R ]');
			$this->_out('>>');
			$this->_out('endobj');
			$this->_newobj();
			$this->_out('<<');
			$this->_out('/S /JavaScript');
			$this->_out('/JS '.$this->_textstring($this->javascript));
			$this->_out('>>');
			$this->_out('endobj');
	}

	function _putresources() {
			parent::_putresources();
			if (!empty($this->javascript)) {
					$this->_putjavascript();
			}
	}

	function _putcatalog() {
			parent::_putcatalog();
			if (isset($this->javascript)) {
					$this->_out('/Names <</JavaScript '.($this->n_js).' 0 R>>');
			}
	}
	function AutoPrint($dialog=false)
	{
			//Embed some JavaScript to show the print dialog or start printing immediately
			$param=($dialog ? 'true' : 'false');
			$script="print($param);";
			$this->IncludeJS($script);
	}
}
