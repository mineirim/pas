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
			$result = $authadapter->authenticate ();
			if ($result->isValid ()) {
				// It is a valid login, store it in the auth storage, but dont save the password and the salt
				$zf_auth = Zend_Auth::getInstance();
				$zf_auth->getStorage ()->write ( $authadapter->getResultRowObject ( null, array ('password', 'salt' ) ) );
				
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
				return $this->indexAction ();
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
	public function logarAction() {
		if (! ($this->_request->isPost ()))
			$this->_redirect ( '/' );
		
		try {
			$filter = new Zend_Filter ( );
			$filter->addFilter ( new Zend_Filter_StringTrim ( ) )->addFilter ( new Zend_Filter_StripTags ( ) )->addFilter ( new Zend_Filter_Alnum ( ) );
			
			$nome = $filter->filter ( $this->_request->getPost ( 'nome' ) );
			$senha = $filter->filter ( $this->_request->getPost ( 'senha' ) );
			
			$config = Zend_Registry::get ( 'config' );
			$db = Zend_Db::factory ( $config->database );
			
			$authAdapter = new Zend_Auth_Adapter_DbTable ( $db );
			$authAdapter->setTableName ( "Usuarios" )->setIdentityColumn ( "Login" )->setCredentialColumn ( "Senha" )->setCredentialTreatment ( 'MD5(?)' )->setIdentity ( $nome )->setCredential ( $senha );
			
			$result = Zend_Auth::getInstance ()->authenticate ( $authAdapter );
			
			$db->closeConnection ();
			
			switch ($result->getCode ()) {
				case Zend_Auth_Result::SUCCESS :
					$data = $authAdapter->getResultRowObject ( null, "Senha" );
					if ($data->Nivel_Acesso > 0) {
						Zend_Auth::getInstance ()->getStorage ()->write ( $data );
						$log_txt = "Login|$nome|" . date ( "Y-m-d H:i:s" );
						$log_xml->log ( $log_txt, Zend_Log::INFO );
						$mensagem = "{success:true, dados: {code: '0', usuario:'" . ucfirst ( strtolower ( $nome ) ) . "'}}";
					} else {
						Zend_Auth::getInstance ()->clearIdentity ();
						$log_txt = "Aguardando liberação|$nome|" . date ( "Y-m-d H:i:s" );
						$log_xml->log ( $log_txt, Zend_Log::INFO );
						$mensagem = "{success:false, dados: {code: '1'}}";
					}
					break;
				case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND :
					$log_xml->log ( 'Erro Usuario nao cadastrado!!!', Zend_Log::WARN );
					$mensagem = "{success:false, dados: {code: '2'}}";
					break;
				case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID :
					$log_xml->log ( 'Erro senha errada!!!', Zend_Log::WARN );
					$mensagem = "{success:false, dados: {code: '3'}}";
					break;
			}
		} catch ( Zend_Db_Adapter_Exception $e ) {
			$mensagem = "{success:false, dados: {code: '4'}}";
			$log_xml->log ( $e->getMessage (), Zend_Log::WARN );
		} catch ( Zend_Exception $e ) {
			$mensagem = "{success:false, dados: {code: '5'}}";
			$log_xml->log ( $e->getMessage (), Zend_Log::WARN );
		}
		$this->getResponse ()->clearBody ();
		$this->getResponse ()->setHeader ( 'Content-Type', 'text/x-json; charset=iso-8859-1' );
		$this->getResponse ()->setBody ( $mensagem );
	}
	
	function logoutAction() {
		Zend_Registry::_unsetInstance ();
		Zend_Auth::getInstance ()->clearIdentity ();
		$this->_redirect ( '/auth' );
	}
}



