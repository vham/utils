<?php

$url_api = "http://api.labelary.com/v1/printers/8dpmm/labels/3.98x3.35/0/";
$zpl = "^XA^FO40,25^ADN,44,15^FDEASY^FS^FO140,20^ATN,56,15^FDPOINT^FS^FO610,20^ADN,36,20^FDTUR-BUS^FS^FO640,50^ADN,26,20^FDCARGO^FS^FO40,75^GB750,1,1^FS^FO70,210^APB,30,30^FDNORMAL^FS^FO720,250^APB,30,30^FDWEB^FS^FO40,565^GB750,1,1^FS^FO40,465^GB750,1,1^FS^FO30,565^GB750,1,1^FS^FO40,140^GB750,1,1^FS^FO40,410^GB750,1,1^FS^FO40,415^ABN,15,10^FDDIRECCIÓN:^FS^FO40,470^ABN,15,10^FDDESTINATARIO:^FS^FO40,515^GB750,1,1^FS^FO40,520^ABN,15,10^FDOBSERVACION:^FS^FO630,520^ABN,15,10^FDTELEFONO:^FS^FO40,575^ABN,15,10^FDREGION Y^FS^FO40,590^ABN,15,10^FDCOMUNA^FS^FO40,620^ABN,15,10^FDAGENCIA^FS^FO40,635^ABN,15,10^FDDESTINO^FS^FO630,575^ABN,15,10^FDBULTO:^FS^FO630,630^ABN,15,10^FDRAMPA:^FS^FO280,20^ASN,36,20^FDR13 SANTIAGO^FS^FO280,55^ABN,15,10^FD1467 CENTRO DISTRIBUCION S.B.^FS^FO40,90^ATN,56,15^FDPIN: 201592^FS^FO390,85^ABN,15,10^FDREFERENCIA:^FS^FO380,95^ATN,56,15^FD^FS^FO640,85^ABN,15,10^FD31-08-2015^FS^FO640,99^APN,15,10^FDCTA.CTE. 41101-9^FS^FO640,115^APN,15,10^FDR.U.T. 76434414-6^FS^FO150,160^BY3^BCN,200,Y,N,N,A^FD92014672821467900481274001^FS^FO40,430^AQN,10,10^FDJOSE MANUEL INFANTE 2320, DEPTO 164 TORRE A, NUNOA, SANTIAGO^FS^FO40,485^AQN,10,10^FDEASYPOINT CAFETERIA AMARANTO^FS^FO40,535^APN,15,10^FDACCESO PASAJE LATERAL^FS^FO630,535^APN,15,10^FD 56 95 1261107^FS^FO110,570^ASN,36,20^FDR13 LAS CONDES DOMICILIO^FS^FO110,620^ACN,26,10^FD1467 CENTRO DISTRIBUCION^FS^FO630,590^ASN,15,10^FD001/001^FS^FO690,625^ASN,15,10^FD82^FS^XZ";
$zpl = $zpl.$zpl.$zpl;

echo $url_api.$zpl;


//$zpl = "^xa^cfa,50^fo100,100^fdHello World^fs^xz";

$curl = curl_init();
// adjust print density (8dpmm), label width (4 inches), label height (6 inches), and label index (0) as necessary
//curl_setopt($curl, CURLOPT_URL, "http://api.labelary.com/v1/printers/8dpmm/labels/4x6/0/");
curl_setopt($curl, CURLOPT_URL, $url_api);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $zpl);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/pdf")); // omit this line to get PNG images back
$result = curl_exec($curl);

if (curl_getinfo($curl, CURLINFO_HTTP_CODE) == 200) {
    $file = fopen("labelx3.pdf", "a+"); // change file name for PNG images
    fwrite($file, $result.$result);
    fclose($file);
    print_r("Ok: $result");
} else {
    print_r("Error: $result");
}

curl_close($curl);

?>
