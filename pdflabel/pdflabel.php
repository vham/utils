<?php
require('fpdf181/fpdf.php');

###############################################################################
## CLASS PDF_JSPRINT
###############################################################################
class PDF_JSPRINT extends FPDF{
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
  ###############################################################################
  ## CLASS PDF_JSPRINT
  ###############################################################################
  class PDF_BARCODE extends PDF_JSPRINT{
  protected $T128;                                         // Tableau des codes 128
  protected $ABCset = "";                                  // jeu des caractères éligibles au C128
  protected $Aset = "";                                    // Set A du jeu des caractères éligibles
  protected $Bset = "";                                    // Set B du jeu des caractères éligibles
  protected $Cset = "";                                    // Set C du jeu des caractères éligibles
  protected $SetFrom;                                      // Convertisseur source des jeux vers le tableau
  protected $SetTo;                                        // Convertisseur destination des jeux vers le tableau
  protected $JStart = array("A"=>103, "B"=>104, "C"=>105); // Caractères de sélection de jeu au début du C128
  protected $JSwap = array("A"=>101, "B"=>100, "C"=>99);   // Caractères de changement de jeu

  //____________________________ Extension du constructeur _______________________
  function __construct($orientation='P', $unit='mm', $format='A4') {

      parent::__construct($orientation,$unit,$format);

      $this->T128[] = array(2, 1, 2, 2, 2, 2);           //0 : [ ]               // composition des caractères
      $this->T128[] = array(2, 2, 2, 1, 2, 2);           //1 : [!]
      $this->T128[] = array(2, 2, 2, 2, 2, 1);           //2 : ["]
      $this->T128[] = array(1, 2, 1, 2, 2, 3);           //3 : [#]
      $this->T128[] = array(1, 2, 1, 3, 2, 2);           //4 : [$]
      $this->T128[] = array(1, 3, 1, 2, 2, 2);           //5 : [%]
      $this->T128[] = array(1, 2, 2, 2, 1, 3);           //6 : [&]
      $this->T128[] = array(1, 2, 2, 3, 1, 2);           //7 : [']
      $this->T128[] = array(1, 3, 2, 2, 1, 2);           //8 : [(]
      $this->T128[] = array(2, 2, 1, 2, 1, 3);           //9 : [)]
      $this->T128[] = array(2, 2, 1, 3, 1, 2);           //10 : [*]
      $this->T128[] = array(2, 3, 1, 2, 1, 2);           //11 : [+]
      $this->T128[] = array(1, 1, 2, 2, 3, 2);           //12 : [,]
      $this->T128[] = array(1, 2, 2, 1, 3, 2);           //13 : [-]
      $this->T128[] = array(1, 2, 2, 2, 3, 1);           //14 : [.]
      $this->T128[] = array(1, 1, 3, 2, 2, 2);           //15 : [/]
      $this->T128[] = array(1, 2, 3, 1, 2, 2);           //16 : [0]
      $this->T128[] = array(1, 2, 3, 2, 2, 1);           //17 : [1]
      $this->T128[] = array(2, 2, 3, 2, 1, 1);           //18 : [2]
      $this->T128[] = array(2, 2, 1, 1, 3, 2);           //19 : [3]
      $this->T128[] = array(2, 2, 1, 2, 3, 1);           //20 : [4]
      $this->T128[] = array(2, 1, 3, 2, 1, 2);           //21 : [5]
      $this->T128[] = array(2, 2, 3, 1, 1, 2);           //22 : [6]
      $this->T128[] = array(3, 1, 2, 1, 3, 1);           //23 : [7]
      $this->T128[] = array(3, 1, 1, 2, 2, 2);           //24 : [8]
      $this->T128[] = array(3, 2, 1, 1, 2, 2);           //25 : [9]
      $this->T128[] = array(3, 2, 1, 2, 2, 1);           //26 : [:]
      $this->T128[] = array(3, 1, 2, 2, 1, 2);           //27 : [;]
      $this->T128[] = array(3, 2, 2, 1, 1, 2);           //28 : [<]
      $this->T128[] = array(3, 2, 2, 2, 1, 1);           //29 : [=]
      $this->T128[] = array(2, 1, 2, 1, 2, 3);           //30 : [>]
      $this->T128[] = array(2, 1, 2, 3, 2, 1);           //31 : [?]
      $this->T128[] = array(2, 3, 2, 1, 2, 1);           //32 : [@]
      $this->T128[] = array(1, 1, 1, 3, 2, 3);           //33 : [A]
      $this->T128[] = array(1, 3, 1, 1, 2, 3);           //34 : [B]
      $this->T128[] = array(1, 3, 1, 3, 2, 1);           //35 : [C]
      $this->T128[] = array(1, 1, 2, 3, 1, 3);           //36 : [D]
      $this->T128[] = array(1, 3, 2, 1, 1, 3);           //37 : [E]
      $this->T128[] = array(1, 3, 2, 3, 1, 1);           //38 : [F]
      $this->T128[] = array(2, 1, 1, 3, 1, 3);           //39 : [G]
      $this->T128[] = array(2, 3, 1, 1, 1, 3);           //40 : [H]
      $this->T128[] = array(2, 3, 1, 3, 1, 1);           //41 : [I]
      $this->T128[] = array(1, 1, 2, 1, 3, 3);           //42 : [J]
      $this->T128[] = array(1, 1, 2, 3, 3, 1);           //43 : [K]
      $this->T128[] = array(1, 3, 2, 1, 3, 1);           //44 : [L]
      $this->T128[] = array(1, 1, 3, 1, 2, 3);           //45 : [M]
      $this->T128[] = array(1, 1, 3, 3, 2, 1);           //46 : [N]
      $this->T128[] = array(1, 3, 3, 1, 2, 1);           //47 : [O]
      $this->T128[] = array(3, 1, 3, 1, 2, 1);           //48 : [P]
      $this->T128[] = array(2, 1, 1, 3, 3, 1);           //49 : [Q]
      $this->T128[] = array(2, 3, 1, 1, 3, 1);           //50 : [R]
      $this->T128[] = array(2, 1, 3, 1, 1, 3);           //51 : [S]
      $this->T128[] = array(2, 1, 3, 3, 1, 1);           //52 : [T]
      $this->T128[] = array(2, 1, 3, 1, 3, 1);           //53 : [U]
      $this->T128[] = array(3, 1, 1, 1, 2, 3);           //54 : [V]
      $this->T128[] = array(3, 1, 1, 3, 2, 1);           //55 : [W]
      $this->T128[] = array(3, 3, 1, 1, 2, 1);           //56 : [X]
      $this->T128[] = array(3, 1, 2, 1, 1, 3);           //57 : [Y]
      $this->T128[] = array(3, 1, 2, 3, 1, 1);           //58 : [Z]
      $this->T128[] = array(3, 3, 2, 1, 1, 1);           //59 : [[]
      $this->T128[] = array(3, 1, 4, 1, 1, 1);           //60 : [\]
      $this->T128[] = array(2, 2, 1, 4, 1, 1);           //61 : []]
      $this->T128[] = array(4, 3, 1, 1, 1, 1);           //62 : [^]
      $this->T128[] = array(1, 1, 1, 2, 2, 4);           //63 : [_]
      $this->T128[] = array(1, 1, 1, 4, 2, 2);           //64 : [`]
      $this->T128[] = array(1, 2, 1, 1, 2, 4);           //65 : [a]
      $this->T128[] = array(1, 2, 1, 4, 2, 1);           //66 : [b]
      $this->T128[] = array(1, 4, 1, 1, 2, 2);           //67 : [c]
      $this->T128[] = array(1, 4, 1, 2, 2, 1);           //68 : [d]
      $this->T128[] = array(1, 1, 2, 2, 1, 4);           //69 : [e]
      $this->T128[] = array(1, 1, 2, 4, 1, 2);           //70 : [f]
      $this->T128[] = array(1, 2, 2, 1, 1, 4);           //71 : [g]
      $this->T128[] = array(1, 2, 2, 4, 1, 1);           //72 : [h]
      $this->T128[] = array(1, 4, 2, 1, 1, 2);           //73 : [i]
      $this->T128[] = array(1, 4, 2, 2, 1, 1);           //74 : [j]
      $this->T128[] = array(2, 4, 1, 2, 1, 1);           //75 : [k]
      $this->T128[] = array(2, 2, 1, 1, 1, 4);           //76 : [l]
      $this->T128[] = array(4, 1, 3, 1, 1, 1);           //77 : [m]
      $this->T128[] = array(2, 4, 1, 1, 1, 2);           //78 : [n]
      $this->T128[] = array(1, 3, 4, 1, 1, 1);           //79 : [o]
      $this->T128[] = array(1, 1, 1, 2, 4, 2);           //80 : [p]
      $this->T128[] = array(1, 2, 1, 1, 4, 2);           //81 : [q]
      $this->T128[] = array(1, 2, 1, 2, 4, 1);           //82 : [r]
      $this->T128[] = array(1, 1, 4, 2, 1, 2);           //83 : [s]
      $this->T128[] = array(1, 2, 4, 1, 1, 2);           //84 : [t]
      $this->T128[] = array(1, 2, 4, 2, 1, 1);           //85 : [u]
      $this->T128[] = array(4, 1, 1, 2, 1, 2);           //86 : [v]
      $this->T128[] = array(4, 2, 1, 1, 1, 2);           //87 : [w]
      $this->T128[] = array(4, 2, 1, 2, 1, 1);           //88 : [x]
      $this->T128[] = array(2, 1, 2, 1, 4, 1);           //89 : [y]
      $this->T128[] = array(2, 1, 4, 1, 2, 1);           //90 : [z]
      $this->T128[] = array(4, 1, 2, 1, 2, 1);           //91 : [{]
      $this->T128[] = array(1, 1, 1, 1, 4, 3);           //92 : [|]
      $this->T128[] = array(1, 1, 1, 3, 4, 1);           //93 : [}]
      $this->T128[] = array(1, 3, 1, 1, 4, 1);           //94 : [~]
      $this->T128[] = array(1, 1, 4, 1, 1, 3);           //95 : [DEL]
      $this->T128[] = array(1, 1, 4, 3, 1, 1);           //96 : [FNC3]
      $this->T128[] = array(4, 1, 1, 1, 1, 3);           //97 : [FNC2]
      $this->T128[] = array(4, 1, 1, 3, 1, 1);           //98 : [SHIFT]
      $this->T128[] = array(1, 1, 3, 1, 4, 1);           //99 : [Cswap]
      $this->T128[] = array(1, 1, 4, 1, 3, 1);           //100 : [Bswap]
      $this->T128[] = array(3, 1, 1, 1, 4, 1);           //101 : [Aswap]
      $this->T128[] = array(4, 1, 1, 1, 3, 1);           //102 : [FNC1]
      $this->T128[] = array(2, 1, 1, 4, 1, 2);           //103 : [Astart]
      $this->T128[] = array(2, 1, 1, 2, 1, 4);           //104 : [Bstart]
      $this->T128[] = array(2, 1, 1, 2, 3, 2);           //105 : [Cstart]
      $this->T128[] = array(2, 3, 3, 1, 1, 1);           //106 : [STOP]
      $this->T128[] = array(2, 1);                       //107 : [END BAR]

      for ($i = 32; $i <= 95; $i++) {                                            // jeux de caractères
          $this->ABCset .= chr($i);
      }
      $this->Aset = $this->ABCset;
      $this->Bset = $this->ABCset;

      for ($i = 0; $i <= 31; $i++) {
          $this->ABCset .= chr($i);
          $this->Aset .= chr($i);
      }
      for ($i = 96; $i <= 127; $i++) {
          $this->ABCset .= chr($i);
          $this->Bset .= chr($i);
      }
      for ($i = 200; $i <= 210; $i++) {                                           // controle 128
          $this->ABCset .= chr($i);
          $this->Aset .= chr($i);
          $this->Bset .= chr($i);
      }
      $this->Cset="0123456789".chr(206);

      for ($i=0; $i<96; $i++) {                                                   // convertisseurs des jeux A & B
          @$this->SetFrom["A"] .= chr($i);
          @$this->SetFrom["B"] .= chr($i + 32);
          @$this->SetTo["A"] .= chr(($i < 32) ? $i+64 : $i-32);
          @$this->SetTo["B"] .= chr($i);
      }
      for ($i=96; $i<107; $i++) {                                                 // contrôle des jeux A & B
          @$this->SetFrom["A"] .= chr($i + 104);
          @$this->SetFrom["B"] .= chr($i + 104);
          @$this->SetTo["A"] .= chr($i);
          @$this->SetTo["B"] .= chr($i);
      }
  }

  //________________ Fonction encodage et dessin du code 128 _____________________
  function Code128($x, $y, $code, $w, $h) {
      $Aguid = "";                                                                      // Création des guides de choix ABC
      $Bguid = "";
      $Cguid = "";
      for ($i=0; $i < strlen($code); $i++) {
          $needle = substr($code,$i,1);
          $Aguid .= ((strpos($this->Aset,$needle)===false) ? "N" : "O");
          $Bguid .= ((strpos($this->Bset,$needle)===false) ? "N" : "O");
          $Cguid .= ((strpos($this->Cset,$needle)===false) ? "N" : "O");
      }

      $SminiC = "OOOO";
      $IminiC = 4;

      $crypt = "";
      while ($code > "") {
                                                                                      // BOUCLE PRINCIPALE DE CODAGE
          $i = strpos($Cguid,$SminiC);                                                // forçage du jeu C, si possible
          if ($i!==false) {
              $Aguid [$i] = "N";
              $Bguid [$i] = "N";
          }

          if (substr($Cguid,0,$IminiC) == $SminiC) {                                  // jeu C
              $crypt .= chr(($crypt > "") ? $this->JSwap["C"] : $this->JStart["C"]);  // début Cstart, sinon Cswap
              $made = strpos($Cguid,"N");                                             // étendu du set C
              if ($made === false) {
                  $made = strlen($Cguid);
              }
              if (fmod($made,2)==1) {
                  $made--;                                                            // seulement un nombre pair
              }
              for ($i=0; $i < $made; $i += 2) {
                  $crypt .= chr(strval(substr($code,$i,2)));                          // conversion 2 par 2
              }
              $jeu = "C";
          } else {
              $madeA = strpos($Aguid,"N");                                            // étendu du set A
              if ($madeA === false) {
                  $madeA = strlen($Aguid);
              }
              $madeB = strpos($Bguid,"N");                                            // étendu du set B
              if ($madeB === false) {
                  $madeB = strlen($Bguid);
              }
              $made = (($madeA < $madeB) ? $madeB : $madeA );                         // étendu traitée
              $jeu = (($madeA < $madeB) ? "B" : "A" );                                // Jeu en cours

              $crypt .= chr(($crypt > "") ? $this->JSwap[$jeu] : $this->JStart[$jeu]); // début start, sinon swap

              $crypt .= strtr(substr($code, 0,$made), $this->SetFrom[$jeu], $this->SetTo[$jeu]); // conversion selon jeu

          }
          $code = substr($code,$made);                                           // raccourcir légende et guides de la zone traitée
          $Aguid = substr($Aguid,$made);
          $Bguid = substr($Bguid,$made);
          $Cguid = substr($Cguid,$made);
      }                                                                          // FIN BOUCLE PRINCIPALE

      $check = ord($crypt[0]);                                                   // calcul de la somme de contrôle
      for ($i=0; $i<strlen($crypt); $i++) {
          $check += (ord($crypt[$i]) * $i);
      }
      $check %= 103;

      $crypt .= chr($check) . chr(106) . chr(107);                               // Chaine cryptée complète

      $i = (strlen($crypt) * 11) - 8;                                            // calcul de la largeur du module
      $modul = $w/$i;

      for ($i=0; $i<strlen($crypt); $i++) {                                      // BOUCLE D'IMPRESSION
          $c = $this->T128[ord($crypt[$i])];
          for ($j=0; $j<count($c); $j++) {
              $this->Rect($x,$y,$c[$j]*$modul,$h,"F");
              $x += ($c[$j++]+$c[$j])*$modul;
          }
      }
  }

  var $angle=0;
  function Rotate($angle,$x=-1,$y=-1)
  {
      if($x==-1)
          $x=$this->x;
      if($y==-1)
          $y=$this->y;
      if($this->angle!=0)
          $this->_out('Q');
      $this->angle=$angle;
      if($angle!=0)
      {
          $angle*=M_PI/180;
          $c=cos($angle);
          $s=sin($angle);
          $cx=$x*$this->k;
          $cy=($this->h-$y)*$this->k;
          $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
      }
  }
  function _endpage()
  {
      if($this->angle!=0)
      {
          $this->angle=0;
          $this->_out('Q');
      }
      parent::_endpage();
  }
  function RotatedText($x,$y,$txt,$angle)
  {
      //Text rotated around its origin
      $this->Rotate($angle,$x,$y);
      $this->Text($x,$y,$txt);
      $this->Rotate(0);
  }
  function RotatedImage($file,$x,$y,$w,$h,$angle)
  {
      //Image rotated around its upper-left corner
      $this->Rotate($angle,$x,$y);
      $this->Image($file,$x,$y,$w,$h);
      $this->Rotate(0);
  }
}

###############################################################################
## CLASS PDF_ZEBRA_LABEL
###############################################################################
class PDF_ZEBRA_LABEL extends PDF_BARCODE{
  # Label dimensions
  const WIDTH = 90;
  const HEIGHT = 73;

  public $data=array();
  public $labels;

  private $CompanyId;
  private $ctaCte;
  private $region;
  private $centre;
  private $pin;
  private $externalId;
  private $date;
  private $barcode;
  private $address;
  private $name;
  private $info;
  private $phone;
  private $region_district;
  private $agency;
  private $parcel;
  private $ramp;

  function __construct($data=array())
	{
    parent::__construct('L', 'mm');
		$this->SetDisplayMode('fullwidth', 'single');
		$this->SetAutoPageBreak('false');
		$this->SetDrawColor(0, 0, 0);
		$this->SetTextColor(0, 0, 0);
    $this->data = $data;
    $this->labels = count($this->data);
	}
  function Generate($autoprint=false,$filename=null){
    foreach ($this->data as $key => $value){
      $this->AddPage('L', array(self::WIDTH, self::HEIGHT));
      $this->SetMargins(0, 0, 0);
      $this->setFields($value);
      $this->drawPackageLabel();
    }
    if ($autoprint) {$this->AutoPrint();}
    if ($filename)  {
      $this->Output($filename,'F');
    } else {
      $this->Output();
    }
  }
  private function setFields($data=array()){
    $this->externalId = $data['externalId'];
    $this->freightOrder = $data['freightOrder'];
    $this->pin = $data['pin'];
    $this->date = $data['date'];
    $this->CompanyId = $data['CompanyId'];
    $this->ctaCte = $data['ctaCte'];
    $this->barcode = $data['barcode'];
    $this->address = substr($data['address'],0,65);
    $this->name = substr($data['name'],0,50);
    $this->info = substr($data['info'],0,65);
    $this->phone = $data['phone'];
    $this->region_district = substr($data['region_district'],0,30);
    $this->agency = $data['agency'];
    $this->parcel = $data['parcel'];
    $this->ramp = $data['ramp'];
  }
  private function drawPackageLabel(){
    // Horizontal Lines
    $this->Line(4,7,86,7);
    $this->Line(4,15,86,15);
    $this->Line(4,41,86,41);
    $this->Line(4,47,86,47);
    $this->Line(4,53,86,53);
    $this->Line(4,59,86,59);

    //Vertical
    $this->Line(42,7,42,15);
    $this->Line(69,7,69,15);

    // Header
    $code = 'EASY';
    $this->SetFont('Arial','',10);
    $this->SetXY(3,1);
    $this->Write(5,$code);

    $code = 'POINT';
    $this->SetFont('Arial','B',10);
    $this->SetXY(13,1);
    $this->Write(5,$code);

    $code = 'TUR-BUS';
    $this->SetFont('Arial','',10);
    $this->SetXY(70,1);
    $this->Write(5,$code);

    $code = 'CARGO';
    $this->SetFont('Arial','B',5);
    $this->SetXY(75,3.4);
    $this->Write(5,$code);

    // Reference/Document Info
    $code = 'REFERENCIA/DOCUMENTO:';
    $this->SetFont('Arial','B',5);
    $this->SetXY(32,1);
    $this->Write(2,$code);

    $code = $this->externalId;
    $this->SetFont('Arial','B',10);
    $this->SetXY(32,4);
    $this->Write(2,$code);

    // Freight Order
    $this->SetFont('Arial','',4);
    $this->RotatedText(4,11,'O.F.',90);
    $code = $this->freightOrder;
    $this->SetFont('Courier','',9);
    $this->Code128(5,7.5,$code,34,4);
    $this->SetXY(11,12.2);
    $this->Write(2,$code);

    // PIN
    $code = 'PIN: '.$this->pin;
    $this->SetFont('Arial','B',12);
    $this->SetXY(46,10);
    $this->Write(3,$code);

    // Date
    $code = 'FECHA: '.$this->date;
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,8);
    $this->Write(1,$code);

    $code = 'CTA.CTE. '.$this->ctaCte;
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,10);
    $this->Write(1,$code);

    $code = 'R.U.T. '.$this->CompanyId;
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,12);
    $this->Write(1,$code);

    // Barcode section
    $this->SetFont('Arial','B',8);
    $this->RotatedText(8,33,'NORMAL',90);
    $this->RotatedText(84,30,'WEB',90);

    $code = $this->barcode;
    $this->SetFont('Courier','',10);
    $this->Code128(10,17,$code,70,20);
    $this->SetXY(18,38);
    $this->Write(2,$code);

    // Third row
    $code = 'DIRECCION:';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,42);
    $this->Write(1,$code);

    $code = $this->address;
    $this->SetFont('Arial','B',6);
    $this->SetXY(3,44);
    $this->Write(1,$code);

    $code = 'DESTINATARIO:';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,48);
    $this->Write(1,$code);

    $code = $this->name;
    $this->SetFont('Arial','B',6);
    $this->SetXY(3,50);
    $this->Write(1,$code);

    $code = 'TELEFONO:';
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,48);
    $this->Write(1,$code);

    $code = $this->phone;
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,50);
    $this->Write(1,$code);

    // Fourth row
    $code = 'OBSERVACION:';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,54);
    $this->Write(1,$code);

    $code = $this->info;
    $this->SetFont('Arial','B',6);
    $this->SetXY(3,56);
    $this->Write(1,$code);

    // Fifth row
    $code = 'REGION Y';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,60);
    $this->Write(1,$code);
    $code = 'COMUNA';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,62);
    $this->Write(1,$code);

    $code = $this->region_district;
    $this->SetFont('Arial','B',8);
    $this->SetXY(12,61);
    $this->Write(1,$code);

    $code = 'AGENCIA';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,65);
    $this->Write(1,$code);
    $code = 'DESTINO';
    $this->SetFont('Arial','',5);
    $this->SetXY(3,67);
    $this->Write(1,$code);

    $code = $this->agency;
    $this->SetFont('Arial','B',6);
    $this->SetXY(12,65);
    $this->Write(1,$code);

    $code = 'BULTO:';
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,60);
    $this->Write(1,$code);

    $code = $this->parcel;
    $this->SetFont('Arial','B',6);
    $this->SetXY(72,62);
    $this->Write(1,$code);

    $code = 'RAMPA:';
    $this->SetFont('Arial','B',4);
    $this->SetXY(72,64);
    $this->Write(1,$code);

    $code = $this->ramp;
    $this->SetFont('Arial','B',6);
    $this->SetXY(72,65.5);
    $this->Write(2,$code);
	}
}

# EXAMPLE

date_default_timezone_set("America/Santiago");
$data[0] = array(
    'CompanyId'=>'76434414-6',
    'ctaCte'=>'41101-9',
    'freightOrder'=>'901046833',
    'pin'=>'1592',
    'externalId'=>'1201589262937',
    'date'=>'07/11/2016',
    'barcode'=>'92014672821467900481274001',
    'address'=>'JOSE MANUEL INFANTE 2320, DEPTO 164 TORRE A, NUNOA, SANTIAGO',
    'name'=>'EASYPOINT CAFETERIA AMARANTO',
    'info'=>'ACCESO PASAJE LATERAL',
    'phone'=>'56 95 1261107',
    'region_district'=>'R13 LAS CONDES DOMICILIO',
    'agency'=>'1467 CENTRO DISTRIBUCION',
    'parcel'=>'001/001',
    'ramp'=>'080',
);
$data[1] = array(
    'CompanyId'=>'76434414-6',
    'ctaCte'=>'41101-9',
    'freightOrder'=>'901046833',
    'pin'=>'1592',
    'externalId'=>'2015892',
    'date'=>'2016-11-07',
    'barcode'=>'92014672821467900481274001',
    'address'=>'JOSE MANUEL 2320, DEPTO 164JOSE MANUEL 2320, DEPTO 164JOSE MANUEL 2320, DEPTO 164JOSE MANUEL 2320, DEPTO 164',
    'name'=>'EASYPOINTEASYPOINTEASYPOINTEASYPOINCAFETERIAETERIA',
    'info'=>'ACCESO PASAJE ',
    'phone'=>'56 95 1261107',
    'region_district'=>'EASYPOINTEASYPOINTEASYPOINTEASY',
    'agency'=>'1467 CENTRO DISTRIBUCION',
    'parcel'=>'1',
    'ramp'=>'80',
);

$pdf = new PDF_ZEBRA_LABEL($data);
$pdf->Generate(false);
//$pdf->Generate(false,'test.pdf');
