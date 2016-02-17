<html lang='es'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=windows-1252'>
  <title>EasyPoint Label Printing Demo</title>

  <link href='css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
  <link href='css/gprint.css' rel='stylesheet'>
	<link href="css/multiprint.css" media="print" rel="stylesheet" type="text/css"/>

  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
  <script type="text/javascript" src="js/gprint.js"></script>
  <script type="text/javascript" src="js/deployJava.js"></script>
  <script type="text/javascript" src="js/qz-websocket.js"></script>
  <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="js/html2canvas.js"></script>
  <script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>

  <script type="text/javascript">

    function deployQZApplet() {
        console.log('Starting deploy of qz applet');

        var attributes = {id: "qz", code:'qz.PrintApplet.class',
            archive:'./qz-print.jar', width:1, height:1};
        var parameters = {jnlp_href: './qz-print_jnlp.jnlp',
            cache_option:'plugin', disable_logging:'false',
            initial_focus:'false', separate_jvm:'true'};
        if (deployJava.versionCheck("1.7+") == true) {}
        else if (deployJava.versionCheck("1.6.0_45+") == true) {}
        else if (deployJava.versionCheck("1.6+") == true) {
            delete parameters['jnlp_href'];
        }
        deployJava.runApplet(attributes, parameters, '1.6');
    }

    function getCertificate(callback) {
        /*
        $.ajax({
            method: 'GET',
            url: 'assets/auth/public-key.txt',
            async: false,
            success: callback // Data returned from ajax call should be the site certificate
        });
        */

        //Non-ajax method, only include public key and intermediate key
        callback("-----BEGIN CERTIFICATE-----\n" +
            "MIIFAzCCAuugAwIBAgICEAIwDQYJKoZIhvcNAQEFBQAwgZgxCzAJBgNVBAYTAlVT\n" +
            "MQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0cmllcywgTExDMRswGQYD\n" +
            "VQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMMEHF6aW5kdXN0cmllcy5j\n" +
            "b20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1c3RyaWVzLmNvbTAeFw0x\n" +
            "NTAzMTkwMjM4NDVaFw0yNTAzMTkwMjM4NDVaMHMxCzAJBgNVBAYTAkFBMRMwEQYD\n" +
            "VQQIDApTb21lIFN0YXRlMQ0wCwYDVQQKDAREZW1vMQ0wCwYDVQQLDAREZW1vMRIw\n" +
            "EAYDVQQDDAlsb2NhbGhvc3QxHTAbBgkqhkiG9w0BCQEWDnJvb3RAbG9jYWxob3N0\n" +
            "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtFzbBDRTDHHmlSVQLqjY\n" +
            "aoGax7ql3XgRGdhZlNEJPZDs5482ty34J4sI2ZK2yC8YkZ/x+WCSveUgDQIVJ8oK\n" +
            "D4jtAPxqHnfSr9RAbvB1GQoiYLxhfxEp/+zfB9dBKDTRZR2nJm/mMsavY2DnSzLp\n" +
            "t7PJOjt3BdtISRtGMRsWmRHRfy882msBxsYug22odnT1OdaJQ54bWJT5iJnceBV2\n" +
            "1oOqWSg5hU1MupZRxxHbzI61EpTLlxXJQ7YNSwwiDzjaxGrufxc4eZnzGQ1A8h1u\n" +
            "jTaG84S1MWvG7BfcPLW+sya+PkrQWMOCIgXrQnAsUgqQrgxQ8Ocq3G4X9UvBy5VR\n" +
            "CwIDAQABo3sweTAJBgNVHRMEAjAAMCwGCWCGSAGG+EIBDQQfFh1PcGVuU1NMIEdl\n" +
            "bmVyYXRlZCBDZXJ0aWZpY2F0ZTAdBgNVHQ4EFgQUpG420UhvfwAFMr+8vf3pJunQ\n" +
            "gH4wHwYDVR0jBBgwFoAUkKZQt4TUuepf8gWEE3hF6Kl1VFwwDQYJKoZIhvcNAQEF\n" +
            "BQADggIBAFXr6G1g7yYVHg6uGfh1nK2jhpKBAOA+OtZQLNHYlBgoAuRRNWdE9/v4\n" +
            "J/3Jeid2DAyihm2j92qsQJXkyxBgdTLG+ncILlRElXvG7IrOh3tq/TttdzLcMjaR\n" +
            "8w/AkVDLNL0z35shNXih2F9JlbNRGqbVhC7qZl+V1BITfx6mGc4ayke7C9Hm57X0\n" +
            "ak/NerAC/QXNs/bF17b+zsUt2ja5NVS8dDSC4JAkM1dD64Y26leYbPybB+FgOxFu\n" +
            "wou9gFxzwbdGLCGboi0lNLjEysHJBi90KjPUETbzMmoilHNJXw7egIo8yS5eq8RH\n" +
            "i2lS0GsQjYFMvplNVMATDXUPm9MKpCbZ7IlJ5eekhWqvErddcHbzCuUBkDZ7wX/j\n" +
            "unk/3DyXdTsSGuZk3/fLEsc4/YTujpAjVXiA1LCooQJ7SmNOpUa66TPz9O7Ufkng\n" +
            "+CoTSACmnlHdP7U9WLr5TYnmL9eoHwtb0hwENe1oFC5zClJoSX/7DRexSJfB7YBf\n" +
            "vn6JA2xy4C6PqximyCPisErNp85GUcZfo33Np1aywFv9H+a83rSUcV6kpE/jAZio\n" +
            "5qLpgIOisArj1HTM6goDWzKhLiR/AeG3IJvgbpr9Gr7uZmfFyQzUjvkJ9cybZRd+\n" +
            "G8azmpBBotmKsbtbAU/I/LVk8saeXznshOVVpDRYtVnjZeAneso7\n" +
            "-----END CERTIFICATE-----\n" +
            "--START INTERMEDIATE CERT--\n" +
            "-----BEGIN CERTIFICATE-----\n" +
            "MIIFEjCCA/qgAwIBAgICEAAwDQYJKoZIhvcNAQELBQAwgawxCzAJBgNVBAYTAlVT\n" +
            "MQswCQYDVQQIDAJOWTESMBAGA1UEBwwJQ2FuYXN0b3RhMRswGQYDVQQKDBJRWiBJ\n" +
            "bmR1c3RyaWVzLCBMTEMxGzAZBgNVBAsMElFaIEluZHVzdHJpZXMsIExMQzEZMBcG\n" +
            "A1UEAwwQcXppbmR1c3RyaWVzLmNvbTEnMCUGCSqGSIb3DQEJARYYc3VwcG9ydEBx\n" +
            "emluZHVzdHJpZXMuY29tMB4XDTE1MDMwMjAwNTAxOFoXDTM1MDMwMjAwNTAxOFow\n" +
            "gZgxCzAJBgNVBAYTAlVTMQswCQYDVQQIDAJOWTEbMBkGA1UECgwSUVogSW5kdXN0\n" +
            "cmllcywgTExDMRswGQYDVQQLDBJRWiBJbmR1c3RyaWVzLCBMTEMxGTAXBgNVBAMM\n" +
            "EHF6aW5kdXN0cmllcy5jb20xJzAlBgkqhkiG9w0BCQEWGHN1cHBvcnRAcXppbmR1\n" +
            "c3RyaWVzLmNvbTCCAiIwDQYJKoZIhvcNAQEBBQADggIPADCCAgoCggIBANTDgNLU\n" +
            "iohl/rQoZ2bTMHVEk1mA020LYhgfWjO0+GsLlbg5SvWVFWkv4ZgffuVRXLHrwz1H\n" +
            "YpMyo+Zh8ksJF9ssJWCwQGO5ciM6dmoryyB0VZHGY1blewdMuxieXP7Kr6XD3GRM\n" +
            "GAhEwTxjUzI3ksuRunX4IcnRXKYkg5pjs4nLEhXtIZWDLiXPUsyUAEq1U1qdL1AH\n" +
            "EtdK/L3zLATnhPB6ZiM+HzNG4aAPynSA38fpeeZ4R0tINMpFThwNgGUsxYKsP9kh\n" +
            "0gxGl8YHL6ZzC7BC8FXIB/0Wteng0+XLAVto56Pyxt7BdxtNVuVNNXgkCi9tMqVX\n" +
            "xOk3oIvODDt0UoQUZ/umUuoMuOLekYUpZVk4utCqXXlB4mVfS5/zWB6nVxFX8Io1\n" +
            "9FOiDLTwZVtBmzmeikzb6o1QLp9F2TAvlf8+DIGDOo0DpPQUtOUyLPCh5hBaDGFE\n" +
            "ZhE56qPCBiQIc4T2klWX/80C5NZnd/tJNxjyUyk7bjdDzhzT10CGRAsqxAnsjvMD\n" +
            "2KcMf3oXN4PNgyfpbfq2ipxJ1u777Gpbzyf0xoKwH9FYigmqfRH2N2pEdiYawKrX\n" +
            "6pyXzGM4cvQ5X1Yxf2x/+xdTLdVaLnZgwrdqwFYmDejGAldXlYDl3jbBHVM1v+uY\n" +
            "5ItGTjk+3vLrxmvGy5XFVG+8fF/xaVfo5TW5AgMBAAGjUDBOMB0GA1UdDgQWBBSQ\n" +
            "plC3hNS56l/yBYQTeEXoqXVUXDAfBgNVHSMEGDAWgBQDRcZNwPqOqQvagw9BpW0S\n" +
            "BkOpXjAMBgNVHRMEBTADAQH/MA0GCSqGSIb3DQEBCwUAA4IBAQAJIO8SiNr9jpLQ\n" +
            "eUsFUmbueoxyI5L+P5eV92ceVOJ2tAlBA13vzF1NWlpSlrMmQcVUE/K4D01qtr0k\n" +
            "gDs6LUHvj2XXLpyEogitbBgipkQpwCTJVfC9bWYBwEotC7Y8mVjjEV7uXAT71GKT\n" +
            "x8XlB9maf+BTZGgyoulA5pTYJ++7s/xX9gzSWCa+eXGcjguBtYYXaAjjAqFGRAvu\n" +
            "pz1yrDWcA6H94HeErJKUXBakS0Jm/V33JDuVXY+aZ8EQi2kV82aZbNdXll/R6iGw\n" +
            "2ur4rDErnHsiphBgZB71C5FD4cdfSONTsYxmPmyUb5T+KLUouxZ9B0Wh28ucc1Lp\n" +
            "rbO7BnjW\n" +
            "-----END CERTIFICATE-----\n");
    }

    function signRequest(toSign, callback) {
        /*
        $.ajax({
            method: 'GET',
            contentType: "text/plain",
            url: '/secure/url/for/sign-message.php?request=' + toSign,
            async: false,
            success: callback // Data returned from ajax call should be the signature
        });
        */

        //Send unsigned messages to socket - users will then have to Allow/Deny each print request
        callback();
    }

    /**
     * Automatically gets called when applet has loaded.
     */
    function qzReady() {
        // If the qz object hasn't been created, fallback on the <applet> tags
        if (!qz) {
            window["qz"] = document.getElementById('qz');
        }
        //var title = document.getElementById("title");
        if (qz) {
            try {
                document.getElementById("qz-status").style.background = "#FF8000";
            } catch(err) { // LiveConnect error, display a detailed message
                document.getElementById("qz-status").style.background = "#F5A9A9";
                alert("ERROR:  \nThe applet did not load correctly.  Communication to the " +
                        "applet has failed, likely caused by Java Security Settings.  \n\n" +
                        "CAUSE:  \nJava 7 update 25 and higher block LiveConnect calls " +
                        "once Oracle has marked that version as outdated, which " +
                        "is likely the cause.  \n\nSOLUTION:  \n  1. Update Java to the latest " +
                        "Java version \n          (or)\n  2. Lower the security " +
                        "settings from the Java Control Panel.");
            }
        }
    }

    function qzSocketError(event) {
        document.getElementById("qz-status").style.background = "#F5A9A9";
        console.log('Error:');
        console.log(event);

        alert("Connection had an error:\n"+ event.reason);
    }

    function qzSocketClose(event) {
        document.getElementById("qz-status").style.background = "#A0A0A0";
        console.log('Close:');
        console.log(event);

        alert("Su conexi\u00f3n se ha interrumpido:\n"+ event.reason);
    }

    function qzNoConnection() {
        alert("No es posible conectarse a QZ, verificar si el servicio est\u00e1 activo.");

        //run deploy applet After page load
        var content = '';
        var oldWrite = document.write;
        document.write = function(text) {
            content += text;
        };
        deployQZApplet();

        var newElem = document.createElement('ins');
        newElem.innerHTML = content;

        document.write = oldWrite;
        document.body.appendChild(newElem);
    }

    /**
     * Returns whether or not the applet is not ready to print.
     * Displays an alert if not ready.
     */
    function notReady() {
        // If applet is not loaded, display an error
        if (!isLoaded()) {
            alert('notReady - !isLoaded');
            return true;
        }
        // If a printer hasn't been selected, display a message.
        else if (!qz.getPrinter()) {
            alert('Por favor seleccione una impresora utilizando la opci\u00f3n  "Detecci\u00f3n de Impresora".');
            return true;
        }
        return false;
    }

    /**
     * Returns is the applet is not loaded properly
     */
    function isLoaded() {
        if (!qz) {
            alert('Error:\n\n\tPrint plugin is NOT loaded!');
                                    return false;
        } else {
            try {
                if (!qz.isActive()) {
                    alert('Error:\n\n\tPrint plugin is loaded but NOT active!');
                    return false;
                }
            } catch (err) {
                alert('Error:\n\n\tPrint plugin is NOT loaded properly!');
                return false;
            }
        }
        return true;
    }

    /**
     * Automatically gets called when "qz.print()" is finished.
     */
    function qzDonePrinting() {
        // Alert error, if any
        if (qz.getException()) {
            alert('Error printing:\n\n\t' + qz.getException().getLocalizedMessage());
            qz.clearException();
            return;
        }

        // Alert success message
        alert('Datos de inpresion exitosamente enviados a la cola: "' + qz.getPrinter() + '.');
    }

    /***************************************************************************
     * Prototype function for finding the "default printer" on the system
     * Usage:
     *    qz.findPrinter();
     *    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
     ***************************************************************************/
    /*function useDefaultPrinter() {
        if (isLoaded()) {
            // Searches for default printer
            qz.findPrinter();

            // Automatically gets called when "qz.findPrinter()" is finished.
            window['qzDoneFinding'] = function() {
                // Alert the printer name to user
                var printer = qz.getPrinter();
                alert(printer !== null ? 'Impresora por defecto encontrada: "' + printer + '"':
                'Impresora por defecto ' + 'no encontrada');

                // Remove reference to this function
                window['qzDoneFinding'] = null;
            };
        }
    }*/

    /***************************************************************************
     * Prototype function for finding the closest match to a printer name.
     * Usage:
     *    qz.findPrinter('zebra');
     *    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
     ***************************************************************************/
    /*function findPrinter(printerName) {
      if (printerName == null) {
        alert_error('findPrinter()','parametro nulo');
        return null;
      } else {
        if (isLoaded()) {
          // Searches for locally installed printer with specified name
          qz.findPrinter(printerName);

          // Automatically gets called when "qz.findPrinter()" is finished.
          window['qzDoneFinding'] = function() {
              g_buffer = qz.getPrinter();
              g_control = true;
              // Remove reference to this function
              window['qzDoneFinding'] = null;
          };
        }
      }
    }*/

    /***************************************************************************
     * Prototype function for listing all printers attached to the system
     * Usage:
     *    qz.findPrinter('\\{dummy_text\\}');
     *    window['qzDoneFinding'] = function() { alert(qz.getPrinters()); };
     ***************************************************************************/
     function findPrinters() {
       // implementa un ciclo de espera de respuesta para sincronizar con applet
       var timer = setInterval(function () {
         // implementa esucha
         if (document.readyState === "complete") {
           if (g_control != null) {
             // carga selector de impresoras
            if (g_buffer != null) {
              loadSelect('comboSelectPrinters',g_buffer);
              document.getElementById('submit1').disabled = false;
            }
             // resetea variables de control
             g_control = null;
             g_buffer = null;
             // mata proceso listener
             window.clearInterval(timer);
             //window.focus();
           } else {
             if (isLoaded()) {
                 // Searches for a locally installed printer
                 qz.findPrinter();

                 // Automatically gets called when "qz.findPrinter()" is finished.
                 window['qzDoneFinding'] = function() {
                     // Get the CSV listing of attached printers
                     var printers = qz.getPrinters().replace(/,/g, '\n');
                     g_buffer = printers.split('\n');
                     g_control = true;

                     // Remove reference to this function
                     window['qzDoneFinding'] = null;
                 }
             }
          }
        }
      }, 2000);
     }

    /***************************************************************************
     * Prototype function for printing raw ZPL commands
     * Usage:
     *    qz.append('^XA\n^FO50,50^ADN,36,20^FDHello World!\n^FS\n^XZ\n');
     *    qz.print();
     ***************************************************************************/
     function printZPL(zpl, printerName) {
      if (notReady()) { return; }

      // Send characters/raw commands to qz using "append"
      // This example is for ZPL.  Please adapt to your printer language
      // Hint:  Carriage Return = \r, New Line = \n, Escape Double Quotes= \"
      qz.findPrinter(printerName);

      // Automatically gets called when "qz.findPrinter()" is finished.
      window['qzDoneFinding'] = function() {
        qz.append(zpl);
        // Tell the applet to print.
        //document.write(zpl);

        qz.print();

        // Remove reference to this function
        window['qzDoneFinding'] = null;
      }
     }

    var region = "<?php echo($region = htmlspecialchars($_POST['region']))?>";
    var centro = "<?php echo($region = htmlspecialchars($_POST['centro']))?>";
    var pin = "<?php echo($region = htmlspecialchars($_POST['pin']))?>";
    var ref = "<?php echo($region = htmlspecialchars($_POST['referencia']))?>";
    var date = "<?php echo($region = htmlspecialchars($_POST['fecha']))?>";
    var barcode = "<?php echo($region = htmlspecialchars($_POST['barcode']))?>";
    var dire = "<?php echo($region = htmlspecialchars($_POST['dire']))?>";
    var dest = "<?php echo($region = htmlspecialchars($_POST['destinatario']))?>";
    var obs = "<?php echo($region = htmlspecialchars($_POST['obs']))?>";
    var fono = "<?php echo($region = htmlspecialchars($_POST['fono']))?>";
    var comuna = "<?php echo($region = htmlspecialchars($_POST['comuna']))?>";
    var agencia = "<?php echo($region = htmlspecialchars($_POST['agencia']))?>";
    var bulto = "<?php echo($region = htmlspecialchars($_POST['bulto']))?>";
    var rampa = "<?php echo($region = htmlspecialchars($_POST['rampa']))?>";
    var printer = "<?php echo($region = htmlspecialchars($_POST['printer']))?>";
    var labels = "<?php echo($region = htmlspecialchars($_POST['labels']))?>";
    var g_buffer = null;
    var g_control = null;

    var rut = "76434414-6";
    var ctacte = "41101-9";

    var url_api = "http://api.labelary.com/v1/printers/8dpmm/labels/3.98x3.35/0/";
    var zpl = "^XA^FO40,25^ADN,44,15^FDEASY^FS^FO140,20^ATN,56,15^FDPOINT^FS";
    zpl = zpl + "^FO610,20^ADN,36,20^FDTUR-BUS^FS^FO640,50^ADN,26,20^FDCA";
    zpl = zpl + "RGO^FS^FO40,75^GB750,1,1^FS^FO70,210^APB,30,30^FDNORMAL^";
    zpl = zpl + "FS^FO720,250^APB,30,30^FDWEB^FS^FO40,565^GB750,1,1^FS^FO";
    zpl = zpl + "40,465^GB750,1,1^FS^FO30,565^GB750,1,1^FS^FO40,140^GB750";
    zpl = zpl + ",1,1^FS^FO40,410^GB750,1,1^FS^FO40,415^ABN,15,10^FDDIREC";
    zpl = zpl + "CIÓN:^FS^FO40,470^ABN,15,10^FDDESTINATARIO:^FS^FO40,515^";
    zpl = zpl + "GB750,1,1^FS^FO40,520^ABN,15,10^FDOBSERVACION:^FS^FO630,";
    zpl = zpl + "520^ABN,15,10^FDTELEFONO:^FS^FO40,575^ABN,15,10^FDREGION";
    zpl = zpl + " Y^FS^FO40,590^ABN,15,10^FDCOMUNA^FS^FO40,620^ABN,15,10^";
    zpl = zpl + "FDAGENCIA^FS^FO40,635^ABN,15,10^FDDESTINO^FS^FO630,575^A";
    zpl = zpl + "BN,15,10^FDBULTO:^FS^FO630,630^ABN,15,10^FDRAMPA:^FS";
    zpl = zpl + "^FO280,20^ASN,36,20^FD";
    zpl = zpl + region;
    zpl = zpl + "^FS^FO280,55^ABN,15,10^FD";
    zpl = zpl + centro;
    zpl = zpl + "^FS^FO40,90^ATN,56,15^FDPIN: ";
    zpl = zpl + pin;
    zpl = zpl + "^FS^FO390,85^ABN,15,10^FDREFERENCIA:^FS";
    zpl = zpl + "^FO380,95^ATN,56,15^FD";
    zpl = zpl + ref;
    zpl = zpl + "^FS^FO640,85^ABN,15,10^FD";
    zpl = zpl + date;
    zpl = zpl + "^FS^FO640,99^APN,15,10^FDCTA.CTE. ";
    zpl = zpl + ctacte;
    zpl = zpl + "^FS^FO640,115^APN,15,10^FDR.U.T. ";
    zpl = zpl + rut;
    zpl = zpl + "^FS^FO150,160^BY3^BCN,200,Y,N,N,A^FD";
    zpl = zpl + barcode;
    zpl = zpl + "^FS^FO40,430^AQN,10,10^FD";
    zpl = zpl + dire;
    zpl = zpl + "^FS^FO40,485^AQN,10,10^FD";
    zpl = zpl + dest;
    zpl = zpl + "^FS^FO40,535^APN,15,10^FD";
    zpl = zpl + obs;
    zpl = zpl + "^FS^FO630,535^APN,15,10^FD";
    zpl = zpl + fono;
    zpl = zpl + "^FS^FO110,570^ASN,36,20^FD";
    zpl = zpl + comuna;
    zpl = zpl + "^FS^FO110,620^ACN,26,10^FD";
    zpl = zpl + agencia;
    zpl = zpl + "^FS^FO630,590^ASN,15,10^FD";
    zpl = zpl + bulto;
    zpl = zpl + "^FS^FO690,625^ASN,15,10^FD";
    zpl = zpl + rampa;
    zpl = zpl + "^FS^XZ\n";
    url_api = url_api + zpl;

    var zpl_ext;
    for (i = 0; i <= labels; i++) {
        zpl_ext = zpl_ext + zpl;
    }

    // Funcion que inicia conexion con la aplicacion QZ-Tray.
    // Detecta y carga el listado de impresoras del sistema.
    function init() {
      var pModeOptions = ["RAW (Zebra)","Impresora Normal"];
      loadSelect('comboSelectPrintMode',pModeOptions);
      loadPreview('comboSelectPrintMode');
      //window["deployQZ"] = typeof(deployQZ) == "function" ? deployQZ : deployQZApplet;

      //deployQZ();
      //findPrinters();
      loadPreview('raw')
    }

    function printLabels() {
      window.print();
    }
  </script>

</head>
<body lang=ES-TRAD style='tab-interval:35.4pt' onload='init()' >
  <div class="fixed_form" id="qz-status">
    <div class='row'>
      <div class='col-md-12'>
        <h4 class="text-center">Preferencias de impresi&oacuten</h4>
      </div>
    </div>
    <div class="form-group">
      <div class='row'>
        <div class='col-md-1'>
        </div>
        <div class='col-md-3'>
          <div class="form-group">
            <label for="Impresoras">Impresoras</label>
            <select class="form-control" name="comboSelectPrinters" id="comboSelectPrinters" disabled="true">
            </select>
          </div>
        </div>
        <div class='col-md-3'>
          <div class="form-group">
            <label for="Tipo">Tipo de impresi&oacuten</label>
            <select class="form-control" name="comboSelectPrintMode" id="comboSelectPrintMode" disabled="true" onchange="loadPreview('comboSelectPrintMode')">
            </select>
          </div>
        </div>
        <div class='col-md-3'>
          <button type="submit" class="btn btn-success btn-lg" id="submit1" onclick="printLabels()">Imprimir</button>
        </div>
        <div class='col-md-1'>
        </div>
      </div>
    </div>
  </div>
	<div class=MsoNormal id="variableDivContent">
  </div>
</body>
</html>

<!-- -->
