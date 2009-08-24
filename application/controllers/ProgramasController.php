<?php

class ProgramasController extends Zend_Controller_Action {
	private $form;
	public function init() {
		/* Initialize action controller here */
	}
	
	public function indexAction() {
		$programas = new Model_Programas ( );
		
		$this->view->programas = $programas->fetchAll ( null, 'id' );
	}
	
	public function addAction() {
		$subformularios = new Form_ObjetivosEMetas($this->getRequest());
		$this->form = new Form_Geral ( );
		
		$this->form->submit->setLabel ( 'Adicionar' );
		
		
		
		$this->form->addSubForm(new Form_Descritivo(),"objetivo_0");
		$this->form->addSubForm(new Form_Descritivo(),"meta_0");
		$this->view->form = $this->form;
		$this->view->objetivos = array();
		$this->view->metas = array();
		
		if ($this->getRequest ()->isPost ()) {
			
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) {
				$dados = $this->form->getDados();
				$programas = new Model_Programas ( );
				$id = $programas->insert ( $dados );
				$programa = $programas->fetchRow('id='.$id);
				$subformularios->gravaObjetivos_e_Metas($programa,$formData);
				
				$this->_redirect ( 'plano/programas' );
			
			} else {
				
				$this->form->populate ( $formData );
			
			}
		
		}
		
		$this->renderScript('form.phtml');
	}
	
	/**
	 * Edita o programa
	 * 
	 */
	public function editAction() {
		$subformularios = new Form_ObjetivosEMetas($this->getRequest());
	    $this->view->title = "Editar";
	    
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		$this->form = new Form_Geral();
		
		$this->form->submit->setLabel('Salvar');
		$this->view->form = $this->form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
				
			if ($this->form->isValid($formData)) {
				$id = $this->form->getValue('id');
				
				$dados = $this->form->getDados ();

				$programas = new Model_Programas ( );;
				$programas->update($dados, 'id='.$id );
				
				$programa = $programas->fetchRow('id='.$id );
				
				$subformularios->gravaObjetivos_e_Metas($programa,$formData);
				
				
				/**
				$objetivos =$programa->findDependentRowset('Model_ObjetivosPrograma');
				$metas  = $programa->findDependentRowset('Model_MetasPrograma');
				$this->form->populate($formData);
				$this->form->addSubForms($subformularios->getSubForms($objetivos,$metas));
				$this->view->objetivos = $objetivos;
				$this->view->metas = $metas;
			*/
				$this->_redirect('plano/programas');
			} else {
				
				$this->form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$programas = new Model_Programas();
				$programa = $programas->fetchRow('id='.$id);
				
				$this->form->populate($programa->toArray());
				
				$objetivos =$programa->findDependentRowset('Model_ObjetivosPrograma');
				$metas  = $programa->findDependentRowset('Model_MetasPrograma');

				$this->view->objetivos = $objetivos;
				$this->view->metas = $metas;
				
				$this->form->addSubForms($subformularios->getSubForms($objetivos,$metas));
				
				
				
			}
		}

		$this->renderScript('form.phtml');
	}
	public function deleteAction(){
		$this->view->title = "Excluir";
	    
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		
		
		$id = $this->_getParam('id', 0);
		
		$form = new Zend_Form();
		$form->addElement('hidden','id');
		$form->addElement('submit','ok');
		
		$programas = new Model_Programas();
		
		if ($this->getRequest()->isPost()) {
			if ($form->isValid($this->getRequest()->getPost())) {
				$id = $form->getValue('id');
				$programa = $programas->fetchRow('id='.$id);
				$programa->situacao_id=2;
				$programa->save();
			}
			$this->_redirect('plano/programas');
		}elseif ($id > 0) {
			
			$programa = $programas->fetchRow('id='.$id);
			$this->view->programa = $programa;
		}
		
		$form->populate($programa->toArray());
		$this->view->form = $form;
	}
}







