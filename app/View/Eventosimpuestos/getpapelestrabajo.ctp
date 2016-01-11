 	
		<div id="form_prepararPapeles" class="prepararPapeles form"  style="float: left;">
	        <h3><?php echo __('Agregar Papeles de Trabajo'); ?></h3>
	        <?php         
	       		echo $this->Form->create('Eventosimpuesto'); 
	       		if($tipopago=='unico'){
	       			echo $this->Form->input('eventoId',array('value'=>$eventoid,'type'=>'hidden'));
	       		}else{
	       			echo $this->Form->input('eventoId',array('value'=>0,'type'=>'hidden'));
	       		}
	          	echo $this->Form->input('id',array('type'=>'hidden'));
	          	echo $this->Form->input('clienteid',array('value'=>$clienteid,'type'=>'hidden'));?>
	          	<table cellpadding="0" cellspacing="0" style="width: 110%;">
	          	<?php
	          	switch ($tipopago) {
	          		case 'provincia':
		          		 ?><tr><td><?php echo $this->Form->input('partido_id', array('style'=>'width:80px')); ?></td><?php
		          		break;
		          	case 'municipio':
		          		?><td><?php echo $this->Form->input('localidade_id', array('style'=>'width:80px') ); ?></td><?php
		          		break;
	          		case 'item':
	          			?><td><?php echo $this->Form->input('item', array('style'=>'width:80px')); ?></td><?php
	          		break;	          	
	          	}
          		 echo $this->Form->input('impcliid',array('value'=>$impcliid,'type'=>'hidden')); ?>
	           	<td><?php echo $this->Form->input('fchvto', array(
								                      'class'=>'datepicker', 
								                      'type'=>'text',
								                      'label'=>'Fch. Vto.',
								                      'readonly','readonly',
								                      'style'=>'width:80px')); ?></td>           	
	          	<td><?php echo $this->Form->input('montovto',array('label'=>'Monto a Pagar','default'=>"0", 'style'=>'width:113px')); ?></td>	
	          	<td><?php echo $this->Form->input('monc',array('label'=>'Monto a Favor','default'=>"0",'style'=>'width:113px')); ?></td>
	          	<td colspan ="2"><?php echo $this->Form->input('descripcion',array('default'=>"-", 'style'=>'width:100px'));        
	        ?></td></tr>
	      	<tr>
	      		<td colspan="2"></td>
	      		<td><a href="#" onclick="agregarPapeldeTrabajo()" class="btn_aceptar" style="margin-top:14px">Agregar</a></td>
	      		<td ><a href="#close"  onclick="" class="btn_cancelar" style="margin-top:14px">Cancelar</a></td>
	      	</tr>
	      <!--<fieldset style="display:none"><?php echo  $this->Form->submit('Aceptare');?> </fieldset>-->
	    </div>
	    <?php //echo print_r($eventosimpuestos) ;?>
	<?php if($tipopago!='unico'){?>
	
	<table cellpadding="0" cellspacing="0" id="tablePapelesPreparados" class="tbl_papeles" style="width: 110%;">
		<tr>
			<td colspan="4s"><h3><?php echo __('Papeles preparados'); ?></h3></td>
		</tr>
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
				<th>Vencimiento</th>
				<th>A Pagar</th>
				<th>Pagado en</th>
				<th>A Favor</th>
				<th>Pagado</th>
				<th>Descripcion</th>

				<th class="actions"><?php echo __('Acciones'); ?></td>
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
			<td><?php echo date('d-m-Y', strtotime(h($eventosimpuesto['Eventosimpuesto']['fchvto']))); ?>&nbsp;</td>
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