<?php
App::uses('AppController', 'Controller');
/**
 * Impclis Controller
 *
 * @property Impcli $Impcli
 * @property PaginatorComponent $Paginator
 */
class ImpclisController extends AppController {

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
		$this->Impcli->recursive = 0;
		$this->set('impclis', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Impcli->exists($id)) {
			throw new NotFoundException(__('Invalid impcli'));
		}
		$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $id));
		$this->set('impcli', $this->Impcli->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$resp ="";
		if ($this->request->is('post')) {
			$this->Impcli->create();
			$this->request->data['Impcli']['desde'] = $this->request->data['Impcli']['mesdesde'].'-'.$this->request->data['Impcli']['aniodesde'];
			$this->request->data['Impcli']['hasta'] = $this->request->data['Impcli']['meshasta'].'-'.$this->request->data['Impcli']['aniohasta'];

			if ($this->Impcli->save($this->request->data)) {
				$resp = $resp ."Se relaciono  impuesto para cliente.";
				$impcli_id = $this->Impcli->getLastInsertID();

			}
			else{
				$resp = $resp ."NO se relaciono impuesto para cliente. Intente de nuevo";
			}
		}
		$this->set('impcli_id',$impcli_id);
		$this->set('respuesta',$resp);	

		$this->layout = 'ajax';
		$this->render('addajax');
	}
	public function addbancosindicato() {
		
		if ($this->request->is('post')) {

			$this->request->data['Impcli']['desde'] = $this->request->data['Impcli']['mesdesde'].'-'.$this->request->data['Impcli']['aniodesde'];
			$this->request->data['Impcli']['hasta'] = $this->request->data['Impcli']['meshasta'].'-'.$this->request->data['Impcli']['aniohasta'];

			$this->Impcli->create();
			if ($this->Impcli->save($this->request->data)) {
				$this->Session->setFlash(__('Se relaciono  con exito.'));
				return $this->redirect(array('controller'=>'Clientes','action' => 'index', $this->request->data['cliente_id']));
			} else {
				$this->Session->setFlash(__('NO se relaciono  con exito.Por favor intentelo mas tarde'));
			}
		}
		$clientes = $this->Impcli->Cliente->find('list');
		$impuestos = $this->Impcli->Impuesto->find('list');
		$this->set(compact('clientes', 'impuestos'));
	}
	public function addajax(){
	 	$this->request->onlyAllow('ajax');
		$this->loadModel('Organismosxcliente');
		$resp="";
		$impcli_id="0";
		
		if(($impid==0)||($impid==null)){
			$resp = $resp ."No se relaciono ningun impuesto para cliente.";
		}else{
			$this->Impcli->create();
			$this->Impcli->set('cliente_id',$cliid);
			$this->Impcli->set('impuesto_id',$impid);
			$this->Impcli->set('descripcion',$desc);
			$this->Impcli->set('desde',$desde);
			$this->Impcli->set('hasta',$hasta);
			$this->Impcli->set('estado','habilitado');
			if ($this->Impcli->save($this->request->data)) {
				$resp = $resp ."Se relaciono  impuesto para cliente.";
				$impcli_id = $this->Impcli->getLastInsertID();

			}
			else{
				$resp = $resp ."NO se relaciono impuesto para cliente. Intente de nuevo";
			}
		}
		$this->set('impcli_id',$impcli_id);
		$this->set('respuesta',$resp);	

		$this->layout = 'ajax';
		$this->render('addajax');
	}/*
	public function addajax($cliid = null,$impid = null,$desc= null,$desde = null,$hasta= null,
		$id = null,$tipoorganismo = null,$estado= null,
		$usuario = null,$clave = null,
		$vencimiento = null,$descripcion = null,
		$expediente = null,$observaciones = null) {
	 	$this->request->onlyAllow('ajax');
		$this->loadModel('Organismosxcliente');
		$resp="";
		$impcli_id="0";
		if ($this->Organismosxcliente->exists($id)) {
			$this->Organismosxcliente->read(null, $id);
			$this->Organismosxcliente->set('tipoorganismo',$tipoorganismo);
			$this->Organismosxcliente->set('estado',$estado);
			$this->Organismosxcliente->set('usuario',$usuario);
			$this->Organismosxcliente->set('clave',$clave);
			$this->Organismosxcliente->set('vencimiento',date('Y-m-d',strtotime($vencimiento)));
			$this->Organismosxcliente->set('descripcion',$descripcion);
			$this->Organismosxcliente->set('expediente',$expediente);
			$this->Organismosxcliente->set('observaciones',$observaciones);

			if ($this->Organismosxcliente->save()) {
				$resp= $resp."Organismo guardado.";	
			} else {
				$resp= $resp."Organismo NO guardado. Intente de nuevo";	
			}
		}else{
			$resp= $resp."Organismo NO existe. Intente de nuevo" ;
		}
		if(($impid==0)||($impid==null)){
			$resp = $resp ."No se relaciono ningun impuesto para cliente.";
		}else{
			$this->Impcli->create();
			$this->Impcli->set('cliente_id',$cliid);
			$this->Impcli->set('impuesto_id',$impid);
			$this->Impcli->set('descripcion',$desc);
			$this->Impcli->set('desde',$desde);
			$this->Impcli->set('hasta',$hasta);
			$this->Impcli->set('estado','habilitado');
			if ($this->Impcli->save($this->request->data)) {
				$resp = $resp ."Se relaciono  impuesto para cliente.";
				$impcli_id = $this->Impcli->getLastInsertID();

			}
			else{
				$resp = $resp ."NO se relaciono impuesto para cliente. Intente de nuevo";
			}
		}
		$this->set('impcli_id',$impcli_id);
		$this->set('respuesta',$resp);	

		$this->layout = 'ajax';
		$this->render('addajax');
	}*/
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Impcli->exists($id)) {
			throw new NotFoundException(__('Invalid impcli'));
		}
		if ($this->request->is('post')) {
			
			if ($this->Impcli->save($this->request->data)) {
				//dont answer anithing bc theres just ajax call to save
				$this->set('showTheForm',false);
				$this->layout = 'ajax';
				if(!empty($this->data)){ 
					echo 'Impuesto Modificado'; 
				}else{ 
					echo 'Impuesto No Modificado'; 
				} 
				$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $id));
				$this->request->data = $this->Impcli->find('first', $options);
				return ;
			} else {

			}
		} else {
			
		}
		$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $id));
		$this->request->data = $this->Impcli->find('first', $options);
		$clientes = $this->Impcli->Cliente->find('list');
		$impuestos = $this->Impcli->Impuesto->find('list');
		$this->set(compact('clientes', 'impuestos'));
	}
	public function editajax($id=null,$cliid = null) {

	 	//$this->request->onlyAllow('ajax');
		$this->loadModel('Clientes');
		if (!$this->Impcli->exists($id)) {
			throw new NotFoundException(__('Impuesto de Cliente Invalido'));
		}
		
		$options = array('conditions' => array('Impcli.' . $this->Impcli->primaryKey => $id));
		$this->request->data = $this->Impcli->find('first', $options);

		$optionsCli = array('conditions' => array('Cliente.id' => $cliid));
		$clientes = $this->Impcli->Cliente->find('list', $optionsCli);

		$optionsImp = array('conditions' => array('Impuesto.id' => $this->request->data['Impcli']['impuesto_id']));
		$impuestos = $this->Impcli->Impuesto->find('list', $optionsImp);
		
		$this->set(compact('clientes', 'impuestos'));
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
		$this->Impcli->id = $id;
		if (!$this->Impcli->exists()) {
			throw new NotFoundException(__('Invalid impcli'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Impcli->delete()) {
			$this->Session->setFlash(__('The impcli has been deleted.'));
		} else {
			$this->Session->setFlash(__('The impcli could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
