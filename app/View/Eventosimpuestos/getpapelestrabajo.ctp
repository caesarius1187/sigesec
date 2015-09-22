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
	
		<div id="form_prepararPapeles" class="prepararPapeles form">
	      <fieldset>
	        <legend><?php echo __('Agregar Papeles de Trabajo'); ?></legend>
	        <?php         
	       		echo $this->Form->create('Eventosimpuesto'); 
	       		if($tipopago=='unico'){
	       			echo $this->Form->input('eventoId',array('value'=>$eventoid,'type'=>'hidden'));
	       		}else{
	       			echo $this->Form->input('eventoId',array('value'=>0,'type'=>'hidden'));
	       		}
	          	echo $this->Form->input('id',array('type'=>'hidden'));
	          	echo $this->Form->input('clienteid',array('value'=>$clienteid,'type'=>'hidden'));

	          	switch ($tipopago) {
	          		case 'provincia':
		          		echo $this->Form->input('partido_id');
		          		break;
		          	case 'municipio':
		          		echo $this->Form->input('localidade_id');
		          		break;
	          		case 'item':
	          			echo $this->Form->input('item');
	          		break;	          	
	          	}
          		echo $this->Form->input('impcliid',array('value'=>$impcliid,'type'=>'hidden'));
	           	echo $this->Form->input('fchvto', array(
								                      'class'=>'datepicker', 
								                      'type'=>'text',
								                      'label'=>'Fecha de Vencimiento',
								                      'readonly','readonly'));	           	
	          	echo $this->Form->input('montovto',array('label'=>'Monto a Pagar','default'=>"0"));
	          	echo $this->Form->input('monc',array('label'=>'Monto a Favor','default'=>"0"));
	          	echo $this->Form->input('descripcion',array('default'=>"-"));        
	        ?>
	      </fieldset>
	      <a href="#"  onclick="agregarPapeldeTrabajo()" class="btn_aceptar">  Agregar </a>
	      <fieldset style="display:none"><?php echo  $this->Form->submit('Aceptare');?> </fieldset>
	    </div>
	    <?php //echo print_r($eventosimpuestos) ;?>
	<?php if($tipopago!='unico'){?>
	<h2><?php echo __('Papeles preparados'); ?></h2>
	<table cellpadding="0" cellspacing="0" id="tablePapelesPreparados">
		<tr>
				<?php
				switch ($tipopago) {
	          		case 'provincia':
		          		echo "<th>Provincia</th>";
		          		break;
		          	case 'municipio':
		          		echo "<th>Municipio</th>";
		          		break;
	          		case 'item':
	          			echo "<th>Item</th>";
	          		break;	          	
	          	}?>
				<th>Fecha Vencimiento</th>
				<th>Monto</th>
				<th>Fecha Realizado</th>
				<th>Monto Realizado</th>
				<th>Monto a Favor</th>
				<th>Descripcion</th>

				<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>

		<?php foreach ($eventosimpuestos as $eventosimpuesto): ?>
		<tr>
			<?php
			switch ($tipopago) {
	      		case 'provincia':
	          		?><td><?php echo h($eventosimpuesto['Partido']['nombre']); ?>&nbsp;</td><?php 
	          		break;
	          	case 'municipio':
	          		?><td><?php echo h($eventosimpuesto['Localidade']['nombre']); ?>&nbsp;</td><?php 
	          		break;
	      		case 'item':
	      			?><td><?php echo h($eventosimpuesto['Eventosimpuesto']['item']); ?>&nbsp;</td><?php 
	      		break;	          	
	      	}?>
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['fchvto']); ?>&nbsp;</td>
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['montovto']); ?>&nbsp;</td>
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['fchrealizado']); ?>&nbsp;</td>
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['montorealizado']); ?>&nbsp;</td>
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['monc']); ?>&nbsp;</td>			
			<td><?php echo h($eventosimpuesto['Eventosimpuesto']['descripcion']); ?>&nbsp;</td>
			
			<td class="actions">			
				<?php echo $this->Form->postLink(__('Eliminar'),"#"); ?>
			</td>
		</tr>
<?php endforeach; ?>
	</table>
<?php } ?>