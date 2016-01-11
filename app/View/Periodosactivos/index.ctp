<div class="periodosactivos form">
	<h2><?php echo __('Periodos Activos'); ?></h2>
	<table cellpadding="0" cellspacing="0" margin="0">
	
	<?php foreach ($periodosactivos as $periodosactivo): 
	if ($periodosactivo['Periodosactivo']['hasta']==null){

	
	?>
	<tr>
		<td>
			<?php echo $this->Form->create('Periodosactivo',array('id'=>'formPeriodosActivosAdd','action'=>'add')); ?>			
			<table cellpadding="0" cellspacing="0">
			<tr>

				<?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$periodosactivo['Periodosactivo']['id'])) ?>
				<?php echo $this->Form->input('impcli_id',array('type'=>'hidden','value'=>$impcli['Impcli']['id'])) ?>
				<td>
					<?php 
		                 echo $this->Form->input('desde', array(
		                            'class'=>'datepicker-month-year', 
		                            'type'=>'text',
		                            'label'=>'Alta',         
		                            'required'=>true,         
		                            'value'=> $periodosactivo['Periodosactivo']['desde'],                 
		                            'readonly'=>'readonly')
		                 );
		             ?>
		        </td>
				<td>
					<?php 
		                 echo $this->Form->input('hasta', array(
		                            'class'=>'datepicker-month-year', 
		                            'type'=>'text',
		                            'label'=>'Baja',        
		                            'value'=> $periodosactivo['Periodosactivo']['hasta'],                                             
		                            'readonly'=>'readonly')
		                 );
		             ?>
		        </td>
				<td><?php echo $this->Form->end(__('Modificar')); ?></td>
			</tr>	
         	</table>
        </td>		
	</tr>	
	<?php
	}
	endforeach; ?>
	</table>	
</div>
<div class="periodosactivos index">
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Altas</th>
			<th>Bajas</th>
	</tr>
	<?php foreach ($periodosactivos as $periodosactivo): ?>
	<tr>
		<td><?php echo h($periodosactivo['Periodosactivo']['desde']); ?></td>
		<td><?php echo h($periodosactivo['Periodosactivo']['hasta']); ?></td>
		
	</tr>
<?php endforeach; ?>
	</table>	
</div>
