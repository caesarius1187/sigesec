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
	
	<h2><?php echo __('Papeles preparados'); ?></h2>
	<?php echo $this->Form->create('Eventosimpuesto'); ?>
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

		</tr>

		<?php 
		$i = 0;
		
		foreach ($eventosimpuestos as $eventosimpuesto): ?>
		<?php 
			echo $this->Form->input('Eventosimpuesto.'.$i.'.impcliid',array('value'=>$impcliid,'type'=>'hidden')); 
			echo $this->Form->input('Eventosimpuesto.'.$i.'.eventoId',array('type'=>'hidden'));
			echo $this->Form->input('Eventosimpuesto.'.$i.'.id',array('type'=>'hidden'));
			echo $this->Form->input('Eventosimpuesto.'.$i.'.clienteid',array('value'=>$clienteid,'type'=>'hidden'));
			?>
		<tr>
			<?php				
			switch ($tipopago) {
	      		case 'provincia':
	          		?>
	          		<td>

	          			<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.partido_id',array('value'=>$eventosimpuesto['partido_id'],'label'=>false)); ?>
          			</td>
	          		<?php 
	          		break;
	          	case 'municipio':
	          		?>
	          		<td>
	          			<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.localidade_id',array('value'=>$eventosimpuesto['localidade_id'],'label'=>false)); ?>
          			</td>
          			<?php 
	          		break;
	      		case 'item':
	      			?>
	      			<td>
	      				<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.item',array('value'=>$eventosimpuesto['Eventosimpuesto']['item'],'label'=>false)); ?>
	      			</td>
	      			<?php 
	      		break;	          	
	      	}?>
			<td>
				<?php 
				echo $this->Form->input('Eventosimpuesto.'.$i.'.fchvto', array(
								                      'class'=>'datepicker', 
								                      'type'=>'text',
								                      'label'=>false,
								                      'readonly'=>'readonly',
								                      'value'=>$eventosimpuesto['Eventosimpuesto']['fchvto']));	       
				?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.montovto',array('value'=>$eventosimpuesto['Eventosimpuesto']['montovto'],'label'=>false)); ?></td>
			<td><?php 
				echo $this->Form->input('Eventosimpuesto.'.$i.'.fchrealizado', array(
								                      'class'=>'datepicker', 
								                      'type'=>'text',
								                      'label'=>false,
								                      'readonly'=>'readonly',
								                      'value'=>$eventosimpuesto['Eventosimpuesto']['fchrealizado']));
                ?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.montorealizado',array('value'=>$eventosimpuesto['Eventosimpuesto']['montorealizado'],'label'=>false)); ?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.monc',array('value'=>$eventosimpuesto['Eventosimpuesto']['monc'],'label'=>false)); ?></td>		
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.descripcion',array('value'=>$eventosimpuesto['Eventosimpuesto']['descripcion'],'label'=>false)); ?></td>					
		</tr>
		<tr>
			<td>
				<?php echo  $this->Form->submit('Aceptar');?>
			</td>
		</tr>
<?php endforeach; ?>
	</table>
	<a href="#"  onclick="agregarAPagar()" class="btn_aceptar">  Agregar </a>
  <fieldset style="display:none"><?php echo  $this->Form->submit('Aceptare');?> </fieldset>

