<div class="honorarios form">
<?php echo $this->Form->create('Honorario'); ?>
	<fieldset>
		<legend><?php echo __('Add Honorario'); ?></legend>
	<?php
		echo $this->Form->input('cliente_id');
		echo $this->Form->input('monto');
		echo $this->Form->input('fecha');
		echo $this->Form->input('descripcion');
		echo $this->Form->input('periodo');
		echo $this->Form->input('estado');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Honorarios'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cliente'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
	</ul>
</div>
