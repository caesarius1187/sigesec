<?php
App::uses('AppModel', 'Model');
/**
 * Ingreso Model
 *
 * @property Cliente $Cliente
 */
class Ingreso extends AppModel {


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
		)
	);
}
