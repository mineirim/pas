<?php
error_reporting(E_ALL);

/**
 * LoginController
 * 
 * @author Marcone Costa
 * @version 
 * 
 * 
 */

require_once 'Zend/Controller/Action.php';

class AuthController extends Zend_Controller_Action {
	/**
	 * The default action - show the home page
	 */
	public function indexAction() {
		$this->view->noLayout = true;  
		$auth = Zend_Auth::getInstance ();  
		$this->view->auth = $auth->hasIdentity ();  
	}
	public function loginAction() {
		if (! ($this->_request->isPost ()))
				$this->_redirect ( '/' );
		    
		// I assume that you have already create a working DB Adapter.
		// I use $dbadaper for my Zend_Db Adapter
		try {
			/**
			 * 
			 *$config = Zend_Registry::get ( 'config' );
			 *$db = Zend_Db::factory ( $config->database );
			 **/
			$db = Zend_Registry::get('db');// Model_Usuarios::getDefaultAdapter();
			
			// Get the Database Table Adapter for Zend_Auth
			Zend_Loader::loadClass ( 'Zend_Auth_Adapter_DbTable' );
			$authadapter = new Zend_Auth_Adapter_DbTable($db);
			
			// Assign the authentication informations to the adapter
			$authadapter->setTableName ( 'usuarios' )
						->setIdentityColumn ( 'username' )
						->setCredentialColumn ( 'password' )
						->setCredentialTreatment ( "MD5(  ? || salt)" );
			//Zend_Registry::set('auth', $authadapter);
			$filter = new Zend_Filter ( );
			$filter->addFilter ( new Zend_Filter_StringTrim ( ) )->addFilter ( new Zend_Filter_StripTags ( ) )->addFilter ( new Zend_Filter_Alnum ( ) );
		
			// Give the adapter the username and the password
			$username = $filter->filter ( $this->_request->getPost ( 'username' ) );
			$password = $filter->filter ( $this->_request->getPost ( 'password' ));
			$authadapter->setIdentity ( $username )->setCredential ( $password);
			
			
			
			// Check it
			
			$auth = Zend_Auth::getInstance();
			$auth->clearIdentity();
			$auth->getStorage()->clear();
			$result =$authadapter->authenticate() ;//  $auth->authenticate ($authadapter);
			
			$zf_auth = Zend_Auth::getInstance();
			
			
			
			if ($result->isValid ()) {
				
				$usuarios = new Model_Usuarios();
				
				// It is a valid login, store it in the auth storage, but dont save the password and the salt
				$zf_auth = Zend_Auth::getInstance();
				$auth->getStorage ()->write ( $authadapter->getResultRowObject ( null, array ('password', 'salt' ) ) );
				
				
				$acl = new App_Myacl(Zend_Auth::getInstance());
				
				$mysession = new Zend_Session_Namespace('mysession');
				$mysession->acl =$acl;
				// Redirect to start page
				if(Zend_Session::namespaceIsset('goto') ){
				    $goto = new Zend_Session_Namespace('goto');
					$module = $goto->module;
					$controller =$goto->controller; 
					$action =$goto->action; 
					$params = $goto->params; 
					Zend_Session::namespaceUnset('goto');
					
		    		$this->_redirect($controller."/".$action);
		    		//$this->_forward($action,$controller,$module,$params);
		    		
		    	}else{
					$this->_redirect ( 'index/index' );
		    	}
			} else {
				// Not valid, show the loginform
				$this->view->errormessage = "Username or Password false.";
				$mensagem = "Erro";
				
			}
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$mensagem = "{success:false, dados: {code: '4'}}";
			
		} catch ( Zend_Exception $e ) {
			$mensagem = "{success:false, dados: {code: '5'}}";
			echo $e->getMessage();
		}
		$this->getResponse ()->clearBody ();
		$this->getResponse ()->setHeader ( 'Content-Type', 'text/html; charset=utf-8' );
		$this->getResponse ()->setBody ( $mensagem );
		
	}

	function logoutAction() {
		Zend_Registry::_unsetInstance ();
		Zend_Auth::getInstance ()->clearIdentity ();
		Zend_Session::destroy();
		$this->_redirect ( '/auth' );
	}
}



