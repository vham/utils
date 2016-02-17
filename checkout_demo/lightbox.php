<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
class pudo
{
  public $name;
  public $address;
  public $city_municipality;
  public $code;
}

$context  = stream_context_create(array('http' => array('header' => 'Accept: application/xml')));
$url      = 'http://www.easypoint.cl/pudo/api';
$xml      = file_get_contents($url, false, $context);
$xml      = simplexml_load_string($xml);

if ($xml === false) {
    echo "Failed loading XML: ";
    foreach(libxml_get_errors() as $error) {
        echo "<br>", $error->message;
    }
} else {
  $municipality_list = array();
  $pudo_list = array();

  echo("<script type='text/javascript'>\n");
  echo("var pudos_list = [];\n");
  $i = 0;
  foreach($xml->marker as $record):
    $pudo = new pudo();
    foreach($record->attributes() as $name => $value):
      if ($name == 'name') {$pudo->name = htmlspecialchars($value);}
      if ($name == 'address') {$pudo->address = htmlspecialchars($value);}
      if ($name == 'city_municipality') {
        array_push($municipality_list, $value);
        $pudo->city_municipality = htmlspecialchars($value);
      }
      if ($name == 'code') {$pudo->code = htmlspecialchars($value);}
    endforeach;
    array_push($pudo_list, $pudo);
    echo("var pudo ={code:'".$pudo->code."',name:'".$pudo->name."', address:'".$pudo->address."', city_municipality:'".$pudo->city_municipality."'};\n");
    echo("pudos_list[".$i."] = pudo;\n");
    $i++;
    unset($pudo);
  endforeach;
  echo("</script>\n");

  $municipality_list = array_unique ($municipality_list);
  $data_muni = "<select id='selector_area' name='selector_area' onchange='selector_area();' class='form-control'>";
  foreach($municipality_list as $record) {
    $data_muni .= "<option value='$record' >".$record."</option>";
  }
  $data_muni .= "</select>";

  $data_ep = "<select id='selector_ep' name='selector_ep' onchange='selector_ep();' class='form-control'>";
  foreach($pudo_list as $pudo):
    if ($pudo->city_municipality == $municipality_list[0]) {
      $data_ep .= "<option value='$pudo->code' >".$pudo->address."</option>";
    }
  endforeach;
  $data_ep .= "</select>";

  $selected_ep = "<h4><strong><p id='choosen_ep' name='choosen_ep'>".$pudo_list[0]->name."</p></strong></h4>";
}
?>
<script type="text/javascript">
var select_area = document.getElementById('selector_area');
var select_ep = document.getElementById('selector_ep');
var ep_city_municipality = select_area.options[select_area.selectedIndex].value;
var ep_code = select_ep.options[select_ep.selectedIndex].value;
var ep_address = select_ep.options[select_ep.selectedIndex].text;
var ep_name = document.getElementById('choosen_ep').innerHTML;

// Function to reaload Select_ep according the area Selected.
  function selector_area() {
    select_ep = document.getElementById('selector_ep');
    select_ep.options.length = 0;

    // Getting the refreshing value of the Select.
    select_area = document.getElementById('selector_area');
    ep_city_municipality = select_area.options[select_area.selectedIndex].value;

    for (i = 0; i < pudos_list.length; i++) {
        if (pudos_list[i].city_municipality == ep_city_municipality) {
          select_ep.options[select_ep.options.length] = new Option(pudos_list[i].address, pudos_list[i].code);
        }
    }
    select_ep.options[0].selected = true;
    // Getting the refreshing value of the selected EP.
    ep_code = select_ep.options[select_ep.selectedIndex].value;
    ep_address = select_ep.options[select_ep.selectedIndex].text;

    selector_ep();
    return null;
  }
// Function to refresh the choosen ep name located in <p>.
  function selector_ep() {
    // Getting the refreshing value of the Select.
    select_ep = document.getElementById('selector_ep');
    var choosen_ep_name = document.getElementById('choosen_ep');

    for (i = 0; i < pudos_list.length; i++) {
        if (pudos_list[i].code == select_ep.options[select_ep.selectedIndex].value) {
          choosen_ep_name.innerHTML = pudos_list[i].name;
          break;
        }
    }
    // Getting the refreshing value of the <p>.
    ep_name = choosen_ep_name.innerHTML;
    return null;
  }
</script>

<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

<div id='matriz_easypoint' style='background-color: #ffffff;' class='fancybox'>
  <div class='row'>
    <div class='col-md-12'>
      <h4 class="text-center">Selecciona tu punto de retiro <br><a href="http://www.easypoint.cl" target="_blank"><img src="logo20px.jpg" title="EasyPoint" alt="EasyPoint"/>Easy<strong>Point</strong></a></h4>
    </div>
  </div>
  <div class='row'>
    <div class='col-md-4'>
      <p class="text-center"></p>
    </div>
    <div class='col-md-4'>
      <div class="form-group">
        <label for="selector_">Comuna:</label>
        <?php echo $data_muni; ?>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='col-md-4'>
      <p class="text-center"></p>
    </div>
    <div class='col-md-4'>
      <div class="form-group">
        <label for="selector_ep">EasyPoint:</label>
        <?php echo $data_ep; ?>
      </div>
    </div>
  </div>
  <div class='row'>
    <div class='col-md-4'>
      <p class="text-center"></p>
    </div>
    <div class='col-md-4'>
        <label for="choosen_ep">Nombre del punto de retiro:</label>
        <center>
          <?php echo $selected_ep; ?>
          <button type="submit" class="btn btn-success" name="enviar" value="Seleccionar punto EasyPoint" id="enviar" onclick="window.top.seleccion_easypoint();">Seleccionar Punto EasyPoint</button>
          <img src="reemp_direccion.png" title="EasyPoint" alt="EasyPoint"/>
      </center>
    </div>
  </div>
  <div class='row'>
    <center>
      <a href="http://www.easypoint.cl/index.php/epmap" target="_blank">D&oacutende hay un EasyPoint?<img src="logo.gif" title="EasyPoint" alt="EasyPoint"/></a>
    </center>
  </div>
