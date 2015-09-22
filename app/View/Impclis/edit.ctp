<?php
if(!$showTheForm){?>
    <td><?php echo $this->request->data['Impuesto']['nombre']; ?></td>
     <?php if( $this->request->data['Impuesto']['organismo']=='banco'||$this->request->data['Impuesto']['organismo']=='sindicato'){?>
    <td><?php $this->request->data['Impcli']['usuario']; ?></td>
    <td><?php $this->request->data['Impcli']['clave']; ?></td>
    <?php } ?>  
    <td><?php echo $this->request->data['Impcli']['descripcion']; ?></td>
    <td><?php echo $this->request->data['Impcli']['estado']; ?></td>
    <td >
       <a href="#"  onclick="loadFormImpuesto(<?php echo $this->request->data['Impcli']['id']; ?>,<?php echo $this->request->data['Impcli']['cliente_id'];?>)" class="button_view"> 
                                     <?php echo $this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit'));?>
                                    </a>
        <a href="#"  onclick="loadFormImpuestoPeriodos(<?php echo $this->request->data['Impcli']['id']; ?>)" class="button_view"> 
            <?php echo $this->Html->image('calendario.png', array('alt' => 'open','class'=>'imgedit'));?>
        </a>
    </td>
<?php 
}else{ ?>
<td colspan="7">
 <?php   echo $this->Form->create('Impcli',array('controller'=>'Impcli','action'=>'edit',"id"=>"ImpcliEditForm".$this->request->data['Impcli']['id']));?>
        <table>
	    <?php echo $this->Form->input('id');?>
		<tr>
              <?php echo $this->Form->input('cliente_id',array('type'=>'hidden'));?>
		      <td colspan="2"><?php echo $this->Form->input('impuesto_id');?></td>
                <?php if( $this->request->data['Impuesto']['organismo']=='banco'||$this->request->data['Impuesto']['organismo']=='sindicato'){?>
                <td><?php echo $this->Form->input('usuario'); ?></td>
                <td><?php echo $this->Form->input('clave'); ?></td>
                <?php } ?>
		      <td colspan="2"><?php echo $this->Form->input('descripcion', array('label' => 'Descripci&oacute;n'));?></td>		      
		      <td colspan="2"><?php echo $this->Form->input('estado', array('label' => 'Estado','type'=>'select','options'=>array('habilitado'=>'Habilitado','deshabilitado'=>'Deshabilitado')));?></td>
              <td><?php echo $this->Form->end(__('Modificar'));?></td>
        </tr>
        </table>
<?php }?>
