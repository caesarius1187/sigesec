<?php
if(isset($respuesta)){
	echo $domicilio_id;

}else{?>
	<tr>
		
		<td>
			<?php echo h($domicilio['Domicilio']['calle']); ?>			
		</td>
		
		<td>
			<?php echo h($domicilio['Localidade']['Partido']['nombre']); ?>
			
		</td>
		<td>
			<?php echo h($domicilio['Localidade']['nombre']); ?>
			
		</td>
		
		<td class="">
            <a href="#" onclick="loadFormDomicilio(<?php echo $domicilio['Domicilio']['id']; ?>,<?php echo $domicilio['Cliente']['id']; ?>)" class="button_view"> 
             <img src="/sigesec/img/edit_view.png" alt="open" class="imgedit">                            </a> 
        </td>
	</tr>
<?php } ?>