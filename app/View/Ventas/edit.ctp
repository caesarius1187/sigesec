<?php
$tdClass = "tdViewVenta".$this->data['Venta']["id"];
if(!$mostrarForm) { ?>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["fecha"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["tipocomprobante"]?>-
    <?php if(isset($this->data['Venta']["Subcliente"]["nombre"])) echo $this->data['Venta']["Puntosdeventa"]['nombre']?>-
    <?php echo $this->data['Venta']["numerocomprobante"]?></td>
    <td class="<?php echo $tdClass?>"><?php if(isset($this->data['Venta']["Subcliente"]["nombre"])) echo $this->data['Venta']["Subcliente"]["nombre"]?></td>
    <td class="<?php echo $tdClass?>"><?php if(isset($this->data['Venta']["Localidade"]["nombre"])) echo $this->data['Venta']["Localidade"]["nombre"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["alicuota"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["neto"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["iva"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["ivapercep"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["actvspercep"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["impinternos"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["nogravados"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["excentos"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["comercioexterior"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Venta']["total"]?></td>
    <td class="<?php echo $tdClass?>"> 
      <?php 
      $paramsVenta=$this->data['Venta']["id"];
      echo $this->Html->image('edit_view.png',array('width' => '20', 'height' => '20','onClick'=>"modificarVenta(".$paramsVenta.")"))?> 
    </td>
<?php }else{ ?>
    <td colspan="15" id="tdventa<?php echo $venid?>">
        <?php echo $this->Form->create('Venta',array('controller'=>'Venta','action'=>'edit','id'=>'VentaFormEdit'.$this->data['Venta']['id'])); 
            echo $this->Form->input('id',array('type'=>'hidden'));
            echo $this->Form->input('cliente_id',array('type'=>'hidden'));
         ?> 
        <table class="tableVentaEditForm">    
            <tr>             
                <td>
                    <?php
                    echo $this->Form->input('fecha', array(
                            'class'=>'datepicker', 
                            'type'=>'text',
                            'label'=>false,                                       
                            'readonly'=>'readonly')
                     );?>                                
                </td>
                <td class="tdVentaComprobante">
                    <table style="margin:0" cellspacing="0" cellpadding="0">                        
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
                            )); 
                            ?>
                            </td>
                            <td><?php                      
                                echo $this->Form->input('puntosdeventa_id', array(
                                      'options' => $puntosdeventas,                              
                                      'label'=> ' ',
                                      'style'=>'width:49px;padding:0;margin:0'
                                      )); 
                                ?>
                            </td>
                             <td><?php                   
                                echo $this->Form->input('numerocomprobante', array(
                                    'label'=> ' ',
                                      'style'=>'width:49px;padding:0;margin:0'
                                    ));    
                                ?>
                            </td>  
                        </tr>
                    </table>  
                </td>                        
                <td><?php                   
                    echo $this->Form->input('subcliente_id',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php       
                    echo $this->Form->input('partido_id',array('label'=>'' ));               
                    echo $this->Form->input('localidade_id',array('label'=>'' ));    
                    ?>
                </td>                       
                <td><?php                   
                    echo $this->Form->input('alicuota',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('neto',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('iva',array('label'=>'' ));    
                    ?>
                </td>                        
                <td><?php                   
                    echo $this->Form->input('ivapercep',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('actvspercep',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('impinternos',array('label'=>'' ));    
                    ?>
                </td>                        
                <td><?php                   
                    echo $this->Form->input('nogravados',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('excentos',array('label'=>'' ));     
                    ?>
                </td>
                <td><?php                  
                    echo $this->Form->input('comercioexterior',array('label'=>'' ));      
                    ?>
                </td>                        
                <td><?php                 
                    echo $this->Form->input('total',array('label'=>'' ));     
                    ?>
                </td>  
                <td> 
                    <?php echo $this->Form->end(__('+'),array('div'=>false)); ?>   
                    <a href="#" class="btn_cancelar" onClick="hideFormModVenta('<?php echo $this->data['Venta']['id'];?>')" style="float: left;width: 45px;margin: 0;">X</a>
                </td> 
            </tr>   
        </table>
             
        
    </td>     
<?php } ?>                      
                    
                      
        