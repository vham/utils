<?php
$rut = "76434414-6";
$ctacte = "41101-9";

$region = htmlspecialchars($_GET['region']);
$centro = htmlspecialchars($_GET['centro']);
$pin = htmlspecialchars($_GET['pin']);
$ref = htmlspecialchars($_GET['referencia']);
$date = htmlspecialchars($_GET['fecha']);
$barcode = htmlspecialchars($_GET['barcode']);
$dire = htmlspecialchars($_GET['dire']);
$dest = htmlspecialchars($_GET['destinatario']);
$obs = htmlspecialchars($_GET['obs']);
$fono = htmlspecialchars($_GET['fono']);
$comuna = htmlspecialchars($_GET['comuna']);
$agencia = htmlspecialchars($_GET['agencia']);
$bulto = htmlspecialchars($_GET['bulto']);
$rampa = htmlspecialchars($_GET['rampa']);
$printer = htmlspecialchars($_GET['printer']);
$labels = htmlspecialchars($_GET['labels']);

$url_api = "http://api.labelary.com/v1/printers/8dpmm/labels/3.98x3.35/0/";
$zpl = "^XA^FO40,25^ADN,44,15^FDEASY^FS^FO140,20^ATN,56,15^FDPOINT^FS";
$zpl = $zpl."^FO610,20^ADN,36,20^FDTUR-BUS^FS^FO640,50^ADN,26,20^FDCA";
$zpl = $zpl."RGO^FS^FO40,75^GB750,1,1^FS^FO70,210^APB,30,30^FDNORMAL^";
$zpl = $zpl."FS^FO720,250^APB,30,30^FDWEB^FS^FO40,565^GB750,1,1^FS^FO";
$zpl = $zpl."40,465^GB750,1,1^FS^FO30,565^GB750,1,1^FS^FO40,140^GB750";
$zpl = $zpl.",1,1^FS^FO40,410^GB750,1,1^FS^FO40,415^ABN,15,10^FDDIREC";
$zpl = $zpl."CIÓN:^FS^FO40,470^ABN,15,10^FDDESTINATARIO:^FS^FO40,515^";
$zpl = $zpl."GB750,1,1^FS^FO40,520^ABN,15,10^FDOBSERVACION:^FS^FO630,";
$zpl = $zpl."520^ABN,15,10^FDTELEFONO:^FS^FO40,575^ABN,15,10^FDREGION";
$zpl = $zpl." Y^FS^FO40,590^ABN,15,10^FDCOMUNA^FS^FO40,620^ABN,15,10^";
$zpl = $zpl."FDAGENCIA^FS^FO40,635^ABN,15,10^FDDESTINO^FS^FO630,575^A";
$zpl = $zpl."BN,15,10^FDBULTO:^FS^FO630,630^ABN,15,10^FDRAMPA:^FS";
$zpl = $zpl."^FO280,20^ASN,36,20^FD".$region."^FS";
$zpl = $zpl."^FO280,55^ABN,15,10^FD".$centro."^FS";
$zpl = $zpl."^FO40,90^ATN,56,15^FDPIN: ".$pin."^FS";
$zpl = $zpl."^FO390,85^ABN,15,10^FDREFERENCIA:^FS";
$zpl = $zpl."^FO380,95^ATN,56,15^FD".$ref."^FS";
$zpl = $zpl."^FO640,85^ABN,15,10^FD".$date."^FS";
$zpl = $zpl."^FO640,99^APN,15,10^FDCTA.CTE. ".$ctacte."^FS";
$zpl = $zpl."^FO640,115^APN,15,10^FDR.U.T. ".$rut."^FS";
$zpl = $zpl."^FO150,160^BY3^BCN,200,Y,N,N,A^FD".$barcode."^FS";
$zpl = $zpl."^FO40,430^AQN,10,10^FD".$dire."^FS";
$zpl = $zpl."^FO40,485^AQN,10,10^FD".$dest."^FS";
$zpl = $zpl."^FO40,535^APN,15,10^FD".$obs."^FS";
$zpl = $zpl."^FO630,535^APN,15,10^FD".$fono."^FS";
$zpl = $zpl."^FO110,570^ASN,36,20^FD".$comuna."^FS";
$zpl = $zpl."^FO110,620^ACN,26,10^FD".$agencia."^FS";
$zpl = $zpl."^FO630,590^ASN,15,10^FD".$bulto."^FS";
$zpl = $zpl."^FO690,625^ASN,15,10^FD".$rampa."^FS^XZ";
$url_api = $url_api.$zpl;

$labels = intval ($labels);
$current_label = 0;
if ($labels%6 == 0) {
	$pages = intval ($labels/6) - 1;
} else {
	$pages = intval ($labels/6);
}

if ($labels < 1) {
  echo '<div class="col-md-8">';
  echo '<h2 class="text-center"><span style="color:red;font-weight:bold">ERROR:</span> No hay etiquetas para imprimir.</h2>';
  echo '</div>';
	} elseif ($printer == "html") {
			for ($i = 0; $i <= $pages; $i++) {
				if ($i == 0) {
					echo "<!-- página número:".$i."-->\n";
					echo "<div class=MsoNormal>"."\n";
					echo "<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0"."\n";
					echo "style='border-collapse:collapse;mso-table-layout-alt:fixed;mso-padding-top-alt:"."\n";
					echo "0cm;mso-padding-bottom-alt:0cm'>"."\n";
				} else {
					echo "<!-- página número:".$i."-->\n";
					echo "<div class=WordSection2>"."\n";
					echo "<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0"."\n";
					echo "style='border-collapse:collapse;mso-table-layout-alt:fixed;mso-padding-top-alt:"."\n";
					echo "0cm;mso-padding-bottom-alt:0cm'>"."\n";
					echo "<!-- fila adicional para agregar margen superior en salto de página-->\n";
					echo "<tr style='height:1cm'><td style='height=1cm'></td></tr>"."\n";
				}
				for ($x = 1; $x <=3 ; $x++) {
					echo "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid;"."\n";
					echo "height:225pt;mso-height-rule:exactly'>"."\n";
					echo "<td width=288 valign=top style='width:288.05pt;padding:0cm .75pt 0cm .75pt;"."\n";
				  echo "height:225pt;mso-height-rule:exactly'>"."\n";
					//echo "height:230pt;mso-height-rule:exactly'>"."\n";

					$current_label++;
					if ($current_label <= $labels) {
						echo "<!-- Label nro:".$current_label." col1 -->";
						echo "<img src='".$url_api."' height=100% width=100% alt='iframe_label_1'></img>"."\n";
					}

					echo "</td>";
					echo "<td width=13 valign=top style='width:13.3pt;padding:0cm .75pt 0cm .75pt;"."\n";
					echo "height:225pt;mso-height-rule:exactly'>"."\n";
					echo "</td>"."\n";
					echo "<td width=288 valign=top style='width:288.05pt;padding:0cm .75pt 0cm .75pt;"."\n";
				  echo "height:225pt;mso-height-rule:exactly'>"."\n";
					//echo "height:230pt;mso-height-rule:exactly'>"."\n";

					$current_label++;
					if ($current_label <= $labels) {
						echo "<!-- Label nro:".$current_label." col2 -->";
						echo "<img src=\"".$url_api."\" height=100% width=100% alt=\"iframe_label_2\"></img>"."\n";
					}

					echo "</td>"."\n";
					echo "</tr>"."\n";
					}
					echo "</table>"."\n";
					echo "</div>"."\n";
				}
		} elseif ($printer == "raw") {
				echo "<!-- página única-->";
				echo "<div class=MsoNormal>"."\n";
				echo "<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0"."\n";
				echo "style='border-collapse:collapse;mso-table-layout-alt:fixed;mso-padding-top-alt:"."\n";
				echo "0cm;mso-padding-bottom-alt:0cm'>"."\n";
				for ($x = 1; $x <= $labels ; $x++) {
					echo "<tr style='mso-yfti-irow:0;mso-yfti-firstrow:yes;page-break-inside:avoid;"."\n";
					echo "height:225pt;mso-height-rule:exactly'>"."\n";
					echo "<td width=288 valign=top style='width:288.05pt;padding:0cm .75pt 0cm .75pt;"."\n";
					echo "height:225pt;mso-height-rule:exactly'>"."\n";

					$current_label++;
					if ($current_label <= $labels) {
						echo "<!-- Label nro:".$current_label." col1 -->";
						echo "<img src='".$url_api."' height=100% width=100% alt='iframe_label_1'></img>"."\n";
					}
					echo "</td>";
					echo "</tr>"."\n";
				}
				echo "</table>"."\n";
				echo "</div>"."\n";
  }
?>
