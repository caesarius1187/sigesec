<div class="periodosactivos form">
<?php echo $this->Form->create('Periodosactivo',array('id'=>'formPeriodosActivosAdd','action'=>'add')); ?>
	<legend><?php echo __('Agregar Periodo activo'); ?></legend>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th>Desde</th>
			<th>Hasta</th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
		</tr>
		<tr>
			<?php echo $this->Form->input('impcli_id',array('type'=>'hidden','value'=>$impcli['Impcli']['id'])) ?>
			<td>
				<?php 
	                 echo $this->Form->input('desde', array(
	                            'class'=>'datepicker-month-year', 
	                            'type'=>'text',
	                            'label'=>'Desde',                                    
	                            'readonly'=>'readonly')
	                 );
                 ?>
            </td>
			<td><?php 
	                 echo $this->Form->input('hasta', array(
	                            'class'=>'datepicker-month-year', 
	                            'type'=>'text',
	                            'label'=>'Hasta',                                    
	                            'readonly'=>'readonly')
	                 );
                 ?></td>
			<td><?php echo $this->Form->end(__('Agregar')); ?></td>
		</tr>
	</table>

<div class="periodosactivos index">
	<h2><?php echo __('Periodos Activos'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th>Desde</th>
			<th>Hasta</th>
			<th class="actions"><?php echo __('Acciones'); ?></th>
	</tr>
	<?php foreach ($periodosactivos as $periodosactivo): ?>
	<tr>
		<td><?php echo h($periodosactivo['Periodosactivo']['desde']); ?></td>
		<td><?php echo h($periodosactivo['Periodosactivo']['hasta']); ?></td>
		<td class="actions">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $periodosactivo['Periodosactivo']['id']), null, __('Estas seguro que quieres eliminar el periodo activo?', $periodosactivo['Periodosactivo']['id'],$impcli['Impcli']['cliente_id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>	
</div>

