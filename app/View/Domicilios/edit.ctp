<?php echo $this->Form->create('Domicilio',array('action' => 'edit', )); ?>
	<?php
		 echo $this->Form->input('id');
		echo $this->Form->input('cliente_id',array('type'=>'hidden'));
	?>
	<h3><?php echo __('Editar Domicilio'); ?></h3>
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
                        <td style="width: 150px;"><?php  echo $this->Form->input('tipo', array('label'=>'Tipo','type'=>'select','options'=>array('comercial'=>'Comercial','fiscal'=>'Fiscal','personal'=>'Personal','laboral'=>'Laboral'),'default'=>$this->request->data['Domicilio']['tipo']));?></td> 
                        <?php //<td>echo $this->Form->input('puntodeventa', array('label'=>'Pto. Vta.', 'size' => '4'));</td>?>
                        <td><?php echo $this->Form->input('fechainicio', array(
                                            'class'=>'datepicker', 
                                            'value'=>date('d-m-Y',strtotime($this->request->data['Domicilio']['fechainicio'])),
                                            'type'=>'text',
                                            'size'=>'10',
                                            'label'=>'Fecha de Inicio',                                    
                                            'readonly'=>'readonly')
                             );?></td>
                        <td></td> 
                    </tr>
                </table>             
            </td>            
        </tr>
        <tr>    

        </tr>
            <td><?php echo $this->Form->input('partido_id', array('label'=>'Provincia','onChange'=>'getLocalidades()','default'=>$this->request->data['Localidade']['partido_id']));?></td>
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
            </table>
	</fieldset>
<?php echo $this->Form->end(__('Modificar')); ?>

