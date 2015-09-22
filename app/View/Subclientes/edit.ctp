<SCRIPT TYPE="text/javascript">
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

</SCRIPT>
<div class="personasrelacionadas form">
<?php echo $this->Form->create('Personasrelacionada',array('action'=>'edit')); ?>
	<fieldset>
		<legend><?php echo __('Editar Persona Relacionada'); ?></legend>	
	<?php
				echo $this->Form->input('id');
                echo $this->Form->input('cliente_id',array('type'=>'hidden'));
                ?>
                <table>
                    <tr>
                        <td>
                        <?php   
                            echo $this->Form->input('tipo', array('options' => array(
                                                                    'tipo1'=>'Tipo 1', 
                                                                    'tipo2'=>'Tipo 2'                                                            
                                                                    ),
                                                                'default'=>$this->request->data['Personasrelacionada']['tipo'],                           
                                                                'label'=> 'Tipo'
                                                            ));  ?>
                         </td>   
                         <td><?php
                            echo $this->Form->input('sede');?>
                         </td>  
                        <td><?php
                            echo $this->Form->input('vtomandato', array(
                                            'class'=>'datepicker', 
                                            'type'=>'text',
                                            'label'=>'Vencimiento Mandato',   
                                            'default'=>$this->request->data['Personasrelacionada']['vtomandato'],                                   
                                            'readonly'=>'readonly')
                                 );?>
                         </td>                      
                    </tr>
                    <tr>     
                        <td>
                          <?php
                            echo $this->Form->input('porcentajeparticipacion');?>
                        </td>                      
                        <td>
                          <?php
                            echo $this->Form->input('puntodeventa');?>
                        </td>   
                        <td>
                        <?php       
                            echo $this->Form->input('localidade_id');?>
                         </td>
                         
                    </tr>
                    <tr> 
                         <td>   <?php
                            echo $this->Form->input('calle');?>
                         </td>  
                        <td><?php
                            echo $this->Form->input('numero');?>
                         </td>
                         <td>   <?php
                            echo $this->Form->input('piso');?>
                         </td>    
                                             
                     </tr>
                     <tr> 
                        <td>
                        <?php
                            echo $this->Form->input('ofidepto');?>
                         </td>    
                        <td> 
                         <?php
                            echo $this->Form->input('ruta');?>
                         </td>    
                         <td> 
                        <?php
                            echo $this->Form->input('kilometro');?>
                         </td>
                         
                     </tr>                     
                     <tr> 
                        <td>   <?php
                            echo $this->Form->input('torre');?>
                         </td>  
                        <td> 
                        <?php
                            echo $this->Form->input('manzana');?>
                         </td>
                         <td>   <?php
                            echo $this->Form->input('entrecalles');?>
                         </td>    
                        <td> 
                        
                     </tr>
                     <tr> 
                         <td>
                       <?php
                            echo $this->Form->input('codigopostal');?>
                         </td>
                         <td>   <?php
                            echo $this->Form->input('telefono');?>
                         </td>  
                         <td> 
                        <?php
                            echo $this->Form->input('movil');?>
                         </td>
                             
                     </tr>

                     <tr> 
                        <td>   <?php
                            echo $this->Form->input('fax');?>
                         </td> 
                        <td> 
                        <?php
                            echo $this->Form->input('email');?>
                         </td>
                         <td>   <?php
                            echo $this->Form->input('personacontacto');?>
                         </td>  
                           
                     </tr>
                     <tr>
                      <td> 
                            <?php
                            echo $this->Form->input('observaciones');?>
                         </td> 
                     </tr>  
                </table>
	</fieldset>
<?php echo $this->Form->end(__('Aceptar')); ?>
</div>

