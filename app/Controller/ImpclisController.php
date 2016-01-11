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
		$this->loadModel('Periodosactivo');
		if ($this->request->is('post')) {
			$this->Impcli->create();
			//tenemos que revisar si ya esta creado el impcli del impuesto seleccionado
			//vamos a buscar un impcli con el impcli_id y el cliente_id que nos viene en $this->request->data
			$id = 0;
			$options = array(
					'contain'=>array(
						'Periodosactivo'=>array(
												'conditions' => array(
								                'Periodosactivo.hasta' => null, 
								            ),
						        	 	), 
						'Impuesto'						
						),
					'conditions' => array(
						'Impcli.impuesto_id'=> $this->request->data['Impcli']['impuesto_id'],
						'Impcli.cliente_id'=> $this->request->data['Impcli']['cliente_id'],
						)
					);
			$createdImp = $this->Impcli->find('first', $options);
			$impcliCreado= false;
			
			if(count($createdImp)>0){
				//el impcli ya esta creado por lo que ahora resta buscar los periodos activos y ver si se puede crear uno
				$impcliCreado= true;
				$this->set('impcliCreado','Error1: El impuesto ya esta relacionado, se cargo el periodo activo.');	

				$id = $createdImp['Impcli']['id'];
			}else{
				//el impcli no existe y lo creamos por aqui
				if ($this->Impcli->save($this->request->data)) {
					$id = $this->Impcli->getLastInsertID();
					$options = array(
						'contain'=>array(
							'Periodosactivo'=>array(
												'conditions' => array(
								                'Periodosactivo.hasta' => null, 
								            ),
						        	 	), 
							'Impuesto'
						),
						'conditions' => array(
							'Impcli.' . $this->Impcli->primaryKey => $id
							)
						);
					$createdImp = $this->Impcli->find('first', $options);									
				}
				else{
					$this->set('respuesta','Error: NO se relaciono impuesto para cliente. Intente de nuevo.');	
					$this->autoRender=false; 
					$this->layout = 'ajax';
					$this->render('add');
					return;
				}
			}		
			//si pasa esos dos controles agregamos la fecha de alta como un nuevo periodoactivo
			$periodoAbierto= false;
			$altaContenidaEnPeriodo= false;
			foreach ($createdImp['Periodosactivo'] as $periodoactivo) {

				//tenemos que buscar los periodos activos.. si tiene uno sin cerrar no agregamos nada
			    if(is_null($periodoactivo['hasta']) || empty($periodoactivo['hasta'])){
			    	$periodoAbierto= true;
			    }
			    //hay 3 campos que pueden tener el valor de periodo alta: alta, altadgr, altadgrm
			    //cualquiera de los 3 que sea != null se guarda en alta
			    
				//si tiene todos cerrados tenemos que ver que los periodos no contengan a la fecha de alta
			    if($periodoactivo['desde'] <=  $this->request->data['Impcli']['alta']
			    	&&
			    	$periodoactivo['hasta'] >=  $this->request->data['Impcli']['alta']){
			    	$altaContenidaEnPeriodo= true;
			    }
			}

			if(!$periodoAbierto && !$altaContenidaEnPeriodo){
				$this->Periodosactivo->create();
				$this->Periodosactivo->set('impcli_id',$id);
				$this->Periodosactivo->set('desde',$this->request->data['Impcli']['alta']);
				if ($this->Periodosactivo->save()) {
					$this->set('Periodoalta',$this->request->data['Impcli']['alta']);
				}else{
					$this->set('respuesta','Error: NO se pudo dar de alta el impuesto(440). Intentelo de nuevo mas tarde.');	
					$this->autoRender=false; 
					$this->layout = 'ajax';
					$this->render('add');
					return;
				}
			}else{
				if($periodoAbierto){
					$this->set('respuesta','Error: NO se pudo dar de alta el impuesto(ya existe un periodo activo abierto para este impuesto). Intentelo de nuevo mas tarde.');	
				}else if($altaContenidaEnPeriodo){
					$this->set('respuesta','Error: NO se pudo dar de alta el impuesto(el periodo de alta ya esta contenido en otro periodo activo). Intentelo de nuevo mas tarde.');	
				}else{
					$this->set('respuesta','Error: NO se pudo dar de alta el impuesto(441). Intentelo de nuevo mas tarde.');	
				}
				$this->autoRender=false; 
				$this->layout = 'ajax';
				$this->render('add');
				return;
			}
			$this->set('impcli',$createdImp);
			$this->autoRender=false; 		
		}
		$this->layout = 'ajax';
		$this->render('add');
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
	}
	
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
