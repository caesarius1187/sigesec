<?php echo $this->Html->script('jquery-ui',array('inline'=>false));?>

<?php echo $this->Html->script('clientes/view',array('inline'=>false));?>
<!--Div izquierdo que muestra lista de grupo de clientes con sus clientes-->
<?php 
$widthDivClientes=25;
if(!$mostrarView){
    $widthDivClientes=95;
}?>
<div class="clientes_view" style="width:<?php echo $widthDivClientes;?>%; ">
    <?php 
        echo $this->Html->script('jquery.dataTables.grouping',array('inline'=>false))   
    ;?>
 <?php /**************************************************************************/ ?>
 <?php /*****************************Div CLientes*****************************/ ?>
 <?php /**************************************************************************/ ?>
<div id="divClientesIndex" class="clientes index" style="margin:0px; overflow:auto;">
    <table>
        <td>
            <h2>
                <?php 
                  if($mostrarView){
                        echo __($cliente['Cliente']['nombre']);                        
                    } 
                    else{
                        echo __('Clientes'); 
                    }            
                ?>
            </h2>
        </td>
        <td style="text-align: right;" title="Agregar Cliente">
            <div class="fab blue">
            <core-icon icon="add" align="center">
                
                <?php echo $this->Form->button('+', 
                                            array('type' => 'button',
                                                'class' =>"btn_add",
                                                'onClick' => "window.location.href='".Router::url(array(
                                                                                    'controller'=>'Clientes', 
                                                                                    'action'=>'add')
                                                                                    )."'"
                                                )
                        );?> 
            </core-icon>
            <paper-ripple class="circle recenteringTouch" fit></paper-ripple>
            </div>
        </td>
    </table>

    <div class="section_view" >
        
        <?php 
        if(count($clienteses)!=0){
             $grupoMostrar=$clienteses[0]['Grupocliente']['nombre'];
        echo $this->Html->link(
                        $clienteses[0]['Grupocliente']['nombre'], 
                        array(
                            'controller' => 'grupoclientes', 
                            'action' => 'view', 
                            $clienteses[0]['Grupocliente']['id']
                        ),
                        array('class' => 'lbl_gpo_view')
                        );
         foreach ($clienteses as $clientex): ?>
                <?php 
                if($grupoMostrar!=$clientex['Grupocliente']['nombre']){
                    $grupoMostrar=$clientex['Grupocliente']['nombre'];
                    echo "</div>";
                    echo "<div class='section_view'>";
                    echo $this->Html->link(
                                    $clientex['Grupocliente']['nombre'], 
                                    array(
                                        'controller' => 'grupoclientes', 
                                        'action' => 'index', 
                                    ), 
                                    array('class' => 'lbl_gpo_view'));
                }
                $classCliente =  "section_cli_view";
                if($mostrarView){
                    if($clientex['Cliente']['id']==$cliente['Cliente']['id']){
                        $classCliente = "section_cli_view_selected";
                    }             
                }

                echo $this->Html->link(
                    $this->Html->div(
                                $classCliente, 
                                $this->Html->image('cli_view.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'float:left')).
                                __($this->Form->label('Cliente', $clientex['Cliente']['nombre'], 'lbl_cli_view',array('style'=>'float:right'))), 
                                array()), 
                    array('action' => 'view', $clientex['Cliente']['id']),
                    array('escape'=>false, 'style' => 'text-decoration:none;')

                    ); 
                ?>

            <?php endforeach;
        }else{?>
            Agregar Grupos de Clientes
       <?php }
       if(count($clientesesDeshabilitados)!=0){
             $grupoMostrar=$clientesesDeshabilitados[0]['Grupocliente']['nombre'];
        echo $this->Html->link(
                        $clientesesDeshabilitados[0]['Grupocliente']['nombre'], 
                        array(
                            'controller' => 'grupoclientes', 
                            'action' => 'view', 
                            $clientesesDeshabilitados[0]['Grupocliente']['id']
                        ),
                        array('class' => 'lbl_gpo_view')
                        );
        echo '<h2>  Clientes Deshabilitados </h3>';
         foreach ($clientesesDeshabilitados as $clientex): ?>
                <?php 
                if($grupoMostrar!=$clientex['Grupocliente']['nombre']){
                    $grupoMostrar=$clientex['Grupocliente']['nombre'];
                    echo "</div>";
                    echo "<div class='section_view'>";
                    echo $this->Html->link(
                                    __($clientex['Grupocliente']['nombre']), 
                                    array(
                                        'controller' => 'grupoclientes', 
                                        'action' => 'index', 
                                       
                                    ), 
                                    array('class' => 'lbl_gpo_view_deshabilitado'));
                }
                ?>
                <?php 
                    $divUsuario = $this->Html->div(
                                                "section_cli_view_deshabilitado", 
                                                $this->Html->image('cli_view.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'float:left')).
                                                __($this->Form->label('Cliente', $clientex['Cliente']['nombre'], 'lbl_cli_view',array('style'=>'float:right'))), 
                                                array()
                                                );
                    echo $this->Form->postLink(
                        $divUsuario, 
                        array(
                            'action' => 'habilitar', 
                            $clientex['Cliente']['id']), 
                            array('escape'=>false), 
                            __('Esta seguro que quiere Habilitar a '.$clientex['Cliente']['nombre'].'? Aparecera en todos los Informes', $clientex['Cliente']['id']
                            )
                    ); ?>    
            <?php endforeach;
        }else{?>
            No hay Clientes Deshabilitados
       <?php }?>
        
    </div>
</div>
</div>
<?php 
if($mostrarView){?>
<!--Div derecho que muestra los datos particulares de cada cliente-->
 <?php /**************************************************************************/ ?>
 <?php /*****************************Datos Personales*****************************/ ?>
 <?php /**************************************************************************/ ?>
<div class="clientes_view" style="width:70%;">
    <div class="" style="width:100%;height:30px;">
         <div class="cliente_view_tab"  onClick="showDatosCliente()" id="cliente_view_tab_cliente">
            <?php
               echo $this->Form->label(null, $text = 'Cliente',array('style'=>'text-align:center;margin-top:5px;cursor:pointer')); 
               //$this->Html->image('cli_view.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'margin-left: 50%;'));
             ?>
        </div>
         <div class="cliente_view_tab"  onClick="showDatosImpuesto()" id="cliente_view_tab_impuesto">
            <?php
                echo $this->Form->label(null, $text = 'Organismos',array('style'=>'text-align:center;margin-top:5px;cursor:pointer'));
                //$this->Html->image('ic_my_library_add_black_18dp.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'margin-left: 50%;'));
             ?>
        </div>
         <div class="cliente_view_tab"  onClick="showDatosVenta()" id="cliente_view_tab_venta">
            <?php
                echo $this->Form->label(null, $text = 'Otros',array('style'=>'text-align:center;margin-top:5px;cursor:pointer'));             
             ?>
        </div>      
    </div>
    <div id="divCliente_Info" style="width:100%; overflow:auto">
	<table class="tbl_view" cellpadding="0" cellspacing="0">
    	<tr class="rowheaderdatosPersonales"> <!--1. Datos personales-->
        	<th colspan="7" class="tbl_view_th1">
        		<h2 id="lblDatosPeronales" class="h2header">
        			<?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgDatosPersonales','class'=>'imgOpenClose'));?>
        			<?php echo __('Datos personales'); ?>
        		</h2>
        	</th>
           
             
            <th class="tbl_view_th2">
                <a href="#" class="button_view" onClick="loadFormEditarPersona()"> 
                    <?php echo $this->Html->image('edit_view.png', array('alt' => 'edit','class'=>'imgedit'));?>
                </a>
            </th>
        </tr>
        <tr class="datosPersonales"><!--1.1 Tabla datos clientes-->
            <th>
                <?php 
                echo $this->Form->create('Cliente',array('action'=>'edit','id'=>'saveDatosPersonalesForm', 'class' => 'form_popin'));            
                echo $this->Form->input('id',array('type'=>'hidden'));?>

                <table cellspacing="0" cellpadding="0" id="tableDatosPersonalesEdit">
                    <tr>
                        <td><?php echo $this->Form->input('tipopersona',array(
                                                            'label'=>'Tipo de Persona',
                                                            'type'=>'select',
                                                            'options'=>array('juridica'=>'Juridica','fisica'=>'Fisica'),
                                                            )
                                            ); ?>
                        </td>
                        <td><?php echo $this->Form->input('tipopersonajuridica',array('label'=>'Tipo de Persona Jur&iacute;dica')); ?></td>
                        <td>&nbsp;</td>
                    </tr>    
                    <tr>
                        <td><?php echo $this->Form->input('nombre',array('label'=>array(
                                                                            'text'=>'Apellido y Nombre o Raz&oacuten Social',
                                                                            'id'=>'clienteEditLabelNombre')
                                                                            )); ?></td>
                        <td><?php echo $this->Form->input('cuitcontribullente',array('label'=>'CUIT','size'=>'10')); ?></td>
                        <td><?php echo $this->Form->input('dni',array('label'=>'DNI', 'size'=>'8')); ?></td>
                    </tr>    
                    <tr> 
                        <td>
                         <?php 
                                 echo $this->Form->input('fchcumpleanosconstitucion', array(
                                            'class'=>'datepicker', 
                                            'type'=>'text',
                                            'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['fchcumpleanosconstitucion'])),
                                            'label'=>'Fecha de Nac. o de Constituci&oacute;n',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>
                        <td>
                            <?php 
                                 echo $this->Form->input('fchcorteejerciciofiscal', array(
                                            'class'=>'datepicker-day-month', 
                                            'type'=>'text',
                                            'label'=>'Fecha de Corte de Ejer. Fiscal',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>    
                        <td><?php echo $this->Form->input('anosduracion',array(
                                            'label'=>'A&ntilde;os de Duraci&oacute;n',
                                            'size' =>'4')
                                 ); ?>
                        </td>
                    </tr>   
                        <!--<?php echo $this->Form->input('numinscripcionconveniomultilateral',array('label'=>'Nro. de Inscrip. en Conv. Multilateral')); ?></td>-->
                    <tr>    
                        <td>
                        <?php 
                            echo $this->Form->input('inscripcionregistrocomercio', array(
                                'class'=>'datepicker', 
                                'type'=>'text',                                            
                                'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['inscripcionregistrocomercio'])),
                                'label'=>'Inscripci&oacute;n en RPC',                                    
                                'readonly'=>'readonly')
                            );?>
                        </td>
                        <td><?php 
                            echo $this->Form->input('modificacionescontrato',array('label'=>'Modificaciones al Contrato')); ?>
                        </td>
                    <tr>
                        <td colspan="3">
                            <?php echo $this->Form->input('descripcionactividad',array('label'=>'Descripci&oacute;n de Actividad','style'=>'width:95%')); ?>
                        </td>
                    </tr>
                    </tr>        
                    <tr>    
                        <td>
                            <?php 
                                 echo $this->Form->input('fchiniciocliente', array(
                                            'class'=>'datepicker', 
                                            'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['fchiniciocliente'])),
                                            'type'=>'text',
                                            'label'=>'Cliente desde',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>
                        <td>
                            <?php 
                                 echo $this->Form->input('fchfincliente', array(
                                            'class'=>'datepicker', 
                                            'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['fchfincliente'])),
                                            'type'=>'text',
                                            'label'=>'Cliente hasta',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>  
                    </tr>
                    <span style="display:none">
                    </span>
                    <tr id="rowButtonsDetallesPersonales" style="display:none">
                        <td>
                             <?php $divUsuario =  'DESHABILITAR';
                                echo $this->Form->postLink(
                                    $divUsuario, 
                                    array(
                                        'action' => 'deshabilitar', 
                                        $cliente['Cliente']['id']), 
                                        array('escape'=>false,'class'=>'btn_aceptar','style'=>'color:red;float:left'), 
                                        __('Esta seguro que quiere Deshabilitar a '.$cliente['Cliente']['nombre'].'? No aparecera en ningun Informe', $cliente['Cliente']['id']
                                        )
                                ); ?>
                        </td>
                        <td>&nbsp;</td>
                        <td align="right">  
                            <?php echo $this->Form->end(__('Aceptar')); ?>                                                  
                        </td>                        
                    </tr>
                </table>
            </th>
        </tr>        
 <?php /**************************************************************************/ ?>
 <?php /*****************************Domicilios***********************************/ ?>
 <?php /**************************************************************************/ ?>
        <tr  class="rowheaderdomicilios"> <!--2. Domicilio-->
            <th colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblDomicilio">
                <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgDomicilio','class'=>'imgOpenClose'));?>
                <?php echo __('Domicilios'); ?>
               </h2>
            </th>
            <th class="tbl_view_th2">
                <a href="#nuevo_domicilio" class="button_view"> 
                    <?php echo $this->Html->image('add_view.png', array('alt' => 'edit','class'=>'imgedit'));?>
                </a>
            </th>
        </tr>
       
        <tr class="domicilios"> <!--2.1 Tabla Domicilios-->
            <td colspan="7">
            <table id="relatedDomicilios" class="tbl_related">
                <head>
                     <tr class="domicilio">    
                        <th><?php echo __('Calle'); ?></th>     
                        <th><?php echo __('Telefono'); ?></th>  
                        <th><?php echo __('Movil'); ?></th>     
                        <th><?php echo __('Acciones'); ?></th>    
                     </tr>  
                     <tr>
                        <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                    </tr>
                </head>     
                <tbody>
            <?php if (!empty($cliente['Domicilio'])): ?>      
              <?php foreach ($cliente['Domicilio'] as $domicilio): ?>     
                     <tr >    
                        <td><?php echo h($domicilio['calle'].' '.$domicilio['numero']); ?></td> 
                        <td><?php echo h($domicilio['telefono']); ?></td>
                        <td><?php echo h($domicilio['movil']); ?></td> 
                        <td class="">
                            <a href="#"  onclick="loadFormDomicilio(<?php echo$domicilio['id']; ?>,<?php echo $domicilio['cliente_id'];?>)" class="button_view"> 
                             <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                            </a> 
                        </td>
                    </tr>      
                           
             <?php endforeach; ?>
              
            <?php endif; ?>   
                  </tbody>
             </table>  
            </td>
        </tr>
 <?php /**************************************************************************/ ?>
 <?php /*****************************Personas Relacionadas************************/ ?>
 <?php /**************************************************************************/ ?>        
        <tr class="rowheaderpersonas"> <!--4. Persona relacionada-->
            <th colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblPersona">
                <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgPersona','class'=>'imgOpenClose'));?>
                <?php echo __('Personas Relacionadas'); ?>
               </h2>
            </th>
            <th class="tbl_view_th2">
                <a href="#nuevo_persona" class="button_view"> 
                    <?php echo $this->Html->image('add_view.png', array('alt' => 'edit','class'=>'imgedit'));?>
                </a>
            </th>
        </tr>
        <tr class="personas">
            <td colspan="7">
            <table id="relatedPersonas" class="tbl_related"> <!--Tabla Persona Relacionada-->
                <head>
                     <tr >    
                        <th><?php echo __('Tipo'); ?></th>     
                        <th><?php echo __('Nombre'); ?></th>  
                        <th><?php echo __('Telefono'); ?></th>  
                        <th><?php echo __('Acciones'); ?></th>     
                     </tr>  
                     <tr>
                        <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                     </tr>
                </head>     
                <tbody>
              <?php if (!empty($cliente['Personasrelacionada'])): ?>      
              <?php foreach ($cliente['Personasrelacionada'] as $persona): ?>     
                     <tr >    
                        <td><?php echo h(ucfirst ($persona['tipo'])); ?></td>
                        <td><?php echo h($persona['nombre']); ?></td> 
                        <td><?php echo h($persona['telefono']); ?></td>
                        <td class="">
                            <a href="#"  onclick="loadFormPersonaRelacionada(<?php echo$persona['id']; ?>,<?php echo $persona['cliente_id'];?>)" class="button_view"> 
                                <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?> 
                            </a>                     
                        </td>
                    </tr>      
                           
             <?php endforeach; ?>
                
            <?php endif; ?>   
                </tbody>
             </table>  
            </td>
        </tr>
 <?php /**************************************************************************/ ?>
 <?php /*****************************Facturacion***********************************/ ?>
 <?php /**************************************************************************/ ?>       
        <tr class="rowheaderfacturacion"> <!--5. Facturacion-->
        	<th colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblFacturacion">
       			<?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgFacturacion','class'=>'imgOpenClose'));?>
        		<?php echo __('Facturaci&oacuten'); ?>
        	   </h2>
            </th>
            <th class="tbl_view_th2">
                 <a href="#editarFacturacion"  class="button_view"> 
                    <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?> 
                </a>    
            </th>
            </tr>
            <tr class="facturacion">
                <td> <!--5.1 Tabla facturacion-->
                    <table class="tbl_related">
                    <tr class="facturacion">    
                        <td><?php echo __('CPA'); ?></td>     
                        <td><?php echo h($cliente['Cliente']['cpa']); ?></td>             
                    </tr>        
                    <tr class="facturacion" >    
                      	<td colspan="4"><?php echo __('Tipo de Factura que emite'); ?></td> 
                    </tr>  
                    <tr class="facturacion">    
                        <td><?php echo __('A'); ?></td>     
                        <td><?php 
                        if($cliente['Cliente']['emitefacturaa']){
                            echo h("Si");
                        }else{
                             echo h("No");
                        }; ?></td>  
                        <td><?php echo __('Vencimiento del CAI'); ?></td>     
                        <td><?php echo h(date('d-m-Y',strtotime($cliente['Cliente']['vtocaia'])));?></td>             
                    </tr>
                    <tr class="facturacion">    
                        <td><?php echo __('B'); ?></td>     
                        <td><?php 
                        if($cliente['Cliente']['emitefacturab']){
                            echo h("Si");
                        }else{
                             echo h("No");
                        }; ?></td>  
                        <td><?php echo __('Vencimiento del CAI'); ?></td>     
                        <td><?php echo h(date('d-m-Y',strtotime($cliente['Cliente']['vtocaib'])));?></td>             
                    </tr>
                    <tr class="facturacion">    
                        <td><?php echo __('C'); ?></td>     
                         <td><?php 
                        if($cliente['Cliente']['emitefacturac']){
                            echo h("Si");
                        }else{
                             echo h("No");
                        }; ?></td> 
                        <td><?php echo __('Vencimiento del CAI'); ?></td>     
                        <td><?php echo h(date('d-m-Y',strtotime($cliente['Cliente']['vtocaic'])));?></td>             
                    </tr> 
                    </table> 
                </tD>
            </tr>     
 <?php /**************************************************************************/ ?>
 <?php /*****************************AFIP*****************************************/ ?>
 <?php /**************************************************************************/ ?>
     	<tr class="rowheaderafip"> <!--7. AFIP-->
        	<th colspan="7" class="tbl_view_th1">
        		<h2 class="h2header" id="lblAFIP">
       				<?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgAFIP','class'=>'imgOpenClose'));?>
        			<?php echo __('AFIP'); ?></h2></th>
	   		<th class="tbl_view_th2">
               
            </th>    		
        </tr> 
        <tr class="afip">
            <td>
            <table class="tbl_related"> <!--7.1 Tabla Organismos-->

            <?php if (!empty($cliente['Organismosxcliente'])): ?>
    	        <?php foreach ($cliente['Organismosxcliente'] as $organizmo): ?>  
        	        <?php if ($organizmo['tipoorganismo']=='afip'): ?>
	         <tr class="afip">    
                <td colspan="7">
                    <?php echo $this->Form->create('Organismosxcliente',array('action'=>'edit','id'=>'formOrganismoAFIP', 'class' => 'form_popin'));?>
                    <?php echo $this->Form->input('id',array('type'=>'hidden','default'=>$organizmo['id'],'label'=>false)); ?>
                    <table>
                        <tr>      
                             <td>
                                
                                <?php echo $this->Form->input('usuario',array('default'=>$organizmo['usuario'],'label'=>'Cuit')); ?></td>
                             <td><?php echo $this->Form->input('clave',array('default'=>$organizmo['clave'],'label'=>'Clave')); ?></td>
                             <td><?php echo $this->Form->end('Guardar');?></td>
                        </tr>
                    </table>  
                </td>    
              </tr>
            </table>
            </td>
        </tr>   		       
        <tr class="afip">  <!--7.2 Impuestos del Organismo -->   
            <td colspan="7"> 
            <table id="tablaImpAfip" class="tbl_related">    
                <tr>    
                    <th><?php echo __('Impuesto'); ?></th>
                    <th><?php echo __('Descripcion'); ?></th>                   
                    <th><?php echo __('Estado'); ?></th>
                    <th><?php echo __('Acciones'); ?></th>
                    <th >
                        <a href="#nuevoImpcliAfip" class="button_view"> 
                            <?php echo $this->Html->image('add_view.png', array('alt' => 'edit','class'=>'imgedit'));?>

                        </a>                                            
                    </th>  
                </tr>  
                <tr>
                    <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                </tr>
                <?php if (!empty($cliente['Impcli'])): ?>                            
                    <?php foreach ($cliente['Impcli'] as $impcli): ?>
                        <?php if ($impcli['Impuesto']['organismo']=='afip'): ?>    
                             <tr id="rowImpcli<?php echo $impcli['id']?>" >                                                
                                <td><?php echo $impcli['Impuesto']['nombre']; ?></td>
                                <td><?php echo $impcli['descripcion']; ?></td>                                
                                <td><?php echo $impcli['estado']; ?></td>
                                <td>
                                    <a href="#"  onclick="loadFormImpuesto(<?php echo$impcli['id']; ?>,<?php echo $impcli['cliente_id'];?>)" class="button_view"> 
                                     <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                     <a href="#"  onclick="loadFormImpuestoPeriodos(<?php echo$impcli['id']; ?>)" class="button_view"> 
                                     <?php echo $this->Html->image('calendario.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                </td>
                            </tr>
                         <?php endif;    ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </table>
            </td>
        </tr>
            <!--FIN Impuestos del Organizmo -->
	        <?php endif; ?>   		
        <?php endforeach; ?>
    <?php endif; ?>   	    
 <?php /**************************************************************************/ ?>
 <?php /*****************************DGR******************************************/ ?>
 <?php /**************************************************************************/ ?>        
        <tr class="rowheaderdgr"><!--8. DGR-->
        	<th  colspan="7" class="tbl_view_th1">
        		<h2 class="h2header" id="lblDGR">
       				<?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgDGR','class'=>'imgOpenClose'));?>
        			<?php echo __('DGR'); ?></h2></th>
	   		<th class="tbl_view_th2">
                
            </th>		
        </tr>
        <tr class="dgr"> 
            <td>
                <table class="tbl_related"> <!--7.1 Tabla Organismos-->

                <?php if (!empty($cliente['Organismosxcliente'])): ?>
                    <?php foreach ($cliente['Organismosxcliente'] as $organizmo): ?>  
                        <?php if ($organizmo['tipoorganismo']=='dgr'): ?>
                 <tr class="dgr">    
                    <td colspan="7">
                        <?php echo $this->Form->create('Organismosxcliente',array('action'=>'edit','id'=>'formOrganismoDGR', 'class' => 'form_popin'));?>
                        <?php echo $this->Form->input('id',array('type'=>'hidden','default'=>$organizmo['id'],'label'=>false)); ?>
                        <table>
                            <tr>      
                                 <td><?php echo $this->Form->input('usuario',array('default'=>$organizmo['usuario'],'label'=>'Cuit')); ?></td>
                                 <td><?php echo $this->Form->input('clave',array('default'=>$organizmo['clave'],'label'=>'Clave')); ?></td>
                                 <td><?php echo $this->Form->end('Guardar');?></td>
                            </tr>
                        </table>  
                    </td>    
                  </tr>
                </table>       
            </td>
        </tr>         
        <tr class="dgr"> 
            <td colspan="7"> 
                <table id="tablaImpDGR" class="tbl_related">   <!--8.2 Impuestos del Organismo -->  
                    <tr>    
                        
                        <th><?php echo __('Impuesto'); ?></th>
                        <th><?php echo __('Descripcion'); ?></th>                        
                        <th><?php echo __('Estado'); ?></th>
                        <th><?php echo __('Acciones'); ?></th>
                        <th>
                            <a href="#nuevo_DGR" class="button_view"> 
                                <?php echo $this->Html->image('add_view.png', array('alt' => 'edit','class'=>'imgedit'));?>
                            </a>
                        </th>
                    </tr>
                    <tr>
                        <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                    </tr>  
                    <?php if (!empty($cliente['Impcli'])): ?>                            
                        <?php foreach ($cliente['Impcli'] as $impcli): ?>
                            <?php if ($impcli['Impuesto']['organismo']=='dgr'): ?>    
                                 <tr id="rowImpcli<?php echo $impcli['id']?>">                                                
                                    <td><?php echo $impcli['Impuesto']['nombre']; ?></td>
                                    <td><?php echo $impcli['descripcion']; ?></td>                                    
                                    <td><?php echo $impcli['estado']; ?></td>
                                    <td>
                                        <a href="#"  onclick="loadFormImpuesto(<?php echo$impcli['id']; ?>,<?php echo $impcli['cliente_id'];?>)" class="button_view"> 
                                         <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                            </a>
                                        <a href="#"  onclick="loadFormImpuestoPeriodos(<?php echo$impcli['id']; ?>)" class="button_view"> 
                                         <?php echo $this->Html->image('calendario.png', array('alt' => 'open','class'=>'imgedit'));?>
                                        </a>
                                    </td>
                                </tr>
                             <?php endif;    ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </td>
        </tr>
        <!--FIN Impuestos del Organismo -->
		        <?php endif; ?>   		
	        <?php endforeach; ?>
        <?php endif; ?>  
 <?php /**************************************************************************/ ?>
 <?php /*****************************DGRM*****************************************/ ?>
 <?php /**************************************************************************/ ?>
        <tr  class="rowheaderdgrm" ><!--9. DGRM-->
        	<th  colspan="7" class="tbl_view_th1">
        		<h2 class="h2header" id="lblDGRM">
       				<?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgDGRM','class'=>'imgOpenClose'));?>
        			<?php echo __('DGRM'); ?></h2></th>
	   		<th class="tbl_view_th2">
                
            </th>
        </tr> 
        <tr class="dgrm"><!--9.1 Tabla DGRM -->
            <td> 
                <table class="tbl_related"> <!--7.1 Tabla Organismos-->

                <?php if (!empty($cliente['Organismosxcliente'])): ?>
                    <?php foreach ($cliente['Organismosxcliente'] as $organizmo): ?>  
                        <?php if ($organizmo['tipoorganismo']=='dgrm'): ?>
                 <tr class="dgrm">    
                    <td colspan="7">
                        <?php echo $this->Form->create('Organismosxcliente',array('action'=>'edit','id'=>'formOrganismoDGRM', 'class' => 'form_popin'));?>
                        <?php echo $this->Form->input('id',array('type'=>'hidden','default'=>$organizmo['id'],'label'=>false)); ?>
                        <table>
                            <tr>      
                                 <td><?php echo $this->Form->input('usuario',array('default'=>$organizmo['usuario'],'label'=>'Cuit')); ?></td>
                                 <td><?php echo $this->Form->input('clave',array('default'=>$organizmo['clave'],'label'=>'Clave')); ?></td>
                                 <td><?php echo $this->Form->end('Guardar',array(),array('style'=>'margin:0px'));?></td>
                            </tr>
                        </table>  
                    </td>    
                  </tr>
                </table> 
            </td>
        </tr>
        <!--9.2 Impuestos del Organismo -->        
        <tr class="dgrm"> 
            <td colspan="7"> 
            <table id="tablaImpDGRM" class="tbl_related">    
                <tr>     
                    <th><?php echo __('Impuesto'); ?></th>
                    <th><?php echo __('Descripci&oacute;n'); ?></th>                   
                    <th><?php echo __('Estado'); ?></th>
                    <th><?php echo __('Acciones'); ?></th>    
                    <th> <a href="#nuevo_DGRM" class="button_view"> 
                            <?php echo $this->Html->image('add_view.png', array('alt' => 'add','class'=>'imgedit'));?>
                        </a> 
                    </th>    
                </tr>  
                <tr>
                    <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                </tr> 
                <?php if (!empty($cliente['Impcli'])): ?>                            
                    <?php foreach ($cliente['Impcli'] as $impcli): ?>
                        <?php if ($impcli['Impuesto']['organismo']=='dgrm'): ?>    
                             <tr id="rowImpcli<?php echo $impcli['id']?>">                                                
                                <td><?php echo $impcli['Impuesto']['nombre']; ?></td>
                                <td><?php echo $impcli['descripcion']; ?></td>                               
                                <td><?php echo $impcli['estado']; ?></td>
                                <td>
                                    <a href="#"  onclick="loadFormImpuesto(<?php echo$impcli['id']; ?>,<?php echo $impcli['cliente_id'];?>)" class="button_view"> 
                                     <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                     <a href="#"  onclick="loadFormImpuestoPeriodos(<?php echo$impcli['id']; ?>)" class="button_view"> 
                                     <?php echo $this->Html->image('calendario.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                </td>
                            </tr>
                         <?php endif;    ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </table>
            </td>
        </tr>
        <!--FIN Impuestos del Organizmo -->
		        <?php endif; ?>   		
	        <?php endforeach; ?>
        <?php endif; ?>
 <?php /**************************************************************************/ ?>
 <?php /*****************************Sindicatos***********************************/ ?>
 <?php /**************************************************************************/ ?>        
        <tr  class="rowheadersindicatos" ><!--9.1. SINDICATO-->
            <th  colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblSINDICATO">
                    <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'ImgSindicatos','class'=>'imgOpenClose'));?>
                    <?php echo __('Sindicatos'); ?></h2></th>
            <th class="tbl_view_th2">
                
            </th>                
        <!--9.2 Impuestos del Organismo -->        
        <tr class="sindicatos"> 
            <td colspan="7"> 
            <table id="tablaImpSINDICATO" class="tbl_related">    
                <tr>     
                    <th><?php echo __('Impuesto'); ?></th>
                    <th><?php echo __('Usuario'); ?></th>
                    <th><?php echo __('Clave'); ?></th>
                    <th><?php echo __('Descripci&oacute;n'); ?></th>                   
                    <th><?php echo __('Estado'); ?></th>
                    <th><?php echo __('Acciones'); ?></th>    
                    <th>
                        <a href="#nuevo_SINDICATO" class="button_view"> 
                        <?php echo $this->Html->image('add_view.png', array('alt' => 'add','class'=>'imgedit'));?>
                        </a>
                    </th>                        
                </tr>  
                <tr>
                    <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                </tr> 
                <?php if (!empty($cliente['Impcli'])): ?>                            
                    <?php foreach ($cliente['Impcli'] as $impcli): ?>
                        <?php if ($impcli['Impuesto']['organismo']=='sindicato'): ?>    
                             <tr id="rowImpcli<?php echo $impcli['id']?>">                                                
                                <td><?php echo $impcli['Impuesto']['nombre']; ?></td>
                                <td><?php echo $impcli['usuario']; ?></td>
                                <td><?php echo $impcli['clave']; ?></td>
                                <td><?php echo $impcli['descripcion']; ?></td>                                
                                <td><?php echo $impcli['estado']; ?></td>
                                <td>
                                    <a href="#"  onclick="loadFormImpuesto(<?php echo$impcli['id']; ?>,<?php echo $impcli['cliente_id'];?>)" class="button_view"> 
                                     <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                </td>
                            </tr>
                         <?php endif;    ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </table>
            </td>
        </tr>
        <!--FIN Impuestos del Organizmo -->
<?php /**************************************************************************/ ?>
<?php /*****************************Bancos***************************************/ ?>      
<?php /**************************************************************************/ ?>                   
        <tr  class="rowheaderbancos" ><!--9.1. BANCO-->
            <th  colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblBANCO">
                    <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgBancos','class'=>'imgOpenClose'));?>
                    <?php echo __('Bancos'); ?>
                </h2>
            </th>
            <th class="tbl_view_th2">
                
            </th>        
        </tr> 
        <tr class="bancos"> 
            <td colspan="7"> 
            <table id="tablaImpBanco" class="tbl_related">    
                <tr>     
                    <th><?php echo __('Banco'); ?></th>
                    <th><?php echo __('Descripci&oacute;n'); ?></th>
                    <th><?php echo __('Usuario'); ?></th>
                    <th><?php echo __('Clave'); ?></th>
                    <th><?php echo __('Desde'); ?></th>
                    <th><?php echo __('Hasta'); ?></th>
                    <th><?php echo __('Estado'); ?></th>
                    <th><?php echo __('Acciones'); ?></th>     
                    <th>
                        <a href="#nuevo_Banco" class="button_view"> 
                            <?php echo $this->Html->image('add_view.png', array('alt' => 'add','class'=>'imgedit'));?>
                        </a>
                    </th>                       
                </tr>  
                <tr>
                    <th colspan="6"><hr color="#E4E4E4" width="100%"></th> 
                </tr> 
                <?php if (!empty($cliente['Impcli'])): ?>                            
                    <?php foreach ($cliente['Impcli'] as $impcli): ?>
                        <?php if ($impcli['Impuesto']['organismo']=='banco'): ?>    
                             <tr id="rowImpcli<?php echo $impcli['id']?>">                                                
                                <td><?php echo $impcli['Impuesto']['nombre']; ?></td>
                                <td><?php echo $impcli['usuario']; ?></td>
                                <td><?php echo $impcli['clave']; ?></td>
                                <td><?php echo $impcli['descripcion']; ?></td>
                                <td><?php echo $impcli['desde']; ?></td>
                                <td><?php echo $impcli['hasta']; ?></td>
                                <td><?php echo $impcli['estado']; ?></td>
                                <td>
                                    <a href="#"  onclick="loadFormImpuesto(<?php echo$impcli['id']; ?>,<?php echo $impcli['cliente_id'];?>)" class="button_view"> 
                                     <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
                                </td>
                            </tr>
                         <?php endif;    ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                </table>
            </td>
        </tr>
        <!--FIN Impuestos del Organizmo -->            
 <?php /**************************************************************************/ ?>
 <?php /*****************************Puntos de Ventas*****************************/ ?>
 <?php /**************************************************************************/ ?>                
        <tr class="rowheaderpuntosdeventas" ><!--15. Puntos de Ventas-->
            <th colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblPuntosdeventas">
                    <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgPuntosdeventas','class'=>'imgOpenClose'));?>
                    <?php echo __('Puntos de Ventas'); ?>                    
                </h2>
            </th>
            <th class="tbl_view_th2">
                <a href="#nuevo_puntodeventa" class="button_view"> 
                    <?php echo $this->Html->image('add_view.png', array('alt' => 'add','class'=>'imgedit'));?>
                </a>
            </th>
        </tr>
        <tr class="puntosdeventa">
            <td>
                <table class="tbl_related">
                <tr class="puntosdeventa">

                    <th><?php echo __('Nombre'); ?></th>
                    <th><?php echo __('Telefono'); ?></th>
                    <th><?php echo __('Direccion'); ?></th>
                    <th class=""><?php echo __('Acciones'); ?></th>
                </tr>
                <tr>
                    <th colspan="7"><hr color="#E4E4E4" width="100%"></th> 
                </tr> 
                 <?php if (!empty($cliente['Puntosdeventa'])): ?>
                    <?php foreach ($cliente['Puntosdeventa'] as $puntodeventa): ?>
                    <tr class="puntosdeventa">
                        
                        <td><?php echo $puntodeventa['nombre']; ?></td>
                        <td><?php echo $puntodeventa['telefono']; ?></td>
                        <td><?php echo $puntodeventa['direccion']; ?></td>
                        
                         <td >
                            <a href="#"  onclick="loadFormVenta(<?php echo$puntodeventa['id']; ?>)" class="button_view"> 
                             <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tr>
                </table>
            </td>
        </tr>
 <?php /**************************************************************************/ ?>
 <?php /*****************************SubClientes***********************************/ ?>
 <?php /**************************************************************************/ ?>
        <tr class="rowheadersubclientes" ><!--15. Sub Clientes-->
            <th colspan="7" class="tbl_view_th1">
                <h2 class="h2header" id="lblSubclientes">
                    <?php echo $this->Html->image('mas2.png', array('alt' => 'open','id'=>'imgSubclientes','class'=>'imgOpenClose'));?>
                    <?php echo __('Sub Clientes'); ?>                    
                </h2>
            </th>
            <th class="tbl_view_th2">
                <a href="#nuevo_subcliente" class="button_view"> 
                    <?php echo $this->Html->image('add_view.png', array('alt' => 'add','class'=>'imgedit'));?>
                </a>
            </th>
        </tr>
        <tr class="subcliente">
            <td>
                <table class="tbl_related">
                <tr class="subcliente">

                    <th><?php echo __('Nombre'); ?></th>
                    <th><?php echo __('CUIT'); ?></th>
                    <th><?php echo __('Cond. IVA'); ?></th>
                    <th class=""><?php echo __('Acciones'); ?></th>
                </tr>
                <tr>
                    <th colspan="7"><hr color="#E4E4E4" width="100%"></th> 
                </tr> 
                    <?php if (!empty($cliente['Subcliente'])): ?>
                    <?php foreach ($cliente['Subcliente'] as $subcliente): ?>
                <tr class="subcliente">
                    <td><?php echo $subcliente['nombre']; ?></td>
                    <td><?php echo $subcliente['cuit']; ?></td>  
                    <td><?php echo $subcliente['condicioniva']; ?></td>                       
                    <td >
                        <a href="#"  onclick="loadFormVenta(<?php echo$subcliente['id']; ?>)" class="button_view"> 
                        <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                        </a>
                    </td>
                </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tr>
                </table>
            </td>
        </tr>
    </table>
</div>

 <?php /**************************************************************************/ ?>
 <?php /*****************************Inicio de POPINS***********************************/ ?>
 <?php /**************************************************************************/ ?>

<!-- Inicio Popin Nuevo Domicilio -->
<a href="#x" class="overlay" id="nuevo_domicilio"></a>
<div class="popup">
        <div id="form_domicilio" >
           
                <h3><?php echo __('Agregar Domicilio'); ?></h3>
                <?php
                    echo $this->Form->create('Domicilio',array('action'=>'add'));
                    echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));
                ?>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <!--<td><?php  echo $this->Form->input('tipo', array('label'=>'Tipo'));?></td>   
                            <td><?php echo $this->Form->input('sede', array('label'=>'Sede'));?></td>  
                            <td><?php echo $this->Form->input('nombrefantasia', array('label'=>'Nombre fantas&iacute;a'));?></td>  -->
                        </tr>
                        <tr>  
                            <td colspan="4">
                                <table>
                                    <tr>
                                        <td style="width: 150px;"><?php  echo $this->Form->input('tipo', array('label'=>'Tipo','type'=>'select','options'=>array('comercial'=>'Comercial','fiscal'=>'Fiscal','personal'=>'Personal','laboral'=>'Laboral')));?></td> 
                                        <?php //<td>echo $this->Form->input('puntodeventa', array('label'=>'Pto. Vta.', 'size' => '4'));</td>?>
                                        <td><?php echo $this->Form->input('fechainicioagregardomicilio', array(
                                                'class'=>'datepicker', 
                                                'type'=>'text',
                                                'size'=>'10',
                                                'label'=>'Fecha de Inicio',                                    
                                                'readonly'=>'readonly')
                                            );?>
                                        </td>
                                        <td></td> 
                                    </tr>
                                </table>             
                            </td>            
                        </tr>
                        <tr>    

                        </tr>
                            <td><?php echo $this->Form->input('partido_id', array('label'=>'Provincia','default','onChange'=>'getLocalidadesForDomicilios()'));?></td>
                            <td><?php echo $this->Form->input('localidade_id', array('label'=>'Localidad'));?></td>
                            <td>&nbsp;</td>
                           
                        <tr>
                            <td><?php echo $this->Form->input('calle', array('label'=>'Calle'));?></td> 
                            <td colspan="2" style="padding:0px;">
                                <table style="margin:0px; padding:0px;" cellpadding="0" cellspacing="0" border="0"> 
                                <tr> 
                                    <td><?php echo $this->Form->input('numero', array('label'=>'Nº', 'size' => '6'));?></td>
                                    <td><?php echo $this->Form->input('piso', array('label'=>'Piso', 'size' => '3'));?></td>    
                                    <td><?php echo $this->Form->input('ofidepto', array('label'=>'Of./Dpto.', 'size' => '3'));?></td>                   
                                    <td><?php echo $this->Form->input('ruta', array('label'=>'Ruta', 'size' => '8'));?></td>    
                                    <td><?php echo $this->Form->input('kilometro', array('label'=>'Km.', 'size' => '3'));?></td>
                                    <td><?php echo $this->Form->input('torre', array('label'=>'Torre', 'size' => '3'));?></td>   
                                    <td><?php echo $this->Form->input('manzana', array('label'=>'Manzana', 'size' => '3'));?></td>
                                </tr>
                                </table>
                            </td>
                         </tr>
                         <tr>
                            <td><?php echo $this->Form->input('entrecalles', array('label'=>'Entre calles'));?></td>    
                            <td><?php echo $this->Form->input('codigopostal', array('label'=>'C&oacute;d. Postal', 'size' => '3'));?></td>
                            <td>&nbsp;</td>
                         </tr>
                         <tr> 
                             <td><?php echo $this->Form->input('telefono', array('label'=>'Tel&eacute;fono', 'size' => '11'));?></td>  
                             <td><?php echo $this->Form->input('movil', array('label'=>'M&oacute;vil', 'size' => '11'));?></td>
                             <td><?php echo $this->Form->input('fax', array('label'=>'Fax', 'size' => '11'));?></td>     
                         </tr>
                         <tr> 
                            <td><?php echo $this->Form->input('email',array('label'=>'E-mail'));?></td>
                            <td><?php echo $this->Form->input('personacontacto', array('label'=>'Persona contacto'));?></td>  
                            <td><?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'size' => '35'));?></td>    
                         </tr> 
                          <tr> 
                            <td></td>    
                            <td><a href="#close"  onclick="" class="btn_cancelar">Cancelar</a></td>    
                            <td><?php echo $this->Form->end('Agregar');?></td>    
                         </tr>     
            </table>
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Nuevo Domicilio --> 

<!-- Inicio Popin Modificar Domicilio-->
<a href="#x" class="overlay" id="modificar_domicilio"></a>
<div class="popup">
        <div id="form_modificar_domicilio" class="domicilio form">          
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Domicilio-->

<!-- Inicio Popin Nueva Persona Relacionada -->
<a href="#x" class="overlay" id="nuevo_persona"></a>
<div class="popup">
        <div id="form_persona" >
            <?php echo $this->Form->create('Personasrelacionada',array('controller'=>'Personasrelacionadas','action'=>'add')); ?>

                <h3><?php echo __('Agregar persona relacionada'); ?></h3>
                <?php
                    echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));
                ?>
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td>
                            <?php echo $this->Form->input('nombre',array('label'=>'Apellido y Nombre'));?>
                        </td>
                        <td>
                            <?php echo $this->Form->input('documento');?>
                        </td>                         
                         <td><?php echo $this->Form->input('tipo',array('type'=>'select','options'=>array(
                            'conyuge'=>'Conyuge','socio'=>'Socio','familiar'=>'Familiar','representante'=>'Representante','presidente'=>'Presidente','gerente'=>'Gerente'
                        )));?>
                        </td>
                                               
                    </tr>
                      <tr>
                       
                        <td><?php echo $this->Form->input('vtomandato', array(
                                            'class'=>'datepicker', 
                                            'type'=>'text',
                                            'size'=>'10',
                                            'label'=>'Vencimiento Mandato',                                    
                                            'readonly'=>'readonly')
                             );?>
                        </td>                         
                        <td width="12%"><?php echo $this->Form->input('porcentajeparticipacion', array('label'=>'% Pci&oacute;n', 'style' => 'width:40px;'));?></td>                       
                        <td ></td>
                    </tr>
                    </tr>
                        <td><?php echo $this->Form->input('partido_id', array('label'=>'Localidad'));?></td>
                        <td><?php echo $this->Form->input('localidade_id', array('label'=>'Localidad'));?></td>
                        <td>&nbsp;</td>
                       
                    <tr>
                        <td><?php echo $this->Form->input('calle', array('label'=>'Calle'));?></td> 
                        <td colspan="2" style="padding:0px;">
                            <table style="margin:0px; padding:0px;" cellpadding="0" cellspacing="0" border="0"> 
                            <tr> 
                                <td><?php echo $this->Form->input('numero', array('label'=>'Nº', 'size' => '6'));?></td>
                                <td><?php echo $this->Form->input('piso', array('label'=>'Piso', 'size' => '3'));?></td>    
                                <td><?php echo $this->Form->input('ofidepto', array('label'=>'Of./Dpto.', 'size' => '3'));?></td>                   
                                <td><?php echo $this->Form->input('ruta', array('label'=>'Ruta', 'size' => '8'));?></td>    
                                <td><?php echo $this->Form->input('kilometro', array('label'=>'Km.', 'size' => '3'));?></td>
                                <td><?php echo $this->Form->input('torre', array('label'=>'Torre', 'size' => '3'));?></td>   
                                <td><?php echo $this->Form->input('manzana', array('label'=>'Manzana', 'size' => '3'));?></td>
                            </tr>
                            </table>
                        </td>
                     </tr>
                     <tr>
                        <td><?php echo $this->Form->input('entrecalles', array('label'=>'Entre calles'));?></td>    
                        <td><?php echo $this->Form->input('codigopostal', array('label'=>'C&oacute;d. Postal', 'size' => '3'));?></td>
                        <td>&nbsp;</td>
                     </tr>
                     <tr> 
                         <td><?php echo $this->Form->input('telefono', array('label'=>'Tel&eacute;fono', 'size' => '11'));?></td>  
                         <td><?php echo $this->Form->input('movil', array('label'=>'M&oacute;vil', 'size' => '11'));?></td>
                         <td><?php echo $this->Form->input('fax', array('label'=>'Fax', 'size' => '11'));?></td>     
                     </tr>
                     <tr> 
                        <td><?php echo $this->Form->input('email',array('label'=>'E-mail'));?></td>
                        <td colspan="2"><?php echo $this->Form->input('observaciones', array('label'=>'Observaciones', 'size' => '35'));?></td>    
                     </tr>    
                    <tr>
                        <td>&nbsp;</td>
                        <td><a href="#close" onclick="" class="btn_cancelar" style="">Cancelar</a></td>
                        <td align="right">
                            <?php echo $this->Form->end(__('Agregar',array('class' =>'btn_aceptar'))); ?>                          
                        </td>
                    </tr>
                </table>
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Nueva Persona Relacionada--> 

 <!-- Inicio Popin Editar Facturacion -->
<a href="#x" class="overlay" id="editarFacturacion"></a>
<div id="divNuevoCbu" class="popup" style="width:45%">
        <div id="form_persona">
        <?php echo $this->Form->create('Cliente',array('action'=>'edit')); 
           echo $this->Form->input('id',array('type'=>'hidden'));?>

         <table style="width:100%">
            <tr class="">
                <td><?php echo __('CPA'); ?></th>
                <td colspan="2"><?php echo $this->Form->input('cpa',array('label'=>false, 'div' => false)); ?></td>
               
            </tr>
            <tr class="">      
                <td><?php echo __('Emite Factura A'); ?></td>
                <td valign="middle"><?php echo $this->Form->input('emitefacturaa',array('label'=>'')); ?></td>
                <td><?php echo __('Vencimiento del CAI  '); ?></td>
                <td valign="top"><?php 
                echo $this->Form->input('vtocaia', array(
                                'class'=>'datepicker', 
                                'type'=>'text',
                                'label'=> false,    
                                'div' => false,
                                'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['fchcumpleanosconstitucion'])),
                                'readonly'=>'readonly')
                     );
                ?></td>                            
            </tr>    
              <tr class="">      
                 <td valign="baseline"><?php echo __('Emite Factura B'); ?></td>
                 <td><?php echo $this->Form->input('emitefacturab',array('label'=>'')); ?></td>
                 <td valign="baseline"><?php echo __('Vencimiento del CAI '); ?></td>
                 <td><?php 
                 echo $this->Form->input('vtocaib', array(
                                'class'=>'datepicker', 
                                'type'=>'text',
                                'label'=>false, 
                                'div' => false,           
                                 'value'=>date('d-m-Y',strtotime($this->request->data['Cliente']['vtocaib'])),
                                'readonly'=>'readonly')
                     );
                 ?></td>                                
            </tr>       
            <tr class="">      
                <td><?php echo __('Emite Factura C'); ?></td>
                <td><?php echo $this->Form->input('emitefacturac',array('label'=>'')); ?></td>
                <td><?php echo __('Vencimiento del CAI  '); ?></td>
                <td valign="top"><?php 
                  $dat1= date('d-m-Y',strtotime($this->request->data['Cliente']['vtocaic']));
                  echo $this->Form->input('vtocaic', array(
                                'class'=>'datepicker', 
                                'type'=>'text',
                                'label'=>false,   
                                'div' => false, 
                                 'value'=>$dat1,
                                'readonly'=>'readonly')
                     );
                ?></td>
            </tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td> 
                    <?php echo $this->Form->end(__('Aceptar'), array('style' =>'display:none')); ?>
                    <a href="#close" class="btn_cancelar" style="margin-top:-28px">Cancelar</a>
                </td>
            <tr>
            </tr>       
        </table>
           
        </div>    
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Editar Facturacion -->

<!-- Inicio Popin Modificar Persona-->
<a href="#x" class="overlay" id="modificar_persona"></a>
<div class="popup">
        <div id="form_modificar_persona" class="persona form" style="width:100%">   
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Persona-->
<!-- Inicio Popin Modificar Persona-->
<a href="#x" class="overlay" id="modificar_periodoactivo"></a>
<div class="popup">
        <div id="form_modificar_periodosactivos" class="persona form" style="width:100%">   
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Persona-->

<!-- Inicio Popin Modificar Impuesto-->
<a href="#x" class="overlay" id="modificar_impcli"></a>
<div class="popup">
        <div id="form_modificar_impcli" > 
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Impuesto-->

<!-- Inicio Popin Modificar Recibo-->
<a href="#x" class="overlay" id="modificar_recibo"></a>
<div class="popup">
        <div id="form_modificar_recibo" class="recibo form">
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Recibo-->

<!-- Inicio Popin Modificar Ingreso-->
<a href="#x" class="overlay" id="modificar_ingreso"></a>
<div class="popup">
        <div id="form_modificar_ingreso" class="ingreso form"> 
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Modificar Ingreso-->

 <!-- Inicio Popin Nuevo ImpClisAFIP -->
<a href="#x" class="overlay" id="nuevoImpcliAfip"></a>
<div id="divNuevoCbu" class="popup" style="width:38%;">        
        <div id="form_impcli_afip">
        <?php if (!empty($impuestosafip)): ?>

       
            <?php echo $this->Form->create('Impcli',array('controller'=>'Impclis','action'=>'add','id'=>'FormImpcliAFIP')); ?>
                
                <h3><?php echo __('Relacionar Impuesto'); ?></h3>
                <?php
                    echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));?>
                    <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="4"><?php echo $this->Form->input('impuesto_id', array('empty'=>'Seleccionar Impuesto', 'div' => false ,'type'=>'select', 'options'=>$impuestosafip));?></td>
                    </tr>                                    
                    <tr>  
                        <td colspan="4"><?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacuten','style'=>'width:95%'));?></td>
                    </tr>
                    <tr>  
                        <td colspan="2"></td>
                        <td><a href="#close"  onclick="" class="btn_cancelar"> Cancelar </a></td>
                        <td ><?php echo $this->Form->end('Agregar');?></td>
                    </tr>
               </table>
        </div>
        <?php else:?>
                <h3><?php echo __('Todos los impuestos han sido agregados'); ?></h3>
        <?php endif?>       
         <a class="close" href="#close"></a>
</div>
   
</div>
<!-- Fin Popin Nuevo ImpClis --> 
 <!-- Inicio Popin Nuevo ImpClisDGR -->
<a href="#x" class="overlay" id="nuevo_DGR"></a>
<div id="divNuevoCbu" class="popup" style="width:38%;">
       
        <div id="form_impcli_dgr">
            <?php if (!empty($impuestosdgr)): ?>  
            <?php echo $this->Form->create('Impcli',array('controller'=>'Impclis','action'=>'add','id'=>'FormImpcliDGR')); ?>

                <h3><?php echo __('Relacionar Impuesto'); ?></h3>
                <?php echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden')); ?>
                
                <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="4"><?php echo $this->Form->input('impuesto_id', array('empty'=>'Seleccionar Impuesto', 'type'=>'select', 'options'=>$impuestosdgr));?></td>
                    </tr>                   
                        <td colspan="2"><?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacute;n'));?></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td > <a href="#close" onclick="" class="btn_cancelar">Cancelar</a></td>
                        <td ><?php echo $this->Form->end('Agregar');?></td>
                    </tr>
                </table>
            
            </div>
            <?php else:?>        
            <h3><?php echo __('Todos los impuestos han sido agregados'); ?></h3>
            </div>
            <?php endif?>            
        
        <a class="close" href="#close"></a>
    </div>
    
<!-- Fin Popin Nuevo ImpClis DGR --> 
 <!-- Inicio Popin Nuevo ImpClisDGRM -->
<a href="#x" class="overlay" id="nuevo_DGRM"></a>
<div id="divNuevoCbu" class="popup" style="width:38%;">
        <div id="form_impcli_dgrm">
            <?php if (!empty($impuestosdgrm)): ?>
            <?php echo $this->Form->create('Impcli',array('controller'=>'Impclis','action'=>'add','id'=>'FormImpcliDGRM')); ?>

                        <h3><?php echo __('Relacionar Impuesto'); ?></h3>
                        <table cellpadding="0" cellspacing="0" border="0">
                        <?php
                        echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));?>
                        <tr>
                            <td colspan="4"><?php echo $this->Form->input('impuesto_id', array('empty'=>'Seleccionar Impuesto', 'type'=>'select', 'options'=>$impuestosdgrm));?></td>
                        </tr>
                        <tr>            
                            <td colspan="2"><?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacute;n'));?></td>
                        </tr>
                         <tr>
                            <td colspan="2"></td>
                            <td > <a href="#close" onclick="" class="btn_cancelar">Cancelar</a></td>
                            <td ><?php echo $this->Form->end('Agregar');?></td>
                        </tr>
                    </table>
                    
            <?php else:?>
                    <h3><?php echo __('Todos los impuestos han sido agregados'); ?></h3>
            <?php endif?>               
        </div>
</div>
<!-- Inicio Popin Nuevo nuevo_SINDICATO -->
<a href="#x" class="overlay" id="nuevo_SINDICATO"></a>
<div id="divSindicato" class="popup">    
    <div id="form_impcliOrganismo_sindicato">
        <?php if (!empty($impuestossindicato)): 
        echo $this->Form->create('Impcli',array('controller'=>'Impclis','action'=>'addbancosindicato')); ?>            
        <h3><?php echo __('Relacionar Sindicato al Cliente'); ?></h3>
        <table>
            <?php
            echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));?>
            <tr>
                <td><?php echo $this->Form->input('impuesto_id', 
                                        array('label'=>'Sindicato','empty'=>'Seleccionar Sindicato', 'type'=>'select', 'options'=>$impuestossindicato));?>
                </td>
                <td> <?php echo $this->Form->input('usuario', array('label'=>'Usuario','size' =>'10', 'default'=>$organizmo['usuario']));?></td>
                <td><?php echo $this->Form->input('clave', array('label'=>'Clave','default'=>$organizmo['clave'], 'size' =>'10'));?></td> 
            </tr>
            <tr>
                <td colspan="2"><?php echo "Periodo Desde";?></td>
                <td colspan="2"><?php echo "Periodo Hasta";?></td>
            </tr>
            <tr>
                <td><?php echo $this->Form->input('mesdesdesindicato', array('options' => array(
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
                                                        'label'=> 'Mes'
                                                    )); ?>  </td>
            
                <td><?php echo $this->Form->input('aniodesdesindicato', array(
                                            'options' => array(
                                                '2014'=>'2014', 
                                                '2015'=>'2015',     
                                                ),
                                            'empty' => 'Elegir',
                                            'label'=> 'A&ntilde;o'

                                            )
                                ); ?>                  

                <td><?php echo $this->Form->input('meshastasindicato', array('options' => array(
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
                                                        'label'=> 'Mes'
                                                    )); ?> </td> 

                <td><?php echo $this->Form->input('aniohastasindicato', array(
                                            'options' => array(
                                                '2014'=>'2014', 
                                                '2015'=>'2015',     
                                                ),
                                            'empty' => 'Elegir',
                                            'label'=> 'A&ntilde;o'

                                            )
                                );  ?>  </td>
            </tr>
            <tr>            
                <td colspan="3">
                    <?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacute;n','style'=>'width:95%'));?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><a href="#close" class="btn_cancelar" >Cancelar</a></td>
                <td><?php echo $this->Form->end(__('Aceptar')); ?></td> 
            </tr>
        </table>
        
    </div>
        <?php else:?>
        <h3><?php echo __('Todos los sindicatos han sido agregados'); ?></h3>
    </div>
        <?php endif;?>
    
    <a class="close" href="#close"></a>
</div>

 <!-- Inicio Popin Nuevo Banco -->
<a href="#x" class="overlay" id="nuevo_Banco"></a>
<div id="divNuevoBanco" class="popup" style="width:38%;">        
        <div id="form_impcliOrganismo_Banco">
        <?php if (!empty($impuestosbancos)): ?>    
            <?php 
                echo $this->Form->create('Impcli',array('controller'=>'Impclis','action'=>'addbancosindicato')); ?>                
                <h3><?php echo __('Relacionar Banco'); ?></h3>
                <?php
                    echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden'));?>
                    <table cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2"><?php echo $this->Form->input('impuesto_id', array('label'=>'Sindicato','empty'=>'Seleccionar Banco', 'div' => false ,'type'=>'select', 'options'=>$impuestosbancos));?></td>
                        <td> <?php echo $this->Form->input('usuario', array('label'=>'Usuario','size' =>'10', 'default'=>$organizmo['usuario']));?></td>
                        <td><?php echo $this->Form->input('clave', array('label'=>'Clave','default'=>$organizmo['clave'], 'size' =>'10'));?></td> 
                    </tr>

                    <tr>
                        <td colspan="2"><?php echo "Periodo Desde";?></td>
                        <td colspan="2"><?php echo "Periodo Hasta";  ?></td> 
                    </tr>
                    <tr>
                        <td><?php echo $this->Form->input('mesdesde', array('options' => array(
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
                                                                'div' => false
                                                            ));  ?></td> 
                    
                        <td><?php echo $this->Form->input('aniodesde', array(
                                                    'options' => array(
                                                        '2014'=>'2014', 
                                                        '2015'=>'2015',     
                                                        ),
                                                    'empty' => 'Elegir',
                                                    'label'=> 'A&ntilde;o'
    
                                                    ));?></td>  
 
                                             
                        <td><?php echo $this->Form->input('meshasta', array('options' => array(
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
                                                                'label'=> 'Mes'
                                                            )); ?>  </td>  

                        <td><?php echo $this->Form->input('aniohasta', array(
                                                    'options' => array(
                                                        '2014'=>'2014', 
                                                        '2015'=>'2015',     
                                                        ),
                                                    'empty' => 'Elegir',
                                                    'label'=> 'A&ntilde;o'
    
                                                    )
                                        ); ?> </td>    
                    </tr>
                    <tr>  
                        <td colspan="2"><?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacuten'));?></td>
                    </tr>
                    <tr>
                        <td colspan="3"><a href="#close"  onclick="" class="btn_cancelar"> Cancelar </a></td>
                        <td ><?php echo $this->Form->end('Agregar');?></td>
                    </tr>
               </table>
        </div>
        <?php else:?>
                <h3><?php echo __('Todos los bancos han sido agregados'); ?></h3>
        <?php endif?>                    
         <a class="close" href="#close"></a>
</div>
   
</div>


<!-- Inicio Popin Nuevo SubCliente -->
<a href="#x" class="overlay" id="nuevo_subcliente"></a>
<div class="popup">
        <div id="form_subcliente" class="form" style="width: 94%;">             
            <?php echo $this->Form->create('Subcliente',array('controller'=>'Subclientes','action'=>'add')); ?>   

            <h3><?php echo __('Agregar SubCliente'); ?></h3>
            <table style="margin-bottom:0px">
                <tr>
                    <td colspan="2"><?php echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden')); ?></td>
                </tr>
                </tr>
                    <td colspan="2"><?php echo $this->Form->input('nombre', array('label' => 'Nombre')); ?></td>
                </tr>
                </tr>
                    <td colspan="2"><?php echo $this->Form->input('cuit', array('label' => 'CUIT', 'size' => '10')); ?> </td>  
                </tr>
                </tr>                 
                    <td colspan="2"><?php echo $this->Form->input('condicioniva', array(
                        'options' => array(
                            'responsableinscripto'=>'Responsable Inscripto', 
                            'consf'=>'Cons. F.', 
                            'excento'=>'Excento', 
                            'noalcanza'=>'No Alcanza', 
                            'monotributista'=>'Monotributista', 
                            ),
                        'empty' => 'Elegir Condicion',
                        'label'=> 'Condicion IVA'
                    ));?></td>   
                </tr>
                <tr>
                    <td><a href="#close" class="btn_cancelar" style="margin-top:12px">Cancelar</a></td>
                    <td><?php echo $this->Form->end(__('Aceptar')); ?></td> 
                </tr>
            </table>
        </div>
    <a class="close" href="#close"></a>
</div>
<!-- Fin Popin Nuevo SubCliente --> 
<!-- Inicio Popin Nuevo Punto de venta -->
<a href="#x" class="overlay" id="nuevo_puntodeventa"></a>
<div class="popup">
        <div id="form_puntodeventa" class="form" style="width: 94%;">             
            <?php echo $this->Form->create('Puntosdeventa',array('controller'=>'Puntosdeventa','action'=>'add')); ?>   

            <h3><?php echo __('Agregar Punto de venta'); ?></h3>
            <table style="margin-bottom:0px">
                <tr>
                    <td colspan="2"><?php echo $this->Form->input('cliente_id',array('default'=>$cliente['Cliente']['id'],'type'=>'hidden')); ?></td>
                </tr>
                <tr>    
                    <td colspan="2"><?php echo $this->Form->input('nombre', array('label' => 'Nombre', 'div' => false));  ?></td>   
                </tr>
                <tr>               
                    <td colspan="2"><?php echo $this->Form->input('telefono', array('label' => 'Tel&eacute;fono', 'size' => '11', 'div' => false)); ?></td>
                </tr>
                <tr>
                    <td colspan="2"><?php echo $this->Form->input('direccion', array('label' => 'Direcci&oacute;n', 'div' => false)); ?></td>
                </tr>
                <tr>
                    <td><a href="#close" class="btn_cancelar" style="margin-top:12px">Cancelar</a></td>
                    <td><?php echo $this->Form->end(__('Aceptar')); ?></td>
                </tr>         
            
            </table>
        </div>
    <a class="close" href="#close"></a>
</div>
    <!-- Fin Popin Nuevo Punto de venta --> 
   
<?php }//fin if(mostrarView) ?>
<!-- Fin Popin Nuevo ImpClis DGRM --> 
