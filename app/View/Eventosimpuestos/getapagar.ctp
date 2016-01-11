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
	
	<h3><?php echo __('Papeles preparados'); ?></h3>
	<?php echo $this->Form->create('Eventosimpuesto'); ?>
	<table cellpadding="0" cellspacing="0" id="tablePapelesPreparados" class="tbl_getpagar">
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
				<th>Fch. Vto.</th>
				<th>Monto</th>
				<th>Fch. Realizado</th>
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

	          			<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.partido_id',array('value'=>$eventosimpuesto['partido_id'],'label'=>false, 'style' => 'width:80px')); ?>
          			</td>
	          		<?php 
	          		break;
	          	case 'municipio':
	          		?>
	          		<td>
	          			<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.localidade_id',array('value'=>$eventosimpuesto['localidade_id'],'label'=>false, 'style' => 'width:80px')); ?>
          			</td>
          			<?php 
	          		break;
	      		case 'item':
	      			?>
	      			<td>
	      				<?php echo $this->Form->input('Eventosimpuesto.'.$i.'.item',array('value'=>$eventosimpuesto['Eventosimpuesto']['item'],'label'=>false, 'style' => 'width:80px')); ?>
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
								                      'style' => 'width:72px',
								                      'readonly'=>'readonly',
								                      'value'=>$eventosimpuesto['Eventosimpuesto']['fchvto']));	       
				?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.montovto',array('value'=>$eventosimpuesto['Eventosimpuesto']['montovto'],'label'=>false, 'style' => 'width:70px')); ?></td>
			<td><?php 
				echo $this->Form->input('Eventosimpuesto.'.$i.'.fchrealizado', array(
								                      'class'=>'datepicker', 
								                      'type'=>'text',
								                      'label'=>false,
								                      'style' => 'width:72px',
								                      'readonly'=>'readonly',
								                      'value'=>$eventosimpuesto['Eventosimpuesto']['fchrealizado']));
                ?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.montorealizado',array('value'=>$eventosimpuesto['Eventosimpuesto']['montorealizado'],'label'=>false, 'style' => 'width:70px')); ?></td>
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.monc',array('value'=>$eventosimpuesto['Eventosimpuesto']['monc'],'label'=>false, 'style' => 'width:70px')); ?></td>		
			<td><?php echo $this->Form->input('Eventosimpuesto.'.$i.'.descripcion',array('value'=>$eventosimpuesto['Eventosimpuesto']['descripcion'],'label'=>false, 'style' => 'width:100px')); ?></td>					
		</tr>
		<!--<tr>
			<td>
				<?php echo  $this->Form->submit('Aceptar');?>
			</td>
		</tr>-->
<?php endforeach; ?>
	<tr>
	<td colspan="4"></td>
	<td><a href="#"  onclick="agregarAPagar()" class="btn_aceptar">  Agregar </a></td>
	<td><a href="#close"  onclick="" class="btn_cancelar" style="margin-top:24px">Cancelar</a></td>
	</tr>
	</table>
  <fieldset style="display:none"><?php echo  $this->Form->submit('Aceptare');?> </fieldset>

