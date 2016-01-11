$(document).ready(function() {

    var iHeaderHeight = $("#header").height() + 40;
    var sCliViewPageHeight = $(window).height();
    sCliViewPageHeight = sCliViewPageHeight - iHeaderHeight;
    sCliViewPageHeight = (sCliViewPageHeight < 250) ? 250 : sCliViewPageHeight;
    $("#divClientesIndex").css("height",sCliViewPageHeight + "px");
    $(".numeric").keyup(function () { 
	    this.value = this.value.replace(/[^0-9\.]/g,'');
	});
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
    
    showDatosCliente();
    activateLabelsFunctionality();    
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
				callAlertPopint(data); 
				loadFormEditarPersona();
				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
		});	
		return false; 
	});
	$('#saveDatosPersonalesForm .ui-datepicker-trigger').datepicker().hide();
	$("#saveDatosPersonalesForm input").change(function () { 
	});
	$('#DomicilioAddForm').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				$("#relatedDomicilios").append(data);
                location.hash ="#x";    

				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
		});	
		return false; 
	});
	$('#ActividadeAddForm').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				$("#relatedActividades").append(data);
                location.hash ="#x";    
				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
		});	
		return false; 
	});
	$('#PersonasrelacionadaAddForm').submit(function(){ 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				$("#relatedPersonas").append(data);
                location.hash ="#x";    
				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
		});	
		return false; 
	});
	
	//Catch de los formularios que agregan impclis y periodos activos y modifican los periodos activos que ya existen

	catchImpCliAFIP();
	catchImpCliDGR();
	catchImpCliDGRM();
	catchImpCliSindicatos();
	catchImpCliBancos();
	
	//esconder de datos personales la edicion y el row de aceptar
	$("#tableDatosPersonalesEdit :input").prop("disabled", true);	
	$('#rowButtonsDetallesPersonales').hide();
	
	//Catch de los formularios que modifican usuario y clave de los organismos AFIP DGR y DGRM
	catchFormOrganismoxCliente('formOrganismoAFIP');
	catchFormOrganismoxCliente('formOrganismoDGR');
	catchFormOrganismoxCliente('formOrganismoDGRM');

	
    $('#txtBuscarClintes').keyup(function () {    
	    var valThis = this.value.toLowerCase();
	    //var lenght  = this.value.length;	    
	    $('a[id^="lnkCliente_"]').each(function () {
	        var oLabelObj = $(this).find('label');
	        var text  = oLabelObj.html();	        
	        var textL = text.toLowerCase();
	        if (textL.indexOf(valThis) >= 0)	        
	        {	
	        	//$(this).slideDown();	        	
	        	$(this).show();	
	        }
	    	else
	    	{
	    		//$(this).slideUp();	    		
	    		$(this).hide();	        	
	    	}	    	
    	});
	    $('a[id^="lnkGrupoCliente_"]').each(function () {	        
	        var textGpo  = $(this).html();	        
	        var textLGpo = textGpo.toLowerCase();	        
	        if (textLGpo.indexOf(valThis) >= 0)	        
	        {	
	        	//$(this).slideDown();	        	
	        	$(this).show();	
	        }
	    	else
	    	{	    		
	    		//$(this).slideUp();	    		
	    		$(this).hide();	        	
	    	}
    	});	   
	});

    $('#txtBuscarClintesDeshabilitados').keyup(function () {    
	    var texto = this.value.toLowerCase();
	    //var lenght  = this.value.length;	    
	    $('a[id^="lnkClienteDeshab_"]').each(function () {
	        var oLabelObjD = $(this).find('label');
	        var textD  = oLabelObjD.html();	        
	        var textLD = textD.toLowerCase();
	        if (textLD.indexOf(texto) >= 0)	        
	        {	
	        	//$(this).slideDown();	
	        	$(this).show();	        	
	        }
	    	else
	    	{
	    		//$(this).slideUp();
	    		$(this).hide();	        	
	    	}	    	
    	});
	    $('a[id^="lnkGpoClienteDeshab_"]').each(function () {	        
	        var textGpoD  = $(this).html();	        
	        var textLGpoD = textGpoD.toLowerCase();
	        if (textLGpoD.indexOf(texto) >= 0)	        
	        {	
	        	//$(this).slideDown();	  
	        	$(this).show();	        	      	
	        }
	    	else
	    	{	    		
	    		//$(this).slideUp();
	    		$(this).hide();	        	
	    	}
    	});	   
	});	
});
function activateLabelsFunctionality(){
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
		$( "#lblActividad" ).click(function() {		
		 if($('.actividades').is(":visible")){
		 	 $('.actividades').hide();
		 	 $("#imgActividad").attr('src',serverLayoutURL+"/img/menos2.png");
		 	}else{
	 		 $('.actividades').show();
			 	 $("#imgActividad").attr('src',serverLayoutURL+"/img/mas2.png");
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
    }
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
				callAlertPopint(data); 
				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
		});	
		return false; 
	});
}
function loadFormEditarPersona(){
	
	if($('#rowButtonsDetallesPersonales').is(":visible")){
		$("#tableDatosPersonalesEdit :input").prop("disabled", true);	
		$('#rowButtonsDetallesPersonales').hide();
		$('#saveDatosPersonalesForm .ui-datepicker-trigger').datepicker().hide();
		
	}else{
		$("#tableDatosPersonalesEdit :input").prop("disabled", false);
		$('#rowButtonsDetallesPersonales').show();
		$( "#saveDatosPersonalesForm #ClienteTipopersona" ).trigger( "change" );
		$('#saveDatosPersonalesForm .ui-datepicker-trigger').datepicker().show();
	
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
         					//$("#form_modificar_domicilio").width("600px");
         					location.href='#modificar_domicilio';   
         					//Overflow: hidden;
         					reloadDatePickers();					
         					
         					//Catch the modify Domicilio
         					$('#DomicilioEditForm').submit(function(){ 
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
										  	var rowid="rowdomicilio"+domid;
                  							$("#"+rowid).html( data);    
                  							location.hash ="#x";    
										}, 
									error: function(xhr,textStatus,error){ 
										callAlertPopint(textStatus); 
									} 
								});	
								return false; 
							});
                       },                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            callAlertPopint(textStatus);
		 	callAlertPopint(XMLHttpRequest);
		 	callAlertPopint(errorThrown);
       }
    });
}
function loadFormPersonaRelacionada(perid,cliid,rowid){	
	var data ="";
    $.ajax({
        type: "post",  // Request method: post, get
        url: serverLayoutURL+"/personasrelacionadas/editajax/"+perid+"/"+cliid,

        // URL to request
        data: data,  // post data
        success: function(response) {
         					$("#form_modificar_persona").html(response);
         					reloadDatePickers();
         					location.href='#modificar_persona';      
         					$('#PersonasrelacionadaEditForm').submit(function(){ 
								//serialize form data 
								var formData = $(this).serialize(); 
								//get form action 
								var formUrl = $(this).attr('action'); 
								$.ajax({ 
									type: 'POST', 
									url: formUrl, 
									data: formData, 
									success: function(data,textStatus,xhr){ 
										$('#'+rowid).replaceWith(data);
						                location.hash ="#x";    
										}, 
									error: function(xhr,textStatus,error){ 
										callAlertPopint(textStatus); 
									} 
								});	
								return false; 
							});   					         			
                       },
                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            callAlertPopint(textStatus);
		 	callAlertPopint(XMLHttpRequest);
		 	callAlertPopint(errorThrown);
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
										callAlertPopint(data); 
										location.href='#close';
										}, 
									error: function(xhr,textStatus,error){ 
										callAlertPopint(textStatus); 
										location.href='#close';
									} 
								});	
								return false; 
							});
                       },                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            callAlertPopint(textStatus);
		 	callAlertPopint(XMLHttpRequest);
		 	callAlertPopint(errorThrown);
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
											callAlertPopint("Impuesto Modificado"); 
											$('#ImpcliEditForm'+impcliid).parent().replaceWith(data);
										}, 
									error: function(xhr,textStatus,error){ 
										callAlertPopint("Deposito NO Modificado. Intente de nuevo mas Tarde"); 
									} 
								});	
								return false; 
							});
					        reloadDatePickers();
                       },
                  
       error:function (XMLHttpRequest, textStatus, errorThrown) {
            callAlertPopint(textStatus);
		 	callAlertPopint(XMLHttpRequest);
		 	callAlertPopint(errorThrown);
       }
    });
}
function getLocalidades(myform,fromfield,tofield){
	var formData = $('#'+myform+' #'+fromfield).serialize(); 
	$.ajax({ 
			type: 'POST', 
			url: serverLayoutURL+'/localidades/getbycategory', 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				$('#'+myform+' #'+tofield).empty();
				$('#'+myform+' #'+tofield).html(data);

				}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
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
 	$('.rowheaderactividades').show();
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
 	$('.rowheaderactividades').hide();
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
 	$('.rowheaderactividades').hide();
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
	$('.actividades').hide();	
		$("#imgActividad").attr('src',serverLayoutURL+"/img/menos2.png");
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
function catchFormAndSaveResult(impForm,impTable,impAlta){
	$('#'+impForm).submit(function(){ 
		$("#"+impForm+" #ImpcliAlta").val($("#"+impForm+" #"+impAlta).val());
		if($("#"+impForm+" #ImpcliAlta").val().length == 0) {
			callAlertPopint("Debe seleccionar un periodo de alta"); 
			return false;
		}
		location.hash ="#x"; 
		//serialize form data 
		var formData = $(this).serialize(); 
		//get form action 
		var formUrl = $(this).attr('action'); 
		$.ajax({ 
			type: 'POST', 
			url: formUrl, 
			data: formData, 
			success: function(data,textStatus,xhr){ 
				var mirespuesta =jQuery.parseJSON(data);
				if(mirespuesta.hasOwnProperty('respuesta')){
              		location.hash ="#x";    						
					callAlertPopint(mirespuesta.respuesta); 
				}else if(mirespuesta.accion == 'editar'){
              		location.hash ="#x";    
					callAlertPopint("Impuesto relacionado con exito.Periodo activo creado.");
					$("#rowImpcli"+mirespuesta.impid).replaceWith(mirespuesta.impclirow);
					$("#"+impForm+" #ImpcliImpuestoId").find('option:selected').remove();						
				}else{
					$("#"+impTable).append(mirespuesta.impclirow);	
					$("#"+impForm+" #ImpcliImpuestoId").find('option:selected').remove();	
              		location.hash ="#x";    
				}
			}, 
			error: function(xhr,textStatus,error){ 
				callAlertPopint(textStatus); 
			} 
			//aqui no deberiamos recargar la pagina sino simplemente agregar esta info donde debe ser.
		});	
		return false; 
	});
}
function catchImpCliAFIP(){	
	catchFormAndSaveResult('FormImpcliAFIP','tablaImpAfip','ImpcliAltaafip');
}
function catchImpCliDGR(){
	catchFormAndSaveResult('FormImpcliDGR','tablaImpDGR','ImpcliAltadgr');
}
function catchImpCliDGRM(){
	catchFormAndSaveResult('FormImpcliDGRM','tablaImpDGRM','ImpcliAltadgrm');	
}
function catchImpCliSindicatos(){
	catchFormAndSaveResult('FormImpcliSindicato','tablaImpSINDICATO','ImpcliAltasindicato');		
}
function catchImpCliBancos(){
	catchFormAndSaveResult('FormImpcliBanco','tablaImpBanco','ImpcliAltabanco');		
}
