function imprimir(){
        Popup($('#situacionIntegral').html());
    }

    //Creates a new window and populates it with your content
function Popup(data) {
    //Create your new window
    var w = window.open('', 'Imprimir', 'height=400,width=600');
    w.document.write('<html><head><title>Informe Tributario Financiero</title>');
    //Include your stylesheet (optional)
    w.document.write('<link rel="stylesheet" href="cake.generic.css" type="text/css" />');
    w.document.write('</head><body><table>');
    //Write your content
    w.document.write(data);
    w.document.write('</table></body></html>');
    w.print();
    w.close();

    return true;
}