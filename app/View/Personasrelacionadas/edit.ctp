<div class="personasrelacionadas form" >
<?php echo $this->Form->create('Personasrelacionada',array('controller'=>'Personasrelacionadas','action'=>'edit')); ?>
    <h3><?php echo __('Editar persona relacionada'); ?></h3>
    <?php
        echo $this->Form->input('id',array('type'=>'hidden'));
        echo $this->Form->input('cliente_id',array('type'=>'hidden'));
    ?>
    <table cellpadding="0" cellspacing="0" border="0">
        <tr>
            <td>
                <?php echo $this->Form->input('nombre',array('label'=>'Apellido y Nombre'));?>
            </td>
            <td>
                <?php echo $this->Form->input('documento');?>
            </td>                         
             <td><?php echo $this->Form->input('tipo',
                                                array('type'=>'select',
                                                      'options'=>array(
                                                        'conyuge'=>'Conyuge',
                                                        'socio'=>'Socio',
                                                        'familiar'=>'Familiar',
                                                        'representante'=>'Representante',
                                                        'presidente'=>'Presidente',
                                                        'gerente'=>'Gerente'
                                                        )
                                                    )
                                                );?>
            </td>
                                   
        </tr>
          <tr>
           
            <td><?php echo $this->Form->input('vtomandatoedit', array(
                                'class'=>'datepicker', 
                                'type'=>'text',
                                'size'=>'10',
                                'value'=>date('d-m-Y',strtotime($this->request->data['Personasrelacionada']['vtomandato'])),
                                'label'=>'Vencimiento Mandato',                                    
                                'readonly'=>'readonly',
                                'default'=>$this->request->data['Personasrelacionada']['vtomandato'])
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

