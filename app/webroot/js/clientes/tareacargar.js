$(document).ready(function() {
  reloadInputDates();
  showVentas();
  $('#saveVentasForm').submit(function(){ 
    //serialize form data 
    var formData = $(this).serialize(); 
    //get form action 
    var formUrl = $(this).attr('action'); 
    
    //Controles de inputs
    var fecha = $('#VentaFecha').val();
    var ventaNumeroComprobante = $('#VentaNumerocomprobante').val();
    if(fecha==null || fecha == ""){
      alert("Debes seleccionar una fecha");
      return false;
    }
    if(ventaNumeroComprobante==null || ventaNumeroComprobante == ""){
      alert("Debes ingresar un numero de Comprobante");
      return false;
    }
   
    $.ajax({ 
      type: 'POST', 
      url: formUrl, 
      data: formData, 
      success: function(data,textStatus,xhr){ 
        var respuesta = JSON.parse(data);
        alert(respuesta.respuesta);
        if(respuesta.venta.Venta!=null){
            var  tdClass = "tdViewVenta"+respuesta.venta_id;
            var row = "<tr id='rowventa"+respuesta.venta_id+"'> ";
            row = row +"<td class='"+tdClass+"'>"+respuesta.venta.Venta.fecha+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.tipocomprobante+"-";
            row = row + respuesta.puntosdeventa.Puntosdeventa.nombre+"-";
            row = row + respuesta.venta.Venta.numerocomprobante+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.subcliente.Subcliente.nombre+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.localidade.Localidade.nombre+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.alicuota+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.neto+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.iva+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.ivapercep+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.actvspercep+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.impinternos+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.nogravados+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.excentos+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.total+"</td>";
            row = row + "<td class='"+tdClass+"'>"+respuesta.venta.Venta.comercioexterior+"</td>";
            row = row + "<td class='"+tdClass+"'>";
            row = row + '<img src="'+serverLayoutURL+'/img/edit_view.png" width="20" height="20" onclick="modificarVenta('+respuesta.venta_id+')" alt=""></td>';                                  
            row = row + "</tr>";
            $("#bodyTablaVentas").append(row);
          }
        }, 
      error: function(xhr,textStatus,error){ 
        alert(textStatus); 
      } 
    }); 
    return false; 
  });
  $('#saveComprasForm').submit(function(){ 
      //serialize form data 
      var formData = $(this).serialize(); 
      //get form action 
      var formUrl = $(this).attr('action'); 
      
      //Controles de inputs
      var fecha = $('#CompraFecha').val();
      var compraNumerocomprobante = $('#CompraNumerocomprobante').val();
      if(fecha==null || fecha == ""){
        alert("Debes seleccionar una fecha");
        return false;
      }
      if(compraNumerocomprobante==null || compraNumerocomprobante == ""){
        alert("Debes ingresar un numero de Comprobante");
        return false;
      }
     
      $.ajax({ 
        type: 'POST', 
        url: formUrl, 
        data: formData, 
        success: function(data,textStatus,xhr){ 
          var respuesta = JSON.parse(data);
          alert(respuesta.respuesta);
          if(respuesta.compra.Compra!=null){
              var  tdClass = "tdViewCompra"+respuesta.compra_id;
              var row = "<tr id='rowcompra"+respuesta.compra_id+"'> ";
              row = row +"<td class='"+tdClass+"'>"+respuesta.compra.Compra.fecha+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.tipocomprobante+"-";
              row = row + respuesta.puntosdeventa.Puntosdeventa.nombre+"-";
              row = row + respuesta.compra.Compra.numerocomprobante+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.subcliente.Subcliente.nombre+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.condicioniva+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.tipogasto+"</td>";

              row = row + "<td class='"+tdClass+"'>"+respuesta.localidade.Localidade.nombre+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.imputacion+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.tipocredito+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.alicuota+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.neto+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.iva+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.tipoiva+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.ivapercep+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.iibbpercep+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.actvspercep+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.impinternos+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.nogravados+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.nogravadogeneral+"</td>";
              row = row + "<td class='"+tdClass+"'>"+respuesta.compra.Compra.total+"</td>";
              row = row + "<td class='"+tdClass+"'>";
              row = row + '<img src="'+serverLayoutURL+'/img/edit_view.png" width="20" height="20" onclick="modificarCompra('+respuesta.compra_id+')" alt=""></td>';                                  
              row = row + "</tr>";
              $("#bodyTablaCompras").append(row);
            }
          }, 
        error: function(xhr,textStatus,error){ 
          alert(textStatus); 
          alert(error); 
        } 
      }); 
      return false; 
    });
  $("#tabVentas" ).click(function() {   
     $("#tabVentas" ).switchClass( 'cliente_view_tab', 'cliente_view_tab_active');
     $("#tabCompras" ).switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
     showVentas();
  });
  $("#tabCompras" ).click(function() {   
     $("#tabCompras" ).switchClass( 'cliente_view_tab', 'cliente_view_tab_active');
     $("#tabVentas" ).switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
     showCompras();
  });
});
function reloadInputDates(){
   $( "input.datepicker" ).datepicker({
    yearRange: "-100:+50",
    changeMonth: true,
    changeYear: true,
    constrainInput: false,
    showOn: 'both',
    buttonImage: "",
    dateFormat: 'dd-mm-yy',
    buttonImageOnly: true
  });
}
function showVentas(){
  $('.tabVentas').show();
  $('.tabCompras').hide();
}
function showCompras(){
  $('.tabVentas').hide();
  $('.tabCompras').show();
}
function hideFormModVenta(venid){
  $(".tdViewVenta"+venid).show();
  $("#tdventa"+venid).remove(); 

}
function hideFormModCompra(comid){
  $(".tdViewCompra"+comid).show();
  $("#tdcompra"+comid).remove(); 

}
function modificarVenta(venid){  
  var data ="";
  $.ajax({
      type: "post",  // Request method: post, get
      url: serverLayoutURL+"/ventas/edit/"+venid,

      // URL to request
      data: data,  // post data
      success: function(response) {
        var oldRow = $("#rowventa"+venid).html();
        var rowid="rowventa"+venid;
        $("#"+rowid).html(oldRow + response);
       // var button = '<a href="#" class="btn_cancelar" onClick="hideFormModVenta('+venid+')">X</a>';
        //$("#tdventa"+venid).append(button); 
        $(".tdViewVenta"+venid).hide();
        reloadInputDates();
        $('#VentaFormEdit'+venid).submit(function(){ 
          //serialize form data 
          var formData = $(this).serialize(); 
          //get form action 
          var formUrl = $(this).attr('action'); 
                                      
          $.ajax({ 
            type: 'POST', 
            url: formUrl, 
            data: formData, 
            success: function(data,textStatus,xhr){ 
                  var rowid="rowventa"+venid;
                  $("#"+rowid).html( data);               
              }, 
            error: function(xhr,textStatus,error){ 
              alert(textStatus); 
            } 
          }); 
          return false; 
        });
      },                
     error:function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus);
          alert(XMLHttpRequest);
          alert(errorThrown);
     }
  });
}
function modificarCompra(comid){  
  var data ="";
  $.ajax({
      type: "post",  // Request method: post, get
      url: serverLayoutURL+"/compras/edit/"+comid,

      // URL to request
      data: data,  // post data
      success: function(response) {
        var oldRow = $("#rowcompra"+comid).html();
        var rowid="rowcompra"+comid;
        $("#"+rowid).html(oldRow + response);
       // var button = '<a href="#" class="btn_cancelar" onClick="hideFormModVenta('+venid+')">X</a>';
        //$("#tdventa"+venid).append(button); 
        $(".tdViewCompra"+comid).hide();
        reloadInputDates();
        $('#CompraFormEdit'+comid).submit(function(){ 
          //serialize form data 
          var formData = $(this).serialize(); 
          //get form action 
          var formUrl = $(this).attr('action'); 
                                      
          $.ajax({ 
            type: 'POST', 
            url: formUrl, 
            data: formData, 
            success: function(data,textStatus,xhr){ 
                  var rowid="rowcompra"+comid;
                  $("#"+rowid).html( data);               
              }, 
            error: function(xhr,textStatus,error){ 
              alert(textStatus); 
            } 
          }); 
          return false; 
        });
      },                
     error:function (XMLHttpRequest, textStatus, errorThrown) {
          alert(textStatus);
          alert(XMLHttpRequest);
          alert(errorThrown);
     }
  });
}
function realizarEventoCliente(periodo,clienteid,estadotarea){

       var datas =  "0/tarea3/"+periodo+"/"+clienteid;
       var data ="";
       $.ajax({
             type: "post",  // Request method: post, get
             url: serverLayoutURL+"/eventosclientes/realizareventocliente/0/tarea3/"+periodo+"/"+clienteid+"/"+estadotarea, // URL to request
             data: data,  // post data
             success: function(response) {                      
                var resp = response.split("&&");
                var respuesta=resp[1];
                var error=resp[0];
                if(error!=0){
                    alert('Error por favor intente mas tarde');
                    return;
                }else{                           
                    alert('Tarea Cargar modificada. Estado:'+estadotarea);
                }      
                location.href=serverLayoutURL+"/cl/realizareventocliente/0/tarea3/"+periodo+"/"+clienteid+"/"+estadotarea;                                                                                  
             },                                                                               
             error:function (XMLHttpRequest, textStatus, errorThrown) {
               alert(textStatus);
               alert(XMLHttpRequest);
               alert(errorThrown);
             }
          });
          return false;
  
}