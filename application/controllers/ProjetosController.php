<?php

class ProjetosController extends Zend_Controller_Action {
	
	public function init() {
		/* Initialize action controller here */
	}
	
	public function indexAction() {
		$programa_id = $this->_getParam ( 'programa_id', 0 );
		
		$projetos = new Model_Projetos ( );
		$this->view->projetos = $projetos->fetchAll ( 'programa_id=' . $programa_id, 'id' );
	}
	
	public function addAction() {
		$programa_id = $this->_getParam ( 'programa_id' );
		if ($programa_id  || $this->getRequest ()->isPost ()) 
		{
		    $usuario_id = Zend_Auth::getInstance ()->getIdentity ()->id;
			$form = new Form_Geral ( );
			$form->addElement('hidden','programa_id',array('value'=>$programa_id));
			$form->submit->setLabel ( 'Adicionar' );
			$this->view->form = $form;
			if ($this->getRequest ()->isPost ()) {
				$formData = $this->getRequest ()->getPost ();
				if ($form->isValid ( $formData )) {
					$dados = $form->getDados ();
					$dados['programa_id']=$form->getValue ( 'programa_id' );
					$projetos = new Model_Projetos ( );
					$projetos->insert ( $dados );
					$this->_redirect ( 'plano/projetos/programa_id/'.$form->getValue ( 'programa_id' ));
				} else {
					$form->populate ( $formData );
				}
			
			}
			$this->renderScript ( 'formulario.phtml' );
		} else {
		/**
		 * caso não tenha sido passado o programa_id
		 */
		}
	
	}
	
	public function editAction() {
		$this->view->title = "Editar";
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		$form = new Form_Geral();
		
		$form->submit->setLabel('Salvar');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = $form->getValue('id');
				$dados = $form->getDados ();
				
				$projetos = new Model_Projetos ( );;
				$projetos->update($dados, 'id='.$id );
				$programa_id = $projetos->find($id)->current()->findParentRow('Model_Programas')->id;
				$this->_redirect('plano/projetos/programa_id/'.$programa_id);
			} else {
				$form->populate($formData);
				$this->renderScript ( 'formulario.phtml' );
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$projeto = new Model_Projetos();
				$form->populate($projeto->fetchRow('id='.$id)->toArray());
			}
			$this->renderScript ( 'formulario.phtml' );
		}
		
	}


	
	
}



