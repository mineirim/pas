<?php

class UsuariosController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addActionContext('localizar', 'json')
                	->addActionContext('salvar',array('json','xml'))
                            ->initContext();  
		
 		//if(!$auth->hasIdentity())
 			//$this->_redirect("auth");
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    }


    public function indexAction()
    {
        $this->view->title = "Usuários";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$usuarios = new Model_Usuarios();
		$this->view->usuarios = $usuarios->fetchAll("situacao_id=1",'nome');
		$this->view->usuarios_excluidos = $usuarios->fetchAll("situacao_id<>1",'nome');
    }

    public function addAction()
    {
        
    	$this->view->title = "Adicionar usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Usuario();
		$form->submit->setLabel('Adicionar');
		$form->addUsernameAndPassword();
		$form->password->addValidator('NotEmpty')->setRequired(true);
		$form->username->addValidator('NotEmpty')->setRequired(true);
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$nome	= $form->getValue('nome');
				$username = $form->getValue('username');
				$password = $form->getValue('password');
				$email = $form->getValue('email');
				
				$dados =array('nome'=> $nome, 'username'=> $username,'password'=>$password,'email'=>$email);
				$grupos = $form->getValue('grupos');
				
				$usuarios = new Model_Usuarios();
				$usuarios->addUsuario($dados,$grupos);
				$this->_redirect('usuarios');
			} else {
				$form->populate($formData);
			}
		}
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
		
    }
	public function adicionarAction()
    {
        $this->view->title = "Adicionar usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Usuario();
		$form->submit->setLabel('Adicionar');
		$form->addUsernameAndPassword();
		$form->password->addValidator('NotEmpty')->setRequired(true);
		$form->username->addValidator('NotEmpty')->setRequired(true);
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$nome	= $form->getValue('nome');
				$username = $form->getValue('username');
				$password = $form->getValue('password');
				$email = $form->getValue('email');
				
				$dados =array('nome'=> $nome, 'username'=> $username,'password'=>$password,'email'=>$email);
				$grupos = $form->getValue('grupos');
				
				$usuarios = new Model_Usuarios();
				$usuarios->addUsuario($dados,$grupos);
				$this->_redirect('usuarios');
			} else {
				$form->populate($formData);
			}
			
		}
    }
    public function editAction()
    {
       $this->view->title = "Editar usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Usuario();
		$form->submit->setLabel('Salvar');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = (int)$form->getValue('id');
				$nome = $form->getValue('nome');
				$username = $form->getValue('username');
				$email = $form->getValue('email');
				$dados =array('id'=>$id,  'nome'=> $nome, 'email'=>$email);
				$grupos = $form->getValue('grupos');
				
				$usuarios = new Model_Usuarios();
				$usuarios->updateUsuario($dados, $grupos, 'id='.$id  );
				$this->_redirect('usuarios');
			} else {
				
				$form->populate($formData);
			}
		} else {
			
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$valores = array ( );
				$grupos = new Model_UsuariosGrupos();
				foreach($grupos->fetchAll("usuario_id=$id") as $p)
					$valores [] = $p->grupo_id;
				
				$form->getElement('grupos')->setValue($valores);
				$usuarios = new Model_Usuarios();
				$form->populate($usuarios->getUsuario($id));
			}
	
		}
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
	
    }
    
	public function changepasswordAction(){
		$usuarios = new Model_Usuarios();
		
		
		$auth = Zend_Auth::getInstance ();  
        $id_auth = $auth->getIdentity()->id;
        
		
		if($id_auth){
			
			$this->view->usuario = $usuarios->find($id_auth)->current();
		
	        $this->view->title = "Alterar senha";
			$this->view->headTitle($this->view->title, 'PREPEND');
			$form = new Zend_Form();
			$id = new Zend_Form_Element_Hidden('id');
			$id->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
			$password = new Zend_Form_Element_Password('password');
			
			$password->setLabel("Nova senha")
				->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty'); 
			$confirm = new Zend_Form_Element_Password('confirm');
			$confirm->setLabel("Confirmar senha"); 
			$submit = new Zend_Form_Element_Submit('submit');
			$submit->setLabel('Alterar');
			$form->addElements(array($id,$password,$confirm,$submit));
			$this->view->form = $form;
			if ($this->getRequest()->isPost()) {
				$formData = $this->getRequest()->getPost();
				if ($form->isValid($formData)) {
					$id = (int)$form->getValue('id');
					$password = $form->getValue('password');
	
					$dados =array('id'=>$id,  'password'=>$password);
					
					
					$usuarios->updatePassword($dados,'id='.$id  );
					$this->_redirect('usuarios');
				} else {
					
					$form->populate($formData);
				}
			} else {
				
				$id = $id_auth;
				if ($id > 0) {
					$usuarios = new Model_Usuarios();
					$form->populate($usuarios->getUsuario($id));
				}
		
			}
		}else{
			$this->_redirect('usuarios');
		}		
						
		
	}
    public function deleteAction()
    {
        $this->view->title = "Apagar Usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		if ($this->getRequest()->isPost()) {
			$del = $this->getRequest()->getPost('del');
			if ($del == 'Sim') {
				$id = $this->getRequest()->getPost('id');
				$usuarios = new Model_Usuarios();
				$usuarios->deleteUsuario($id);
			}
			$this->_redirect('usuarios');
		} else {
			$id = $this->_getParam('id');
			$usuarios = new Model_Usuarios();
			$this->view->usuario = $usuarios->getUsuario($id);
		}

        if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}		
		
    }
    public function restoreAction()
    {
        $this->view->title = "Restaurar Usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		if ($this->getRequest()->isPost()) {
			$restore = $this->getRequest()->getPost('restore');
			if ($restore == 'Sim') {
				$id = $this->getRequest()->getPost('id');
				$usuarios = new Model_Usuarios();
				$usuarios->restoreUsuario($id);
			}
			$this->_redirect('usuarios');
		} else {
			$id = $this->_getParam('id');
			$usuarios = new Model_Usuarios();
			$this->view->usuario = $usuarios->getUsuario($id);
		}

        if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}		
		
    }
    public function localizarAction(){
    	
    	$model_usuarios = new Model_Usuarios();
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    	

    	$response = array();
    	$page =$this->_getParam('page', 1);
    	$limit = $this->_getParam('rows', 15);
    	$sidx = $this->_getParam('sidx','nome');
    	$sord = $this->_getParam('sord'); // get the direction
    	$where = " situacao_id=".$this->_getParam('situacao_id', 1);
    	if($this->_getParam('_search')=="true"){
    		$filtros = Zend_Json::decode($this->_getParam('filters'), Zend_Json::TYPE_OBJECT);
    		foreach ($filtros->rules as $regra){
    			$where .= " ".$filtros->groupOp." ".$regra->field." like '%".$regra->data."%'";
    		}
    	}
    		
    	$usuarios =$model_usuarios->fetchAll($where); 
    	
    	$count = $usuarios->count();
    	$total_pages =$count >0 ? ceil($count/$limit): $total_pages = 1;
    	$page = ($page > $total_pages)? $total_pages:$page;
    	
    	$start = $limit*$page - $limit; // do not put $limit*($page - 1)
    	
    	
    	$usuarios =$model_usuarios->fetchAll($where,$sidx,$limit,$start);
    	
        $response['page'] = $page; 
        $response['total'] = $total_pages; 
        $response['records'] = $count;
    	
    	$i=0;
    	foreach ($usuarios as $usuario){
    		$response['rows'][$i]['id']=$usuario->id;
    		$cell = array($usuario->id,$usuario->nome,$usuario->email, $usuario->username, $usuario->situacao_id);
    		$response['rows'][$i]['cell']=$cell;
    		$i++;
    	}
		
		$this->_helper->json($response);
    	
    }
    /**
    public function salvarAction(){
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    	
    	if($this->_getParam('oper')=='edit'){
    		$model_usuarios = new Model_Usuarios();
    		$dados = array('nome'=>$this->_getParam('nome'),
    						'email'=>$this->_getParam('email'));
    		try{
    		 	$model_usuarios->update($dados, "id=".$this->_getParam('id'));
    			$usuario =$model_usuarios->fetchRow('id='.$this->_getParam('id'))->toArray();
    			
    		}catch (Exception  $e){
    			$usuario = array('erro'=>$e->getMessage(), 'codigo'=> $e->getCode());
    		}
    	}elseif ($this->_getParam('oper')=='del'){
	    	$model_usuarios = new Model_Usuarios();
    		try{
    		 	$model_usuarios->deleteUsuario($this->_getParam('id'));
    			$usuario =$model_usuarios->fetchRow('id='.$this->_getParam('id'))->toArray();
    			
    		}catch (Exception  $e){
    			$usuario = array('erro'=>$e->getMessage(), 'codigo'=> $e->getCode());
    		}
    	}
		$this->_helper->json($usuario);
    }
    */
}

