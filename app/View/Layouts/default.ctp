<?php
/**
 *
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 */

$cakeDescription = __d('sigesec.com.ar', 'SIGESEC');
?>
<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript">
		var serverLayoutURL = "";
		function callAlertPopint(message){
			location.hash ="#PopupMessage";
			$(lblMessagePP).html(message);
			setTimeout(function(){
			  location.hash ="#x";
			}, 3000); 
			
		}	
	</script>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta(
			    'icon',
			    '/img/cake.icon.png',
			    array('type' => 'icon')
			);
		echo $this->Html->script('jquery');
		echo $this->Html->script('jquery.dataTables');
		echo $this->Html->script('floatHead/dist/jquery.floatThead');
		echo $this->Html->script('menu');
		echo $this->Html->css('cake.generic');
		echo $this->Html->css('demo_table');
		echo $this->Html->css('md_buttons');
		echo $this->Html->css('popin');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<SCRIPT TYPE="text/javascript">
	$(document).ajaxStart(function () {
		$("#loading").css('visibility','visible')
	});
	$(document).ajaxComplete(function () {
		$("#loading").css('visibility','hidden')

	});
	$('#ui-datepicker-div').hide();
	</SCRIPT>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
			<?php if ($this->Session->read('Auth.User.username')) { ?>
			
			<p align="right">
			<?php echo 'Bienvenido '.$this->Session->read('Auth.User.username').'!'; ?>
			<?php echo $this->Html->link("Salir",array(
														'controller' => 'users', 
														'action' => 'logout', 
														)
										); 	?>
</p>
			<?php } ?>
			
			<div id='cssmenu'>
				<ul>				  
				   	<li class='active has-sub'><a href='#'><span>Parametros</span></a>
				      <ul>
					    <li class='has-sub'>
							<?php
								echo $this->Html->link("Usuarios",
																array(
																	'controller' => 'users', 
																	'action' => 'index', 
																	)
													); 	
							?>	
					    </li>				       
						<li class='has-sub'>
				         	<?php
								echo $this->Html->link("Tareas",
																array(
																	'controller' => 'tareasxclientesxestudios', 
																	'action' => 'index', 
																	)
													); 	
							?>		
				        </li>
				      </ul>
				   	</li>			   
				   	<li class='active has-sub'><a href='#'><span>Clientes</span></a>
				      <ul>
				        <li class='has-sub'>
			         		<?php
								echo $this->Html->link("Clientes",
																array(
																	'controller' => 'clientes', 
																	'action' => 'index', 
																	)
													); 	
							?>	
				         </li>
			         	<li class='has-sub'>		
				         	<?php
								echo $this->Html->link("Grupos",
																array(
																	'controller' => 'grupoclientes', 
																	'action' => 'index', 
																	)
													); 	
							?>	
						</li>	
				      </ul>
				   	</li>
					<li class='active has-sub'>
						<?php
								echo $this->Html->link("Informes",
																array(
																	'controller' => 'clientes', 
																	'action' => 'index', 
																	)
													); 	
							?>	
						<ul>							
							<li class='has-sub'>
								<?php
								echo $this->Html->link("Tributario Financiero",
																array(
																	'controller' => 'clientes', 
																	'action' => 'informefinancierotributario', 
																	)
													); 	
								?>
							</li>	 
							<li class='has-sub'>
								<?php
								echo $this->Html->link("Pagos del Mes",
																array(
																	'controller' => 'clientes', 
																	'action' => 'pagosdelmes', 
																	)
													); 	
								?>
							</li>	 
							<li class='has-sub'>
								<?php
								echo $this->Html->link("Comparativo",
																array(
																	'controller' => 'clientes', 
																	'action' => 'comparativo', 
																	)
													); 	
								?>
							</li>	 
						</ul>
					</li>
					<li class='active has-sub'><a href='#'><span>Gestion</span></a>
				      	<ul>
					    	<li class='has-sub'>
								<?php
									echo $this->Html->link("Mi Estudio",
																	array(
																		'controller' => 'clientes', 
																		'action' => 'avance', 
																		)
														); 	
								?>	
							</li>	       						
				      	</ul>
				   	</li>				 
				</ul>
				</div>
		</div>
		<div id="content">
			
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<!--<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>-->
	</div>
	<a href="#x" class="overlay" id="PopupLoading"></a>
		<div class="popupNews" id="loading">
        	<div id=""><?php echo $this->Html->image('progress.gif'); ?></div>
        <div id="result"></div>
    </div>
    <a href="#x" class="overlay" id="PopupMessage"></a>
		<div class="popup" id="alertMessage" style="padding:0px">
        	<label id="lblMessagePP" style="margin:20px">this is a message</label>
        <div id="result"></div>
    </div>
</div>
	<!--<?php echo $this->element('sql_dump'); ?>-->
</body>
</html>
