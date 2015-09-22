<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'DebugKit.Toolbar',
	    'Session',
	    'Auth' => array(
            'loginAction' => array(
                'controller' => 'users',
                'action' => 'login'
            ),
            'loginRedirect' => array(
                'controller' => 'clientes',
                'action' => 'index'
            ),
            'logoutRedirect' => array(
                'controller' => 'users',
                'action' => 'login'               
            ),           
        )
	);

	public function beforeFilter() {
		set_time_limit(0);
        $this->Auth->allow('login');
    }

	public function isAuthorized($user) {
	    // Admin can access every action
	    if (isset($user['tipo']) && $user['tipo'] === 'administrador') {
	        return true;
	    }

	    // Default deny
	    return false;
	}

}
