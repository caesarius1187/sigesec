<?php
$miRespuesta = array();
if(isset($respuesta)){ 
     $miRespuesta['respuesta'] = $respuesta; 
	 $miRespuesta['algo'] = 1; 
}else{ 
    $class='add';
    if(!isset($impcliCreado)){ 
 	   $miRespuesta['accion']= 'agregar';
    }else{ 
       $miRespuesta['accion']= 'editar';
       $miRespuesta['impid']= $impcli['Impcli']['id'];
    }
    
    $miRespuesta['impclirow']= '
    <tr id="rowImpcli'.$impcli['Impcli']['id'].'">                                                
        <td>'.$impcli['Impuesto']['nombre'].'</td>
        <td>'.$Periodoalta.'</td>                                    
        <td>
            <a href="#"  onclick="loadFormImpuesto('.$impcli['Impcli']['id'].','.$impcli['Impcli']['cliente_id'].')" class="button_view"> 
             '.$this->Html->image('edit_view.png', array('alt' => 'open','class'=>'imgedit')).'
                </a>
            <a href="#"  onclick="loadFormImpuestoPeriodos('.$impcli['Impcli']['id'].')" class="button_view"> 
             '.$this->Html->image('calendario.png', array('alt' => 'open','class'=>'imgedit')).'
            </a>
        </td>
    </tr>';
} 
echo json_encode($miRespuesta);
?>