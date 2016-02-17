<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
  <title>EasyPoint Label Printing Demo</title>

  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
  <link href='css/gprint.css' rel='stylesheet'>
</head>
<style>
p.MsoNormal, li.MsoNormal, div.MsoNormal, div.WordSection2, table.MsoNormalTable
	{mso-style-unhide:no;
	mso-style-qformat:yes;
	mso-style-parent:"";
	margin-top:1cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:0cm;
	line-height:115%;
	mso-pagination:widow-orphan;
	font-size:11.0pt;
	font-family:Calibri;
	mso-fareast-font-family:Calibri;
	mso-bidi-font-family:"Times New Roman";
	mso-ansi-language:ES-CL;
	mso-fareast-language:EN-US;}
@page WordSection1
	{size:612.0pt 792.0pt;
	margin:34.0pt 11.35pt 0cm 11.35pt;
	mso-header-margin:36.0pt;
	mso-footer-margin:36.0pt;
	mso-paper-source:4;}
div.WordSection1
	{page:WordSection1;}
@media all {
	   div.WordSection2{
	      display: visibility;
	   }
	}
@media print{
   div.WordSection2{
      display:block;
		  page-break-before:always;
   }
}

</style>
</head>

<?php
$printer = "normal";
$labels = 12;
$url_api = "http://api.labelary.com/v1/printers/8dpmm/labels/3.98x3.35/0/^XA^FO40,25^ADN,44,15^FDEASY^FS^FO140,20^ATN,56,15^FDPOINT^FS^FO610,20^ADN,36,20^FDTUR-BUS^FS^FO640,50^ADN,26,20^FDCARGO^FS^FO40,75^GB750,1,1^FS^FO70,210^APB,30,30^FDNORMAL^FS^FO720,250^APB,30,30^FDWEB^FS^FO40,565^GB750,1,1^FS^FO40,465^GB750,1,1^FS^FO30,565^GB750,1,1^FS^FO40,140^GB750,1,1^FS^FO40,410^GB750,1,1^FS^FO40,415^ABN,15,10^FDDIRECCIÃ“N:^FS^FO40,470^ABN,15,10^FDDESTINATARIO:^FS^FO40,515^GB750,1,1^FS^FO40,520^ABN,15,10^FDOBSERVACION:^FS^FO630,520^ABN,15,10^FDTELEFONO:^FS^FO40,575^ABN,15,10^FDREGION Y^FS^FO40,590^ABN,15,10^FDCOMUNA^FS^FO40,620^ABN,15,10^FDAGENCIA^FS^FO40,635^ABN,15,10^FDDESTINO^FS^FO630,575^ABN,15,10^FDBULTO:^FS^FO630,630^ABN,15,10^FDRAMPA:^FS^FO280,20^ASN,36,20^FDR13 SANTIAGO^FS^FO280,55^ABN,15,10^FD1467 CENTRO DISTRIBUCION S.B.^FS^FO40,90^ATN,56,15^FDPIN: 1870^FS^FO390,85^ABN,15,10^FDREFERENCIA:^FS^FO380,95^ATN,56,15^FD201592^FS^FO640,85^ABN,15,10^FD31-08-2015^FS^FO640,99^APN,15,10^FDCTA.CTE. 41101-9^FS^FO640,115^APN,15,10^FDR.U.T. 76434414-6^FS^FO150,160^BY3^BCN,200,Y,N,N,A^FD92014672821467900481274001^FS^FO40,430^AQN,10,10^FDJOSE MANUEL INFANTE 2320, DEPTO 164 TORRE A, NUNOA, SANTIAGO^FS^FO40,485^AQN,10,10^FDEASYPOINT CAFETERIA AMARANTO^FS^FO40,535^APN,15,10^FDACCESO PASAJE LATERAL^FS^FO630,535^APN,15,10^FD+56 95 1261107^FS^FO110,570^ASN,36,20^FDR13 LAS CONDES DOMICILIO^FS^FO110,620^ACN,26,10^FD1467  CENTRO DISTRIBUCION^FS^FO630,590^ASN,15,10^FD001/001^FS^FO690,625^ASN,15,10^FD82^FS^XZ";
$current_label = 0;
$pages = 0;

if ($labels%6 == 0) {
	$pages = intval ($labels/6) - 1;
} else {
	$pages = intval ($labels/6);
}

if ($labels < 1) {
	echo '<p><h1>No hay etiquetas para imprimir</h1></p>';
} elseif ($printer == "normal") {
		for ($i = 0; $i <= $pages; $i++) {
			echo "<body lang=ES-TRAD style='tab-interval:35.4pt'>"."\n";
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
}

?>
</body>
</html>
