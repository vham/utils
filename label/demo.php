<html>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
  <title>EasyPoint Label Printing Demo</title>

  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
  <link href='css/gprint.css' rel='stylesheet'>
</head>

<body>
  <div class='row'>
    <div class='head'>
      <div class='col-md-12'>
        <h2 class="text-center">Test de impresi&oacuten</h2>
      </div>
    </div>
  </div>
  <div class='row'>
    <br>
  </div>
  <div class='row'>
    <div class='col-md-4'>
      <p class="text-center"></p>
    </div>
    <div>
      <div class='col-md-4'>
        <p class="text-center">Datos para etiqueta de prueba</p>
        <form action='multilabel.php' method='get' target='_blank'>
          <div class="form-group">
            <label for="region">Region-ciudad:</label>
            <input class='form-control' id='region' type='text' name='region' value='R13 SANTIAGO'/>
          </div>
          <div class="form-group">
            <label for="centro">Centro de distribuci&oacuten:</label>
            <input class='form-control' id='centro' type='text' name='centro' value='1467 CENTRO DISTRIBUCION S.B.'/>
          </div>
          <div class="form-group">
            <label for="pin">PIN:</label>
            <input class='form-control' id='pin' type='text' name='pin' value='1870'/>
          </div>
          <div class="form-group">
            <label for="referencia">Referencia:</label>
            <input class='form-control' id='referencia' type='text' name='referencia' value='201592'/>
          </div>
          <div class="form-group">
            <label for="pin">Fecha:</label>
            <input class='form-control' id='fecha' type='text' name='fecha' value='31-08-2015'/>
          </div>
          <div class="form-group">
            <label for="ctacte">Cta-cte:</label>
            <input class='form-control' id='ctacte' type='text' name='ctacte' value='41101-9'/>
          </div>
          <div class="form-group">
            <label for="rut">Rut:</label>
            <input class='form-control' id='rut' type='text' name='rut' value='76434414-6'/>
          </div>
          <div class="form-group">
            <label for="Barcode">Barcode:</label>
            <input class='form-control' id='barcode' type='text' name='barcode' value='92014672821467900481274001'/>
          </div>
          <div class="form-group">
            <label for="dire">Direcci&oacute;n:</label>
            <input class='form-control' id='dire' type='text' name='dire' value='JOSE MANUEL INFANTE 2320, DEPTO 164 TORRE A, NUNOA, SANTIAGO'/>
          </div>
          <div class="form-group">
            <label for="destinatario">Destinatario:</label>
            <input class='form-control' id='destinatario' type='text' name='destinatario' value='EASYPOINT CAFETERIA AMARANTO'/>
          </div>
          <div class="form-group">
            <label for="obs">Observaci&oacute;n:</label>
            <input class='form-control' id='obs' type='text' name='obs' value='ACCESO PASAJE LATERAL'/>
          </div>
          <div class="form-group">
            <label for="fono">fono:</label>
            <input class='form-control' id='fono' type='text' name='fono' value='+56 95 1261107'/>
          </div>
          <div class="form-group">
            <label for="comuna">Regi&oacute;n-comuna:</label>
            <input class='form-control' id='comuna' type='text' name='comuna' value='R13 LAS CONDES DOMICILIO'/>
          </div>
          <div class="form-group">
            <label for="bulto">Bulto:</label>
            <input class='form-control' id='bulto' type='text' name='bulto' value='001/001'/>
          </div>
          <div class="form-group">
            <label for="agencia">Agencia-destino:</label>
            <input class='form-control' id='agencia' type='text' name='agencia' value='1467 CENTRO DISTRIBUCION'/>
          </div>
          <div class="form-group">
            <label for="rampa">Rampa:</label>
            <input class='form-control' id='rampa' type='text' name='rampa' value='82'/>
          </div>
          <div class="form-group" type="hidden">
            <input type="hidden" class='form-control' id='printer' type='text' name='printer' value='html'/>
          </div>
          <div class="labels">
            <label for="labels">N&uacute;mero de etiquetas (Para prueba):</label>
            <input class='form-control' id='labels' type='text' name='labels' value='6'/>
          </div>
          <button type="submit" class="btn btn-success">Imprimir</button>
        </form>
      </div>
    </div>
  </div>
</html>
