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
		$this->view->usuarios = $usuarios->fetchAll();
    }

    public function addAction()
    {
        $this->view->title = "Adicionar usuário";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Usuario();
		$form->submit->setLabel('Add');
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
				$password = $form->getValue('password');
				$email = $form->getValue('email');
				
				$dados =array('id'=>$id,  'nome'=> $nome, 'username'=> $username,'password'=>$password,'email'=>$email);
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

