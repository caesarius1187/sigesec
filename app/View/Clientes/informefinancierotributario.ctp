<?php echo $this->Html->script('jquery-ui',array('inline'=>false));?>
<?php echo $this->Html->script('clientes/informefinancierotributario',array('inline'=>false));?>
<div id="Formhead" class="clientes informefinancierotributario index" style="margin-bottom:10px;">

	<!--<input class="button" type="button" id="btnHiddeForm" onClick="hideForm()" value="Ocultar" style="float:right;"/>-->
	<?php echo $this->Form->create('clientes',array('action' => 'informefinancierotributario')); ?> 
		
        <table class="tbl_informefinancierotributario tblInforme">        
        <tr>
        	
            <td>
              <?php
                echo $this->Form->input('gclis', array(
                    'type' => 'select',
                    'label' => 'Grupos de clientes' 
                ));?>
                
            </td>
           
        	<td>                      
            <?php
            echo $this->Form->input('periodomes', array(
                    'options' => array(
                        '01'=>'Enero', 
                        '02'=>'Febrero', 
                        '03'=>'Marzo', 
                        '04'=>'Abril', 
                        '05'=>'Mayo', 
                        '06'=>'Junio', 
                        '07'=>'Julio', 
                        '08'=>'Agosto', 
                        '09'=>'Septiembre', 
                        '10'=>'Octubre', 
                        '11'=>'Noviembre', 
                        '12'=>'Diciembre', 
                        ),
                    'empty' => 'Elegir mes',
                    'label'=> 'Mes',
                    'required' => true, 
                    'placeholder' => 'Por favor seleccione Mes'
                ));
  	        ?>
            </td>
            <td>
             <?php echo $this->Form->input('periodoanio', array(
                                                    'options' => array(
                                                        '2012'=>'2012', 
                                                        '2013'=>'2013', 
                                                        '2014'=>'2014', 
                                                        '2015'=>'2015',     
                                                        ),
                                                    'empty' => 'Elegir año',
                                                    'label'=> 'Año',
                                                    'required' => true, 
                                                    'placeholder' => 'Por favor seleccione año'
                                                    )
                                        );?>
          </td>
              <?php echo $this->Form->input('selectby',array('default'=>'none','type'=>'hidden'));//?>

                <td rowspan="1"><?php echo $this->Form->end(__('Aceptar')); ?></td>
                <?php if(isset($mostrarInforme)){?>
                 <td rowspan="1">
                    <?php echo $this->Form->button('Imprimir', 
                                            array('type' => 'button',
                                                'class' =>"btn_add2",
                                                'onClick' => "imprimir()"
                                                )
                        );?> 
                    </td>
                <?php }?>
            
         </tr>
         </table>
</div> <!--End Clietenes_avance-->

<?php if(isset($mostrarInforme)){
    //Calculos de Montos Actuales
    $ingresosTotal=0;
    $egresosTotal=0;
    $totalPlanificado=0;
    $honorariosTotal=0;
    foreach ($grupoclientesActual as $gcliActual ) {
        $deudasActuales = 0;
        $recibosActuales = 0;
        $honorariosActuales = 0;
        $ingresosActuales = 0;
        $egresosActuales = 0;
        foreach ($gcliActual['Cliente'] as $cliente) {
            //calculo de Deuda
            foreach ($cliente['Impcli'] as $impcli) {
                foreach ($impcli['Eventosimpuesto'] as $eventoimpuesto) {
                   $deudasActuales+=$eventoimpuesto['montovto'];
                }
            }
            //calculo de Depositos
            foreach ($cliente['Deposito'] as $deposito) {
                 $recibosActuales+=$deposito['monto'];
            }
            //Calculo de Honorarios
            foreach ($cliente['Honorario'] as $honorario) {
                $honorariosActuales+=$honorario['monto'];
            }
            //Calculo de Ingresos
            foreach ($cliente['Ingreso'] as $ingreso) {
                if($ingreso['tipo']=="ingreso"){
                    $ingresosActuales+=$ingreso['importe'];
                }else{
                    $egresosActuales+=$ingreso['importe'];
                }
                
            }
        }                        
    }
    $ingresosTotal=$ingresosActuales;
    $egresosTotal=$egresosActuales;
    $honorariosTotal=$honorariosActuales;
     $totalActual=$recibosActuales*1-$deudasActuales*1-$honorariosActuales*1;
      $totalPlanificado=$deudasActuales;
    //Calculos de Montos Historicos
      $deudasHistoricos = 0;
        $recibosHistoricos = 0;
        $honorariosHistoricos = 0;
        $ingresosHistoricos = 0;
        $egresosHistoricos = 0;
    foreach ($grupoclientesHistorial as $gcliHistoricos ) {
     
        foreach ($gcliHistoricos['Cliente'] as $clienteh) {
            //calculo de Deuda
            foreach ($clienteh['Impcli'] as $impclih) {
                foreach ($impclih['Eventosimpuesto'] as $eventoimpuestoh) {
                   $deudasHistoricos+=$eventoimpuestoh['montovto'];
                }
            }
            //calculo de Depositos
            foreach ($clienteh['Deposito'] as $depositoh) {
                 $recibosHistoricos+=$depositoh['monto'];
            }
            //Calculo de Honorarios
            foreach ($clienteh['Honorario'] as $honorarioh) {
                $honorariosHistoricos+=$honorarioh['monto'];
            }       
             //Calculo de Ingresos
            foreach ($cliente['Ingreso'] as $ingresoh) {
                if($ingresoh['tipo']=="ingreso"){
                    $ingresosHistoricos+=$ingreso['importe'];
                }else{
                    $egresosHistoricos+=$ingreso['importe'];
                }
                
            }     
        }        
    }
    $totalAnterior=$recibosHistoricos*1-$deudasHistoricos*1-$honorariosHistoricos*1;

    $totalGral = $totalActual+ $totalAnterior
    ?>
<div class="index">
<table id="situacionIntegral" class="tblInforme tblTributarioFinanciero">
    <tr id="titulo" >
        <td >
            <label style='font-size:24px;font-family:"Times New Roman", Times, serif;font-weight:bold;text-align:center;'>Informe Tributario Financiero</label>
            
        </td>
    </tr><!-- fin titulo-->
    <tr id="periodo" style='font-family:"Times New Roman", Times, serif;font-size:20px;text-align:left;'>
            <td>
                <table width="100%" align="center" cellspacing="0" cellpadding="2"  >
                    <tr>                    
                        <th width="150" style='font-family:"Times New Roman", Times, serif;font-size:20px;text-align:left;background:#FF0000background:#0C0' >
                            Grupo: 
                        </th>
                        <td width="271">
                            <?php echo $grupoclientesActual[0]['Grupocliente']["nombre"];?>
                        </td>                    
                        <th colspan="2" style='font-family:"Times New Roman", Times, serif;font-size:20px;text-align:left;'>
                            Periodo: <?php echo $periodomes."-".$periodoanio;?> 
                        </th>
                    </tr> 
                    <tr>
                        <td align="center" colspan="4">
                            <hr width="450px" color="#000000" style='width:100%' />
                        </td>
                    </tr>
                    <tr><td></td>
                        <td title="Acumulado de Recibos del Periodo">Recibos</td>
                        <td title="Acumulado de Recibos del Periodo" 
                            <?php if($recibosActuales>=0){echo "style='color:#0C0'";} 
                                    else{echo "style='color:#FF0000'";}
                            ?>
                            >
                            <?php echo "$".number_format($recibosActuales, 2, ",", ".");?>
                        </td>
                     </tr>
                     <tr><td></td>
                        <td title="Acumulado de Impuestos del Periodo">Impuestos</td>
                        <td title="Acumulado de Recibos del Periodo" style='color:#FF0000'>
                            <?php echo "$".number_format($deudasActuales, 2, ",", "."); ?>
                        </td>
                     </tr>
                     <tr><td></td>
                        <td title="Acumulado de Honorarios del Periodo">Honorarios</td>
                        <td title="Acumulado de Honorarios del Periodo" style='color:#FF0000'>
                            <?php echo "$".number_format($honorariosActuales, 2, ",", "."); //echo $qhonoact;?>
                        </td>
                     </tr>                     
                     <tr><td></td>
                        <td title="Acumulado de Recibos-Impuestos-Honorarios del los Periodos Anteriores" >Periodo Ant.</td>
                        <td title="Acumulado de Recibos-Impuestos-Honorarios del los Periodos Anteriores" 
                            <?php if($totalAnterior>=0){
                                echo "style='color:#0C0'";} 
                            else{
                                echo "style='color:#FF0000'";}
                                ?>   >
                            <?php echo "$".number_format($totalAnterior, 2, ",", ".");?>
                        </td>
                     </tr>
                     <tr><td></td>
                        <td title="Total a Pagar en el Periodo">
                            <?php if($totalGral>0){echo 'A Favor';} 
                            else{echo 'A Pagar';}?>
                        </td>
                        <td title="Total a Pagar en el Periodo" 
                            <?php if($totalGral>=0){
                                echo " style='color:#0C0'>$".number_format($totalGral, 2, ",", ".");}
                         else{
                                echo " style='color:#FF0000'>$".number_format($totalGral*-1, 2, ",", ".");}
                                ?>   
                                                                 
                        </td>                       
                     </tr>
                                                                                                              
                </table> 
            </td>
    </tr><!-- fin periodo -->

    
    <tr>
        <td id="tdTotGral">
            <table>
                <thead></thead>
                <tbody>
                    <tr>
                        <td>
                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                Totales Generales del Grupo: 
                            </label>
                        </td>
                        <td>
                            <?php /*Busqueda de las direcciones del Grupo*/ 
                            if(count($grupoclientesActual)!=0){
                                ?>                                                                                
                                <select id="direUsu" >
                                    <?php 
                                    foreach ($grupoclientesActual as $gcliActual ) {
                                        foreach ($gcliActual['Cliente'] as $cliente) {
                                            foreach ($cliente['Domicilio'] as $domicilio) { ?>
                                                 <option value="<?php echo $domicilio["calle"]."-".$domicilio["numero"]?>" >
                                                    <?php echo $cliente["nombre"]."-".$domicilio["calle"]."-".$domicilio["numero"]?>
                                                </option>
                                        <?php }
                                        }
                                    }?>                                
                                </select>   
                            <?php
                            }else{?>
                                    <input name="direUsu" type="text" value="" id="direUsu" />
                            <?php } ?>  
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <table style='padding:0px 0px 0px;width: 100%;' cellspacing="0">
                                <thead> </thead>
                                <tbody>
                                    <tr>
                                        <th style='border:1px solid #333;text-align:left;' width="115">
                                            Ingresos
                                        </th> 
                                        <td style='border:thin solid #333 ;text-align:right;' width="115">
                                            <?php echo "$".number_format($ingresosTotal, 2, ",", ".")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style='border:1px solid #333;text-align:left;' width="115">
                                            Egresos
                                        </th>
                                        <td style='border:thin solid #333 ;text-align:right;' width="115">
                                            <?php echo "$".number_format($egresosTotal, 2, ",", ".")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style='border:1px solid #333;text-align:left;' width="115">
                                            Impuestos
                                        </th>
                                        <td style='border:thin solid #333 ;text-align:right;' width="95"> 
                                            <?php $totalPlanificado; echo "$".number_format($totalPlanificado, 2, ",", ".")?>
                                        </td>    
                                    </tr>
                                    <tr>
                                        <th style='border:1px solid #333;text-align:left;' width="115">
                                            Saldo
                                        </th>    
                                        <td style='border:thin solid #333 ;text-align:right;' width="115">
                                            <?php $saldoTotal=$ingresosTotal-$egresosTotal-$totalPlanificado; 
                                            echo "$".number_format($saldoTotal, 2, ",", ".");?>
                                        </td>
                                    </tr>               
                                </tbody>
                             </table><!--fin tabla ingresos y egresos -->
                             <table style='padding:0px 0px 0px; ' cellspacing="0">
                                <thead>
                                    <tr>
                                                                               
                                    </tr>    
                                </thead>
                                <tbody>                                                
                                    <tr>
                                        <th style='border:1px solid #333;text-align:left;' width="115">Honorarios</th>   
                                        <td style='border:thin solid #333 ;text-align:right;' width="115"><?php echo "$".number_format($honorariosTotal, 2, ",", ".")?></td>
                                    </tr>   
                                </tbody>
                            </table>
                        </td>
                        <td>
                            <table cellspacing="0" style='padding:0px 0px 0px;'>
                                <thead>
                                    <tr>    
                                        <th style='border:1px solid #333;text-align:left;' width="115">Vencimientos</td>
                                        <th style='border:1px solid #333;text-align:left;' width="115">A Pagar</th>
                                        <th style='border:1px solid #333;text-align:left;' width="115">Pagado</th>
                                        <th style='border:1px solid #333;text-align:left;' width="115">Saldo</th>
                                    </tr>  
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style='border:1px solid #333;text-align:left;text-align:left'><label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>hasta d&iacute;a 2</label></td>
                                        <?php
                                         
                                        $planificadoAl2=0;
                                        $pagadoAl2=0;

                                        $planificadoAl7=0;
                                        $pagadoAl7=0;

                                        $planificadoAl12=0;
                                        $pagadoAl12=0;

                                        $planificadoAl18=0;
                                        $pagadoAl18=0;
                                        foreach ($grupoclientesActual as $gcliActual ) {
                                            foreach ($gcliActual['Cliente'] as $cliente) {
                                                foreach ($cliente['Impcli'] as $impcli) { 
                                                    foreach ($impcli['Eventosimpuesto'] as $eventosimpuesto) { 
                                                        if(date("d",strtotime($eventosimpuesto['fchvto']))<07){
                                                            //menor que 07
                                                            $planificadoAl2=$eventosimpuesto['montovto'];
                                                            $pagadoAl2=$eventosimpuesto['montorealizado'];
                                                        }else if(date("d",strtotime($eventosimpuesto['fchvto']))<12){
                                                            //menor que 12 y mayor que 07
                                                            $planificadoAl7=$eventosimpuesto['montovto'];
                                                            $pagadoAl7=$eventosimpuesto['montorealizado'];
                                                            } else if(date("d",strtotime($eventosimpuesto['fchvto']))<18){
                                                                //menor que 18 y mayor que 12
                                                                $planificadoAl12=$eventosimpuesto['montovto'];
                                                                 $pagadoAl12=$eventosimpuesto['montorealizado'];
                                                                }else {
                                                                    //mayor que 18
                                                                    $planificadoAl18=$eventosimpuesto['montovto'];
                                                                    $pagadoAl18=$eventosimpuesto['montorealizado'];
                                                                }
                                                    
                                                    }
                                                       
                                                } 
                                            }
                                        }?>                                                                                        
                                        <td style='border:thin solid #333 ;text-align:right;'>
                                            <?php echo "$".number_format($planificadoAl2, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php echo "$".number_format($pagadoAl2, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php 
                                            $diferencia2 = $planificadoAl2 - $pagadoAl2;
                                            echo "$".number_format($diferencia2, 2, ",", ".")?>
                                        </td>                                                                  
                                    </tr>
                                    <tr>
                                        <td style='border:1px solid #333;text-align:left;text-align:left'>
                                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                                hasta d&iacute;a 7
                                            </label>
                                        </td>
                                                                                                                                  
                                        <td style='border:thin solid #333 ;text-align:right;'>
                                            <?php echo "$".number_format($planificadoAl7, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php echo "$".number_format($pagadoAl7, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php $diferencia7 = $planificadoAl7 - $pagadoAl7;
                                            echo "$".number_format($diferencia7, 2, ",", ".")?>
                                        </td>                                                                  
                                    </tr>
                                    <tr>
                                        <td style='border:1px solid #333;text-align:left;text-align:left'>
                                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                                hasta d&iacute;a 12
                                            </label>
                                        </td>
                                                                                                        
                                        <td style='border:thin solid #333 ;text-align:right;'>
                                            <?php echo "$".number_format($planificadoAl12, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php echo "$".number_format($pagadoAl12, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php $diferencia12 = $planificadoAl12 - $pagadoAl12;
                                            echo "$".number_format($diferencia12, 2, ",", ".")?>
                                        </td>                                                                  
                                    </tr>
                                    <tr>
                                        <td style='border:1px solid #333;text-align:left;text-align:left'>
                                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                                hasta d&iacute;a 18
                                            </label>
                                        </td>
                                                                                                         
                                        <td style='border:thin solid #333 ;text-align:right;'>
                                            <?php echo "$".number_format($planificadoAl18, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php echo "$".number_format($pagadoAl18, 2, ",", ".")?>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'> 
                                            <?php $diferencia18 = $planificadoAl18 - $pagadoAl18;
                                            echo "$".number_format($diferencia18, 2, ",", ".")?>
                                        </td>                                                                  
                                    </tr>
                                    <tr>
                                        <td style='border:1px solid #333;text-align:left;'>
                                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                                Totales
                                            </label>
                                        </td>
                                        <td style='border:thin solid #333 ;text-align:right;'><?php echo  "$".number_format($planificadoAl2+$planificadoAl7+$planificadoAl12+$planificadoAl18, 2, ",", ".");?></td>
                                        <td style='border:thin solid #333 ;text-align:right;'><?php echo  "$".number_format($pagadoAl2+$pagadoAl7+$pagadoAl12+$pagadoAl18, 2, ",", ".");?></td>
                                        <td style='border:thin solid #333 ;text-align:right;'><?php echo  "$".number_format($diferencia2+$diferencia7+$diferencia12+$diferencia18, 2, ",", ".");?></td>
                                    </tr>
                                </tbody>                
                            </table> 
                        </td>
                    </tr>
                </tbody>
            </table>    
        </td>
    </tr>

   <?php  
   foreach ($grupoclientesActual as $gcliActual ) {       
        foreach ($gcliActual['Cliente'] as $cliente) { ?>

    <!-- Inicio Tabla Cliente -->
    <tr class="cliente"  >          
        <td>
            <table width="782">
                <tr>
                    <th width="70" style='font-family:"Times New Roman", Times, serif;font-size:12px;text-align:left;'>
                        <label style='font-family:"Times New Roman", Times, serif;font-size:20px;' >
                            Cliente:
                        </label>
                    </th> 
                    <td width="272">
                        <label style='font-family:"Times New Roman", Times, serif;font-size:18px;' >
                            <?php echo $cliente["nombre"];?>
                        </label>
                    </td>
                    <th style='font-family:"Times New Roman", Times, serif;font-size:12px;text-align:left;' width="77">
                        <label style='font-family:"Times New Roman", Times, serif;font-size:20px;' >
                            Cuit :
                        </label> 
                    </th>
                    <td width="343">
                        <label style='font-family:"Times New Roman", Times, serif;font-size:20px;' >
                            <?php echo $cliente["cuitcontribullente"];?>
                        </label>
                    </td>
                </tr>
                
          </table><!--fin tabla cliente -->
        </td>
    </tr><!-- fin cliente -->
    <tr class="Ingresos">
        <td colspan="0">
            <table style='padding:0px 0px;' cellspacing="0"   >
                <tr>
                    <td valign="top">                                        
                        <table style='padding:0px 0px;' cellspacing="0"   >
                            <thead>                      
                                <tr>               
                                    <th style='border:1px solid #333;text-align:left;' width="125px">
                                        <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                            Ingresos
                                        </label>
                                    </th>
                                    <th style='border:1px solid #333;text-align:left;' width="95px">
                                        Importe
                                    </th>                     
                                </tr>
                            </thead>
                            <tbody> 
                                <?php
                                $totalIngresoCliente=0;
                                foreach ($cliente['Ingreso'] as $ingreso) {   
                                    if($ingreso['tipo']=='ingreso'){?>
                                         <tr  >                          
                                            <td style='border:thin solid #333 ;text-align:left;' align="left"> 
                                               <?php echo $ingreso["motivo"];?>
                                            </td>
                                            <td style='border:thin solid #333 ;text-align:right;'> 
                                               <?php echo "$".number_format($ingreso["importe"], 2, ",", ".");
                                               $totalIngresoCliente+=$ingreso["importe"];?>
                                            </td>    
                                            <td></td>                                              
                                        </tr>   
                                  <?php  }
                                   }
                                ?>                                               
                                                               
                                <tr >
                                    <th style='border:thin solid #333 ;background:#CCCCCC;' align='left'>
                                        Total 
                                    </th>
                                    <td style='border:thin solid #333 ;background:#CCCCCC;' align='right'>
                                        <?php echo "$".number_format($totalIngresoCliente, 2, ",", ".");?>
                                    </td>   
                                    <td></td>               
                                </tr>
                            </tbody>
                         </table>                 
                    </td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>    
    </tr>
    <!--fin tabla ingresos -->
    <!--Inicio Egresos -->
    <tr class="Egresos">
        <td colspan="0">
            <table>
                <tr>
                    <td valign="top">
                        <table style='padding:0px 0px;' cellspacing="0" >
                            <thead>  
                                <tr>
                                    <th style='border:1px solid #333;text-align:left;' width="125px">
                                        <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                            Egresos
                                        </label>
                                    </th>
                                    <th style='border:1px solid #333;text-align:left;' width="95px">
                                        Importe
                                    </th>
                                    <td></td>
                                </tr>
                            </thead>    
                            <tbody> 
                                <?php
                                $totalEgresoCliente=0;
                                foreach ($cliente['Ingreso'] as $ingreso) {   
                                    if($ingreso['tipo']=='egreso'){?>
                                         <tr  >                          
                                            <td style='border:thin solid #333 ;text-align:left;' align="left"> 
                                               <?php echo $ingreso["motivo"];?>
                                            </td>
                                            <td style='border:thin solid #333 ;text-align:right;'> 
                                               <?php echo "$".number_format($ingreso["importe"], 2, ",", ".");
                                                $totalEgresoCliente+=$ingreso["importe"];?>
                                            </td>    
                                            <td></td>                                              
                                        </tr>   
                                  <?php  }
                                   }
                                ?>                                               
                                                               
                                <tr >
                                    <th style='border:thin solid #333 ;background:#CCCCCC;' align='left'>
                                        Total 
                                    </th>
                                    <td style='border:thin solid #333 ;background:#CCCCCC;' align='right'>
                                        <?php echo "$".number_format($totalEgresoCliente, 2, ",", ".");?>
                                    </td>   
                                    <td></td>               
                                </tr>
                            </tbody>
                        </table>
                       <!--fin tabla egresos -->
                    </td>
                    <td>&nbsp;</td>                        
                </tr>
            </table>       
        </td>
    </tr>       
    <!--fin Egresos -->

    <!--INFORME RESUMEN TRIBUTARIO-->              
    <tr class="resultado" >
        <td> 
            <table style='padding:0px 0px;' cellspacing="0"  >
                <thead>
                    <tr>
                        <th style='border:1px solid #333;text-align:left;' width="125px">
                            <label style='font-family:"Times New Roman", Times, serif;font-size:20px;'>
                                Tributario
                            </label>
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="125px">
                            Datos Ad.
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="95px">
                            Formulario
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="95px">
                            A Favor
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="95px">
                            A Pagar
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="95px">
                            Pagado
                        </th>
                        <th style='border:1px solid #333;text-align:left;' width="40px">
                            Vto.
                        </th>                        
                        <th style='border:1px solid #333;text-align:left;' width="60px">
                            Lugar
                        </th>
                        <th style='border:1px solid #333;text-align:left;arch' width="30px">
                            Arch
                        </th>
                    
                    </tr>
                </thead>
                <tbody> 
                    <?php 
                    $tpag=0;
                    $tpla=0;
                    $tcon=0;
                    foreach ($cliente['Impcli'] as $impcli) {
                        foreach ($impcli['Eventosimpuesto'] as $eventoimpuesto) {  ?>
                         <tr  >
                            <td style='border:thin solid #333 ;text-align:left;' align="left"> 
                                <?php echo utf8_decode($impcli['Impuesto']["nombre"]);?>
                            </td>
                            <td style='border:thin solid #333 ;text-align:left;' align="left"> 
                                <?php echo utf8_decode($eventoimpuesto["descripcion"])?>
                            </td>
                            <td style='border:thin solid #333 ;text-align:left;' align="left"> 
                                <?php echo utf8_decode($impcli["descripcion"])?>
                            </td>
                            <td style='border:thin solid #333 ;text-align:right;'> 
                                <?php echo "$".number_format($eventoimpuesto["monc"], 2, ",", ".");
                                $tcon+=$eventoimpuesto["monc"];
                                ?>
                            </td>
                            <td style='border:thin solid #333 ;text-align:right;'> 
                                <?php echo "$".number_format($eventoimpuesto["montovto"], 2, ",", ".");
                                $tpla+=$eventoimpuesto["montovto"];
                                ?>
                            </td>
                            <td style='border:thin solid #333 ;text-align:right;'> 
                                <?php echo "$".number_format($eventoimpuesto["montorealizado"], 2, ",", ".");
                                $tpag+=$eventoimpuesto["montorealizado"];
                                ?>
                            </td> 
                            <td style='border:thin solid #333 ;text-align:right; padding-left:4px'> 
                                <?php echo date("d/m",strtotime($eventoimpuesto["fchvto"]));?>
                            </td>                            
                            <td style='border:thin solid #333 ;text-align:left;'> 
                                <?php echo $impcli['Impuesto']["lugarpago"];?>
                            </td>  
                            <td style='border:thin solid #333 ;text-align:left;'>
                                file.link                            
                            </td> 
                        </tr>

                        <?php }
                    }   ?>                   
                    <tr>
                        
                        <th ></th>
                        <th ></th>
                        <th ></th>
                        <th style='border:thin solid #333 ;background:#CCCCCC;' align='left'>
                            Total 
                        </th>
                        <td style='border:thin solid #333 ;background:#CCCCCC;' align='right'>
                            $<?php echo number_format($tpla, 2, ",", ".");?>
                        </td>                               
                        <td style='border:thin solid #333 ;background:#CCCCCC;' align='right'>
                            $<?php echo number_format($tpag, 2, ",", ".");?>
                        </td>                        
                    </tr>
                    <tr>
                        <th style='font-family:"."'"."Times New Roman"."'".", Times, serif;font-size:20px; text-align:left' colspan='1' >
                            <label >
                                Mov. Neto: 
                            </label>
                        </th>
                        <th style='text-align:right' 
                            title='Ingreso: $<?php echo number_format($totalIngresoCliente, 2, ",", ".");?>,Egreso: $<?php echo number_format($totalEgresoCliente, 2, ",", ".");?>,Planificado: $<?php echo number_format($tpla, 2, ",", ".");?>'
                        >

                            $<?php
                            //$de = ingreso - egreso - impuestos 
                            $de = $totalIngresoCliente - $totalEgresoCliente - $tpla;
                            echo number_format($de, 2, ",", ".")?>
                        </th>
                        <th ></th>
                        <th ></th>
                        <th style='border:thin solid #333 ;background:#CCCCCC;' align='left'>
                            Saldo 
                        </th>
                        <td style='border:thin solid #333 ;background:#CCCCCC;' align='right'>
                            $<?php 
                            $saldo= $tpla - $tpag;
                            echo number_format($saldo, 2, ",", ".");
                            ?>
                        </td>
                    </tr>                    
                </tbody>
           </table>
                 
        </td>
    </tr>
    <!-- fin Resumen Tributario -->
    <tr>
        <td align="center">
            <hr width="450px" color="#000000" style='width:100%' />
        </td>
    </tr>     

        <?php }
    } ?>       
    
    <tr><td>&nbsp</td> </tr>
    <tr>
        <th class='sith' align="left"></br></br>Comentarios:</br>
        <textarea cols="60" rows="8" ></textarea></th>
    </tr>
</table><!--fin tabla situacion integral -->   
</div>
<?php } ?>