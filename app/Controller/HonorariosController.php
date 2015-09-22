<?php
App::uses('AppController', 'Controller');
/**
 * Honorarios Controller
 *
 * @property Honorario $Honorario
 * @property PaginatorComponent $Paginator
 */
class HonorariosController extends AppController {

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
		$this->Honorario->recursive = 0;
		$this->set('honorarios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Honorario->exists($id)) {
			throw new NotFoundException(__('Invalid honorario'));
		}
		$options = array('conditions' => array('Honorario.' . $this->Honorario->primaryKey => $id));
		$this->set('honorario', $this->Honorario->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Honorario->create();
			if ($this->Honorario->save($this->request->data)) {
				$this->Session->setFlash(__('The honorario has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The honorario could not be saved. Please, try again.'));
			}
		}
		$clientes = $this->Honorario->Cliente->find('list');
		$this->set(compact('clientes'));
	}
	public function addajax($cliid = null,$fecha = null,$monto= null,$periodo= null,$desc= null) {
	 	$this->request->onlyAllow('ajax');

		$this->Honorario->create();
		$this->Honorario->set('cliente_id',$cliid);

		$this->Honorario->set('fecha',date('Y-m-d',strtotime($fecha)));
		
		$this->Honorario->set('monto',$monto);
		$this->Honorario->set('periodo',$periodo);
		$this->Honorario->set('descripcion',$desc);
		$this->Honorario->set('estado','no pagado');

		if ($this->Honorario->save($this->request->data)) {
			$this->set('respuesta','El Honorario ha sido creado.');	
			$this->set('honorario_id',$this->Honorario->getLastInsertID());
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
		if (!$this->Honorario->exists($id)) {
			throw new NotFoundException(__('Invalid honorario'));
		}
		if ($this->request->is('post')) {
			$honoid=$this->request->data['Honorario']['id'];
			$this->request->data['Honorario']['fecha'] =date('Y-m-d',strtotime($this->request->data['Honorario']['fecha'.$honoid]));
			$this->request->data['Honorario']['periodo'] = $this->request->data['Honorario']['mesdesde'].'-'.$this->request->data['Honorario']['aniodesde'];

			if ($this->Honorario->save($this->request->data)) {
				//dont answer anithing bc theres just ajax call to save
				$this->set('showTheForm',false);
				$this->layout = 'ajax';
				if(!empty($this->data)){ 
					echo 'Honorario Modificado'; 
				}else{ 
					echo 'Honorario No Modificado'; 
				} 
				return ;
			}else{

			} 
		} else {
			
		}
		$options = array('conditions' => array('Honorario.' . $this->Honorario->primaryKey => $id));
		$this->request->data = $this->Honorario->find('first', $options);
		$clientes = $this->Honorario->Cliente->find('list');
		$this->set(compact('clientes'));
	}
	public function editajax($id=null) {

	 	//$this->request->onlyAllow('ajax');
		if (!$this->Honorario->exists($id)) {
			throw new NotFoundException(__('Honorario Invalido'));
		}
		
		$options = array('conditions' => array('Honorario.' . $this->Honorario->primaryKey => $id));
		$this->request->data = $this->Honorario->find('first', $options);

		$optionsCli = array('conditions' => array('Cliente.id' => $this->request->data['Honorario']['cliente_id']));
		$clientes = $this->Honorario->Cliente->find('list', $optionsCli);
	
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
		$this->Honorario->id = $id;
		if (!$this->Honorario->exists()) {
			throw new NotFoundException(__('Invalid honorario'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Honorario->delete()) {
			$this->Session->setFlash(__('The honorario has been deleted.'));
		} else {
			$this->Session->setFlash(__('The honorario could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
