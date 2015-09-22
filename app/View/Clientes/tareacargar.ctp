<?php echo $this->Html->script('jquery-ui.js',array('inline'=>false));?>
<?php echo $this->Html->script('clientes/tareacargar',array('inline'=>false));?>
<div class="index">  
  <div id="headerCarga" style="height:34px;text-align: center;">
    <div style="padding:0 0 0 1%">
      <h2 style="float:left">Cliente:</h2>
      <h3 style="float:left;margin-left:20px;"> <?php echo $cliente["Cliente"]['nombre']?></h3>
      <h2 style="float:left;margin-left:20px;">Periodo:</h2>
      <h3 style="float:left;margin-left:20px;"> <?php echo $periodo?></h3>
     <!--<div class="fab blue" style="width: 100px;">
      <core-icon icon="add" align="center">            
        <?php echo $this->Form->button('Realizado', 
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
    </div>-->
    </div>  
  </div>
  <div id="bodyCarga"  >
    <div class="" style="width:100%;height:30px;">
      <div class="cliente_view_tab_active" style="width:22%;"  onClick="" id="tabVentas">
        <?php
           echo $this->Form->label(null, $text = 'Ventas',array('style'=>'text-align:center;margin-top:5px;cursor:pointer')); 
         ?>
      </div>
      <div class="cliente_view_tab" style="width:22%;"  onClick="" id="tabCompras">
        <?php
            echo $this->Form->label(null, $text = 'Compras',array('style'=>'text-align:center;margin-top:5px;cursor:pointer'));
         ?>
      </div>
      <div class="cliente_view_tab" style="width:22%;"  onClick="" id="tabNovedades">
        <?php
            echo $this->Form->label(null, $text = 'Novedades',array('style'=>'text-align:center;margin-top:5px;cursor:pointer'));

            //$this->Html->image('cli_view.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'margin-left: 50%;'));
         ?>
      </div>
      <div class="cliente_view_tab" style="width:22%;" onClick="" id="tabRetenciones">
        <?php
            echo $this->Form->label(null, $text = 'Retenciones',array('style'=>'text-align:center;margin-top:5px;cursor:pointer'));

            //$this->Html->image('cli_view.png', array('alt' => '','id'=>'imgcli','class'=>'','style'=>'margin-left: 50%;'));
         ?>
      </div>
    </div>
    <?php /**************************************************************************/ ?>
    <?php /*****************************Ventas**************************************/ ?>
    <?php /**************************************************************************/ ?> 
    <div id="form_venta" class="tabVentas" style="overflow:auto;width:100%;margin: 0 0 0 0%;">             
      <?php
          echo $this->Form->create('Venta',array('id'=>'saveVentasForm','action'=>'addajax')); 
          echo $this->Form->input('cliente_id',array('default'=>$cliente["Cliente"]['id'],'type'=>'hidden'));
       ?> 
      <table class="tareaCargarFormTable" style="border:1px solid white" cellspacing="0" cellpading="0">
        <tr class="">
          <td class="tareaCargarFormTD"><?php
              echo $this->Form->input('fecha', array(
                      'class'=>'datepicker', 
                      'type'=>'text',
                      'label'=>'Fecha',
                      'default'=>"",
                      'readonly'=>'readonly',
                      'required'=>true
                      )
               );?>                                
          </td>                                                                                    
          <td class="tareaCargarFormTD" style="padding:0" >
            <table style="margin:0;" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3">Numero Comprobante</td>
              </tr>
              <tr>
                <td class="tareaCargarFormTD" style="padding:0"><?php             
                    //Aca tenemos que sacar los tipos de comprobantes que el cliente puede emitir                              
                    echo $this->Form->input('tipocomprobante', array(
                        'options' => array(
                            'A'=>'A', 
                            'B'=>'B', 
                            'C'=>'C',                                         
                            ),                              
                        'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0')
                    ); 
                    ?>
                </td>
               <td class="tareaCargarFormTD" style="padding:0">                                   
                <?php                      
                    echo $this->Form->input('puntosdeventa_id', array(
                        'options' => $puntosdeventas,                              
                        'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0'
                        )
                    ); 
                    ?>
                </td>
               <td class="tareaCargarFormTD" style="padding:0">
                      <?php                   
                  echo $this->Form->input('numerocomprobante', array(
                      'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0'
                      )
                  );  
                  ?>
                </td>                
              </tr>
            </table>  
          </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('subcliente_id', array(
                    'options' => $subclientes,                              
                    'label'=> 'Cliente',
                    )
                );  
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
               echo $this->Form->input('partido_id',array(
                    ));   
                echo $this->Form->input('localidade_id',array(
                    ));    
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('alicuota',array(
                   'options' => $alicuotas,
                    'style'=>'width:60px'));    
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('neto',array(
                    ));    
                ?>
            </td> 
         
           
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('iva',array(
                    ));    
                ?>
            </td>
      
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('ivapercep',array(
                      'label'=> 'IVA Percep',                              
                    ));    
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('actvspercep',array(
                      'label'=> 'Act vs Percep',
                    ));    
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('impinternos',array(
                    'label'=> 'Imp Internos',
                    ));    
                ?>
            </td>
       
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('nogravados',array(
                      'label'=> 'No Gravados',
                    ));    
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                   
                echo $this->Form->input('excentos',array(
                    ));     
                ?>
            </td>
            <td class="tareaCargarFormTD"><?php                  
                echo $this->Form->input('comercioexterior',array(
                    'label'=>'Otros',
                    ));      
                ?>
            </td>
        
            <td class="tareaCargarFormTD"><?php                 
                echo $this->Form->input('total',array(
                    ));     
                ?>
            </td>
            <td class="tareaCargarFormTD">               
                <?php                  
                 echo $this->Form->input('asiento',array('type'=>'hidden'));      
                ?>
                <?php                  
                  echo $this->Form->input('periodo',array('default'=>$periodo,'type'=>'hidden'));      
                ?>        
                <?php echo $this->Form->submit('+', array('type'=>'image','src' => '/sigesec/img/add_view.png','class'=>'imgedit','style'=>'width:25px;height:25px;','div'=>false));  ?>  
                <?php echo $this->Form->end();  ?>  
            </td>
                                            
        </tr>
      </table>                    
    </div>        
    <div style="overflow:auto;width:100%;margin: 0 0 0 0%;" class="tareaCargarIndexTable tabVentas">
      <table class="" style="border:1px solid white" id="bodyTablaVentas">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Comprobante</th>
            <th>SubCliente</th>
            <th>Localidad</th>
            <th>Alicuota</th>
            <th>Neto</th>
            <th>IVA</th>
            <th>IVA Percep</th>
            <th>Act Vs Perc</th>
            <th>Imp Internos</th>
            <th>No Gravados</th>
            <th>Excentos</th>
            <th>Otros</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="bodyTablaVentas">
          <?php
          foreach($cliente["Venta"] as $venta ){
            echo $this->Form->create('Venta',array('controller'=>'Venta','action'=>'edit')); 
            $tdClass = "tdViewVenta".$venta["id"];
            ?>
            <tr id="rowventa<?php echo $venta["id"]?>"> 
              <td class="<?php echo $tdClass?>"><?php echo $venta["fecha"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["tipocomprobante"]?>-
              <?php if(isset($venta["Subcliente"]["nombre"])) echo $venta["Puntosdeventa"]['nombre']?>-
              <?php echo $venta["numerocomprobante"]?></td>
              <td class="<?php echo $tdClass?>"><?php if(isset($venta["Subcliente"]["nombre"])) echo $venta["Subcliente"]["nombre"]?></td>
              <td class="<?php echo $tdClass?>"><?php if(isset($venta["Localidade"]["nombre"])) echo $venta["Localidade"]["nombre"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["alicuota"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["neto"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["iva"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["ivapercep"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["actvspercep"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["impinternos"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["nogravados"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["excentos"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["comercioexterior"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $venta["total"]?></td>
              <td class="<?php echo $tdClass?>"> 
                <?php 
                $paramsVenta=$venta["id"];
                echo $this->Html->image('edit_view.png',array('width' => '20', 'height' => '20','onClick'=>"modificarVenta(".$paramsVenta.")"))?> 
              </td>
            </tr>
            <?php

          }
          ?>
        </tbody>
      </table>  
    </div> 
   <?php /**************************************************************************/ ?>
   <?php /*****************************Compras**************************************/ ?>
   <?php /**************************************************************************/ ?>        
    <div id="form_compra" class="tabCompras" style="overflow:auto;width:100%;margin: 0 0 0 0%;">             
      <?php
          echo $this->Form->create('Compra',array('id'=>'saveComprasForm','action'=>'addajax')); 
          echo $this->Form->input('cliente_id',array('default'=>$cliente["Cliente"]['id'],'type'=>'hidden'));
       ?> 
      <table class="tareaCargarFormTable tabCompras" style="border:1px solid white" cellspacing="0" cellpading="0">
        <tr class="">
          <td class="tareaCargarFormTD"><?php
              echo $this->Form->input('fecha', array(
                      'class'=>'datepicker', 
                      'type'=>'text',
                      'label'=>'Fecha',
                      'default'=>"",
                      'readonly'=>'readonly',
                      'required'=>true
                      )
               );?>                                
          </td>                                                                                    
          <td class="tareaCargarFormTD" style="padding:0" >
            <table style="margin:0;" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3">Numero Comprobante</td>
              </tr>
              <tr>
                <td class="tareaCargarFormTD" style="padding:0"><?php             
                    //Aca tenemos que sacar los tipos de comprobantes que el cliente puede emitir                              
                    echo $this->Form->input('tipocomprobante', array(
                        'options' => array(
                            'A'=>'A', 
                            'B'=>'B', 
                            'C'=>'C',                                         
                            ),                              
                        'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0')
                    ); 
                    ?>
                </td>
                <td class="tareaCargarFormTD" style="padding:0">                                   
                <?php                      
                    echo $this->Form->input('puntosdeventa_id', array(
                        'options' => $puntosdeventas,                              
                        'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0'
                        )
                    ); 
                    ?>
                </td>
                <td class="tareaCargarFormTD" style="padding:0">
                      <?php                   
                  echo $this->Form->input('numerocomprobante', array(
                      'label'=> ' ',
                        'style'=>'width:49px;padding:0;margin:0'
                      )
                  );  
                  ?>
                </td>                
              </tr>
            </table>  
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('subcliente_id', array(
                  'options' => $subclientes,                              
                  'label'=> 'Cliente',
                  )
              );  
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
             echo $this->Form->input('partido_id',array(
                  ));   
              echo $this->Form->input('localidade_id',array(
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('alicuota',array(
                 'options' => $alicuotas,
                  'style'=>'width:60px'));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('neto',array(
                  ));    
              ?>
          </td> 
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('iva',array(
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('ivapercep',array(
                    'label'=> 'IVA Percep',                              
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('actvspercep',array(
                    'label'=> 'Act vs Percep',
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('impinternos',array(
                  'label'=> 'Imp Internos',
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('nogravados',array(
                    'label'=> 'No Gravados',
                  ));    
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                   
              echo $this->Form->input('excentos',array(
                  ));     
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                  
              echo $this->Form->input('comercioexterior',array(
                  'label'=>'Otros',
                  ));      
              ?>
          </td>
          <td class="tareaCargarFormTD"><?php                 
              echo $this->Form->input('total',array(
                  ));     
              ?>
          </td>
          <td class="tareaCargarFormTD">               
              <?php                  
               echo $this->Form->input('asiento',array('type'=>'hidden'));      
              ?>
              <?php                  
                echo $this->Form->input('periodo',array('default'=>$periodo,'type'=>'hidden'));      
              ?>        
              <?php echo $this->Form->submit('+', array('type'=>'image','src' => '/sigesec/img/add_view.png','class'=>'imgedit','style'=>'width:25px;height:25px;','div'=>false));  ?>  
              <?php echo $this->Form->end();  ?>  
          </td>                                          
        </tr>
      </table>                
    </div>
    <div style="overflow:auto;width:100%;margin: 0 0 0 0%;" class="tareaCargarIndexTable tabCompras">
      <table class="" style="border:1px solid white" id="bodyTablaCompras">
        <thead>
          <tr>
            <th>Fecha</th>
            <th>Comprobante</th>
            <th>SubCliente</th>
            <th>Localidad</th>
            <th>Alicuota</th>
            <th>Neto</th>
            <th>IVA</th>
            <th>IVA Percep</th>
            <th>Act Vs Perc</th>
            <th>Imp Internos</th>
            <th>No Gravados</th>
            <th>Excentos</th>
            <th>Otros</th>
            <th>Total</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="bodyTablaCompras">
          <?php
          foreach($cliente["Compra"] as $compra ){
            echo $this->Form->create('Compra',array('controller'=>'Venta','action'=>'edit')); 
            $tdClass = "tdViewCompra".$compra["id"];
            ?>
            <tr id="rowventa<?php echo $compra["id"]?>"> 
              <td class="<?php echo $tdClass?>"><?php echo $compra["fecha"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["tipocomprobante"]?>-
              <?php if(isset($compra["Subcliente"]["nombre"])) echo $compra["Puntosdeventa"]['nombre']?>-
              <?php echo $compra["numerocomprobante"]?></td>
              <td class="<?php echo $tdClass?>"><?php if(isset($compra["Subcliente"]["nombre"])) echo $compra["Subcliente"]["nombre"]?></td>
              <td class="<?php echo $tdClass?>"><?php if(isset($compra["Localidade"]["nombre"])) echo $compra["Localidade"]["nombre"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["alicuota"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["neto"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["iva"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["ivapercep"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["actvspercep"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["impinternos"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["nogravados"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["excentos"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["comercioexterior"]?></td>
              <td class="<?php echo $tdClass?>"><?php echo $compra["total"]?></td>
              <td class="<?php echo $tdClass?>"> 
                <?php 
                $paramsCompra=$compra["id"];
                echo $this->Html->image('edit_view.png',array('width' => '20', 'height' => '20','onClick'=>"modificarCompra(".$paramsCompra.")"))?> 
              </td>
            </tr>
            <?php

          }
          ?>
        </tbody>
      </table>  
    </div> 
  </div>
</div>

<!-- Inicio Popin VerEventoCliente -->
<a href="#x" class="overlay" id="popInModificarVenta"></a>
<div  class="popup">
<div class='section body' id="divModificarVenta">
   
</div>
<a class="close" href="#close"></a>
</div>
<!-- Fin Popin VerEventoCliente--> 