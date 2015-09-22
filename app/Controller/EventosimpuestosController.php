<?php
App::uses('AppController', 'Controller');
/**
 * Eventosimpuestos Controller
 *
 * @property Eventosimpuesto $Eventosimpuesto
 * @property PaginatorComponent $Paginator
 */
class EventosimpuestosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');



	public function realizareventoimpuesto($id = null,$tarea = null,$periodo= null,$implcid= null,$estadoTarea=null) {
	 	$this->request->onlyAllow('ajax');
		
		//Configure::write('debug', 2);
		if (!$this->Eventosimpuesto->exists($id)) {
			//throw new NotFoundException(__('Evento de cliente invalido'));
			$this->Eventosimpuesto->create();
			$this->Eventosimpuesto->set('impcli_id',$implcid);
			$this->Eventosimpuesto->set('periodo',$periodo);
			$this->Eventosimpuesto->set($tarea,$estadoTarea);
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			$this->Eventosimpuesto->set('fchvto','2015/01/01');
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			$this->Eventosimpuesto->set('user_id',$this->Session->read('Auth.User.estudio_id'));
			if($this->Eventosimpuesto->save()){
				$this->set('error',0);
				$this->set('respuesta','La tarea ha sido realizada.1');	
				$this->set('evento_id',$this->Eventosimpuesto->getLastInsertID());
			}else{
				$this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.2:   ');
			}
		}else{
			$this->Eventosimpuesto->read(null, $id);
			$this->Eventosimpuesto->set($tarea,$estadoTarea);
			$this->Eventosimpuesto->set('plan',0);

			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			$this->Eventosimpuesto->set('fchvto','2015/01/01');
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!

			if ($this->Eventosimpuesto->save()) {
				$this->set('error',0);
				$this->set('respuesta','La tarea ha sido realizada.3');	
				$this->set('evento_id',$id);
			} else {
				$this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.4:   ');
			    //debug($this->Eventosimpuesto->invalidFields()); die();
			}
		}
		$this->layout = 'ajax';
		$this->render('realizartarea5');
	}
	public function realizartarea5($id = null,$periodo= null,$implcid= null, $montovto = null,$fchvto = null,$monc= null,$descripcion= null) {

	 	$this->request->onlyAllow('ajax');
		$this->loadModel('Impcli');
	
		//Configure::write('debug', 2);
		if (!$this->Eventosimpuesto->exists($id)) {
			//throw new NotFoundException(__('Evento de cliente invalido'));
			$this->Eventosimpuesto->create();
			$this->Eventosimpuesto->set('impcli_id',$implcid);
			$this->Eventosimpuesto->set('periodo',$periodo);

			$this->Eventosimpuesto->set('montovto',$montovto);

			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			$this->Eventosimpuesto->set('fchvto',date('Y-m-d',strtotime($fchvto)));
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!

			$this->Eventosimpuesto->set('monc',$monc);
			$this->Eventosimpuesto->set('descripcion',$descripcion);

			$this->Eventosimpuesto->set('user_id',$this->Session->read('Auth.User.estudio_id'));
			if($this->Eventosimpuesto->save()){
				$this->set('respuesta','La tarea ha sido realizada.1');	
				$this->set('evento_id',$this->Eventosimpuesto->getLastInsertID());
				$this->set('error',0);
			}else{
			    //debug($this->Eventosimpuesto->invalidFields()); die();

				$this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.2:   ');//.print_r($this->Eventosimpuesto->validationErrors, true));	
			}
		}else{
			$this->Eventosimpuesto->read(null, $id);
			$this->Eventosimpuesto->set('montovto',$montovto);

			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			$this->Eventosimpuesto->set('fchvto',date('Y-m-d',strtotime($fchvto)));
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!
			//esta fecha debe buscarse en la tabla de vencimientos!!!!!!!!!!!

			$this->Eventosimpuesto->set('monc',$monc);
			$this->Eventosimpuesto->set('descripcion',$descripcion);

			if ($this->Eventosimpuesto->save()) {
				$this->set('respuesta','La tarea ha sido realizada.3');	
				$this->set('evento_id',$id);
				$this->set('error',0);

			} else {
			    $this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.4'.$this->validationErrors());	

			}
		}
		$this->layout = 'ajax';
		$this->render('realizartarea5');
	}

	public function getpapelestrabajo($periodo,$impcli){
		$this->loadModel('Impcli');
		$this->loadModel('Partido');
		$this->loadModel('Localidade');
		//4 formas de pagar impuestos Provincia, Municipio, Item , unico
		
		$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $impcli));
		$myImpCli = $this->Impcli->find('first', $options);
		$eventoId= 0;
		switch ($myImpCli["Impuesto"]["tipopago"]) {
			case 'provincia':
				
			case 'municipio':
				
			case 'item':
				$options = array(
					'conditions' => array(
						'Eventosimpuesto.impcli_id'=> $impcli,
						'Eventosimpuesto.periodo'=>$periodo
						)
					);
				$eventosimpuestos = $this->Eventosimpuesto->find('all', $options);
				if(count($eventosimpuestos)!=0){
					$eventoId=$eventosimpuestos[0]['Eventosimpuesto']['id'];
				}
				$this->set('eventosimpuestos',$eventosimpuestos);
			break;
			case 'unico':
				

				$options = array(
				'conditions' => array(
					'Eventosimpuesto.impcli_id'=> $impcli,
					'Eventosimpuesto.periodo'=>$periodo
					)
				);
				$eventosimpuestos = $this->Eventosimpuesto->find('first', $options);
				
				if(count($eventosimpuestos)==0){
					$this->Eventosimpuesto->set('periodo',$periodo);
					$this->Eventosimpuesto->set('impcli_id',$impcli);
					if($this->Eventosimpuesto->save()){
						$eventoId=$this->Eventosimpuesto->getLastInsertID();				
					}

					$options = array(
						'conditions' => array(
							'Eventosimpuesto.id'=> $eventoId,
							)
						);
					$eventosimpuestos = $this->Eventosimpuesto->find('first', $options);
				}
				$this->request->data = $eventosimpuestos;

				$this->set('eventosimpuestos',$eventosimpuestos);
			break;
			default:
				$this->set('eventosimpuestos',array());
			break;
		}
		$this->set('partidos',$this->Partido->find('list'));
		$this->set('localidades',$this->Localidade->find('list'));

		$this->set('tipopago',$myImpCli["Impuesto"]["tipopago"]);
		$this->set('clienteid',$myImpCli["Impcli"]["cliente_id"]);
		$this->set('impcliid',$myImpCli["Impcli"]["id"]);
		$this->set('periodo',$periodo);
		$this->set('eventoid',$eventoId);
		$this->layout = 'ajax';
		$this->render('getpapelestrabajo');
	}
	public function getapagar($periodo,$impcli){
		$this->loadModel('Impcli');
		$this->loadModel('Partido');
		$this->loadModel('Localidade');
		//4 formas de pagar impuestos Provincia, Municipio, Item , unico
		
		$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $impcli));
		$myImpCli = $this->Impcli->find('first', $options);
		$eventoId= 0;
		
		$options = array(
			'conditions' => array(
				'Eventosimpuesto.impcli_id'=> $impcli,
				'Eventosimpuesto.periodo'=>$periodo
				)
			);
		$eventosimpuestos = $this->Eventosimpuesto->find('all', $options);
		$this->set('eventosimpuestos',$eventosimpuestos);
					
		$this->set('partidos',$this->Partido->find('list'));
		$this->set('localidades',$this->Localidade->find('list'));

		$this->set('tipopago',$myImpCli["Impuesto"]["tipopago"]);
		$this->set('clienteid',$myImpCli["Impcli"]["cliente_id"]);
		$this->set('impcliid',$myImpCli["Impcli"]["id"]);
		$this->set('periodo',$periodo);

		$this->layout = 'ajax';
		$this->render('getapagar');
	}
	public function realizartarea13($id = null,$tarea = null,$periodo= null,$implcid= null,	$montorealizado = null,$fchrealizado = null) {
	 	$this->request->onlyAllow('ajax');
		//Configure::write('debug', 2);
		if (!$this->Eventosimpuesto->exists($id)) {
			//throw new NotFoundException(__('Evento de cliente invalido'));
			$this->Eventosimpuesto->create();
			$this->Eventosimpuesto->set('impcli_id',$implcid);
			$this->Eventosimpuesto->set('periodo',$periodo);

			$this->Eventosimpuesto->set('montorealizado',$montorealizado);
			$this->Eventosimpuesto->set('fchrealizado',date('Y-m-d',strtotime($fchrealizado)));
			$this->Eventosimpuesto->set($tarea,'realizado');
			$this->Eventosimpuesto->set('user_id',$this->Session->read('Auth.User.estudio_id'));
			if($this->Eventosimpuesto->save()){
				$this->set('respuesta','La tarea ha sido realizada.1');	
				$this->set('evento_id',$this->Eventosimpuesto->getLastInsertID());
				$this->set('error',0);
			}else{
			    //debug($this->Eventosimpuesto->invalidFields()); die();

				$this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.2');
  					//.print_r($this->Eventosimpuesto->validationErrors, true));	
			}
		}else{
			$this->Eventosimpuesto->read(null, $id);
			$this->Eventosimpuesto->set($tarea,'realizado');
			$this->Eventosimpuesto->set('montorealizado',$montorealizado);
			$this->Eventosimpuesto->set('fchrealizado',date('Y-m-d',strtotime($fchrealizado)));

			if ($this->Eventosimpuesto->save()) {
				$this->set('respuesta','La tarea ha sido realizada.3');	
				$this->set('evento_id',$id);
				$this->set('error',0);

			} else {
			    $this->set('error',1);
  				$this->set('respuesta','La tarea NO ha sido realizada.4');	

			}
		}
		$this->layout = 'ajax';
		$this->render('realizartarea5');
	}

}
