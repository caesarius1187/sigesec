<?php
App::uses('AppController', 'Controller');
/**
 * Compras Controller
 *
 * @property Compra $Compra
 * @property PaginatorComponent $Paginator
 */
class ComprasController extends AppController {

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
		$this->Compra->recursive = 0;
		$this->set('compras', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Compra->exists($id)) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$options = array('conditions' => array('Compra.' . $this->Compra->primaryKey => $id));
		$this->set('compra', $this->Compra->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Compra->create();
			if ($this->Compra->save($this->request->data)) {
				$this->Session->setFlash(__('The compra has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The compra could not be saved. Please, try again.'));
			}
		}
		$clientes = $this->Compra->Cliente->find('list');
		$puntosdeventas = $this->Compra->Puntosdeventum->find('list');
		$subclientes = $this->Compra->Subcliente->find('list');
		$localidades = $this->Compra->Localidade->find('list');
		$this->set(compact('clientes', 'puntosdeventas', 'subclientes', 'localidades'));
	}

/**
 * add method
 *
 * @return void
 */
	public function addajax(){
	 	//$this->request->onlyAllow('ajax');
	 	$this->loadModel('Subcliente');
	 	$this->loadModel('Localidade');
	 	$this->loadModel('Puntosdeventa');
	 	$this->autoRender=false; 
	 	if ($this->request->is('post')) { 		
	 		//Preguntar si hay que filtrar por numero de comprobante y alicuota tambien aqui
			$compraAnterior = $this->Compra->findAllByNumerocomprobanteAndAlicuota($this->request->data['Compra']['numerocomprobante'],$this->request->data['Compra']['alicuota']);	
			if(count($compraAnterior) != 0){
				$data = array(
		            "respuesta" => "La Compra ".$this->request->data['Compra']['numerocomprobante']." ya ha sido creada. Por favor cambie el numero de comprobante o la alicuota",
		            "compra_id" => 0,
		            "compra"=> array(),		            
		        );
		        $this->layout = 'ajax';
		        $this->set('data', $data);
				$this->render('serializejson');
				return ;
	 		}
			

			$this->Compra->create();
			if($this->request->data['Compra']['fecha']!="")
				$this->request->data('Compra.fecha',date('Y-m-d',strtotime($this->request->data['Compra']['fecha'])));				
			if ($this->Compra->save($this->request->data)) {
				$optionsPuntosDeVenta = array('conditions'=>array('Puntosdeventa.id' => $this->request->data['Compra']['puntosdeventa_id']));
				$optionsSubCliente = array('conditions'=>array('Subcliente.id'=>$this->request->data['Compra']['subcliente_id']));
				$optionsLocalidade = array('conditions'=>array('Localidade.id'=>$this->request->data['Compra']['localidade_id']));
				$this->Puntosdeventa->recursive = -1;
				$this->Subcliente->recursive = -1;
				$this->Localidade->recursive = -1;
				$data = array(
		            "respuesta" => "La Compra ha sido creada.".$this->request->data['Compra']['fecha'],
		            "compra_id" => $this->Compra->getLastInsertID(),
		            "compra"=> $this->request->data,
		            "puntosdeventa"=> $this->Puntosdeventa->find('first',$optionsPuntosDeVenta),
		            "subcliente"=> $this->Subcliente->find('first',$optionsSubCliente),
		            "localidade"=> $this->Localidade->find('first',$optionsLocalidade)
		        );
			}
			else{
				$data = array(
		        	"respuesta" => "La Compra NO ha sido creada.Intentar de nuevo mas tarde",
		            "compra_id" => $this->Compra->getLastInsertID()
		        );
			}
			$this->layout = 'ajax';
	        $this->set('data', $data);
			$this->render('serializejson');
			
			}
		}
	
/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->loadModel('Subcliente');
		$this->loadModel('Localidade');
		$this->loadModel('Partido');
		$this->loadModel('Puntosdeventa');
		if (!$this->Compra->exists($id)) {
			throw new NotFoundException(__('Compra No Existe'));
			return;
		}
		$mostrarForm=true;
		if(!empty($this->data)){ 
			$this->request->data('Compra.fecha',date('Y-m-d',strtotime($this->request->data['Compra']['fecha'])));
			if ($this->Compra->save($this->request->data)) {
				$this->Session->setFlash(__('La Compra ha sido Modificada.'));				
			} else {
				$this->Session->setFlash(__('La Compra no ha sido Modificada. Por favor, intente de nuevo mas tarde.'));
			}
			$options = array('conditions' => array('Compra.' . $this->Compra->primaryKey => $id));
			$this->set('compra',$this->Compra->find('first', $options));
			$mostrarForm=false;			
		}
		$this->set('mostrarForm',$mostrarForm);	
		$options = array('conditions' => array('Compra.' . $this->Compra->primaryKey => $id));
		$this->request->data = $this->Compra->find('first', $options);
		
		$this->set('comid',$id);
		
	   	$conditionspuntosdeventa = array('Puntosdeventa.cliente_id' => $this->request->data['Compra']['cliente_id'],);
		$puntosdeventas = $this->Puntosdeventa->find('list',array('conditions' =>$conditionspuntosdeventa));	
		$this->set(compact('puntosdeventas'));

		$conditionsSubClientes = array('Subcliente.cliente_id' => $this->request->data['Compra']['cliente_id'],);
		$subclientes = $this->Subcliente->find('list',array('conditions' =>$conditionsSubClientes));	
		$this->set(compact('subclientes'));

		$localidades = $this->Localidade->find('list');
		$this->set('localidades', $localidades);
		
		$partidos = $this->Partido->find('list');
		$this->set('partidos', $partidos);

		$alicuotas = array("10,50" => '10,50',"20,10" => '20,10',"50,50" => '50,50',);
		$this->set('alicuotas', $alicuotas);

		$this->layout = 'ajax';
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Compra->id = $id;
		if (!$this->Compra->exists()) {
			throw new NotFoundException(__('Invalid compra'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Compra->delete()) {
			$this->Session->setFlash(__('The compra has been deleted.'));
		} else {
			$this->Session->setFlash(__('The compra could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}}
