// funcion que carga preview de etiquetas
 function preview (div,page,params) {
    var element = document.getElementById(div);
    var url = page + "?";
    var get_params;
    var temp;
    var i=0;
    form=document.createElement('form');
	  form.method = 'GET';
	  form.action = page;
	  form.name = 'jsform';
	  for (index in params)
	  {
			var input = document.createElement('input');
			input.type='hidden';
      if (page == 'printerslist.php') {
        temp = 'p';
        temp = temp.concat(i);
        i++;
        input.name=temp;
        input.id=temp;
      }
      else {
        temp = index;
        input.name=temp;
  			input.id=temp;
      }
			input.value=params[index];
			form.appendChild(input);
      if (get_params != null) {
        get_params = get_params + temp + "=" + params[index] + "&";
      } else {
          get_params = temp + "=" + params[index] + "&";
      }
	  }
    element.appendChild(form);
    url = url + encodeURI(get_params);
    $(element).load(url);
    // Imprimir en patalla la URL
    //document.write(url);
 }

 // funcion que carga los controles select
 function loadSelect (sControl, options) {
   if (sControl == null || options == null)  {
     alert_error('loadSelect()','parametros nulos');
     return null;
   } else {
     var select = document.getElementById(sControl);
     for (index in options) {
       select.options[select.options.length] = new Option(options[index], options[index]);
     }
     select.options[0].selected = true;
     select.disabled = false;
   }
   return null;
 }

 // funcion que recarga el preview en funcion del tipo de impresion seleccionada (RAW o HTML)
 function loadPreview(sControl) {
   if (sControl == null) {
     alert_error('loadPreview()','parametro nulo');
     return null;
   } else {
     var select = document.getElementById(sControl);
     var pMode = select.options[select.selectedIndex].value;
     if (pMode == "RAW (Zebra)") {
       preview('variableDivContent','multilabel.php',{'region':region,'centro':centro,'pin':pin,'referencia':ref,'fecha':date,'barcode':barcode,'dire':dire,'destinatario':dest,'obs':obs,'fono':fono,'comuna':comuna,'agencia':agencia,'bulto':bulto,'rampa':rampa,'printer':'raw','labels':labels});
       var select2 = document.getElementById('comboSelectPrinters');
       select2.disabled = false;
     } else if (pMode == "HTML Directo") {
       preview('variableDivContent','multilabel.php',{'region':region,'centro':centro,'pin':pin,'referencia':ref,'fecha':date,'barcode':barcode,'dire':dire,'destinatario':dest,'obs':obs,'fono':fono,'comuna':comuna,'agencia':agencia,'bulto':bulto,'rampa':rampa,'printer':'html','labels':labels});
       var select2 = document.getElementById('comboSelectPrinters');
       select2.disabled = false;
     } else {
       preview('variableDivContent','multilabel.php',{'region':region,'centro':centro,'pin':pin,'referencia':ref,'fecha':date,'barcode':barcode,'dire':dire,'destinatario':dest,'obs':obs,'fono':fono,'comuna':comuna,'agencia':agencia,'bulto':bulto,'rampa':rampa,'printer':'html','labels':labels});
       var select2 = document.getElementById('comboSelectPrinters');
       select2.disabled = true;
     }
   }
   return null;
 }

 // funcion que recibe errores, los formatea y los despliega en pantala
 function alert_error (fn, message) {
   var log_error = 'error en funcion ';
   log_error = log_error.concat(String(fn));
   log_error = log_error.concat(':');
   log_error = log_error.concat(String(message));
   alert(log_error);
   return null;
 }
