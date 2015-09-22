$(document).ready(function() {

    var iHeaderHeight = $("#header").height() + 40;
    var sCliViewPageHeight = $(window).height();
    sCliViewPageHeight = sCliViewPageHeight - iHeaderHeight;
    sCliViewPageHeight = (sCliViewPageHeight < 250) ? 250 : sCliViewPageHeight;
    $("#divClientesIndex").css("height",sCliViewPageHeight + "px");

    var sClienteInfoHeight = sCliViewPageHeight - 22;
    //30 es el tamaño de los Tabs.
    $("#divCliente_Info").css("height",sClienteInfoHeight + "px");
    reloadDatePickers();
    $('#tbl_recibos').dataTable({
    	"sPaginationType": "full_numbers",
    	"sScrollY": "600px",
    	"bScrollCollapse": true,
    	"iDisplaylength": 50,
    });
    $("#saveDatosPersonalesForm #ClienteTipopersona").on('change', function() {
	  switch(this.value){
	  	case "fisica":
	  		$("#saveDatosPersonalesForm #ClienteEditLabelNombre").text("Apellido y Nombre");
	  		$('#saveDatosPersonalesForm #ClienteTipopersonajuridica').val("");
			$('#saveDatosPersonalesForm #ClienteTipopersonajuridica').attr('disabled', true);

			$("#saveDatosPersonalesForm #ClienteDni").attr('disabled', false);

			$("#saveDatosPersonalesForm #ClienteAnosduracion").val("");
			$("#saveDatosPersonalesForm #ClienteAnosduracion").attr('disabled', true);

			$("#saveDatosPersonalesForm #ClienteInscripcionregistrocomercio").val("");
			$("#saveDatosPersonalesForm #ClienteInscripcionregistrocomercio").attr('disabled', true);

 			$("#saveDatosPersonalesForm #ClienteModificacionescontrato").val("");
            $("#saveDatosPersonalesForm #ClienteModificacionescontrato").attr('disabled', true);			
	  	break;
	  	case "juridica":
	  		$("#saveDatosPersonalesForm #clienteEditLabelNombre").text("Razon Social");

	  		$('#saveDatosPersonalesForm #ClienteTipopersonajuridica').attr('disabled', false);

			$("#saveDatosPersonalesForm #ClienteModificacionescontrato").attr('disabled', false);

			$("#saveDatosPersonalesForm #ClienteDni").val("");
			$("#saveDatosPersonalesForm #ClienteDni").attr('disabled', true);

			$("#saveDatosPersonalesForm #ClienteAnosduracion").attr('disabled', false);

			$("#saveDatosPersonalesForm #ClienteInscripcionregistrocomercio").attr('disabled', false);
	  	break;
	  }
	  if($('#ClienteTipopersona').val()=='juridica'){
		}else{
			
		}
	});
    showDatosCliente();
    $( "#lblDatosPeronales" ).click(function() {		
	 if($('.datosPersonales').is(":visible")){
	 	 $('.datosPersonales').hide();
	 	 $("#imgDatosPersonales").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.datosPersonales').show();
		 	 $("#imgDatosPersonales").attr('src',serverLayoutURL+"/img/mas2.png");
	 	}
	});
	$( "#lblDomicilio" ).click(function() {		
	 if($('.domicilios').is(":visible")){
	 	 $('.domicilios').hide();
	 	 $("#imgDomicilio").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.domicilios').show();
		 	 $("#imgDomicilio").attr('src',serverLayoutURL+"/img/mas2.png");
	 	}
	});
	$( "#lblPersona" ).click(function() {		
	 if($('.personas').is(":visible")){
	 	 $('.personas').hide();
	 	 $("#imgPersona").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.personas').show();
		 	 $("#imgPersona").attr('src',serverLayoutURL+"/img/mas2.png");
	 	}
	});
	$( "#lblFacturacion" ).click(function() {		
	 if($('.facturacion').is(":visible")){
	 	 $('.facturacion').hide();
		 	 $("#imgFacturacion").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.facturacion').show();
		 	 $("#imgFacturacion").attr('src',serverLayoutURL+"/img/mas2.png");
	 	}
	});
	$( "#lblAFIP" ).click(function() {		
	 if($('.afip').is(":visible")){
	 	 $('.afip').hide();
		 	 $("#imgAFIP").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.afip').show();
		 	 $("#imgAFIP").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}
	});
	$( "#lblDGRM" ).click(function() {		
	 if($('.dgrm').is(":visible")){
	 	 $('.dgrm').hide();
		 	 $("#imgDGRM").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.dgrm').show();
		 	 $("#imgDGRM").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}
	});
	$( "#lblDGR" ).click(function() {		
	 if($('.dgr').is(":visible")){
	 	 $('.dgr').hide();
		 	 $("#imgDGR").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.dgr').show();
		 	 $("#imgDGR").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}
	});	
	$( "#lblBANCO" ).click(function() {		
	 if($('.bancos').is(":visible")){
	 	 $('.bancos').hide();
		 	 $("#imgBancos").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.bancos').show();
		 	 $("#imgBancos").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}
	});
	$( "#lblSINDICATO" ).click(function() {		
	 if($('.sindicatos').is(":visible")){
	 	 $('.sindicatos').hide();
		 	 $("#ImgSindicatos").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.sindicatos').show();
		 	 $("#ImgSindicatos").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}	 	
	});	
	$( "#lblPuntosdeventas").click(function() {		
	 if($('.puntosdeventa').is(":visible")){
 	 	$("#imgPuntosdeventas").attr('src',serverLayoutURL+"/img/menos2.png");
			$('.puntosdeventa').hide();
 	 }else{
			 $('.puntosdeventa').show();
	 	 $("#imgPuntosdeventas").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
 	 } 
	});	
	$( "#lblSubclientes" ).click(function() {		
	 if($('.subcliente').is(":visible")){
	 	 $('.subcliente').hide();
		 	 $("#imgSubclientes").attr('src',serverLayoutURL+"/img/menos2.png");
	 	}else{
 		 $('.subcliente').show();
		 	 $("#imgSubclientes").attr('src',serverLayoutURL+"/img/mas2.png");	 		 
	 	}		 	
	});
	$('#saveDatosPersonalesForm').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				alert(data); 
				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
			} 
		});	
		return false; 
	});
	catchImpCliAFIP();
	catchImpCliDGR();
	catchImpCliDGRM();
	//esconder de datos personales la edicion y el row de aceptar
	$("#tableDatosPersonalesEdit :input").prop("disabled", true);	
	$('#rowButtonsDetallesPersonales').hide();
	
	catchFormOrganismoxCliente('formOrganismoAFIP');
	catchFormOrganismoxCliente('formOrganismoDGR');
	catchFormOrganismoxCliente('formOrganismoDGRM');

	
});

function catchFormOrganismoxCliente(forname){
	$('#'+forname).submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				alert(data); 
				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
			} 
		});	
		return false; 
	});
}
function loadFormEditarPersona(){
	
	if($('#rowButtonsDetallesPersonales').is(":visible")){
		$("#tableDatosPersonalesEdit :input").prop("disabled", true);	
		$('#rowButtonsDetallesPersonales').hide();
	}else{
		$("#tableDatosPersonalesEdit :input").prop("disabled", false);
		$('#rowButtonsDetallesPersonales').show();
		$( "#saveDatosPersonalesForm #ClienteTipopersona" ).trigger( "change" );
	}	
}
function loadFormDomicilio(domid,cliid){	
	var data ="";
    $.ajax({
        type: "post",  // Request method: post, get
        url: serverLayoutURL+"/domicilios/editajax/"+domid+"/"+cliid,
        // URL to request
        data: data,  // post data
        success: function(response) {
         					$("#form_modificar_domicilio").html(response);
         					$("#form_modificar_domicilio").width("600px");
         					location.href='#modificar_domicilio';   
         					//Overflow: hidden;
         					reloadDatePickers();					
                       },                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
		 	alert(XMLHttpRequest);
		 	alert(errorThrown);
       }
    });
}
function loadFormPersonaRelacionada(perid,cliid){	
	var data ="";
    $.ajax({
        type: "post",  // Request method: post, get
        url: serverLayoutURL+"/personasrelacionadas/editajax/"+perid+"/"+cliid,

        // URL to request
        data: data,  // post data
        success: function(response) {
         					$("#form_modificar_persona").html(response);
         					location.href='#modificar_persona';
         					$("#form_modificar_persona").width("600px");
         					
                       },
                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
		 	alert(XMLHttpRequest);
		 	alert(errorThrown);
       }
    });
}
function loadFormImpuestoPeriodos(impcliid){	
	var data ="";
    $.ajax({
        type: "post",  // Request method: post, get
        url: serverLayoutURL+"/periodosactivos/index/"+impcliid,
        // URL to request
        data: data,  // post data
        success: function(response) {
         					$("#form_modificar_periodosactivos").html(response);
         					$("#form_modificar_periodosactivos").width("600px");
         					location.href='#modificar_periodoactivo'; 
         					reloadDatePickers();  
         					//Overflow: hidden;
         					//reloadDatePickers();					
         					$('#formPeriodosActivosAdd').submit(function(){ 
								//serialize form data 
								var formData = $(this).serialize(); 
								//get form action 
								var formUrl = $(this).attr('action'); 
								$.ajax({ 
									type: 'POST', 
									url: formUrl, 
									data: formData, 
									success: function(data,textStatus,xhr){ 
										alert(data); 
										location.href='#close';
										}, 
									error: function(xhr,textStatus,error){ 
										alert(textStatus); 
										location.href='#close';
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
function loadFormImpuesto(impcliid,cliid){	
	var data ="";
    $.ajax({
        type: "post",  // Request method: post, get
        url: serverLayoutURL+"/impclis/editajax/"+impcliid+"/"+cliid,

        // URL to request
        data: data,  // post data
        success: function(response) {
         				var rowAModificar = $('#rowImpcli'+impcliid).html();	
         					$('#rowImpcli'+impcliid).html(response);	
         					$('#ImpcliEditForm'+impcliid).submit(function(){ 
								//serialize form data 
								var formData = $(this).serialize(); 
								//get form action 
								var formUrl = $(this).attr('action'); 
								$.ajax({ 
									type: 'POST', 
									url: formUrl, 
									data: formData, 
									success: function(data,textStatus,xhr){ 
											alert("Impuesto Modificado"); 
											$('#ImpcliEditForm'+impcliid).parent().replaceWith(data);
										}, 
									error: function(xhr,textStatus,error){ 
										alert("Deposito NO Modificado. Intente de nuevo mas Tarde"); 
									} 
								});	
								return false; 
							});
					        reloadDatePickers();
                       },
                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            alert(textStatus);
		 	alert(XMLHttpRequest);
		 	alert(errorThrown);
       }
    });
}
function getLocalidadesForDomicilios(){
	var formData = $('#DomicilioPartidoId').serialize(); 
	$.ajax({ 
			type: 'POST', 
			url: serverLayoutURL+'/localidades/getbycategory', 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				$('#DomicilioLocalidadeId').empty();
				$('#DomicilioLocalidadeId').html(data);

				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
			} 
		});	
		return false; 
}
function reloadDatePickers(){
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
	$( "input.datepicker-day-month" ).datepicker({
					            yearRange: "-100:+50",
					            changeMonth: true,
					            changeYear: false,
					            constrainInput: false,
					            showOn: 'both',
					            buttonImage: "",
					            dateFormat: 'dd-mm',
					            buttonImageOnly: true
					        });	
	$( "input.datepicker-month-year" ).datepicker({
					            yearRange: "-100:+50",
					            changeMonth: true,
					            changeYear: true,
					            constrainInput: false,
					            showOn: 'both',
					            buttonImage: "",
					            dateFormat: 'mm-yy',
					            buttonImageOnly: true
					        });
	
}
function showDatosCliente(){
	hiddeAll();
	deselectAll();
	$('#cliente_view_tab_cliente').switchClass( 'cliente_view_tab', 'cliente_view_tab_active');

	$('.rowheaderdatosPersonales').show();
 	$('.rowheaderdomicilios').show();
	$('.rowheaderpersonas').show();
			
 	$('.rowheaderafip').hide();
 	$('.rowheaderdgrm').hide();
 	$('.rowheaderdgr').hide();
 	$('.rowheaderbancos').hide();
 	$('.rowheadersindicatos').hide();

 	$('.rowheaderventas').hide();
 	$('.rowheaderfacturacion').hide();
 	$('.rowheaderpuntosdeventas').hide();
 	$('.rowheadersubclientes').hide();

 	$('.rowheadercompras').hide();
}
function showDatosImpuesto(){
	hiddeAll();
	deselectAll();
	$('#cliente_view_tab_impuesto').switchClass( 'cliente_view_tab', 'cliente_view_tab_active');

	$('.rowheaderdatosPersonales').hide();
 	$('.rowheaderdomicilios').hide();
	$('.rowheaderpersonas').hide();
	$('.rowheaderfacturacion').hide();	
 		
 	$('.rowheaderafip').show();
 	$('.rowheaderdgrm').show();
 	$('.rowheaderdgr').show();
 	$('.rowheaderbancos').show();
 	$('.rowheadersindicatos').show();

 	$('.rowheaderventas').hide();
 	$('.rowheaderfacturacion').hide();
 	$('.rowheaderpuntosdeventas').hide();
 	$('.rowheadersubclientes').hide();

 	$('.rowheadercompras').hide();
}
function showDatosVenta(){
	hiddeAll();
	deselectAll();
	$('#cliente_view_tab_venta').switchClass( 'cliente_view_tab', 'cliente_view_tab_active');

	$('.rowheaderdatosPersonales').hide();
 	$('.rowheaderdomicilios').hide();
	$('.rowheaderpersonas').hide();
		$('.rowheaderfacturacion').hide();	

	 	$('.rowheaderrecibo').hide();
	 	$('.rowheaderingreso').hide();
	 	$('.rowheaderhonorario').hide(); 	

	 	$('.rowheaderafip').hide();
	 	$('.rowheaderdgrm').hide();
	 	$('.rowheaderdgr').hide();
	 	$('.rowheaderbancos').hide();
	 	$('.rowheadersindicatos').hide();

	 	$('.rowheaderventas').show();
	 	$('.rowheaderfacturacion').show();
	 	$('.rowheaderpuntosdeventas').show();
	 	$('.rowheadersubclientes').show();

	 	$('.rowheadercompras').hide();
}
function deselectAll(){
	$('#cliente_view_tab_cliente').switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
	$('#cliente_view_tab_impuesto').switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
	$('#cliente_view_tab_venta').switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
	$('#cliente_view_tab_compra').switchClass( 'cliente_view_tab_active', 'cliente_view_tab');
}
function hiddeAll(){
	$('.datosPersonales').hide();
	 	$("#imgDatosPersonales").attr('src',serverLayoutURL+"/img/menos2.png");	
 	$('.domicilios').hide();
		$("#imgDomicilio").attr('src',serverLayoutURL+"/img/menos2.png");
	$('.personas').hide();
	 	$("#imgPersona").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.facturacion').hide();
	 	$("#imgFacturacion").attr('src',serverLayoutURL+"/img/menos2.png");
	 	
	$('.afip').hide();
	 	$("#imgAFIP").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.dgrm').hide();
	 	$("#imgDGRM").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.dgr').hide();
	 	$("#imgDGR").attr('src',serverLayoutURL+"/img/menos2.png");
	 	

	 	$("#imgBancos").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.bancos').hide();

	 	$("#ImgSindicatos").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.sindicatos').hide();
		
	 	$("#imgVentas").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.venta').hide();
	 	$("#imgPuntosdeventas").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.puntosdeventa').hide();
	 	$("#imgSubclientes").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.subcliente').hide();
	 	
	 	$("#imgCompras").attr('src',serverLayoutURL+"/img/menos2.png");
	 	$('.compra').hide();
}
function catchImpCliAFIP(){	
    $('#FormImpcliAFIP').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				alert(data); 
				location.reload();
				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
				location.reload();
			} 
			//aqui no deberiamos recargar la pagina sino simplemente agregar esta info donde debe ser.
		});	
		return false; 
	});
}
function catchImpCliDGR(){
	$('#FormImpcliDGR').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				alert(data); 
				location.reload();
				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
				location.reload();
			} 
			//aqui no deberiamos recargar la pagina sino simplemente agregar esta info donde debe ser.
		});	
		return false; 
	});
}
function catchImpCliDGRM(){
	$('#FormImpcliDGRM').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				alert(data);
				location.reload(); 
				}, 
			error: function(xhr,textStatus,error){ 
				alert(textStatus); 
				location.reload();
			} 
			//aqui no deberiamos recargar la pagina sino simplemente agregar esta info donde debe ser.
		});	
		return false; 
	});
}

