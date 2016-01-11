<?php
$tdClass = "tdViewCompra".$this->data['Compra']["id"];
if(!$mostrarForm) { ?>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["fecha"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["tipocomprobante"]?>-
    <?php if(isset($this->data["Puntosdeventa"]["nombre"])) echo $this->data["Puntosdeventa"]['nombre']?>-
    <?php echo $this->data['Compra']["numerocomprobante"]?></td>
    <td class="<?php echo $tdClass?>"><?php if(isset($this->data["Subcliente"]["nombre"])) echo $this->data["Subcliente"]["nombre"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["condicioniva"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["tipogasto"]?></td>              
    <td class="<?php echo $tdClass?>"><?php if(isset($this->data["Localidade"]["nombre"])) echo $this->data["Localidade"]["nombre"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["imputacion"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["tipocredito"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["alicuota"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["neto"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["iva"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["tipoiva"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["ivapercep"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["iibbpercep"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["actvspercep"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["impinternos"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["nogravados"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["nogravadogeneral"]?></td>
    <td class="<?php echo $tdClass?>"><?php echo $this->data['Compra']["total"]?></td>
    <td class="<?php echo $tdClass?>"> 
      <?php 
      $paramsCompra=$this->data['Compra']["id"];
      echo $this->Html->image('edit_view.png',array('width' => '20', 'height' => '20','onClick'=>"modificarCompra(".$paramsCompra.")"))?> 
    </td>
<?php }else{ ?>
    <td colspan="20" id="tdcompra<?php echo $comid?>">
        <?php echo $this->Form->create('Compra',array('controller'=>'Compra','action'=>'edit','id'=>'CompraFormEdit'.$this->data['Compra']['id'])); 
            echo $this->Form->input('id',array('type'=>'hidden'));
            echo $this->Form->input('cliente_id',array('type'=>'hidden'));
         ?> 
        <table class="tableCompraEditForm">    
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
                <td class="tdCompraComprobante">
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
                    echo $this->Form->input('condicioniva',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('tipogasto',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php       
                    echo $this->Form->input('partido_id',array('label'=>'' ));               
                    echo $this->Form->input('localidade_id',array('label'=>'' ));    
                    ?>
                </td>           
                <td><?php                   
                    echo $this->Form->input('imputacion',array('label'=>'' ));    
                    ?>
                </td>  
                <td><?php                   
                    echo $this->Form->input('tipocredito',array('label'=>'' ));    
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
                    echo $this->Form->input('tipoiva',array(
                        'label'=>'' ,
                        'options'=>array('directo'=>'Directo','prorateable'=>'Prorateable')
                        )
                    );    
                    ?>
                </td>                        
                <td><?php                   
                    echo $this->Form->input('ivapercep',array('label'=>'' ));    
                    ?>
                </td>
                <td><?php                   
                    echo $this->Form->input('iibbpercep',array('label'=>'' ));    
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
                    echo $this->Form->input('nogravadogeneral',array('label'=>'' ));      
                    ?>
                </td>                        
                <td><?php                 
                    echo $this->Form->input('total',array('label'=>'' ));     
                    ?>
                </td>  
                <td> 
                    <?php echo $this->Form->end(__('+'),array('div'=>false)); ?>   
                    <a href="#" class="btn_cancelar" onClick="hideFormModCompra('<?php echo $this->data['Compra']['id'];?>')" style="float: left;width: 45px;margin: 0;">X</a>
                </td> 
            </tr>   
        </table>        
    </td>     
<?php } ?>                      
                    
                      
        