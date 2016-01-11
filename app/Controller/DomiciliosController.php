<?php
App::uses('AppController', 'Controller');
/**
 * Direcciones Controller
 *
 * @property Domicilios $Domicilios
 * @property PaginatorComponent $Paginator
 */
class DomiciliosController extends AppController {

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
		$this->Domicilio->recursive = 0;
		$this->set('domicilios', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Domicilio->exists($id)) {
			throw new NotFoundException(__('Invalid domicilio'));
		}
		$options = array('conditions' => array('Domicilio.' . $this->Domicilio->primaryKey => $id));
		$this->set('domicilio', $this->Domicilio->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Domicilio->create();
			if ($this->Domicilio->save($this->request->data)) {
				$id = $this->Domicilio->getLastInsertID();
				$options = array(
				 'contain'=>array(
				      'Cliente',
				      'Localidade'=>array(
				         'Partido'=>array(
				         ),
						)									       
				    ),
				'conditions' => array(
					'Domicilio.' . $this->Domicilio->primaryKey => $id
					)
				);
				$this->set('domicilio', $this->Domicilio->find('first', $options));
			} else {
				$this->set('respuesta','El Domicilio No ha sido creado.');	
			}
		}
				
		$this->layout = 'ajax';
		$this->render('addajax');
	}
	public function addajax(
		$cliid = null,$tipo = null,$sede= null,$nombrefantasia= null,$puntodeventa= null,
		$localidadeid = null,$calle= null,$numero= null,$piso= null,$ofidepto = null,
		$ruta= null,$kilometro= null,$torre= null,$manzana = null,$entrecalles= null,
		$codigopostal= null,$telefono= null,$movil= null,$fax = null,$email= null,
		$personacontacto= null,$observaciones= null) {

	 	$this->request->onlyAllow('ajax');

		$this->Domicilio->create();
		$this->Domicilio->set('cliente_id',$cliid);
		$this->Domicilio->set('tipo',$tipo);
		$this->Domicilio->set('sede',$sede);
		$this->Domicilio->set('nombrefantasia',$nombrefantasia);
		$this->Domicilio->set('puntodeventa',$puntodeventa);

		$this->Domicilio->set('localidade_id',$localidadeid);
		$this->Domicilio->set('calle',$calle);
		$this->Domicilio->set('numero',$numero);
		$this->Domicilio->set('piso',$piso);
		$this->Domicilio->set('ofidepto',$ofidepto);

		$this->Domicilio->set('ruta',$ruta);
		$this->Domicilio->set('kilometro',$kilometro);
		$this->Domicilio->set('torre',$torre);
		$this->Domicilio->set('manzana',$manzana);
		$this->Domicilio->set('entrecalles',$entrecalles);

		$this->Domicilio->set('codigopostal',$codigopostal);
		$this->Domicilio->set('telefono',$telefono);
		$this->Domicilio->set('movil',$movil);
		$this->Domicilio->set('fax',$fax);
		$this->Domicilio->set('email',$email);

		$this->Domicilio->set('personacontacto',$personacontacto);
		$this->Domicilio->set('observaciones',$observaciones);


		if ($this->Domicilio->save($this->request->data)) {
			$this->set('respuesta','El Domicilio ha sido creado.');	
			$this->set('domicilio_id',$this->Domicilio->getLastInsertID());
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
	public function edit($id = null) 
	{
		$this->loadModel('Partido');
		if (!$this->Domicilio->exists($id)) {
			throw new NotFoundException(__('Invalid direccione'));
		}
		if ($this->request->is('post')) {
			if ($this->Domicilio->save($this->request->data)) {
			} else {
			}
		} else {
			$options = array('conditions' => array('Domicilio.' . $this->Domicilio->primaryKey => $id));
			$this->request->data = $this->Domicilio->find('first', $options);
		}
		$clientes = $this->Domicilio->Cliente->find('list');
		$partidos = $this->Partido->find('list');
		$localidades = $this->Domicilio->Localidade->find('list');
		$mostrarFormulario=false;

		$options = array(
			 'contain'=>array(
			      'Cliente',
			      'Localidade'=>array(
			         'Partido'=>array(
			         ),
					)									       
			    ),
			'conditions' => array(
				'Domicilio.' . $this->Domicilio->primaryKey => $id
				)
			);
		$domicilio = $this->Domicilio->find('first', $options);
		$this->set(compact('clientes', 'localidades','partidos','mostrarFormulario','domicilio'));
		
		$this->layout = 'ajax';
		$this->render('edit');		
	}

	public function editajax($id=null,$cliid = null) 
	{
		$this->loadModel('Partido');
	 	//$this->request->onlyAllow('ajax');

		if (!$this->Domicilio->exists($id)) {
			throw new NotFoundException(__('Invalid direccione'));
		}
		
		$options = array('conditions' => array('Domicilio.' . $this->Domicilio->primaryKey => $id));
		$this->request->data = $this->Domicilio->find('first', $options);

		$optionsCli = array('conditions' => array('Cliente.id' => $cliid));
		$clientes = $this->Domicilio->Cliente->find('list', $optionsCli);

		$partidos = $this->Partido->find('list');

		$optionsLoc = array(
			'conditions' => array(
					'Localidade.partido_id' => $this->request->data['Localidade']['partido_id']
								)
			);
		$localidades = $this->Domicilio->Localidade->find('list',$optionsLoc);
		$mostrarFormulario=true;
		$this->set(compact('clientes', 'localidades','partidos','mostrarFormulario'));

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
	public function delete($id = null, $cliid=null) {
		$this->Domicilio->id = $id;
		if (!$this->Domicilio->exists()) {
			throw new NotFoundException(__('Invalid direccione'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Domicilio->delete()) {
			$this->Session->setFlash(__('El domicilio a sido eliminado'));
		} else {
			$this->Session->setFlash(__('No se ha podido eliminar el domicilio'));
		}
		return $this->redirect(array(
			'controller'=>'clientes',
			'action' => 'view',
			$cliid));
	}}
