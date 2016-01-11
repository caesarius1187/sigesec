<?php
App::uses('AppController', 'Controller');
/**
 * Clientes Controller
 *
 * @property Cliente $Cliente
 * @property PaginatorComponent $Paginator
 */
class ClientesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator','RequestHandler');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$conditionsCli = array(
							 'Grupocliente',
							 );
		$clientes = $this->Cliente->find('list',array(
										'contain' =>$conditionsCli,
										'conditions' => array(
								 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),								 		
								 			),	
										)
									);
		$this->redirect(array('action' => 'view'));	
	}
	public function avance($data=null) {
		$this->loadModel('Impcli');
		$this->loadModel('Tareasxclientesxestudio');
		$this->loadModel('Tareascliente');
		$this->loadModel('Tareasimpuesto');
		$this->loadModel('Grupocliente');
		$this->loadModel('Periodosactivo');
		$pemes="";
		$peanio="";
		$selectby="";
		if ($this->request->is('post')) {
			$pemes=$this->request->data['clientes']['periodomes'];
			$peanio=$this->request->data['clientes']['periodoanio'];
			$selectby=$this->request->data['clientes']['selectby'];			
			$this->set('periodomes', $pemes);
			$this->set('periodoanio', $peanio);

			
			//Como Buscar los clientes
			$conditionsClientesAvance = "";
			if($selectby=='clientes'){
				$conditionsClientesAvance =  array(
									                'Cliente.id' => $this->request->data['clientes']['lclis'],  
									                'Cliente.estado' => 'habilitado',  
									            );
			}else{
				$conditionsClientesAvance = array(
									                'Cliente.grupocliente_id' => $this->request->data['clientes']['gclis'],  
									                'Cliente.estado' => 'habilitado',  
									            );

			}
			//Como buscar los implcis del periodo 
			$conditionsImpCliHabilitados = array(
					//El periodo esta dentro de un desde hasta		
					array(
						'OR'=>array(
		            		'SUBSTRING(Periodosactivo.desde,4,7)*1 < '.$peanio.'*1',
		            		'AND'=>array(
		            			'SUBSTRING(Periodosactivo.desde,4,7)*1 <= '.$peanio.'*1',
		            			'SUBSTRING(Periodosactivo.desde,1,2) < '.$pemes.'*1'
		            			),												            		
		            		)
					),
					array(
						//HASTA es mayor que el periodo
		            	'OR'=>array(
		            		'SUBSTRING(Periodosactivo.hasta,4,7)*1 > '.$peanio.'*1',
		            		'AND'=>array(
		            			'SUBSTRING(Periodosactivo.hasta,4,7)*1 >= '.$peanio.'*1',
		            			'SUBSTRING(Periodosactivo.hasta,1,2) > '.$pemes.'*1'
		            			),												            		
		            		)
		            	)
				);
			$Periodosactivo = $this->Periodosactivo->find('all',array(
												'contain'=>array(
													'Impcli'=>array(
														//'conditions'=>$conditionsImpCliHabilitados																								
														)
													),
												'conditions'=>$conditionsImpCliHabilitados
												)
			);
			/*	'AND'=>array(
												            			'Periodosactivo.hasta IS NULL',
												            			'Periodosactivo.hasta = ""',
											            			),*/

			$this->set('impuestoshabilitados',$Periodosactivo);
			$clientes3=$this->Cliente->find('all', array(
							   'contain'=>array(
							      'Grupocliente',
							      'Eventoscliente'=>array(
							      		'conditions' => array(
								                'Eventoscliente.periodo =' => $pemes.'-'.$peanio  
								            ),
							      	),
							      'Honorario'=>array(
							      		'conditions' => array(
								                'Honorario.periodo =' => $pemes.'-'.$peanio  
								            ),
							      	),
							      'Deposito'=>array(
							      		'conditions' => array(
								                'Deposito.periodo =' => $pemes.'-'.$peanio  
								            ),
							      	),
							      'Impcli'=>array(
							         'Impuesto'=>array(
							            'fields'=>array('id','nombre'),
							             'conditions'=>array(

							             	)
							         ),
						        	 'Eventosimpuesto', 
						        	 'Periodosactivo'=>array(
						        	 		'conditions'=>$conditionsImpCliHabilitados
						        	 	),
						        	 'conditions' => array(
						        	 	'OR'=>array(
								            	//'Impcli.id'=>$impuestoshabilitados,							            		
								            	)
								            ),

									)									       
							    ),
							   'conditions' => $conditionsClientesAvance,
							   'order' => array(
								                'Grupocliente.nombre','Cliente.nombre'  
								            ),

							));
			
			$this->set('clientes', $clientes3);

			//'order' => 'orden ASC',
			$this->Tareasxclientesxestudio->recursive = 0;
			$tareascliente = $this->Tareasxclientesxestudio->find('all',array(
													'order' => 'Tareasxclientesxestudio.orden ASC',
													'conditions' => array(
										                'Tareasxclientesxestudio.estudio_id' => $this->Session->read('Auth.User.estudio_id') ,
										                'Tareasxclientesxestudio.estado' => 'habilitado' , 
										            ),
										            'contain'=>array('Tareascliente')));
			$this->set('tareas',$tareascliente);
			/*$tareasimp = $this->Tareasimpuesto->find('all',array( 'order' => 'orden ASC',));
			$this->set('tareasimp',$tareasimp);*/
			$mostrarInforme=true;
			$this->set('mostrarInforme',$mostrarInforme);
			//return $this->redirect(array('action' => 'avance'));
		}

		$conditionsGcli = array('Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),);
		$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli));

		$conditionsCli = array(
							 'Grupocliente',
							 );

		$lclis = $this->Cliente->find('list',array(
									'contain' =>$conditionsCli,
									'conditions' => array(
							 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id')
							 		)));
		$this->set(compact('lclis'));
		$this->set(compact('gclis'));
	
	}
	public function tareacargar($id=null,$periodo=null,$selectedBy=null){
		// PRIMERO CHEKIAR QUE EL CLIENTE QUE MUESTRA LAS VENTAS SEA PARTE DEL ESTUDIO ACTIVO

		$this->loadModel('Localidade');
		$this->loadModel('Partido');
		$this->loadModel('Grupocliente');
		$cliente=$this->Cliente->find('first', array(
				   'contain'=>array(
				   		'Venta'=>array(					   			
			   				'Puntosdeventa'=>array(
			   						'fields'=>array('id','nombre')
			   					),	
		   					'Subcliente'=>array(
		   						'fields'=>array('id','nombre')
		   					),	
		   					'Localidade'=>array(
		   						'fields'=>array('id','nombre')
		   					),				   								   			
			   				'conditions' => array(					            	
					            	'Venta.periodo'=>$periodo					           
				   			),	
				   		),	
				   		'Compra'=>array(					   			
			   				'Puntosdeventa'=>array(
			   						'fields'=>array('id','nombre')
			   					),	
		   					'Subcliente'=>array(
		   						'fields'=>array('id','nombre')
		   					),	
		   					'Localidade'=>array(
		   						'fields'=>array('id','nombre')
		   					),				   								   			
			   				'conditions' => array(					            	
					            	'Compra.periodo'=>$periodo					           
				   			),	
				   		),				   				   	
			   		),'conditions' => array(
					            	'id' => $id,						            						          
				   			),	
		   		)
	   		);
	   	$this->set('periodo',$periodo);	  
	   	$this->set('cliente',$cliente);

	   	$conditionspuntosdeventa = array('Puntosdeventa.cliente_id' => $id,);
		$puntosdeventas = $this->Cliente->Puntosdeventa->find('list',array('conditions' =>$conditionspuntosdeventa));	
		$this->set(compact('puntosdeventas'));

		$conditionsSubClientes = array('Subcliente.cliente_id' => $id,);
		$subclientes = $this->Cliente->Subcliente->find('list',array('conditions' =>$conditionsSubClientes));	
		$this->set(compact('subclientes'));


		$localidades = $this->Localidade->find('list');
		$this->set('localidades', $localidades);
		
		$partidos = $this->Partido->find('list');
		$this->set('partidos', $partidos);

		$alicuotas = array("10,50" => '10,50',"20,10" => '20,10',"50,50" => '50,50',);
		$this->set('alicuotas', $alicuotas);

		$conditionsGcli = array('Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),);
		$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli));

		$conditionsCli = array(
							 'Grupocliente',
							 );

		$lclis = $this->Cliente->find('list',array(
									'contain' =>$conditionsCli,
									'conditions' => array(
							 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id')
							 		)));
		$this->set(compact('lclis'));
		$this->set(compact('gclis'));
	}
	public function informepagosdelmes($data=null) {
		$pemes="";
		$peanio="";
		$this->loadModel('Grupocliente');

		$conditionsGcli = array(
			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
			);
		$fields = array('id');
		$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli,'fields'=>$fields));	

		if ($this->request->is('post')) {
			$pemes=$this->request->data['clientes']['periodomes'];
			$peanio=$this->request->data['clientes']['periodoanio'];
			$this->set('periodomes', $pemes);
			$this->set('periodoanio', $peanio);

			$grupoclientesActual=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(	
				   			'Deposito'=>array(
				   				'conditions' => array(
						            	'Deposito.periodo' => $pemes."-".$peanio
						            ),
				   			),	
				   			'Honorario'=>array(
					   				'conditions' => array(
						            	'Honorario.periodo' => $pemes."-".$peanio
							            ),
					   			),		   							   							   	
					   		'Impcli'=>array(
						         'Impuesto'=>array(
						            'fields'=>array('id','nombre','lugarpago'),						             
						         ),
					        	 'Eventosimpuesto'=>array( 
					        	  'conditions' => array(
							            	 'Eventosimpuesto.periodo' => $pemes."-".$peanio
							            ),
            						'order' => array('fchvto' => 'ASC')
					        	  ),
					       	),
			   			),
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $gclis 
					            ),
				   	'order' => array('Grupocliente.nombre'),

			   )
			);
			$grupoclientesHistorial=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(
				   			'Deposito'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Deposito.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Deposito.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Deposito.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
				   			'Ingreso'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Ingreso.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Ingreso.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Ingreso.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
					   		'Honorario'=>array(
					   				'conditions' => array(
					   						'OR'=>array(
								            		'SUBSTRING(Honorario.periodo,4,7)*1 < '.$peanio.'*1',
								            		'AND'=>array(
								            			'SUBSTRING(Honorario.periodo,4,7)*1 <= '.$peanio.'*1',
								            			'SUBSTRING(Honorario.periodo,1,2) < '.$pemes.'*1'
								            			),
								            		),
							            ),
					   			),	
					   		'Impcli'=>array(					         
					        	 'Eventosimpuesto'=>array(
					        	  'conditions' => array(
			        	  					'OR'=>array(
							            		'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Eventosimpuesto.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
							            ),
					        	  ),
					       	),
			   			),
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $gclis 
					            ),

			   )
			);		
			$this->set('grupoclientesActual', $grupoclientesActual);
			$this->set('grupoclientesHistorial', $grupoclientesHistorial);
			$mostrarInforme=true;
			$this->set('mostrarInforme',$mostrarInforme);
		}
		
	}
	public function pagosdelmes($data=null) {
		$pemes="";
		$peanio="";
		$this->loadModel('Grupocliente');

		$conditionsGcli = array(
			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
			);
		$fields = array('id');
		//$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli,'fields'=>$fields));	
		
		if ($this->request->is('post')) {
			$gclis = $this->request->data['clientes']['gclis'];
			$pemes=$this->request->data['clientes']['periodomes'];
			$peanio=$this->request->data['clientes']['periodoanio'];
			$this->set('periodomes', $pemes);
			$this->set('periodoanio', $peanio);

			$grupoclientesActual=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(	
				   			'Deposito'=>array(
				   				'conditions' => array(
						            	'Deposito.periodo' => $pemes."-".$peanio
						            ),
				   			),	
				   			'Honorario'=>array(
					   				'conditions' => array(
						            	'Honorario.periodo' => $pemes."-".$peanio
							            ),
					   			),		   							   							   	
					   		'Impcli'=>array(
						         'Impuesto'=>array(
						            'fields'=>array('id','nombre','lugarpago'),						             
						         ),
					        	 'Eventosimpuesto'=>array( 
					        	  'conditions' => array(
							            	 'Eventosimpuesto.periodo' => $pemes."-".$peanio
							            ),
            						
					        	  ),
					       	),
			   			),
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $gclis 
					            ),
				   	'order' => array('Grupocliente.nombre'),

			   )
			);
			$grupoclientesHistorial=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(
				   			'Deposito'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Deposito.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Deposito.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Deposito.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
				   			'Ingreso'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Ingreso.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Ingreso.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Ingreso.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
					   		'Honorario'=>array(
					   				'conditions' => array(
					   						'OR'=>array(
								            		'SUBSTRING(Honorario.periodo,4,7)*1 < '.$peanio.'*1',
								            		'AND'=>array(
								            			'SUBSTRING(Honorario.periodo,4,7)*1 <= '.$peanio.'*1',
								            			'SUBSTRING(Honorario.periodo,1,2) < '.$pemes.'*1'
								            			),
								            		),
							            ),
					   			),	
					   		'Impcli'=>array(					         
					        	 'Eventosimpuesto'=>array(
					        	  'conditions' => array(
			        	  					'OR'=>array(
							            		'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Eventosimpuesto.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
							            ),
					        	  ),
					       	),
			   			),
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $gclis 
					            ),

			   )
			);		
			$this->set('grupoclientesActual', $grupoclientesActual);
			$this->set('grupoclientesHistorial', $grupoclientesHistorial);
			$mostrarInforme=true;
			$this->set('mostrarInforme',$mostrarInforme);
		}
		$conditionsGcli = array('Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),);
		$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli));	
		$this->set(compact('gclis'));
	}
	public function informefinancierotributario($data=null) {
		$this->loadModel('Impcli');
		$this->loadModel('Tareasxclientesxestudios');
		$this->loadModel('Tareasimpuesto');
		$this->loadModel('Grupocliente');
		$pemes="";
		$peanio="";
		if ($this->request->is('post')) {
			$pemes=$this->request->data['clientes']['periodomes'];
			$peanio=$this->request->data['clientes']['periodoanio'];
			$this->set('periodomes', $pemes);
			$this->set('periodoanio', $peanio);

			$grupoclientesActual=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(
				   			'Domicilio',
				   			'Deposito'=>array(
				   				'conditions' => array(
						            	 'Deposito.periodo' => $pemes."-".$peanio,
						            	
						            ),
				   			),
				   			'Ingreso'=>array(
				   				'conditions' => array(
						            	 'Ingreso.periodo' => $pemes."-".$peanio
						            ),
				   			),
					   		'Honorario'=>array(
					   				'conditions' => array(
							            	 'Honorario.periodo' => $pemes."-".$peanio
							            ),
					   			),	
					   		'Impcli'=>array(
						         'Impuesto'=>array(
						            'fields'=>array('id','nombre','lugarpago'),						             
						         ),
					        	 'Eventosimpuesto'=>array( 
					        	  'conditions' => array(
							            	 'Eventosimpuesto.periodo' => $pemes."-".$peanio
							            ),
					        	  ),
					       	),
					       	'order' => array('Cliente.nombre'),
					   		
			   			),			   				
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $this->request->data['clientes']['gclis']  ,

					            ),

			   )
			);
			$grupoclientesHistorial=$this->Grupocliente->find('all', array(
				   'contain'=>array(
				   		'Cliente'=>array(
				   			'Deposito'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Deposito.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Deposito.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Deposito.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
				   			'Ingreso'=>array(
				   				'conditions' => array(						            	 
						            	 'OR'=>array(
							            		'SUBSTRING(Ingreso.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Ingreso.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Ingreso.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
						            ),
				   			),
					   		'Honorario'=>array(
					   				'conditions' => array(
					   						'OR'=>array(
								            		'SUBSTRING(Honorario.periodo,4,7)*1 < '.$peanio.'*1',
								            		'AND'=>array(
								            			'SUBSTRING(Honorario.periodo,4,7)*1 <= '.$peanio.'*1',
								            			'SUBSTRING(Honorario.periodo,1,2) < '.$pemes.'*1'
								            			),
								            		),
							            ),
					   			),	
					   		'Impcli'=>array(					         
					        	 'Eventosimpuesto'=>array(
					        	  'conditions' => array(
			        	  					'OR'=>array(
							            		'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 < '.$peanio.'*1',
							            		'AND'=>array(
							            			'SUBSTRING(Eventosimpuesto.periodo,4,7)*1 <= '.$peanio.'*1',
							            			'SUBSTRING(Eventosimpuesto.periodo,1,2) < '.$pemes.'*1'
							            			),
							            		),
							            ),
					        	  ),
					       	),
			   			),
				   		
				   	),
				   'conditions' => array(
					                'Grupocliente.id' => $this->request->data['clientes']['gclis']  
					            ),

			   )
			);			
			
			$this->set('grupoclientesActual', $grupoclientesActual);
			$this->set('grupoclientesHistorial', $grupoclientesHistorial);
					
			$mostrarInforme=true;
			$this->set('mostrarInforme',$mostrarInforme);
			//return $this->redirect(array('action' => 'avance'));
		}

		$conditionsGcli = array('Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),);
		$gclis = $this->Grupocliente->find('list',array('conditions' =>$conditionsGcli));	
		$this->set(compact('gclis'));
	
	}
/**
 * comparativo method
 *
 * @throws NotFoundException
 * @return void
 */
	public function comparativo(){
		$this->loadModel('Grupocliente');

		//para seleccion de clientes
		$conditionsCli = array(
							 'Grupocliente',
							 );
		$clienteses = $this->Grupocliente->find('list',array(
									'conditions' => array(
							 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
							 							),
									'order'=>array('Grupocliente.nombre')
									)

		);
		$this->set('gclis',$clienteses);
	}

	public function comparativolistacliente(){
		$clientes3=$this->Cliente->find('all', array(
							   'contain'=>array(							      							     
							      'Impcli'=>array(
							         'Impuesto'=>array(
							            'fields'=>array('id','nombre'),
							             'conditions'=>array(

							             	)
							         ),
						        	 'Eventosimpuesto'=>array(
						        	 	'conditions' => array(
						        	 		'Eventosimpuesto.periodo' => $this->request->data['clientes']['periodomes']."-".$this->request->data['clientes']['periodoanio']
						        	 		),
						        	 	'fields'=>array('id','impcli_id','monc','periodo','montovto'),
						        	 	), 						        	 
						        	 'conditions' => array(
						        	 	'OR'=>array(
								            	//'Impcli.id'=>$impuestoshabilitados,							            		
								            	)
								            ),
						        	 'fields'=>array('id','cliente_id','impuesto_id'),
									)									       
							    ),
							   'conditions' => array(
							   					'Cliente.grupocliente_id'=>$this->request->data['clientes']['gclis'],
							   					),
							   'fields'=>array('id','nombre','grupocliente_id'),
							   'order' => array(
								                'Cliente.nombre'  
								            ),

							));
			
		$this->set('clientes', $clientes3);
		$this->set('shownombre', $this->request->data['clientes']['shownombre']);
		$this->autoRender=false; 				
		$this->layout = 'ajax';
		$this->render('comparativolistacliente');
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->loadModel('Impuesto');
		$this->loadModel('Localidade');
		$this->loadModel('Partido');
		$this->loadModel('Cbus');
		$this->loadModel('Puntosdeventa');
		$this->loadModel('Subcliente');
		$this->loadModel('Actividades');

		if(!is_null($id)){
			$conditionsCliAuth = array(
								 'Grupocliente',
								 );
			$clientesAuth = $this->Cliente->find('all',array(
										'contain' =>$conditionsCliAuth,
										'conditions' => array(
								 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
								 			'Cliente.id' => $id ,
								 		)));
			$numClis = sizeof($clientesAuth);
			if($numClis==0){
				$this->Session->setFlash(__('Cliente No existente. Alerta enviada.'));
				return $this->redirect(array('controller'=>'users','action' => 'index'));
			}


			if (!$this->Cliente->exists($id)) {
				$this->Session->setFlash(__('Cliente No existente '.$numClis));
				return $this->redirect(array('controller'=>'users','action' => 'index'));
			}
				
			$clientes3=$this->Cliente->find('first', array(
										   'contain'=>array(
										      'Grupocliente',
										      'Ingreso',	
										      'Organismosxcliente',
										      'Domicilio'=>array(
										      	'Localidade'=>array(
										      			'Partido'
										      		)
										      	),
										      'Personasrelacionada',
										      'Subcliente',
  										      'Venta'=>array(										         
									        	 'Subcliente', 
										       ),
  										      'Actividade'=>array(),
  										      'Puntosdeventa',
										      'Impcli'=>array(
										         'Impuesto'=>array(
										            'fields'=>array('id','nombre','organismo'),								             
										         ),
									        	 'Eventosimpuesto', 
									        	 'Periodosactivo'=>array(
 														'conditions' => array(
											                'Periodosactivo.hasta' => null, 
											            ),
									        	 	), 
										       ),
										      'Deposito',
										      'Honorario',
										      'Bancosysindicato',	
										    ),
										   'conditions' => array(
											                'Cliente.id' => $id, // <-- Notice this addition
											            ),
										));	
			$this->set('cliente', $clientes3);
		
			$clientes = $this->Cliente->find('list');
			$this->set('clientes', $clientes);

					
			$resAfip = $this->Impuesto->find('all', 
				array(
				    'contain' => array(
				    	'Impcli' => array(
					    	'Periodosactivo'=>array(
								'conditions' => array(
				                	'Periodosactivo.hasta' => null, 					                	
					            ),
		        	 		), 
		        	 		'conditions' => array(
					                'cliente_id' => $id, 
					            ),
				    	),
	    			),
	    			'conditions' => array(
					                'organismo' => 'afip',
					            ),
				)
			);
			$this->set('impuestosafip', $resAfip);

			$resDGR = $this->Impuesto->find('all',array(
				    'contain' => array(
				    	'Impcli' => array(
					    	'Periodosactivo'=>array(
								'conditions' => array(
					                'OR'=> array(
						                	'Periodosactivo.hasta' => null, 
					                	),
					            ),
		        	 		), 
		        	 		'conditions' => array(
					                'cliente_id' => $id, 
					            ),
				    	),
	    			),
	    			'conditions' => array(
					                'organismo' => 'dgr',
					            ),
				)
			);
			$this->set('impuestosdgr', $resDGR);
			
			$resDGRM = $this->Impuesto->find('all',array(
				    'contain' => array(
				    	'Impcli' => array(
					    	'Periodosactivo'=>array(
								'conditions' => array(
					                'Periodosactivo.hasta' => null, 
					            ),
		        	 		), 
		        	 		'conditions' => array(
					                'cliente_id' => $id, 
					            ),
				    	),
	    			),
	    			'conditions' => array(
					                'organismo' => 'dgrm',
					            ),
				)
			);
			$this->set('impuestosdgrm', $resDGRM);

			$resSINDICATO = $this->Impuesto->find('all',array(
				    'contain' => array(
				    	'Impcli' => array(
					    	'Periodosactivo'=>array(
								'conditions' => array(
					                'Periodosactivo.hasta' => null, 
					            ),
		        	 		), 
		        	 		'conditions' => array(
					                'cliente_id' => $id, 
					            ),
				    	),
	    			),
	    			'conditions' => array(
					                'organismo' => 'sindicato',
					            ),
				)
			);
			$this->set('impuestossindicato', $resSINDICATO);

			$resBANCO = $this->Impuesto->find('all',array(
				    'contain' => array(
				    	'Impcli' => array(
					    	'Periodosactivo'=>array(
								'conditions' => array(
					                'Periodosactivo.hasta' => null, 
					            ),
		        	 		), 
		        	 		'conditions' => array(
					                'cliente_id' => $id, 
					            ),
				    	),
	    			),
	    			'conditions' => array(
					                'organismo' => 'banco',
					            ),
				)
			);
			$this->set('impuestosbancos', $resBANCO);


			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);

			$partidos = $this->Partido->find('list');
			$this->set('partidos', $partidos);
			

			$optionsLoc = array(
					'conditions' => array(
										'Localidade.partido_id' => array_keys($partidos)[0]
								)
			);			

			$localidades = $this->Localidade->find('list',$optionsLoc);
			$this->set('localidades', $localidades);
			
			$optionsAct = array(
					'fields' => array(
										'id','nombre'
								)
			);			

			$actividades = $this->Actividades->find('list',$optionsAct);
			$this->set('actividades', $actividades);

			$optionsPdV = array('conditions' => array('Puntosdeventa.cliente_id' => $id));
			$puntosdeventa = $this->Puntosdeventa->find('list',$optionsPdV);
			$this->set('puntosdeventas', $puntosdeventa);

			$optionsSC = array('conditions' => array('Subcliente.cliente_id' => $id));
			$subcliente = $this->Subcliente->find('list',$optionsSC);
			$this->set('subclientes', $subcliente);
			
			$cbuses = $this->Cbus->find('all',array(
									'conditions' => array('bancosysindicato_id IN (SELECT id FROM bancosysindicatos WHERE cliente_id = '.$id.')')));
			$this->set('cbuses',$cbuses);

			$mostrarView=true;

		}else{
			$mostrarView=false;
		}

		//for index
		$conditionsCli = array(
							 'Grupocliente',
							 );
		$clienteses = $this->Cliente->find('all',array(
									'contain' =>$conditionsCli,
									'conditions' => array(
							 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
							 			'Cliente.estado'=>'habilitado'
							 							),
									'order'=>array('Grupocliente.nombre','Cliente.nombre')
									)

		);
		$this->set('clienteses',$clienteses);

		$clientesesDeshabilitados = $this->Cliente->find('all',array(
									'contain' =>$conditionsCli,
									'conditions' => array(
							 			'Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),
							 			'Cliente.estado'=>'deshabilitado'
							 							),
									'order'=>array('Grupocliente.nombre','Cliente.nombre')
									)

		);
		$this->set('clientesesDeshabilitados',$clientesesDeshabilitados);

		$this->set('mostrarView',$mostrarView);
	}
	public function habilitar($id=null) {
		$this->Cliente->id = $id;		
		if($this->Cliente->saveField('estado', 'habilitado')){
					$this->Session->setFlash(__('El cliente a sido habilitado.'));
		}else{
					$this->Session->setFlash(__('El cliente NO a sido habilitado.'));
		}
		$this->redirect(array('action' => 'view'));	
	}
	public function deshabilitar($id=null) {
		$this->Cliente->id = $id;		
		if($this->Cliente->saveField('estado', 'deshabilitado')){
					$this->Session->setFlash(__('El cliente a sido deshabilitado.'));
		}else{
					$this->Session->setFlash(__('El cliente NO a sido deshabilitado	.'));
		}
		$this->redirect(array('action' => 'view'));	
	}
/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->loadModel('Organismosxcliente');
		if ($this->request->is('post')) {
			$this->Cliente->create();

			//if($this->request->data['Cliente']['fchcorteejerciciofiscal']!="")
			//$this->request->data('Cliente.fchcorteejerciciofiscal',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcorteejerciciofiscal'])));
			if($this->request->data['Cliente']['fchcumpleanosconstitucion']!="")
				$this->request->data('Cliente.fchcumpleanosconstitucion',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcumpleanosconstitucion'])));
			//if($this->request->data['Cliente']['inscripcionregistrocomercio']!="")
			//	$this->request->data('Cliente.inscripcionregistrocomercio',date('Y-m-d',strtotime($this->request->data['Cliente']['inscripcionregistrocomercio'])));
			if($this->request->data['Cliente']['fchiniciocliente']!="")
				$this->request->data('Cliente.fchiniciocliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchiniciocliente'])));
			if($this->request->data['Cliente']['fchfincliente']!="")
				$this->request->data('Cliente.fchfincliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchfincliente'])));
			//if($this->request->data['Cliente']['vtocaia']!="")
			//	$this->request->data('Cliente.vtocaia',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaia'])));
			//if($this->request->data['Cliente']['vtocaib']!="")
			//	$this->request->data('Cliente.vtocaib',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaib'])));
			//if($this->request->data['Cliente']['vtocaic']!="")
			//	$this->request->data('Cliente.vtocaic',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaic'])));

			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash(__('El cliente a sido guardado	.'));

				//Debemos crear 
				$this->Organismosxcliente->create();
				$this->Organismosxcliente->set('cliente_id',$this->Cliente->getLastInsertID());
				$this->Organismosxcliente->set('tipoorganismo','afip');
				$this->Organismosxcliente->save();

				$this->Organismosxcliente->create();
				$this->Organismosxcliente->set('cliente_id',$this->Cliente->getLastInsertID());
				$this->Organismosxcliente->set('tipoorganismo','dgr');
				$this->Organismosxcliente->save();

				$this->Organismosxcliente->create();
				$this->Organismosxcliente->set('cliente_id',$this->Cliente->getLastInsertID());
				$this->Organismosxcliente->set('tipoorganismo','dgrm');
				$this->Organismosxcliente->save();

				$this->Organismosxcliente->create();
				$this->Organismosxcliente->set('cliente_id',$this->Cliente->getLastInsertID());
				$this->Organismosxcliente->set('tipoorganismo','sindicato');
				$this->Organismosxcliente->save();

				$this->Organismosxcliente->create();
				$this->Organismosxcliente->set('cliente_id',$this->Cliente->getLastInsertID());
				$this->Organismosxcliente->set('tipoorganismo','banco');
				$this->Organismosxcliente->save();

				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('El cliente no pudo ser guardado. Por favor, intente de nuevo mas tarde.'));
			}
		}
		$conditionsGcli = array('Grupocliente.estudio_id' => $this->Session->read('Auth.User.estudio_id'),);
		$grupoclientes = $this->Cliente->Grupocliente->find('list',array('conditions' =>$conditionsGcli));
		$this->set(compact('grupoclientes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
/*	public function edit($id = null) {
		if (!$this->Cliente->exists($id)) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		if ($this->request->is('post')) {
			$this->request->data('Cliente.fchcorteejerciciofiscal',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcorteejerciciofiscal'])));
			$this->request->data('Cliente.fchcumpleanosconstitucion',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcumpleanosconstitucion'])));
			$this->request->data('Cliente.inscripcionregistrocomercio',date('Y-m-d',strtotime($this->request->data['Cliente']['inscripcionregistrocomercio'])));
			$this->request->data('Cliente.fchiniciocliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchiniciocliente'])));
			$this->request->data('Cliente.fchfincliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchfincliente'])));			
			$this->request->data('Cliente.vtocaia',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaia'])));
			$this->request->data('Cliente.vtocaib',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaib'])));
			$this->request->data('Cliente.vtocaic',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaic'])));

			if ($this->Cliente->save($this->request->data)) {
				$this->Session->setFlash(__('El Cliente ha sido Modificado.'));
				return $this->redirect(array('action' => 'view',$this->request->data['Cliente']['id']));
			} else {
				$this->Session->setFlash(__('El Cliente no ha sido Modificado. Por favor, intente de nuevo mas tarde.'));
			}
		} else {
			$options = array('conditions' => array('Cliente.' . $this->Cliente->primaryKey => $id));
			$this->request->data = $this->Cliente->find('first', $options);
		}
		$grupoclientes = $this->Cliente->Grupocliente->find('list');
		$this->set(compact('grupoclientes'));
	}*/
	public function edit(){	
		$this->autoRender=false; 
		if($this->RequestHandler->isAjax()){ 
			Configure::write('debug', 0); } 
		if(!empty($this->data)){ 
			if($this->request->data['Cliente']['fchcorteejerciciofiscal']!="")
			//$this->request->data('Cliente.fchcorteejerciciofiscal',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcorteejerciciofiscal'])));
			if($this->request->data['Cliente']['fchcumpleanosconstitucion']!="")
			$this->request->data('Cliente.fchcumpleanosconstitucion',date('Y-m-d',strtotime($this->request->data['Cliente']['fchcumpleanosconstitucion'])));
			if($this->request->data['Cliente']['inscripcionregistrocomercio']!="")
			$this->request->data('Cliente.inscripcionregistrocomercio',date('Y-m-d',strtotime($this->request->data['Cliente']['inscripcionregistrocomercio'])));
			if($this->request->data['Cliente']['fchiniciocliente']!="")
			$this->request->data('Cliente.fchiniciocliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchiniciocliente'])));
			if($this->request->data['Cliente']['fchfincliente']!="")
			$this->request->data('Cliente.fchfincliente',date('Y-m-d',strtotime($this->request->data['Cliente']['fchfincliente'])));
			if($this->request->data['Cliente']['vtocaia']!="")
			$this->request->data('Cliente.vtocaia',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaia'])));
			if($this->request->data['Cliente']['vtocaib']!="")
			$this->request->data('Cliente.vtocaib',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaib'])));
			if($this->request->data['Cliente']['vtocaic']!="")
			$this->request->data('Cliente.vtocaic',date('Y-m-d',strtotime($this->request->data['Cliente']['vtocaic'])));


			if($this->Cliente->save($this->data)){
				echo 'El Cliente ha sido modificado.'; 
			}else{ 
				echo 'El NO Cliente ha sido modificado.'; } 
		} 
	}
	public function editajax($cliId = null,$nombre = null,$Dni= null,$Cuitcontribullente= null,$Numinscripcionconveniomultilateral= null,
		$Tipopersona = null,$Tipopersonajuridica = null,$Fchcorteejerciciofiscal= null,$Fchcumpleanosconstitucion= null,$Anosduracion= null,
		$Inscripcionregistrocomercio = null,$Modificacionescontrato = null,$Descripcionactividad= null,$Fchiniciocliente= null,$Fchfincliente= null) {

	 	$this->request->onlyAllow('ajax');
		//Configure::write('debug', 2);
		if ($this->Cliente->exists($cliId)) {
			//throw new NotFoundException(__('Evento de cliente invalido'));
			$this->Cliente->read(null, $cliId);
			$this->Cliente->set('nombre',$nombre);
			$this->Cliente->set('dni',$Dni);
			$this->Cliente->set('cuitcontribullente',$Cuitcontribullente);
			$this->Cliente->set('numinscripcionconveniomultilateral',$Numinscripcionconveniomultilateral);

			$this->Cliente->set('tipopersona',$Tipopersona);
			$this->Cliente->set('tipopersonajuridica',$Tipopersonajuridica);
			//$this->Cliente->set('fchcorteejerciciofiscal',date('Y-m-d',strtotime($Fchcorteejerciciofiscal)));
			$this->Cliente->set('fchcumpleanosconstitucion',date('Y-m-d',strtotime($Fchcumpleanosconstitucion)));
			$this->Cliente->set('anosduracion',$Anosduracion);

			$this->Cliente->set('inscripcionregistrocomercio',date('Y-m-d',strtotime($Inscripcionregistrocomercio)));
			$this->Cliente->set('modificacionescontrato',$Modificacionescontrato);
			$this->Cliente->set('descripcionactividad',$Descripcionactividad);
			$this->Cliente->set('fchiniciocliente',date('Y-m-d',strtotime($Fchiniciocliente)));
			$this->Cliente->set('fchfincliente',date('Y-m-d',strtotime($Fchfincliente)));

			if($this->Cliente->save()){
				$this->set('respuesta','El Cliente ha sido modificado.');	
				$this->set('evento_id',$this->Cliente->getLastInsertID());
			}else{
				$this->set('respuesta','error');	
			}
		}else{
			$this->set('respuesta','error');			
		}
		$this->layout = 'ajax';
		$this->render('editajax');
	}
	
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Cliente->id = $id;
		if (!$this->Cliente->exists()) {
			throw new NotFoundException(__('Invalid cliente'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Cliente->delete()) {
			$this->Session->setFlash(__('The cliente has been deleted.'));
		} else {
			$this->Session->setFlash(__('The cliente could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
?>