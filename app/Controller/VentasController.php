<?php
App::uses('AppController', 'Controller');
/**
 * Ventas Controller
 *
 * @property Venta $Venta
 * @property PaginatorComponent $Paginator
 */
class VentasController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');


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

	 		
			$ventaAnterior = $this->Venta->findAllByNumerocomprobanteAndAlicuota($this->request->data['Venta']['numerocomprobante'],$this->request->data['Venta']['alicuota']);	
			if(count($ventaAnterior) != 0){
				$data = array(
		            "respuesta" => "La Venta ".$this->request->data['Venta']['numerocomprobante']." ya ha sido creada. Por favor cambie el numero de comprobante o la alicuota",
		            "venta_id" => 0,
		            "venta"=> array(),		            
		        );
		        $this->layout = 'ajax';
		        $this->set('data', $data);
				$this->render('serializejson');
				return ;
	 		}
			

			$this->Venta->create();
			if($this->request->data['Venta']['fecha']!="")
				$this->request->data('Venta.fecha',date('Y-m-d',strtotime($this->request->data['Venta']['fecha'])));				
			if ($this->Venta->save($this->request->data)) {
				$optionsPuntosDeVenta = array('conditions'=>array('Puntosdeventa.id' => $this->request->data['Venta']['puntosdeventa_id']));
				$optionsSubCliente = array('conditions'=>array('Subcliente.id'=>$this->request->data['Venta']['subcliente_id']));
				$optionsLocalidade = array('conditions'=>array('Localidade.id'=>$this->request->data['Venta']['localidade_id']));
				$this->Puntosdeventa->recursive = -1;
				$this->Subcliente->recursive = -1;
				$this->Localidade->recursive = -1;
				$data = array(
		            "respuesta" => "La Venta ha sido creada.".$this->request->data['Venta']['fecha'],
		            "venta_id" => $this->Venta->getLastInsertID(),
		            "venta"=> $this->request->data,
		            "puntosdeventa"=> $this->Puntosdeventa->find('first',$optionsPuntosDeVenta),
		            "subcliente"=> $this->Subcliente->find('first',$optionsSubCliente),
		            "localidade"=> $this->Localidade->find('first',$optionsLocalidade)
		        );
			}
			else{
				$data = array(
		        	"respuesta" => "La Venta NO ha sido creada.Intentar de nuevo mas tarde".$myfecha,
		            "venta_id" => $this->Venta->getLastInsertID()
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
		if (!$this->Venta->exists($id)) {
			throw new NotFoundException(__('Venta No Existe'));
			return;
		}
		$mostrarForm=true;
		if(!empty($this->data)){ 
			$this->request->data('Venta.fecha',date('Y-m-d',strtotime($this->request->data['Venta']['fecha'])));
			if ($this->Venta->save($this->request->data)) {
				$this->Session->setFlash(__('La Venta ha sido Modificada.'));				
			} else {
				$this->Session->setFlash(__('La Venta no ha sido Modificada. Por favor, intente de nuevo mas tarde.'));
			}
			$options = array('conditions' => array('Venta.' . $this->Venta->primaryKey => $id));
			$this->set('venta',$this->Venta->find('first', $options));
			$mostrarForm=false;			
		}
		$this->set('mostrarForm',$mostrarForm);	
		$options = array('conditions' => array('Venta.' . $this->Venta->primaryKey => $id));
		$this->request->data = $this->Venta->find('first', $options);
		
		$this->set('venid',$id);
		
	   	$conditionspuntosdeventa = array('Puntosdeventa.cliente_id' => $this->request->data['Venta']['cliente_id'],);
		$puntosdeventas = $this->Puntosdeventa->find('list',array('conditions' =>$conditionspuntosdeventa));	
		$this->set(compact('puntosdeventas'));

		$conditionsSubClientes = array('Subcliente.cliente_id' => $this->request->data['Venta']['cliente_id'],);
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
		/*$this->Contacto->id = $id;
		if (!$this->Contacto->exists()) {
			throw new NotFoundException(__('Invalid contacto'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Contacto->delete()) {
			$this->Session->setFlash(__('The contacto has been deleted.'));
		} else {
			$this->Session->setFlash(__('The contacto could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));*/
	}}
