<?php
App::uses('AppController', 'Controller');
/**
 * Personasrelacionadas Controller
 *
 * @property Personasrelacionada $Personasrelacionada
 * @property PaginatorComponent $Paginator
 */
class PersonasrelacionadasController extends AppController {

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
		$this->Personasrelacionada->recursive = 0;
		$this->set('personasrelacionadas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Personasrelacionada->exists($id)) {
			throw new NotFoundException(__('Invalid personasrelacionada'));
		}
		$options = array('conditions' => array('Personasrelacionada.' . $this->Personasrelacionada->primaryKey => $id));
		$this->set('personasrelacionada', $this->Personasrelacionada->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Personasrelacionada->create();
			$this->request->data('Personasrelacionada.vtomandato',date('Y-m-d',strtotime($this->request->data['Personasrelacionada']['vtomandato'])));
			if ($this->Personasrelacionada->save($this->request->data)) {
				$this->Session->setFlash(__('La Persona Relacionada ha sido Guardada.'));
				return $this->redirect(array('controller'=>'clientes','action' => 'view',$this->request->data['Personasrelacionada']['cliente_id']));
			} else {
				$this->Session->setFlash(__('La Persona Relacionada no ha sido Guardada. Por favor intente de nuevo mas tarde'));
			}
		}
		$clientes = $this->Personasrelacionada->Cliente->find('list');
		$localidades = $this->Personasrelacionada->Localidade->find('list');
		$this->set(compact('clientes', 'localidades'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Personasrelacionada->exists($id)) {
			throw new NotFoundException(__('Invalid personasrelacionada'));
		}
		if ($this->request->is('post')) {
			$this->request->data('Personasrelacionada.vtomandato',date('Y-m-d',strtotime($this->request->data['Personasrelacionada']['vtomandatoedit'])));
			if ($this->Personasrelacionada->save($this->request->data)) {
				$this->Session->setFlash(__('La Persona Relacionada ha sido Modificada.'));
				return $this->redirect(array('controller'=>'clientes','action' => 'view',$this->request->data['Personasrelacionada']['cliente_id']));
			} else {
				$this->Session->setFlash(__('La Persona Relacionada no ha sido Modificada. Por favor intente de nuevo mas tarde'));
			}
		} else {
			$options = array('conditions' => array('Personasrelacionada.' . $this->Personasrelacionada->primaryKey => $id));
			$this->request->data = $this->Personasrelacionada->find('first', $options);
		}
		$clientes = $this->Personasrelacionada->Cliente->find('list');
		$localidades = $this->Personasrelacionada->Localidade->find('list');
		$this->set(compact('clientes', 'localidades'));
	}
	public function editajax(
				$id=null,$cliid = null) {
		$this->loadModel('Partido');
		$this->loadModel('Localidade');
	 	//$this->request->onlyAllow('ajax');

		if (!$this->Personasrelacionada->exists($id)) {
			throw new NotFoundException(__('Invalid direccione'));
		}
		
		$options = array('conditions' => array('Personasrelacionada.' . $this->Personasrelacionada->primaryKey => $id));
		$this->request->data = $this->Personasrelacionada->find('first', $options);

		$optionsCli = array('conditions' => array('Cliente.id' => $cliid));
		$clientes = $this->Personasrelacionada->Cliente->find('list', $optionsCli);

		$partidos = $this->Partido->find('list');
		$this->set('partidos', $partidos);
		
		$optionsLoc = array(
				'conditions' => array(
									'Localidade.partido_id' => $this->request->data['Localidade']['partido_id']
							)
		);			

		$localidades = $this->Localidade->find('list',$optionsLoc);
		$this->set('localidades', $localidades);

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
		$this->Personasrelacionada->id = $id;
		if (!$this->Personasrelacionada->exists()) {
			throw new NotFoundException(__('Invalid personasrelacionada'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Personasrelacionada->delete()) {
			$this->Session->setFlash(__('The personasrelacionada has been deleted.'));
		} else {
			$this->Session->setFlash(__('The personasrelacionada could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
