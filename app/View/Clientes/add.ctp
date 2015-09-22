<?php echo $this->Html->script('jquery-ui',array('inline'=>false));?>
<?php echo $this->Html->script('clientes/add',array('inline'=>false));?>

<div class="clientes form">	
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
                                            'type'=>'text',
                                            'label'=>'Cliente desde',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>
                        <td>
                            <?php 
                                 echo $this->Form->input('fchfincliente', array(
                                            'class'=>'datepicker', 
                                            'type'=>'text',
                                            'label'=>'Cliente hasta',                                    
                                            'readonly'=>'readonly')
                                 );?>
                        </td>  
                    </tr>
                    <span style="display:none">
                    </span>
                    <tr id="rowButtonsDetallesPersonales" >                        
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right">  
                            <?php echo $this->Form->end(__('Aceptar')); ?>                                                  
                        </td>                        
                    </tr>
                </table>
	

</div>

