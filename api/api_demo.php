<?php

// Creacion de envios.
echo('<br><p>CREATE SHIPMENT</p>');
$url = "http://www.easypoint.cl";
$url = $url."/ws/api/create_shipment";

$fields_string = '';
$fields = array(

    'CustomerCode' => urlencode('ACME'), //Codigo unico de cliente, ID de Beerly.
    'ExtID' => urlencode(''), //Codigo de envio externo, informado desde plataforma cliente. Ej: nro de orde de venta.
    'SenderID' => urlencode('WH001'), //Codigo de bodega. Utilizado para obtener datos de direccion de retiro de productos.
    'SenderAddress' => urlencode(''), //Direccion de retiro en caso de no indicar bodega.
    'SenderProvince' => urlencode(''), //Comuna de retiro en caso de no indicar bodega.
    'CustomerName1' => urlencode('Victor Hugo'), //Nombre de cliente.
    'CustomerName2' => urlencode('Avila Moncada'),//Apellido de cliente.
    'MobileNumber' => urlencode('51261107'),//Numero de telefono 8 digitos. No informar 56 9
    'Email' => urlencode('victorhugo.avila.cl@gmail.com'),//Mail de destinatario.
    'ParcelNumber' => urlencode('1'),//Numero de paquetes del envio.
    'DestinationID' => urlencode('DOM'),//EasyPoint destino. Si va a un domicilio indicar 'DOM'.
    'DestinationName' => urlencode(''),//Campo no utilizado. Debe ir vacio.
    'DestinationAddress' => urlencode('Jose Manuel Infante 2320, Depto. 2320, Torre Arrayan'),//Direccion destino cuando envio es DOM.
    'DestinationProvince' => urlencode('NUNOA'),//Comuna destino cuando envio es DOM.
    'ProductDescription' => urlencode('mp3 sony'),//Descripcion de producto.
    'ProductPrice' => urlencode('9990'),//Precio de producto.
    'ShipmentInfo1' => urlencode('ipod nano'),//Observacion adicional.
    'ShipmentInfo1' => urlencode('verde'),//Segunda observacion adicional.
    'CreateLabel' => urlencode('0'),//Parametro para creacion de etiqueta.
    'ShippingProduct' => urlencode('paquete')
);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$headers = array(
    'access_token: ' . '4aHDmGpjdNET5tA5FXBrM9bjv74S6IJ0',
);

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      $result = curl_exec($ch);
      curl_close($ch);

// Tracking de envios
echo('<br><p>TRACKING</p>');
$url = "http://www.easypoint.cl";
$url = $url."/ws/api/tracking";

$fields_string = '';
$fields = null;
$fields = array(
    'EcommerceCode' => urlencode('ACME'),
    'OrderNumber' => urlencode('202342'),
);

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
$headers = array(
    'access_token: ' . '4aHDmGpjdNET5tA5FXBrM9bjv74S6IJ0',
);

curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch,CURLOPT_POST, count($fields));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
      $result = curl_exec($ch);
      curl_close($ch);

echo($result);
