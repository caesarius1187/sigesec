<?php
App::uses('AppModel', 'Model');
/**
 * Compra Model
 *
 * @property Cliente $Cliente
 * @property Puntosdeventa $Puntosdeventa
 * @property Subcliente $Subcliente
 * @property Localidade $Localidade
 */
class Compra extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'numerocomprobante';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Cliente' => array(
			'className' => 'Cliente',
			'foreignKey' => 'cliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Puntosdeventa' => array(
			'className' => 'Puntosdeventa',
			'foreignKey' => 'puntosdeventa_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subcliente' => array(
			'className' => 'Subcliente',
			'foreignKey' => 'subcliente_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Localidade' => array(
			'className' => 'Localidade',
			'foreignKey' => 'localidade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
