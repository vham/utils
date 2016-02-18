<html><!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE --><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Easypoint Label Print Plugin</title>
<script type="text/javascript" src="js/deployJava.js"></script>
<script type="text/javascript" src="js/qz-websocket.js"></script>
<script type="text/javascript">

/**
 * Re-use the new WebSockets deployment if available.  If not, fallback on the Oracle deployment
 */

 window["deployQZ"] = typeof(deployQZ) == "function" ? deployQZ : deployQZApplet;

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

 /**
  * Deploy tray version of QZ, or
  * Optionally used to deploy multiple versions of the applet for mixed
  * environments.  Oracle uses document.write(), which puts the applet at the
  * top of the page, bumping all HTML content down.
  */
 deployQZ();

 function getCertificate(callback) {

     $.ajax({
         method: 'GET',
         //url: 'assets/auth/public-key.txt',
         url: 'public-key.txt',
         async: false,
         success: callback // Data returned from ajax call should be the site certificate
     });


     //Non-ajax method, only include public key and intermediate key
     /*
     callback("-----BEGIN CERTIFICATE-----\n" +
         "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\n" +
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
         */
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
     var title = document.getElementById("title");
     if (qz) {
         try {
             //title.innerHTML = title.innerHTML + " " + qz.getVersion();
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
     alert('Datos de inpresión exitosamente enviados a la cola: "' + qz.getPrinter() + '.');
 }

 /***************************************************************************
  * Prototype function for finding the "default printer" on the system
  * Usage:
  *    qz.findPrinter();
  *    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
  ***************************************************************************/
 function useDefaultPrinter() {
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
 }


 /***************************************************************************
  * Prototype function for finding the closest match to a printer name.
  * Usage:
  *    qz.findPrinter('zebra');
  *    window['qzDoneFinding'] = function() { alert(qz.getPrinter()); };
  ***************************************************************************/
 function findPrinter(name) {
     // Get printer name from input box
     var p = document.getElementById('printer');
     if (name) {
         p.value = name;
     }

     if (isLoaded()) {
         // Searches for locally installed printer with specified name
         qz.findPrinter(p.value);

         // Automatically gets called when "qz.findPrinter()" is finished.
         window['qzDoneFinding'] = function() {
             var p = document.getElementById('printer');
             var printer = qz.getPrinter();

             // Alert the printer name to user
             alert(printer !== null ? 'Printer found: "' + printer +
             '" after searching for "' + p.value + '"' : 'Printer "' +
             p.value + '" not found.');

             // Remove reference to this function
             window['qzDoneFinding'] = null;
         };
     }
 }

 /***************************************************************************
  * Prototype function for listing all printers attached to the system
  * Usage:
  *    qz.findPrinter('\\{dummy_text\\}');
  *    window['qzDoneFinding'] = function() { alert(qz.getPrinters()); };
  ***************************************************************************/
 function findPrinters() {
     if (isLoaded()) {
         // Searches for a locally installed printer with a bogus name
         qz.findPrinter('\\{bogus_printer\\}');

         // Automatically gets called when "qz.findPrinter()" is finished.
         window['qzDoneFinding'] = function() {
             // Get the CSV listing of attached printers
             var printers = qz.getPrinters().replace(/,/g, '\n');
             alert(printers);

             // Remove reference to this function
             window['qzDoneFinding'] = null;
         };
     }
 }

 /***************************************************************************
  * Prototype function for printing raw ZPL commands
  * Usage:
  *    qz.append('^XA\n^FO50,50^ADN,36,20^FDHello World!\n^FS\n^XZ\n');
  *    qz.print();
  ***************************************************************************/
 function printZPL() {
     if (notReady()) { return; }

     // Send characters/raw commands to qz using "append"
     // This example is for ZPL.  Please adapt to your printer language
     // Hint:  Carriage Return = \r, New Line = \n, Escape Double Quotes= \"
     qz.append('^XA\n');
     qz.append('^FO50,50^ADN,36,20^FDPRINTED USING QZ PRINT PLUGIN ' + qz.getVersion() + '\n');
     qz.appendImage(getPath() + 'assets/img/image_sample_bw.png', 'ZPLII');

     // Automatically gets called when "qz.appendImage()" is finished.
     window['qzDoneAppending'] = function() {
         // Append the rest of our commands
         qz.append('^FS\n');
         qz.append('^XZ\n');

         // Tell the apple to print.
         qz.print();

         // Remove any reference to this function
         window['qzDoneAppending'] = null;
     };
 }

 /***************************************************************************
  * Prototype function for controlling print spooling between pages
  * Usage:
  *    qz.setEndOfDocument('P1,1\r\n');
  *    qz.setDocumentsPerSpool('5');
  *    qz.appendFile('/path/to/file.txt');
  *    window['qzDoneAppending'] = function() { qz.print(); };
  ***************************************************************************/
 function printPages() {
     if (notReady()) { return; }

     // Mark the end of a label, in this case  P1 plus a newline character
     // qz-print knows to look for this and treat this as the end of a "page"
     // for better control of larger spooled jobs (i.e. 50+ labels)
     qz.setEndOfDocument('P1,1\r\n');

     // The amount of labels to spool to the printer at a time. When
     // qz-print counts this many `EndOfDocument`'s, a new print job will
     // automatically be spooled to the printer and counting will start
     // over.
     qz.setDocumentsPerSpool("2");

     qz.appendFile(getPath() + "assets/epl_multiples.txt");

     // Automatically gets called when "qz.appendFile()" is finished.
     window['qzDoneAppending'] = function() {
         // Tell the applet to print.
         qz.print();

         // Remove reference to this function
         window['qzDoneAppending'] = null;
     };
 }

 /***************************************************************************
  * Prototype function for printing a text or binary file containing raw
  * print commands.
  * Usage:
  *    qz.appendFile('/path/to/file.txt');
  *    window['qzDoneAppending'] = function() { qz.print(); };
  ***************************************************************************/
 function printFile(file) {
     if (notReady()) { return; }

     // Append raw or binary text file containing raw print commands
     qz.appendFile(getPath() + "assets/" + file);

     // Automatically gets called when "qz.appendFile()" is finished.
     window['qzDoneAppending'] = function() {
         // Tell the applet to print.
         qz.print();

         // Remove reference to this function
         window['qzDoneAppending'] = null;
     };
 }

 /***************************************************************************
  * Prototype function for printing a graphic to a PostScript capable printer.
  * Not to be used in combination with raw printers.
  * Usage:
  *    qz.appendImage('/path/to/image.png');
  *    window['qzDoneAppending'] = function() { qz.printPS(); };
  ***************************************************************************/
 function printImage(scaleImage) {
     if (notReady()) { return; }

     // Optional, set up custom page size.  These only work for PostScript printing.
     // setPaperSize() must be called before setAutoSize(), setOrientation(), etc.
     if (scaleImage) {
         qz.setPaperSize("8.5in", "11.0in");  // US Letter
         //qz.setPaperSize("210mm", "297mm");  // A4
         qz.setAutoSize(true);
         //qz.setOrientation("landscape");
         //qz.setOrientation("reverse-landscape");
     }

     //qz.setCopies(3);
     qz.setCopies(parseInt(document.getElementById("copies").value));

     // Append our image (only one image can be appended per print)
     qz.appendImage(getPath() + "assets/img/image_sample.png");

     // Automatically gets called when "qz.appendImage()" is finished.
     window['qzDoneAppending'] = function() {
         // Tell the applet to print PostScript.
         qz.printPS();

         // Remove reference to this function
         window['qzDoneAppending'] = null;
     };
 }

 /***************************************************************************
  * Prototype function for printing a PDF to a PostScript capable printer.
  * Not to be used in combination with raw printers.
  * Usage:
  *    qz.appendPDF('/path/to/sample.pdf');
  *    window['qzDoneAppending'] = function() { qz.printPS(); };
  ***************************************************************************/
 function printPDF() {
     if (notReady()) { return; }
     // Append our pdf (only one pdf can be appended per print)
     qz.appendPDF(getPath() + "assets/pdf_sample.pdf");

     //qz.setCopies(3);
     qz.setCopies(parseInt(document.getElementById("copies").value));

     // Automatically gets called when "qz.appendPDF()" is finished.
     window['qzDoneAppending'] = function() {
         // Tell the applet to print PostScript.
         qz.printPS();

         // Remove reference to this function
         window['qzDoneAppending'] = null;
     };
 }

 /***************************************************************************
  * Prototype function for printing plain HTML 1.0 to a PostScript capable
  * printer.  Not to be used in combination with raw printers.
  * Usage:
  *    qz.appendHTML('<h1>Hello world!</h1>');
  *    qz.printPS();
  ***************************************************************************/
 function printHTML() {
     if (notReady()) { return; }

     // Preserve formatting for white spaces, etc.
     var colA = fixHTML('<h2>*  QZ Print Plugin HTML Printing  *</h2>');
     colA = colA + '<color=red>Version:</color> ' + qz.getVersion() + '<br />';
     colA = colA + '<color=red>Visit:</color> http://code.google.com/p/jzebra';

     // HTML image
     var colB = '<img src="' + getPath() + 'assets/img/image_sample.png">';

     //qz.setCopies(3);
     qz.setCopies(parseInt(document.getElementById("copies").value));

     // Append our image (only one image can be appended per print)
     qz.appendHTML(
             '<html>' +
                 '<table face="monospace" border="1px">' +
                 '<tr height="6cm">' +
                     '<td valign="top">' + colA + '</td>' +
                     '<td valign="top">' + colB + '</td>' +
                 '</tr>' +
                 '</table>' +
             '</html>'
     );

     qz.printHTML();
 }

 /***************************************************************************
  * Prototype function for printing an HTML screenshot of the existing page
  * Usage: (identical to appendImage(), but uses html2canvas for png rendering)
  *    qz.setPaperSize("8.5in", "11.0in");  // US Letter
  *    qz.setAutoSize(true);
  *    qz.appendImage($("canvas")[0].toDataURL('image/png'));
  ***************************************************************************/
 function printHTML5Page() {
     $("#qz-status").html2canvas({
         canvas: hidden_screenshot,
         onrendered: function() {
             if (notReady()) { return; }
             // Optional, set up custom page size.  These only work for PostScript printing.
             // setPaperSize() must be called before setAutoSize(), setOrientation(), etc.
             qz.setPaperSize("8.5in", "11.0in");  // US Letter
             qz.setAutoSize(true);
             qz.appendImage($("canvas")[0].toDataURL('image/png'));

             //qz.setCopies(3);
             qz.setCopies(parseInt(document.getElementById("copies").value));

             // Automatically gets called when "qz.appendFile()" is finished.
             window['qzDoneAppending'] = function() {
                 // Tell the applet to print.
                 qz.printPS();

                 // Remove reference to this function
                 window['qzDoneAppending'] = null;
             };
         }
     });
 }

 /***************************************************************************
  ****************************************************************************
  * *                          HELPER FUNCTIONS                             **
  ****************************************************************************
  ***************************************************************************/


 /***************************************************************************
  * Gets the current url's path, such as http://site.com/example/dist/
  ***************************************************************************/
 function getPath() {
     var path = window.location.href;
     return path.substring(0, path.lastIndexOf("/")) + "/";
 }

 /**
  * Fixes some html formatting for printing. Only use on text, not on tags!
  * Very important!
  *   1.  HTML ignores white spaces, this fixes that
  *   2.  The right quotation mark breaks PostScript print formatting
  *   3.  The hyphen/dash autoflows and breaks formatting
  */
 function fixHTML(html) {
     return html.replace(/\s/g, "&nbsp;").replace(/’/g, "'").replace(/-/g,"&#8209;");
 }

 /**
  * Equivalent of VisualBasic CHR() function
  */
 function chr(i) {
     return String.fromCharCode(i);
 }

 </script>
 <script type="text/javascript" src="js/jquery-1.10.2.js"></script>
 <script type="text/javascript" src="js/html2canvas.js"></script>
 <script type="text/javascript" src="js/jquery.plugin.html2canvas.js"></script>
 <!--<style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
 .en-markup-crop-options {
     top: 18px !important;
     left: 50% !important;
     margin-left: -100px !important;
     width: 200px !important;
     border: 2px rgba(255,255,255,.38) solid !important;
     border-radius: 4px !important;
 }

 .en-markup-crop-options div div:first-of-type {
     margin-left: 0px !important;
 }
 </style>-->
 </head>
 <script type="text/javascript">
    function init() {
      findPrinters();
      alert("a_findPrinetes()");
    }
 </script>
 <body id="qz-status" bgcolor="#FFF380" style="background: rgb(240, 240, 240);">
 <div style="margin: 0 1em;"><h1 id="title" style="margin:0;">Impresi&oacute;n de etiquetas EasyPoint</h1></div>

 <table border="1px" cellpadding="5px" cellspacing="0px">
 <tbody><tr>
     <td valign="top"><h2>Todas las impresoras</h2>
         <input type="button" onclick="findPrinter()" value="Detect Printer"><br>
         <input id="printer" type="text" value="zebra" size="15"><br>
         <input type="button" onclick="init()" value="List All Printers"><br>
         <input type="button" onclick="useDefaultPrinter()" value="Use Default Printer"><br><br>
     </td>

     <td valign="top"><h2>Impresi&oacute;n Raw (Zebra)</h2>
         <input type="button" onclick="printZPL()" value="Impresi&oacute;n ZPL"><br><br>
     </td>

     <td valign="top"><h2>Impresoras PostScript</h2>
         <input type="button" onclick="printHTML()" value="Print HTML"><br>
         <input type="button" onclick="printPDF()" value="Print PDF"><br>
         <input type="button" onclick="printImage(false)" value="Print PostScript Image"><br>
         <input type="button" onclick="printImage(true)" value="Print Scaled PostScript Image"><br>
         <input type="button" onclick="printHTML5Page()" value="Print Current Page"><br>
         <p>Copies</p><p><input type="text" id="copies" size="8" value="1">
     </p></td>
 </tr>
 </tbody></table>


 <canvas id="hidden_screenshot" style="display:none;"></canvas>


 <div id="extension-kmmojbkhfhninkelnlcnliacgncnnikf-installed" onload='init()'></div></body></html>
