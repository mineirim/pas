<?php

class UsuariosController extends Zend_Controller_Action
{

    public function init()
    {
		$auth = Zend_Auth::getInstance();
		
 		//if(!$auth->hasIdentity())
 			//$this->_redirect("auth");
    }


    public function indexAction()
    {
        $this->view->title = "Usuários";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$usuarios = new Model_Usuarios();
		$this->view->usuarios = $usuarios->fetchAll(null,'nome');
    }

    public function addAction()
    {
        $this->view->title = "Adicionar usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Usuario();
		$form->submit->setLabel('Add');
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
    }
	public function changepasswordAction(){
		$usuarios = new Model_Usuarios();
		if($this->_getParam('id')){
			
			$this->view->usuario = $usuarios->find($this->_getParam('id'))->current();
		
	        $this->view->title = "Alterar senha";
			$this->view->headTitle($this->view->title, 'PREPEND');
			$form = new Zend_Form();
			$id = new Zend_Form_Element_Hidden('id');
			$id->setRequired(true)
				->addFilter('StripTags')
				->addFilter('StringTrim')
				->addValidator('NotEmpty');
			$password = new Zend_Form_Element_Password('password');
			
			$password->setLabel("Senha")
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
				
				$id = $this->_getParam('id', 0);
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
    }


}

