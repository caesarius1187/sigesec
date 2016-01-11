<?php
App::uses('AppModel', 'Model');
/**
 * Actividadcliente Model
 *
 * @property Cliente $Cliente
 * @property Actividade $Actividade
 */
class Actividadcliente extends AppModel {


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
		'Actividade' => array(
			'className' => 'Actividade',
			'foreignKey' => 'actividade_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
