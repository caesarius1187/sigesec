<?php echo $this->Html->script('clientes/avance',array('inline'=>false)); ?>
<?php echo $this->Html->script('http://code.jquery.com/ui/1.10.1/jquery-ui.js',array('inline'=>false)); ?>
<input class="button" type="button" id="btnShowForm" onClick="showForm()" value="Mostrar" style="display:none" />

<div id="Formhead" class="clientes avanse index" style="width:99%; margin:0px 0px 8px 0px">

  <!--<input class="button" type="button" id="btnHiddeForm" onClick="hideForm()" value="Ocultar" style="float:right;"/>-->
  <?php 
  echo $this->Form->create('clientes',array('action' => 'avance')); ?> 
  <table class="tbl_avance">      
    <tr>          
      <td>
        <?php
        echo $this->Form->input('gclis', array(
          //'multiple' => 'multiple',
          'type' => 'select',
          'label' => 'Grupos de clientes' 
        )); ?>
      </td>
      <td>              
        <?php
        echo $this->Form->input('lclis', array(
          //'multiple' => 'multiple',
          'type' => 'select',
          'label' => 'Clientes',                    
        )); ?>
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
                                                  '2016'=>'2016',     
                                                  '2017'=>'2017',     
                                                  '2018'=>'2018',     
                                                  ),
                                              'empty' => 'Elegir año',
                                              'label'=> 'Año',
                                              'required' => true, 
                                              'placeholder' => 'Por favor seleccione año'
                                              )
                                  ); ?>
      </td>
      <td> 
        <?php echo $this->Form->input('selectby',array('default'=>'none','type'=>'hidden'));// ?>
        <?php echo $this->Form->end(__('Aceptar')); ?>
      </td>
    </tr>
  </table>
</div> <!--End Clietenes_avance-->
  <?php /**************************************************************************/  ?>
  <?php /*****************************Mostrar el informe**************************/  ?>
  <?php /**************************************************************************/ ?>
<div class="clientes_avance">
  <?php 
  if(isset($mostrarInforme)){
  //echo print_r($impuestoshabilitados);
  $periodoSel=$periodomes."-".$periodoanio;
  echo $this->Form->input('periodoSel',array('type'=>'hidden','value'=>$periodoSel)); ?>
  <table cellpadding="0" cellspacing="0" class="tbl_tareas" id="tbl_tareas"> <!--Tbl 1-->
    <thead>
      <?php /**************************************************************************/  ?>
      <?php /*****************************Row de tareas*****************************/  ?>
      <?php /**************************************************************************/  ?>
      <tr>
        <th valign="top"><label style="width:100px"><?php echo 'Impuestos'; ?></label></th>
          <?php foreach ($tareas as $tarea){ ?>
            <th valign="top" class="<?php echo 'tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]; ?> ">
              <label style="width:70px">
              <?php echo h($tarea["Tareascliente"]['nombre']); ?>
              </label>
            </th> 
        <?php }; ?>
      </tr>
    </thead>
    <?php /**************************************************************************/ ?>
    <?php /*****************************Recorremos los clientes**********************/ ?>
    <?php /**************************************************************************/ ?>
    <tbody>
      <?php 
      foreach ($clientes as $cliente){ 
        echo $this->Form->input('cliid'+$cliente['Cliente']['id'],array('type'=>'hidden','value'=>$cliente['Cliente']['id']));
         ?>
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
          } ?>
        </tr>
        <tr>
          <td>
            <table class="tbl_tareaimp" cellpadding="0" cellspacing="0"> <!--Tbl 1.1-->       
              <?php
              //Aqui se pinta la caja que identifica a que impuesto pertenece cada row.
              foreach ($cliente["Impcli"] as $impcli){ ?>
              <tr>
                <?php 
                if(Count($impcli['Periodosactivo'])==0){ ?>
                  <td style="height:70px;background-color:#F0F0F0"><?php echo h($impcli['Impuesto']['nombre']); ?></td>
                <?php
                }else{ ?>
                  <td style="height:70px"><?php echo h($impcli['Impuesto']['nombre']); ?></td>
                <?php }  ?>
              </tr>
              <?php }; 
              if(count($cliente["Impcli"])==0){ ?>
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
              <?php } ?>
            </table>
          </td> 
          <?php /**************************************************************************/ ?>
          <?php /****************Recorremos las tareas una ves por cada evento de impuesto**/ ?>
          <?php /**cliente chekiando que la tarea este habilitada para el usuario logueado**/ ?>
          <?php /**********************y que tipo de tarea es*******************************/ ?>

          <?php 
          foreach ($tareas as $tarea){ 
          $tareaFild='tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]; //nombre de la tarea que estoy recorriendo
          $Tareahabilitado=false;                                                   //por defecto no esta habilitada la tarea
          if($tarea["Tareasxclientesxestudio"]['user_id']==$this->Session->read('Auth.User.id')){ 
            $Tareahabilitado=true;
          }   
          if($tarea["Tareasxclientesxestudio"]['tipo']=="cliente"){ ?>
            <?php /**************************************************************************/ ?>
            <?php /*******************************tarea tipo cliente*************************/ ?>
            <?php /**************************************************************************/ ?>
            <?php
            $eventoCreado=false; 
           
            foreach ($cliente["Eventoscliente"] as $evento){          
              mostrarEventoCliente($this, $evento, $periodoSel, $tareaFild, $cliente,$Tareahabilitado);
              $eventoCreado=true;           
            }; 
            if(!$eventoCreado){
              mostrarEventoCliente($this, null, $periodoSel, $tareaFild, $cliente,$Tareahabilitado);
            }
          }
          if($tarea["Tareasxclientesxestudio"]['tipo']=="impuesto"){
            //tarea tipo impuesto ?>
            <td class="impuesto"> <!--Tbl 1.2-->
              <table class="tbl_tareaimp" cellpadding="0" cellspacing="0">
                <?php 
                $hayImpuestoRelacioado=false;
                foreach ($cliente["Impcli"] as $impcli){ 
                  //Recorremos los impuestos de cada cliente
                  $hayImpuestoRelacioado=true;
                  $eventoNoCreado=true; 
                  //Recorremos los impuestos de cada cliente
                  //Chekiamos si el evento esta creado
                  foreach ($impcli["Eventosimpuesto"] as $evento){ 
                    if($evento['periodo']==$periodoSel){
                      $eventoNoCreado=false;
                    }
                  }
                  $tareaFild='tarea'.$tarea["Tareasxclientesxestudio"]["tareascliente_id"]; ?>
                  <tr>
                    <?php if($eventoNoCreado){  
                      mostrarEventoImpuesto($this, null, $tareaFild, $periodoSel, $cliente, $impcli, $Tareahabilitado); 
                    } else {
                      mostrarEventoImpuesto($this, $evento, $tareaFild, $periodoSel, $cliente, $impcli, $Tareahabilitado); 
                    }?>
                  </tr>
                <?php 
                } 
                if(!$hayImpuestoRelacioado){  ?>  
                  <tr>
                      <td class="pendiente"></td>
                  </tr>
                <?php } ?>
              </table>  
            </td>       
          <?php 
          }  
        } ?>
        </tr>
        <?php 
      } ?>
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
<div class="popup" style="width:auto" >
  <a class="close" href="#close"></a>
      <div id="form_pagar" class="pagar form" style="float:left">
        
        <a href="#"  onclick="enviarPagar()" class="btn_aceptar">  Agregar </a>
    </div>
  </div>
  <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Pagar--> 

<!-- Inicio Popin getPrepararPapeles -->
<a href="#x" class="overlay" id="popInPapelesDeTrabajo"></a>
<div  class="popup" style="width:auto" id="divpopPapelesDeTrabajo">

  <a class="close" href="#close"></a>
</div>
<a href="#x" class="overlay" id="popInSolicitar"></a>
<div  class="popup" style="width:auto" id="divpopSolicitar">
  <div class="honorarios form">
  <?php echo $this->Form->create('Honorario',array('id'=>'formAddHonoraio','controller'=>'honorarios','action'=>'add')); ?>
    <fieldset>
      <legend><?php echo __('Agregar Honorario'); ?></legend>
    <?php
      echo $this->Form->input('id',array('type'=>'hidden'));
      echo $this->Form->input('evento_id',array('type'=>'hidden'));
      echo $this->Form->input('cliente_id',array('type'=>'hidden'));
      echo $this->Form->input('clientenombre',array('type'=>'text'));
      echo $this->Form->input('monto');
      echo $this->Form->input('fecha');
      echo $this->Form->input('fecha', array(
                                      'class'=>'datepicker', 
                                      'type'=>'text',
                                      'label'=>'Fecha',                                    
                                      'readonly'=>'readonly')
                                 );
      echo $this->Form->input('descripcion');
      echo $this->Form->input('periodo',array('type'=>'hidden'));
      echo $this->Form->input('estado',array('type'=>'hidden','value'=>'habilitado'));
    ?>
    </fieldset>
  <?php echo $this->Form->end(__('Agregar')); ?>
  </div>
  <a class="close" href="#close"></a>
</div>
<a href="#x" class="overlay" id="popInInformar"></a>
<div  class="popup" style="width:auto" id="divpopInformar">
  <div class="deposito form">
  <?php echo $this->Form->create('Deposito',array('id'=>'formAddDeposito','controller'=>'depositos','action'=>'add')); ?>
    <fieldset>
      <legend><?php echo __('Agregar Recibo'); ?></legend>
    <?php
      echo $this->Form->input('id',array('type'=>'hidden'));
      echo $this->Form->input('evento_id',array('type'=>'hidden'));
      echo $this->Form->input('cliente_id',array('type'=>'hidden'));
      echo $this->Form->input('clientenombre',array('type'=>'text'));
      echo $this->Form->input('monto');
      echo $this->Form->input('fecha');
      echo $this->Form->input('fecha', array(
                                      'class'=>'datepicker', 
                                      'type'=>'text',
                                      'label'=>'Fecha',                                    
                                      'readonly'=>'readonly')
                                 );
      echo $this->Form->input('descripcion');
      echo $this->Form->input('periodo',array('type'=>'hidden'));
      echo $this->Form->input('estado',array('type'=>'hidden','value'=>'habilitado'));
    ?>
    </fieldset>
  <?php echo $this->Form->end(__('Agregar')); ?>
  </div>
  <a class="close" href="#close"></a>
</div>
<?php 
function mostrarEventoCliente($context, $evento, $periodoSel, $tareaFild, $cliente,$Tareahabilitado){
    //Recorremos el evento de este periodo (supuestamente vendra uno solo por cada impuesto del cliente)
    //Si el evento en esta tarea esta ""PENDIENTE""
    $eventoID = 0;
    $params="";
    if($evento!=null){
      $eventoID = $evento['id'];
    }
    $class = 'pendiente';
    if($evento==null||$evento[$tareaFild]=='pendiente'){ 
       $class = 'pendiente';
     }  else if($evento[$tareaFild]=='realizado') { 
       $class = 'realizado';
     }  
      $params= $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','realizado'"; ?>   
      <td class="<?php echo $class.' '.$tareaFild; ?>" id="cell<?php echo $cliente['Cliente']['id'].'-'.$tareaFild; ?>">  
        <?php 
        //Si el evento esta habilitado
        $confImg=array('width' => '20', 'height' => '20', 'title' => 'Pendiente','onClick'=>"realizarEventoCliente(".$params.")");
        if($Tareahabilitado) {
          if($tareaFild=="tarea1"){
            //En esta tarea vamos a crear el Honorario por que solician la documentacion de los impuestos a liquidar
            $honorario = array();
            $honorarioCreado=false; 

            foreach ($cliente["Honorario"] as $vhonorario){          
              $honorario = $vhonorario;
              $honorarioCreado=true; 
            }; 
            if($honorarioCreado){
              $paramsSolicitar= $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$cliente['Cliente']['nombre']."','realizado','".$honorario['id']."','".$honorario['monto']."','".$honorario['fecha']."','".$honorario['descripcion']."'";
            }else{
              $paramsSolicitar= $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$cliente['Cliente']['nombre']."','realizado','0','0','".date("d-m-Y")."',''";
            }
            
            $confImg=array('width' => '20', 'height' => '20', 'title' => 'Pendiente' ,'onClick'=>"verFormSolicitar(".$paramsSolicitar.")");
          }
          if($tareaFild=="tarea14"){
            //Tarea Informar[en esta tarea informamos al cliente lo que debe pagar y le solicitamos la plata]
            $deposito = array();
            $depositoCreado=false; 
            foreach ($cliente["Deposito"] as $vdeposito){          
              $deposito = $vdeposito;
              $depositoCreado=true; 
            }; 
            if($depositoCreado){
              $paramsInformar= $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$cliente['Cliente']['nombre']."','realizado','".$deposito['id']."','".$deposito['monto']."','".$deposito['fecha']."','".$deposito['descripcion']."'";
            }else{
              $paramsInformar= $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$cliente['Cliente']['nombre']."','realizado','0','0','".date("d-m-Y")."',''";
            }
            
            $confImg=array('width' => '20', 'height' => '20', 'title' => 'Pendiente' ,'onClick'=>"verFormInformar(".$paramsInformar.")");
          }

        } else{
          $confImg=array('width' => '20', 'height' => '20', 'title' => 'Pendiente','onClick'=>"noHabilitado()");
        } 
        echo $context->Html->image('add.png',$confImg); ?>
      </td>
    <?php 
   
     //Si el evento en esta tarea esta ""REALIZADO"" ?>

      <?php /* $paramsVer = $eventoID.",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','pendiente'"; ?>
      <td class="realizado  <?php echo $tareaFild; ?>" id="cell<?php echo $cliente['Cliente']['id'].'-'.$tareaFild; ?>">
        <?php echo $context->Html->image('edit.png',array('width' => '20', 'title' => 'Realizado','height' => '20','onClick'=>"realizarEventoCliente(".$paramsVer.")")); ?> 
      </td>
    <?php */     
}
function mostrarEventoImpuesto($context, $evento, $tareaFild, $periodoSel, $cliente, $impcli, $Tareahabilitado){
  if ($evento==null){
    //Si el evento no esta creado ""NO CREADO""
    echo $context->Form->input('eventoID-cliid-'+$cliente['Cliente']['id']+'impclid-'+ $impcli["id"],array('type'=>'hidden','value'=>0)); ?>  
    <td class="pendiente " id="cellimp<?php echo $cliente['Cliente']['id'].'-'.$tareaFild.'-'.$impcli['id']; ?>"> 
      <?php
      $params= "0,'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','realizado'";
      $paramsPrepPapeles= "'".$periodoSel."','".$impcli['id']."'";
      if($Tareahabilitado) {
        //Aqui controlo si el evento esta que siendo realizado es uno que debe mostrar un popin 
        if($tareaFild=="tarea5"){
            //Tarea5 es "Prepar Papeles de Trabajo" debe mostrar popin para inicializar variables del pagoa realiar del impuesto
            echo $context->Html->image('edit.png',array('width' => '20', 'title' => 'Papeles de Trabajo','height' => '20','onClick'=>"papelesDeTrabajo(".$paramsPrepPapeles.")"));
        } else if ($tareaFild=="tarea13") {
          //Tarea13 es "A Pagar" debe mostrar popin para cargar variables del pago realizado del impuesto
          echo $context->Html->image('add.png',array('width' => '20', 'height' => '20','title' => 'Pagar','onClick'=>"showPagar(".$paramsPrepPapeles.")"));
        } else {
          echo $context->Html->image('add.png',array('width' => '20', 'title' => 'Pendiente','height' => '20','onClick'=>"realizarEventoImpuesto(".$params.")"));
        }                     
      } else{
        echo $context->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()"));
      } ?>                                                      
    </td> <?php
    return ;
  }
  $tdClass = 'pendiente';
  if($evento[$tareaFild]=='pendiente'){
    $tdClass = 'pendiente';
  }else if($evento[$tareaFild]=='realizado'){
    $tdClass = 'realizado';
  }



    //Si el evento esta ""PENDIENTE"" ?>          
    <td class="<?php echo $tdClass.' '.$tareaFild; ?>" id="cellimp<?php echo $cliente['Cliente']['id'].'-'.$tareaFild.'-'.$impcli['id']; ?>" >
      <?php $params= $evento['id'].",'".$tareaFild."','".$periodoSel."','".$cliente['Cliente']['id']."','".$impcli['id']."','realizado'"; ?>
      <?php $paramsPrepPapeles= "'".$periodoSel."','".$impcli['id']."'"; ?>

      <?php 
        if($Tareahabilitado) {
          //Aqui controlo si el evento esta que siendo realizado es uno que debe mostrar un popin 
          if($tareaFild=="tarea5"){
            //Tarea5 es "Prepar Papeles de Trabajo" debe mostrar popin para inicializar variables del pagoa realiar del impuesto
            echo $context->Html->image('edit.png',array('width' => '20', 'title' => 'Papeles de Trabajo','height' => '20','onClick'=>"papelesDeTrabajo(".$paramsPrepPapeles.")"));
          }else if ($tareaFild=="tarea13") {
            //Tarea13 es "A Pagar" debe mostrar popin para cargar variables del pago realizado del impuesto
            echo $context->Html->image('add.png',array('width' => '20', 'title' => 'Pagar' , 'height' => '20','onClick'=>"showPagar(".$paramsPrepPapeles.")"));

          }else{
            echo $context->Html->image('add.png',array('width' => '20', 'title' => 'Cargar','height' => '20','onClick'=>"realizarEventoImpuesto(".$params.")"));
          }

        } else {
          //El evento no esta habilitado
           echo $context->Html->image('add.png',array('width' => '20', 'height' => '20','onClick'=>"noHabilitado()"));
        } ?>                            
    </td>
  </td>
<?php } ?>