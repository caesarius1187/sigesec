<?php
App::uses('AppController', 'Controller');
/**
 * Depositos Controller
 *
 * @property Deposito $Deposito
 * @property PaginatorComponent $Paginator
 */
class DepositosController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Deposito->recursive = 0;
		$this->set('depositos', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Deposito->exists($id)) {
			throw new NotFoundException(__('Invalid deposito'));
		}
		$options = array('conditions' => array('Deposito.' . $this->Deposito->primaryKey => $id));
		$this->set('deposito', $this->Deposito->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$resp ="";
		$this->autoRender=false; 
		if ($this->request->is('post')) {

			$this->request->data('Deposito.fecha',date('Y-m-d',strtotime($this->request->data['Deposito']['fecha'])));				

			$this->Deposito->create();
			$id = 0;
			$options = array(
					'conditions' => array(
						'Deposito.id'=> $this->request->data['Deposito']['id'],
						)
					);
			$createdDepo = $this->Deposito->find('first', $options);
			$depoCreado= false;
			
			if(count($createdDepo)>0){
				//el impcli ya esta creado por lo que ahora resta buscar los periodos activos y ver si se puede crear uno
				$depoCreado= true;
				$this->set('depoCreado','Error1: El deposito ya esta relacionado.');	
				$id = $createdDepo['Deposito']['id'];
				$this->set('ruta','deposito ya creado');
			}else{
				unset($this->request->data['Deposito']['id']);
				$this->set('ruta','deposito NO creado');
				
			}
			if ($this->Deposito->save($this->request->data)) {
					if(!$depoCreado){
						$id = $this->Deposito->getLastInsertID();
					}
						
					$options = array(
						'conditions' => array(
							'Deposito.' . $this->Deposito->primaryKey => $id
							)
						);
					$createdDepo = $this->Deposito->find('first', $options);	
					$this->set('deposito',$createdDepo);
					$this->autoRender=false; 		
					$this->layout = 'ajax';
					$this->render('add');		
					return;									
				}
				else {
					$this->set('respuesta','Error: NO se creo el deposito. Intente de nuevo.');	
					$this->autoRender=false; 
					$this->layout = 'ajax';
					$this->render('add');
					return;
				}
		}	else {
			$this->set('respuesta','Error: NO se creo el deposito. Intente de nuevo. (500)');	
			$this->autoRender=false; 
			$this->layout = 'ajax';
			$this->render('add');
			return;
		}		
	}
	public function addajax($cliid = null,$fecha = null,$monto= null,$periodo= null,$desc= null) {
	 	$this->request->onlyAllow('ajax');

		$this->Deposito->create();
		$this->Deposito->set('cliente_id',$cliid);
		$this->Deposito->set('fecha',date('Y-m-d',strtotime($fecha)));
		$this->Deposito->set('monto',$monto);
		$this->Deposito->set('periodo',$periodo);
		$this->Deposito->set('descripcion',$desc);
		if ($this->Deposito->save($this->request->data)) {
			$this->set('respuesta','El Deposito ha sido creado.');	
			$this->set('deposito_id',$this->Deposito->getLastInsertID());
		}
		else{

		}
		$this->layout = 'ajax';
		$this->render('addajax');
	}
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Deposito->exists($id)) {
			throw new NotFoundException(__('Invalid deposito'));
		}
		if ($this->request->is('post')) {
			$depoid=$this->request->data['Deposito']['id'];
			$this->request->data('Deposito.fecha',date('Y-m-d',strtotime($this->request->data['Deposito']['fecha'.$depoid])));
			$this->request->data['Deposito']['periodo'] = $this->request->data['Deposito']['mesdesde'].'-'.$this->request->data['Deposito']['aniodesde'];
			if ($this->Deposito->save($this->request->data)) {
				//dont answer anithing bc theres just ajax call to save
				$this->set('showTheForm',false);
				$this->layout = 'ajax';
				if(!empty($this->data)){ 
					echo 'Deposito Modificado'; 
				}else{ 
					echo 'Deposito No Modificado'; 
				} 
				return ;
			}else{

			} 
				//$this->redirect(array('controller'=>'clientes','action' => 'view',$this->request->data['Deposito']['cliente_id']));		
		} else {

		}
		$options = array('conditions' => array('Deposito.' . $this->Deposito->primaryKey => $id));
		$this->request->data = $this->Deposito->find('first', $options);
		$clientes = $this->Deposito->Cliente->find('list');
		$this->set(compact('clientes','myFormReturn'));
		

		
	}
	public function editajax($id=null) {

	 	//$this->request->onlyAllow('ajax');
		if (!$this->Deposito->exists($id)) {
			throw new NotFoundException(__('Deposito Invalido'));
		}
		
		$options = array('conditions' => array('Deposito.' . $this->Deposito->primaryKey => $id));
		$this->request->data = $this->Deposito->find('first', $options);

		$optionsCli = array('conditions' => array('Cliente.id' => $this->request->data['Deposito']['cliente_id']));
		$clientes = $this->Deposito->Cliente->find('list', $optionsCli);
	
		$this->set(compact('clientes'));
		$this->set('showTheForm',$this->request->is('post'));

		$this->layout = 'ajax';
		$this->render('edit');	
	}
/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Deposito->id = $id;
		if (!$this->Deposito->exists()) {
			throw new NotFoundException(__('Invalid deposito'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Deposito->delete()) {
			$this->Session->setFlash(__('The deposito has been deleted.'));
		} else {
			$this->Session->setFlash(__('The deposito could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
