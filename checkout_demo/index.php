<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<!-- Add jQuery library -->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="./fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="./fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="./fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="./fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="./fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="./fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

<link rel="stylesheet" href="./fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="./fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

<script type="text/javascript">
var choosen_ep = false;
var ep_code = false;
var ep_name = false;
var ep_address = false;
var ep_city_municipality = false;

$(document).ready(function(){
	$("input").click(function(){
    choosen_ep = false;
		// Get the clicked radio button option.
    $radio = $(this);
		//alert($(this).attr('name'));
    if ($radio.val() == 'EasyPoint') {
      $.fancybox({
				'scrolling'						: 'no',
				'width'								: 300,
				'height'							: 200,
				'type'								: 'iframe',
				'showCloseButton'			: true,
				'showIframeLoading' 	: true,
				'enableEscapeButton' 	: true,
				'titleShow'						: false,
				'href'								: 'lightbox.php',

        beforeClose: function () {
          if (choosen_ep == false) {
            alert('Ha cancelado sin escoger un EasyPoint.\nSe deshabilitará la selección de EasyPoint como punto de retiro.');
            $radio.attr('checked', false);
						if ($('#display_choosen_ep').html()) {
							jQuery('#display_choosen_ep').remove();
						}
          }
        ;}

			});
    } else if ($('#display_choosen_ep').html()) {
			jQuery('#display_choosen_ep').remove();
		}
  });
});

function seleccion_easypoint() {
// Getting choosen ep attributes.
	ep_code = $('.fancybox-iframe').contents().find('#selector_ep').val();
	ep_name = $('.fancybox-iframe').contents().find('#choosen_ep').html();
	ep_address = $('.fancybox-iframe').contents().find('#selector_ep :selected').text();
	ep_city_municipality = $('.fancybox-iframe').contents().find('#selector_area').val();

	choosen_ep = true;
	var $p_choosen_ep = '<div id="display_choosen_ep"><h6>Delivery to:</h6><table class="resume table table-bordered"><tr><td><h4><p><strong>';
	$p_choosen_ep = $p_choosen_ep + ep_name + ': ' + ep_address + ', ' + ep_city_municipality;
	$p_choosen_ep = $p_choosen_ep + '</strong></p></h4></td></tr></table>';

// Explanation begins
	$p_choosen_ep = $p_choosen_ep + '<blockquote>The EasyPoint selection must replace:<br><h6><samp>Address 1 field = easypoint code {' + ep_code + '}<br>';
	$p_choosen_ep = $p_choosen_ep + 'Address 2 field = easypoint address {' + ep_address + ', ' + ep_city_municipality + '}</samp></h6></blockquote>';
// Explanation ends

	$p_choosen_ep = $p_choosen_ep + '<div>';

	if ($('#display_choosen_ep').html()) {
		jQuery('#display_choosen_ep').remove();
	}

	jQuery('.delivery_options_address').append($p_choosen_ep);
	$.fancybox.close();

	$.ajax({
	  type: 'POST',
	   url: baseDir+'modules/easypoint/ajax.php',
  	   data: { cart_id: "{$cart_id}", id_customer: "{$id_customer}" , monto: "{$monto}" , destino_easypoint: $('#fancybox-frame').contents().find('#selector_ep').val() },
	   success: function(data){


			 jQuery('.delivery_options_address').append($p_choosen_ep);
	   		//$('input:submit[name=processCarrier]').click();
	   		$.fancybox.close();
	   },
	   error: function(XMLHttpRequest, textStatus, errorThrown){
	   		alert('Se ha producido un error al intentar enviar los datos, por favor intente nuevamente: ' + XMLHttpRequest + '\n' + 'Estado: ' + textStatus);
	   }
	});
}

</script>
<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

<div class='row'>
	<div class='col-md-12'>
		<h4 class="text-center">Delivery Address step on shopping cart</h4>
		<div class='col-md-4'></div>
		<div class='col-md-4'>
			<div class="form-group">
				<label for="region">Address field</label>
				<input class='form-control' id='add1' type='text' name='region' value='Vitacura 2271' readonly="true"/>
			</div>
			<div class="form-group">
				<label for="region">Address 2 field</label>
				<input class='form-control' id='add2' type='text' name='region' value='office 405, Las Condes' readonly="true"/>
			</div>
		</div>

	</div>
</div>
<div class='row'>
  <div class='col-md-12'>
    <h4 class="text-center">Shipping Method step on shopping cart</h4>
  </div>
</div>
<div class='row'>
  <div class='col-md-4'>
    <p class="text-center"></p>
  </div>
  <div class='col-md-4'>
    <div class="radio">
      <label>
        <input type="radio" name="optionsRadios" id="Other" value="Other" checked>
        Home delivery to the delivery address
      </label>
    </div>
    <div class="radio">
      <label>
        <input type="radio" name="optionsRadios" id="EasyPoint" value="EasyPoint">
        EasyPoint delivery
      </label>
    </div>
  </div>
</div>
<div class='row'>
	<div class='col-md-4'>
		<p class="text-center"></p>
	</div>
	<div class='col-md-4'>
		<div class='delivery_options_address'>
		</div>
	</div>
</div>
