function noHabilitado(){
  alert('Usted no posee permisos para realizar esta tarea. En la seccion Parametros/Tareas podra habilitar la tarea.');
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
                            alert('Error por favor intente mas tarde');
                            //alert(respuesta);
                            return;
                          }else{
                            var newtd="";
                            var idCell='#cell'+clienteid+'-'+tarea;
                            var myparams="";
                            if(estadotarea=='pendiente'){
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','realizado'";      
                              newtd+='<img src="/sigesec/img/add.png" onclick="realizarEventoCliente('+myparams+')" height="20" width="20"> ';                           
                                                       
                              $(idCell).attr("class", "pendiente");   
                            }else{
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','pendiente'";   
                              newtd+='<img src="/sigesec/img/edit.png" onclick="realizarEventoCliente('+myparams+')" height="20" width="20"> ';                           
                            
                              $(idCell).attr("class", "realizado");  
                            }
                             
                              $(idCell).html(newtd);
                              alert('Tarea modificada. Estado:'+estadotarea);
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
                            alert('Error por favor intente mas tarde');
                            alert(respuesta);
                            return;
                          }else{
                            var newtd="";
                            var idCell='#cellimp'+clienteid+'-'+tarea+'-'+impcliid;
                            var myparams="";
                            if(estadotarea=='pendiente'){
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','"+impcliid+"','realizado'";      
                              newtd+='<img src="/sigesec/img/add.png" onclick="realizarEventoImpuesto('+myparams+')" height="20" width="20"> ';                           
                                                       
                              $(idCell).attr("class", "pendiente");   
                            }else{
                              myparams= eventId+",'"+tarea+"','"+periodo+"','"+clienteid+"','"+impcliid+"','pendiente'";   
                              newtd+='<img src="/sigesec/img/edit.png" onclick="realizarEventoImpuesto('+myparams+')" height="20" width="20"> ';                           
                            
                              $(idCell).attr("class", "realizado");  
                            }
                             
                              $(idCell).html(newtd);
                              alert('Tarea modificada. Estado:'+estadotarea);
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

                        alert(response);
                        alert(respuesta);                                             
                   },
           error:function (XMLHttpRequest, textStatus, errorThrown) {
                  alert(textStatus);
                  alert(XMLHttpRequest);
                  alert(errorThrown);
          }
        });
        return false;    
      }else{
        alert(error);
        return false;    

      }
}  

/*
function showPagar(eventId,tarea,periodo,clienteid,impcliid){
  $('#form_pagar #clienteid').val(clienteid)
   $("#form_pagar #eventId").val(eventId);
   $("#form_pagar #tarea").val(tarea);
   $("#form_pagar #periodo").val(periodo);
   $("#form_pagar #impcliid").val(impcliid);
   location.href="#PIPagar";
}*/
function showPagar(periodo,impcli){
   var data = "";
       $.ajax({
             type: "post",  // Request method: post, get
             url: serverLayoutURL+"/eventosimpuestos/getapagar/"+periodo+"/"+impcli, // URL to request
             data: data,  // post data
             success: function(response) {
                      //alert(response);
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
                        alert("1: error: "+error+" respuesta: "+respuesta+" servResp: "+response);
                        if(error!=0){
                          alert(respuesta);
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
        alert(error);
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
    
});