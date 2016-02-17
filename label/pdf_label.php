<?php

$url_api = "http://api.labelary.com/v1/printers/8dpmm/labels/3.98x3.35/0/";
$zpl = "%5EXA%5EFO40,25%5EADN,44,15%5EFDEASY%5EFS%5EFO140,20%5EATN,56,15%5EFDPOINT%5EFS%5EFO610,20%5EADN,36,20%5EFDTUR-BUS%5EFS%5EFO640,50%5EADN,26,20%5EFDCARGO%5EFS%5EFO40,75%5EGB750,1,1%5EFS%5EFO70,210%5EAPB,30,30%5EFDNORMAL%5EFS%5EFO720,250%5EAPB,30,30%5EFDWEB%5EFS%5EFO40,565%5EGB750,1,1%5EFS%5EFO40,465%5EGB750,1,1%5EFS%5EFO30,565%5EGB750,1,1%5EFS%5EFO40,140%5EGB750,1,1%5EFS%5EFO40,410%5EGB750,1,1%5EFS%5EFO40,415%5EABN,15,10%5EFDDIRECCI%C3%93N:%5EFS%5EFO40,470%5EABN,15,10%5EFDDESTINATARIO:%5EFS%5EFO40,515%5EGB750,1,1%5EFS%5EFO40,520%5EABN,15,10%5EFDOBSERVACION:%5EFS%5EFO630,520%5EABN,15,10%5EFDTELEFONO:%5EFS%5EFO40,575%5EABN,15,10%5EFDREGION%20Y%5EFS%5EFO40,590%5EABN,15,10%5EFDCOMUNA%5EFS%5EFO40,620%5EABN,15,10%5EFDAGENCIA%5EFS%5EFO40,635%5EABN,15,10%5EFDDESTINO%5EFS%5EFO630,575%5EABN,15,10%5EFDBULTO:%5EFS%5EFO630,630%5EABN,15,10%5EFDRAMPA:%5EFS%5EFO280,20%5EASN,36,20%5EFDR13%20SANTIAGO%5EFS%5EFO280,55%5EABN,15,10%5EFD1467%20CENTRO%20DISTRIBUCION%20S.B.%5EFS%5EFO40,90%5EATN,56,15%5EFDPIN:%20201592%5EFS%5EFO390,85%5EABN,15,10%5EFDREFERENCIA:%5EFS%5EFO380,95%5EATN,56,15%5EFD%5EFS%5EFO640,85%5EABN,15,10%5EFD31-08-2015%5EFS%5EFO640,99%5EAPN,15,10%5EFDCTA.CTE.%2041101-9%5EFS%5EFO640,115%5EAPN,15,10%5EFDR.U.T.%2076434414-6%5EFS%5EFO150,160%5EBY3%5EBCN,200,Y,N,N,A%5EFD92014672821467900481274001%5EFS%5EFO40,430%5EAQN,10,10%5EFDJOSE%20MANUEL%20INFANTE%202320,%20DEPTO%20164%20TORRE%20A,%20NUNOA,%20SANTIAGO%5EFS%5EFO40,485%5EAQN,10,10%5EFDEASYPOINT%20CAFETERIA%20AMARANTO%5EFS%5EFO40,535%5EAPN,15,10%5EFDACCESO%20PASAJE%20LATERAL%5EFS%5EFO630,535%5EAPN,15,10%5EFD%2056%2095%201261107%5EFS%5EFO110,570%5EASN,36,20%5EFDR13%20LAS%20CONDES%20DOMICILIO%5EFS%5EFO110,620%5EACN,26,10%5EFD1467%20CENTRO%20DISTRIBUCION%5EFS%5EFO630,590%5EASN,15,10%5EFD001/001%5EFS%5EFO690,625%5EASN,15,10%5EFD82%5EFS%5EXZ";
//$url_api = $url_api.$zpl;


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
    $file = fopen("label.pdf", "w"); // change file name for PNG images
    fwrite($file, $result);
    fclose($file);
} else {
    print_r("Error: $result");
}

curl_close($curl);

?>
