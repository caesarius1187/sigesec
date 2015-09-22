<?php echo $this->Html->script('clientes/avance',array('inline'=>false));?>
<?php echo $this->Html->script('http://code.jquery.com/ui/1.10.1/jquery-ui.js',array('inline'=>false));?>
<input class="button" type="button" id="btnShowForm" onClick="showForm()" value="Mostrar" style="display:none" />

<div id="Formhead" class="clientes avanse index">

	<!--<input class="button" type="button" id="btnHiddeForm" onClick="hideForm()" value="Ocultar" style="float:right;"/>-->
	<?php echo $this->Form->create('clientes',array('action' => 'avance')); ?> 
		<table class="tbl_avance">      
        <tr>        	
            <td>
              
              <?php
                echo $this->Form->input('gclis', array(
                    //'multiple' => 'multiple',
                    'type' => 'select',
                    'label' => 'Grupos de clientes' 
                ));?>
                
            </td>
            <td>
              
              <?php
                echo $this->Form->input('lclis', array(
                    //'multiple' => 'multiple',
                    'type' => 'select',
                    'label' => 'Clientes',                    
                ));?>
            </td>
          	<td>                      
              <?php
              echo $this->Form->input('periodomes', array(
                      'options' => array(
                          '01'=>'Enero', 
                          '02'=>'Febrero', 
                          '03'=>'Marzo', 
                          '04'=>'Abril', 
                          '05'=>'Mayo', 
                          '06'=>'Junio', 
                          '07'=>'Julio', 
                          '08'=>'Agosto', 
                          '09'=>'Septiembre', 
                          '10'=>'Octubre', 
                          '11'=>'Noviembre', 
                          '12'=>'Diciembre', 
                          ),
                      'empty' => 'Elegir mes',
                      'label'=> 'Mes',
                      'required' => true, 
                      'placeholder' => 'Por favor seleccione Mes'
                  ));
    	        ?>
            </td>
            <td> 
             <?php echo $this->Form->input('periodoanio', array(
                                                    'options' => array(
                                                        '2014'=>'2014', 
                                                        '2015'=>'2015',     
                                                        ),
                                                    'empty' => 'Elegir año',
                                                    'label'=> 'Año',
                                                    'required' => true, 
                                                    'placeholder' => 'Por favor seleccione año'
                                                    )
                                        );?>
            </td>
            <td> 
              <?php echo $this->Form->input('selectby',array('default'=>'none','type'=>'hidden'));//?>
              <?php echo $this->Form->end(__('Aceptar')); ?>
            </td>
          </tr>
        </table>
</div> <!--End Clietenes_avance-->
<?php /**************************************************************************/ ?>
 <?php /*****************************Mostrar el informe**************************/ ?>
 <?php /**************************************************************************/ ?>
<div class="clientes_avance">
<?php if(isset($mostrarInforme)){

//echo print_r($impuestoshabilitados);
	$periodoSel=$periodomes."-".$periodoanio;
  echo $this->Form->input('periodoSel',array('type'=>'hidden','value'=>$periodoSel));?>

	<table cellpadding="0" cellspacing="0" class="tbl_tareas" id="tbl_tareas"> <!--Tbl 1-->
  <thead>
  <?php /**************************************************************************/ ?>
 <?php /*****************************Row de tareas*****************************/ ?>
 <?php /**************************************************************************/ ?>
	<tr>
    <th valign="top"><label style="width:100px"><?php echo 'Impuestos'; ?></label></th>
			<?php foreach ($tareas as $tarea): ?>
		<th valign="top" class="<?php echo 'tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]; ?>">
          <label style="width:70px">
					<?php echo h($tarea["Tareascliente"]['nombre']); ?>
          </label>
		</th>	
		<?php endforeach; ?>
	</tr>
  </thead>
	<?php/**************************************************************************/ ?>
 <?php /*****************************Recorremos los clientes**********************/ ?>
 <?php /**************************************************************************/ ?>
  <?php foreach ($clientes as $cliente): 
    echo $this->Form->input('cliid'+$cliente['Cliente']['id'],array('type'=>'hidden','value'=>$cliente['Cliente']['id']));
    ?>
  <tbody>
	<tr style="height:30px">
    <td colspan="5" style="height:30px">
            <?php 
              echo $this->Html->link(
                  $cliente['Grupocliente']['nombre'], 
                  array('controller' => 'grupoclientes', 
                  'action' => 'index'),
                  array('style'=>'float:left')); ?>
                <label style="float:right"><?php 
                       echo $this->Html->link(
                      $cliente['Cliente']['nombre'], 
                      array('controller' => 'clientes', 
                      'action' => 'view', $cliente['Cliente']['id'])
                      ); ?>
                </label>
          </td>

          <?php 
          $numcolspan=Count($tareas)-5;
          foreach ($tareas as $tarea){
            if($numcolspan>0){
              echo '<td style="height:30px">&nbsp</td>';
              $numcolspan--;
            }
            
          }?>
  </tr>
  <tr>
		<td>
			<table class="tbl_tareaimp" cellpadding="0" cellspacing="0"> <!--Tbl 1.1-->
				<tr>

        </tr>

  <?php/**************************************************************************/ ?>
 <?php /*****************Reconrremos los impuestos de Cada Cliente****************/ ?>
 <?php /**************************************************************************/ ?>
        <?php
        //
        foreach ($cliente["Impcli"] as $impcli): ?>
				<tr>
          <?php if(Count($impcli['Periodosactivo'])==0){?>
            <td style="height:70px;background-color:#F0F0F0"><?php echo h($impcli['Impuesto']['nombre']);?></td>
          <?php
          }else{?>
            <td style="height:70px"><?php echo h($impcli['Impuesto']['nombre']);?></td>
          <?php }  ?>
					
				</tr>
				<?php endforeach; ?>	
        <?php if(count($cliente["Impcli"])==0){?>
        <tr>
          <td >
                <?php
                echo $this->Html->link("Relacionar Impuestos",
                                array(
                                  'controller' => 'clientes', 
                                  'action' => 'view', 
                                  $cliente["Cliente"]["id"]
                                  )
                          );  
              ?>  
         </td>
        </tr>
       <?php }?>
			</table>
		</td>	

  <?php/**************************************************************************/ ?>
 <?php /****************Recorremos las tareas una ves por cada impuesto de********/ ?>
 <?php /**cliente chekiando que la tarea este habilitada para el usuario logueado**/ ?>
  <?php/**************************************************************************/ ?>

		<?php 
    foreach ($tareas as $tarea): 
				$eventVacio=0;                                                            //bandera para evento vacio
				$tareaFild='tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]; //nombre de la tarea que estoy recorriendo
      $Tareahabilitado=false;                                                     //por defecto no esta habilitada la tarea
    if($tarea["Tareasxclientesxestudio"]['user_id']==$this->Session->read('Auth.User.id')){ 
      $Tareahabilitado=true;
    }   
  		if($tarea["Tareasxclientesxestudio"]['tipo']=="cliente"){
  				//tarea tipo cliente?>
            <?php/**************************************************************************/ ?>
           <?php /*******************************tarea tipo cliente*************************/ ?>
           <?php /**************************************************************************/ ?>
  				<?php
  				$eventoNoCreado=true; 
  				foreach ($cliente["Eventoscliente"] as $evento): 
  				if($evento['periodo']==$periodoSel){
    				//Recorremos el evento de este periodo (supuestamente vendra uno solo por cada impuesto del cliente)

            //Si el evento en esta tarea esta ""PENDIENTE""
    				if($evento[$tareaFild]=='pendiente'){?>
      				<?php $params= $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','realizado'";?>             
          		<td class="pendiente  <?php echo $tareaFild;?>" id="cell<?php echo $cliente['Cliente']['id'].'-'.$tareaFild;?>">  
                <?php 
                //Si el evento esta habilitado
                if($Tareahabilitado) {
                  $confImg=array('width' => '20', 'height' => '20','onClick'=>"realizarEventoCliente(".$params.")");
                  if($tareaFild=="tarea5"){
                    $confImg=array('width' => '20', 'height' => '20','onClick'=>"verFormCargar(".$params.")");
                  }
                } else{
                  $confImg=array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()");
                } ?>         
          		  <?php echo $this->Html->image('add.png',$confImg)?>

              </td>
        		<?php }            
             //Si el evento en esta tarea esta ""REALIZADO""
            if($evento[$tareaFild]=='realizado'){?>
              <?php $paramsVer = $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','pendiente'";?>
              <td class="realizado  <?php echo $tareaFild;?>" id="cell<?php echo $cliente['Cliente']['id'].'-'.$tareaFild;?>">
                <?php echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"realizarEventoCliente(".$paramsVer.")"))?> 
              </td>
        		<?php }
            $eventoNoCreado=false;
            }
          ?>
      		<?php endforeach;
      		if($eventoNoCreado){	
              //SI el evento no esta creado procedemos por aca ""NO CREADO""
              ?> 	      				
             	<td id="cell<?php echo $cliente['Cliente']['id'].'-'.$tareaFild;?>" class="pendiente  <?php echo $tareaFild;?>">
      		    <?php 
      		    	$params= "0,'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','realizado'";
      			    $eventVacio++;?>
                <?php if($Tareahabilitado) {
                  $confImg=array('width' => '20', 'height' => '20','onClick'=>"realizarEventoCliente(".$params.")");
                } else{
                  $confImg=array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()");
                } ?>         
                <?php echo $this->Html->image('add.png',$confImg)?>
      		    </td>
      		<?php } ?>
  		<?php }

		  if($tarea["Tareasxclientesxestudio"]['tipo']=="impuesto"){
        //tarea tipo impuesto?>
    		<td class="impuesto"> <!--Tbl 1.2-->
          <table class="tbl_tareaimp" cellpadding="0" cellspacing="0">
            <?php 
            $hayImpuestoRelacioado=false;
            foreach ($cliente["Impcli"] as $impcli): 
                //Recorremos los impuestos de cada cliente
                $hayImpuestoRelacioado=true;

                $eventoNoCreado=true; 
                $eventoCliente=array();
                //Recorremos los impuestos de cada cliente
                //Chekiamos si el evento esta creado
                foreach ($impcli["Eventosimpuesto"] as $evento): 
                    if($evento['periodo']==$periodoSel){
                        $eventoCliente=$evento;
                        $eventoNoCreado=false;
                    }
                ?>
            <?php endforeach;
            $tareaFild='tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"];?>
            <tr>

      	  	<?php if($eventoNoCreado){	
                //Si el evento no esta creado ""NO CREADO""
                /*
                  Los parametros que necesito son los siguientes
                  Parametros Generales
                    periodoSel(creado)
                  Parametros de ROW Cliente                    
                    cliid 
                      id = 'clienteID'+cliidID (creado)
                  Parametros de ROW Impuesto
                    eventoID 
                      id = 'cliid-'+cliid+'impclid-'+ impcliID
                    impcliID
                      id = 'impclid-'+ impcliID
  
                  Parametros de Cell                    
                    
                    fchvto
                      id = 'fchvto'+eventoID
                    montovto
                      id = 'montovto'+eventoID
                    monc
                      id = 'monc'+eventoID
                    descripcion
                      id = 'descripcion'+eventoID

                  La logica es
                  Evento no creado
                  | TRUE
                  | |   EstoyHabilitado
                  | |   |  Habilitado
                  | |   |  |  numero de tarea
                  | |   |  |  |Tarea 5          showPapelesDeTrabajo. Crea el Evento y llama al popin para esos eventos
                  | |   |  |  |Tarea 13
                  | |   |  |  |Tarea normal
                  | |   |  Deshabilitado              
                  | False
                  | |   Estado
                  | |   | Pendiente
                  | |   |   Habilitado
                  | |   |   |  numero de tarea
                  | |   |   |  |Tarea 5         papelesDeTrabajo          
                  | |   |   |  |Tarea 13
                  | |   |   |  |Tarea normal
                  | |   |   Deshabilitado              
                  | |   | Realizado
                  | |   |   Habilitado
                  | |   |   |  numero de tarea
                  | |   |   |  |Tarea 5
                  | |   |   |  |Tarea 13
                  | |   |   |  |Tarea normal
                  | |   |   Deshabilitado              
                  
                  */



                /*  Parametros de ROW Impuesto
                    eventoID 
                      id = 'eventoID-cliid-'+cliid+'impclid-'+ impcliID
                    */
                   echo $this->Form->input('eventoID-cliid-'+$cliente['Cliente']['id']+'impclid-'+ $impcli["id"],
                                            array('type'=>'hidden','value'=>0));

                ?> 	
              	<td class="pendiente " id="cellimp<?php echo $cliente['Cliente']['id'].'-'.$tareaFild.'-'.$impcli['id'];?>"> 
                  <?php


                	 $params= "0,'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','realizado'";
                   /* Parametros de Cell                                       
                      fchvto
                        id = 'fchvto'+impclid
                      montovto
                        id = 'montovto'+impclid
                      monc
                        id = 'monc'+impclid
                      descripcion
                        id = 'descripcion'+impclid
                  */

                   echo $this->Form->input('montovto-'+ $impcli["id"],
                                            array('type'=>'hidden','value'=>0));

                    if($Tareahabilitado) {
                      //Aqui controlo si el evento esta que siendo realizado es uno que debe mostrar un popin 
                      if($tareaFild=="tarea5"){
                          //Tarea5 es "Prepar Papeles de Trabajo" debe mostrar popin para inicializar variables del pagoa realiar del impuesto
                          $paramsPrepPapeles= "'".$periodoSel."','".$impcli['id']."'";
                          echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"papelesDeTrabajo(".$paramsPrepPapeles.")"));
                      } elseif ($tareaFild=="tarea13") {
                        //Tarea13 es "A Pagar" debe mostrar popin para cargar variables del pago realizado del impuesto
                        echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"showPagar(".$paramsPrepPapeles.")"));
                      } else {
                        echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"realizarEventoImpuesto(".$params.")"));
                      }                     
                    } else{
                       echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()"));
                    } ?>                                                      
                </td>
          	<?php	
            }	else {
              	if($evento[$tareaFild]=='pendiente'){
                    //Si el evento esta ""PENDIENTE""?>          
                  	<td class="pendiente  <?php echo $tareaFild;?>" id="cellimp<?php echo $cliente['Cliente']['id'].'-'.$tareaFild.'-'.$impcli['id'];?>" >

                      <?php $params= $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','realizado'";?>
                      <?php $paramsPrepPapeles= "'".$periodoSel."','".$impcli['id']."'";?>

                      <?php if($Tareahabilitado) {
                     
                          //Aqui controlo si el evento esta que siendo realizado es uno que debe mostrar un popin 
                          if($tareaFild=="tarea5"){
                          //Tarea5 es "Prepar Papeles de Trabajo" debe mostrar popin para inicializar variables del pagoa realiar del impuesto

                            echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"papelesDeTrabajo(".$paramsPrepPapeles.")"));
                          }elseif ($tareaFild=="tarea13") {
                          //Tarea13 es "A Pagar" debe mostrar popin para cargar variables del pago realizado del impuesto
                            echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"showPagar(".$paramsPrepPapeles.")"));

                          }else{
                            echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"realizarEventoImpuesto(".$params.")"));
                          }

                      } else{
                        //El evento no esta habilitado
                         echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()"));
                      } ?>                            
                    </td>
          	  	<?php }
                        	
        		    if($evento['tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]]=='realizado'){
                  //Si el evento esta ""Realizado""
                  $paramsVer= $evento['id'].",'".$tareaFild."','".$impcli['id']."'";?>            
              	   <td class="realizado "> 
                                           
                       <?php $params= $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','pendiente'";?>
                       <?php $paramsPrepPapeles= "'".$periodoSel."','".$impcli['id']."'";?>
                       <?php //$paramsModPagar= $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','".$evento['montorealizado']."','".$evento['fchrealizado']."'";?>   
                      <?php if($Tareahabilitado) {
                          // esta dentro de algun periodo que permita trabajar en el impuesto?

                          //Aqui controlo si el evento esta que siendo realizado es uno que debe mostrar un popin 
                          if($tareaFild=="tarea5"){
                          //La Tarea 5 es "Prepar Papeles de Trabajo" debe mostrar popin para inicializar variables del pago a realiar del impuesto

                            /* ************************************************** 
                            Aqui deberia preguntar que tipo de impuesto es y si este impuesto se paga por provincia, localidad o item debe desplegar un formulario que te permita cargar varios eventos. */

                             echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"papelesDeTrabajo(".$paramsPrepPapeles.")"));
                          }elseif ($tareaFild=="tarea13") {
                          //Tarea13 es "A Pagar" debe mostrar popin para cargar variables del pago realizado del impuesto
                            echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"showPagar(".$paramsPrepPapeles.")"));

                          }else{
                            echo $this->Html->image('edit.png',array('width' => '20', 'height' => '20','onClick'=>"realizarEventoImpuesto(".$params.")"));
                          }                     
                      } else{
                        //NO esta Habiltiado para realizar esta Tarea de Impuesto
                         echo $this->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()"));
                      } ?>  
                    </td> 
                    <?php 	} 
                } ?></td>
                </tr>
          			<?php endforeach; 
          			if(!$hayImpuestoRelacioado){  ?> 	
                  <tr>
                  		<td class="pendiente"></td>
                  </tr>
    					<?php	}?>
      				</table>	
            </td>				
        <?php }?>	
        <?php endforeach; ?>
     </tr>
  	 <?php endforeach; ?>
     </tbody>
 	 </table>
	 <?php } ?>
</div>
<div id="popInCrearEventCli">

</div>
<!-- Inicio Popin Preparar papeles de Trabajo -->
<a href="#x" class="overlay" id="PIPrepararPapeles"></a>
<div class="popup">
  <div class='section body'>
      <div id="form_prepararPapeles" class="prepararPapeles form">
      <fieldset>
        <legend><?php echo __('Preparar Papeles de Trabajo'); ?></legend>
        <?php         
       
          echo $this->Form->input('eventId',array('default'=>"",'type'=>'hidden'));
          echo $this->Form->input('tarea',array('default'=>"",'type'=>'hidden'));
          echo $this->Form->input('clienteid',array('default'=>"",'type'=>'hidden'));
          echo $this->Form->input('periodo',array('default'=>"",'type'=>'hidden'));
          echo $this->Form->input('impcliid',array('default'=>"",'type'=>'hidden'));
          //,'type'=>'hidden'
           echo $this->Form->input('fchvto', array(
                      'class'=>'datepicker', 
                      'type'=>'text',
                      'label'=>'Fecha de Vencimiento',
                      'readonly','readonly')
           );

          echo $this->Form->input('montovto',array('label'=>'Monto a Pagar','default'=>"0"));
          echo $this->Form->input('monc',array('label'=>'Monto a Favor','default'=>"0"));
          echo $this->Form->input('descripcion',array('default'=>"-"));        
        ?>
      </fieldset>
      <a href="#"  onclick="enviarPrepararPapeles()" class="btn_aceptar">  Agregar </a>
    </div>
  </div>
  <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Preparar papeles de Trabajo  --> 
<!-- Inicio Popin Pagar -->
<a href="#x" class="overlay" id="PIPagar" ></a>
<div class="popup" style="width:1100px">
  <div class='section body'>
      <div id="form_pagar" class="pagar form" >
      
      <a href="#"  onclick="enviarPagar()" class="btn_aceptar">  Agregar </a>
    </div>
  </div>
  <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Pagar--> 

<!-- Inicio Popin getPrepararPapeles -->
<a href="#x" class="overlay" id="popInPapelesDeTrabajo"></a>
<div  class="popup" style="width:1100px">
  <div class='section body' id="divpopPapelesDeTrabajo">
     
  </div>
  <a class="close" href="#close"></a>
</div>
<!-- Fin Popin getPrepararPapeles--> 

