$(document).ready(function() {
    var $table = $('#tbl_tareas');
    $table.floatThead();

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
    
    $( "#clientesLclis" ).change(function(){
      $("#clientesGclis option:selected").removeAttr("selected");
      $("#clientesSelectby").val("clientes");       
    });
    $( "#clientesGclis" ).change(function(){
      $("#clientesLclis option:selected").removeAttr("selected");
      $("#clientesSelectby").val("grupos");
    });
    $('#formAddHonoraio').submit(function(){ 
      //serialize form data 
      var formData = $(this).serialize(); 
      //get form action 
      var formUrl = $(this).attr('action'); 
      $.ajax({ 
        type: 'POST', 
        url: formUrl, 
        data: formData, 
        success: function(data,textStatus,xhr){ 
          //callAlertPopint(data); 

          var mirespuesta =jQuery.parseJSON(data);
          if(mirespuesta.hasOwnProperty('respuesta')){
            location.hash ="#x";                
            callAlertPopint(mirespuesta.respuesta);
            return false;
          }

          var cliid = mirespuesta.honorario.cliente_id;

          var cellid ="cell"+cliid+'-'+"tarea1"; 

          var eventoid =  $('#formAddHonoraio #HonorarioEventoId').val();
          var periodo = $('#formAddHonoraio #HonorarioPeriodo').val();
          var clinombre = $('#formAddHonoraio #HonorarioClientenombre').val();
          var honoid = mirespuesta.honorario.id;
          var honomonto = mirespuesta.honorario.monto;
          var honofecha = mirespuesta.honorario.fecha;
          var descripcion = mirespuesta.honorario.descripcion;
          var js = eventoid+",'tarea1','"+periodo+"','"+cliid+"','"+clinombre+"','realizado','"+honoid+"','"+honomonto+"','"+honofecha+"','"+descripcion+"'";
          js = "verFormSolicitar("+js+")";
          // create a function from the "js" string
          var newclick = new Function(js);

          // clears onclick then sets click using jQuery
          $("#"+cellid).attr('onclick', '').click(newclick);
          location.href="#close";
          return false;
        }, 
        error: function(xhr,textStatus,error){ 
          callAlertPopint(textStatus); 
          return false;
        } 
      }); 
          return false;
    }); 
    $('#formAddDeposito').submit(function(){ 
      //serialize form data 
      var formData = $(this).serialize(); 
      //get form action 
      var formUrl = $(this).attr('action'); 
      $.ajax({ 
        type: 'POST', 
        url: formUrl, 
        data: formData, 
        success: function(data,textStatus,xhr){ 
          //callAlertPopint(data); 

          var mirespuesta =jQuery.parseJSON(data);
          if(mirespuesta.hasOwnProperty('respuesta')){
                    location.hash ="#x";                
            callAlertPopint(mirespuesta.respuesta);
          }

          var cliid = mirespuesta.deposito.cliente_id;

          var cellid ="cell"+cliid+'-'+"tarea14"; 

          var eventoid =  $('#formAddDeposito #DepositoEventoId').val();
          var periodo = $('#formAddDeposito #DepositoPeriodo').val();
          var clinombre = $('#formAddDeposito #DepositoClientenombre').val();
          var depoid = mirespuesta.deposito.id;
          var depomonto = mirespuesta.deposito.monto;
          var depofecha = mirespuesta.deposito.fecha;
          var descripcion = mirespuesta.deposito.descripcion;
          var js = eventoid+",'tarea14','"+periodo+"','"+cliid+"','"+clinombre+"','realizado','"+depoid+"','"+depomonto+"','"+depofecha+"','"+descripcion+"'";
          js = "verFormInformar("+js+")";
          // create a function from the "js" string
          var newclick = new Function(js);

          // clears onclick then sets click using jQuery
          $("#"+cellid).attr('onclick', '').click(newclick);
          location.href="#close";
          return false;
        }, 
        error: function(xhr,textStatus,error){ 
          callAlertPopint(textStatus); 
          return false;
        } 
      }); 
          return false;
    }); 
});
function noHabilitado(){
  callAlertPopint('Usted no posee permisos para realizar esta tarea. En la seccion Parametros/Tareas podra habilitar la tarea.');
}
function verFormSolicitar(eventId,tarea,periodo,clienteid,clientenombre,estadotarea,honoid,honomonto,honofecha,descripcion){
  
  $('#formAddHonoraio #HonorarioId').val(honoid);
  $('#formAddHonoraio #HonorarioClienteId').val(clienteid);
  $('#formAddHonoraio #HonorarioEventoId').val(eventId);

  $('#formAddHonoraio #HonorarioPeriodo').val(periodo);
  $('#formAddHonoraio #HonorarioMonto').val(honomonto);
  $('#formAddHonoraio #HonorarioFecha').val(honofecha);
  $('#formAddHonoraio #HonorarioClientenombre').val(clientenombre);
  $('#formAddHonoraio #HonorarioDescripcion').val(descripcion);
  
  location.href="#popInSolicitar";

}
function verFormInformar(eventId,tarea,periodo,clienteid,clientenombre,estadotarea,depoid,depomonto,depofecha,descripcion){
  
  $('#formAddDeposito #DepositoId').val(depoid);
  $('#formAddDeposito #DepositoClienteId').val(clienteid);
  $('#formAddDeposito #DepositoEventoId').val(eventId);

  $('#formAddDeposito #DepositoPeriodo').val(periodo);
  $('#formAddDeposito #DepositoMonto').val(depomonto);
  $('#formAddDeposito #DepositoFecha').val(depofecha);
  $('#formAddDeposito #DepositoClientenombre').val(clientenombre);
  $('#formAddDeposito #DepositoDescripcion').val(descripcion);
  
  location.href="#popInInformar";

}
function realizarEventoCliente(eventId,tarea,periodo,clienteid,estadotarea){

   var datas =  eventId+"/"+tarea+"/"+periodo+"/"+clienteid;
   var data ="";
   $.ajax({
         type: "post",  // Request method: post, get
         url: serverLayoutURL+"/eventosclientes/realizareventocliente/"+eventId+"/"+tarea+"/"+periodo+"/"+clienteid+"/"+estadotarea, // URL to request
         data: data,  // post data
         success: function(response) {
                  
                  var resp = response.split("&&");
                        var respuesta=resp[1];
                        var error=resp[0];

                      if(error!=0){
                        callAlertPopint('Error por favor intente mas tarde');
                        //alert(respuesta);
                        return;
                      }else{
                        var newtd="";
                        var idCell='#cell'+clienteid+'-'+tarea;
                        var myparams="";
                        if(estadotarea=='pendiente'){
                          myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','realizado'";      
                          newtd+='<img src="'+serverLayoutURL+'/img/add.png" onclick="realizarEventoCliente('+myparams+')" height="20" width="20"> ';                           
                                                   
                          $(idCell).attr("class", "pendiente");   
                        }else{
                          myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','pendiente'";   
                          newtd+='<img src="'+serverLayoutURL+'/img/edit.png" onclick="realizarEventoCliente('+myparams+')" height="20" width="20"> ';                           
                        
                          $(idCell).attr("class", "realizado");  
                        }
                         
                          $(idCell).html(newtd);
                          callAlertPopint('Tarea modificada. Estado:'+estadotarea);
                      }                                                                                              
                     },                                                                               
         error:function (XMLHttpRequest, textStatus, errorThrown) {
           alert(textStatus);
           alert(XMLHttpRequest);
           alert(errorThrown);
         }
      });
      return false;
}
function realizarEventoImpuesto(eventId,tarea,periodo,clienteid,impcliid,estadotarea){

       var datas =  eventId+"/"+tarea+"/"+periodo+"/"+impcliid;
       var data ="";
       $.ajax({
             type: "post",  // Request method: post, get
             url: serverLayoutURL+"/eventosimpuestos/realizareventoimpuesto/"+eventId+"/"+tarea+"/"+periodo+"/"+impcliid+"/"+estadotarea, // URL to request
             data: data,  // post data
             success: function(response) {
                           var resp = response.split("&&");
                            var respuesta=resp[1];
                            var error=resp[0];

                          if(error!=0){
                            callAlertPopint('Error por favor intente mas tarde');
                            return;
                          }else{
                            var newtd="";
                            var idCell='#cellimp'+clienteid+'-'+tarea+'-'+impcliid;
                            var myparams="";
                            if(estadotarea=='pendiente'){
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','"+impcliid+"','realizado'";      
                              newtd+='<img src="'+serverLayoutURL+'/img/add.png" onclick="realizarEventoImpuesto('+myparams+')" height="20" width="20"> ';                           
                                                       
                              $(idCell).attr("class", "pendiente");   
                            }else{
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','"+impcliid+"','pendiente'";   
                              newtd+='<img src="'+serverLayoutURL+'/img/edit.png" onclick="realizarEventoImpuesto('+myparams+')" height="20" width="20"> ';                           
                            
                              $(idCell).attr("class", "realizado");  
                            }
                             
                              $(idCell).html(newtd);
                              callAlertPopint('Tarea modificada. Estado:'+estadotarea);
                          }                                                                                              
                         },
             error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                    alert(XMLHttpRequest);
                    alert(errorThrown);
             }
          });
          return false;
  
}
function showPrepararPapeles(eventId,tarea,periodo,clienteid,impcliid){
  $('#form_prepararPapeles #clienteid').val(clienteid)
   $("#form_prepararPapeles #eventId").val(eventId);
   $("#form_prepararPapeles #tarea").val(tarea);
   $("#form_prepararPapeles #periodo").val(periodo);
   $("#form_prepararPapeles #impcliid").val(impcliid);
   location.href="#PIPrepararPapeles";
}
function modificarPrepararPapeles(eventId,tarea,periodo,clienteid,impcliid,fchvto,montovto,monc,descripcion){
  $('#form_prepararPapeles #clienteid').val(clienteid)
   $("#form_prepararPapeles #eventId").val(eventId);
   $("#form_prepararPapeles #tarea").val(tarea);
   $("#form_prepararPapeles #periodo").val(periodo);
   $("#form_prepararPapeles #impcliid").val(impcliid);
   $("#form_prepararPapeles #fchvto").val(fchvto);
   $("#form_prepararPapeles #montovto").val(montovto);
   $("#form_prepararPapeles #monc").val(monc);
   $("#form_prepararPapeles #descripcion").val(descripcion);
   location.href="#PIPrepararPapeles";
}
function papelesDeTrabajo(periodo,impcli){
  var data = "";
       $.ajax({
             type: "post",  // Request method: post, get
             url: serverLayoutURL+"/eventosimpuestos/getpapelestrabajo/"+periodo+"/"+impcli, // URL to request
             data: data,  // post data
             success: function(response) {
                      //alert(response);
                      $('#divpopPapelesDeTrabajo').html(response);
                       $(document).ready(function() {
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
                        });
                      location.href='#popInPapelesDeTrabajo';
                           },
             error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                    alert(XMLHttpRequest);
                    alert(errorThrown);
             }
          });
          return false;
}
function solicitar(){
  $.ajax({
       type: "post",  // Request method: post, get
       url: serverLayoutURL+"/eventosimpuestos/realizartarea5/"+id+"/"+periodo+"/"+impcliid+"/"+montovto+"/"+fchvto+"/"+monc+"/"+descripcion, // URL to request
       data: data,  // post data
       success: function(response) {
                    var resp = response.split("&&");
                    var respuesta=resp[1];
                    var error=resp[0];
                   
                    callAlertPopint(respuesta); 
               },
       error:function (XMLHttpRequest, textStatus, errorThrown) {
              alert(textStatus);
              alert(XMLHttpRequest);
              alert(errorThrown);
      }
  });
  return false;    
}
function agregarPapeldeTrabajo(){
  clienteid = $('#form_prepararPapeles #EventosimpuestoClienteid').val();
  id=0;
  eventId = $('#form_prepararPapeles #EventosimpuestoEventoId').val();
  eventId2= $('#form_prepararPapeles #EventosimpuestoId').val();
  periodo = $('#periodoSel').val();
  impcliid = $('#form_prepararPapeles #EventosimpuestoImpcliid').val();

  montovto = $('#form_prepararPapeles #EventosimpuestoMontovto').val();
  fchvto = $('#form_prepararPapeles #EventosimpuestoFchvto').val();
  monc = $('#form_prepararPapeles #EventosimpuestoMonc').val();
  descripcion = $('#form_prepararPapeles #EventosimpuestoDescripcion').val();

  error="";
  if(monc==""){
    error+="Debe cargar monto/n";
  }
  if(fchvto==""){
    error+="Debe cargar Fecha de Vencimiento/n";
  }
  if(eventId!=""){
    id=eventId;
  }
  if(eventId2!=""){
    id=eventId2;
  }
  if(error==""){
   var datas =  eventId2+"/"+periodo+"/"+impcliid+"/"+montovto+"/"+fchvto+"/"+monc+"/"+descripcion;
   var data ="";
   $.ajax({
         type: "post",  // Request method: post, get
         url: serverLayoutURL+"/eventosimpuestos/realizartarea5/"+id+"/"+periodo+"/"+impcliid+"/"+montovto+"/"+fchvto+"/"+monc+"/"+descripcion, // URL to request
         data: data,  // post data
         success: function(response) {
                      var resp = response.split("&&");
                      var respuesta=resp[1];
                      var error=resp[0];
                     
                      callAlertPopint(respuesta); 
                 },
         error:function (XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
                alert(XMLHttpRequest);
                alert(errorThrown);
        }
    });
    return false;    
  }else{
    callAlertPopint(error);
    return false;    
  }
}  

function showPagar(periodo,impcli){
   var data = "";
       $.ajax({
             type: "post",  // Request method: post, get
             url: serverLayoutURL+"/eventosimpuestos/getapagar/"+periodo+"/"+impcli, // URL to request
             data: data,  // post data
             success: function(response) {
                      $('#form_pagar').html(response);
                      location.href='#PIPagar';
                           },
             error:function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(textStatus);
                    alert(XMLHttpRequest);
                    alert(errorThrown);
             }
          });
          return false;
}
function modificarPagar(eventId,tarea,periodo,clienteid,impcliid,montorealizado,fchrealizado){
  $('#form_pagar #clienteid').val(clienteid)
   $("#form_pagar #eventId").val(eventId);
   $("#form_pagar #tarea").val(tarea);
   $("#form_pagar #periodo").val(periodo);
   $("#form_pagar #impcliid").val(impcliid);
   $("#form_pagar #montorealizado").val(montorealizado);
   $("#form_pagar #fchrealizado").val(fchrealizado);
   location.href="#PIPagar";
}
function enviarPagar(){
    clienteid = $('#form_pagar #clienteid').val();
    eventId = $('#form_pagar #eventId').val();
    tarea = $('#form_pagar #tarea').val();
    periodo = $('#form_pagar #periodo').val();
    impcliid = $('#form_pagar #impcliid').val();

    montorealizado = $('#form_pagar #montorealizado').val();
    fchrealizado = $('#form_pagar #fchrealizado').val();

    error="";
    if(fchrealizado==""){
      fchrealizado+="Debe Seleccionar una fecha de realizacion</br>";
    }
    
   if(error==""){

     var datas =  eventId+"/"+tarea+"/"+periodo+"/"+impcliid+"/"+montovto+"/"+fchvto+"/"+monc+"/"+descripcion;
     var data ="";
     $.ajax({
           type: "post",  // Request method: post, get
           url: serverLayoutURL+"/eventosimpuestos/realizartarea13/"+eventId+"/"+tarea+"/"+periodo+"/"+impcliid+"/"+montorealizado+"/"+fchrealizado, // URL to request
           data: data,  // post data
           success: function(response) {
                        var resp = response.split("&&");
                        var respuesta=resp[1];
                        var error=resp[0];

                        if(error!=0){
                          callAlertPopint(respuesta);
                          return;
                        }
                        if(eventId==0){
                          /*alert("Evento creado: "+respuesta);
                          var evento_id=resp[2]
                          for(i=0;i<=50;i++){
                            if($('#cellimp'+clienteid+'-tarea'+i+'-'+impcliid).length != 0) {
                                var params= evento_id+",'tarea"+i+"','"+periodo+"','"+clienteid+"','"+impcliid+"'";
                                var cd = 'cellimp'+clienteid+'-tarea'+i+'-'+impcliid;
                                var func="";
                                func=getFunctionToShow(params,i);                            
                               $('#'+cd).html('<img src="/sigesec/img/add.png" onclick="'+func+'" alt="" height="20" width="20">');
                               $('#'+cd).attr("class", "pendiente  tarea"+i);                             
                            }
                          }*/
                          location.reload(true);
                        }                     
                    $('#cellimp'+clienteid+'-tarea13-'+impcliid).html('<img src="'+serverLayoutURL+'/img/remove.png" onclick="" alt="" height="20" width="20">');
                    $('#cellimp'+clienteid+'-tarea13-'+impcliid).attr("class", "realizado ");
                   },
           error:function (XMLHttpRequest, textStatus, errorThrown) {
                  alert(textStatus);
                  alert(XMLHttpRequest);
                  alert(errorThrown);
          }
        });
        return false;    
      }else{
        callAlertPopint(error);
        return false;    

      }
}
function getFunctionToShow(params,i){
  var func="";
  if(i==5){
     func='showPrepararPapeles('+params+')';
  }else if(i==13){
     func='showPagar('+params+')';                               
  }else{
     func='realizarEventoImpuesto('+params+')';
  }  
  return func;
}
