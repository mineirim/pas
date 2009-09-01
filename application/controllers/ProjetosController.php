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
		$projeto_id = $this->_getParam ( 'projeto_id' );
		$subformularios = new Form_ObjetivosEMetas($this->getRequest());
		$this->form = new Form_Geral ( );
		$this->form->submit->setLabel ( 'Adicionar' );
		$this->form->addSubForm(new Form_Descritivo(),"objetivo_0");
		$this->form->addSubForm(new Form_Descritivo(),"meta_0");
		
		$this->view->form = $this->form;
		$this->view->objetivos = array();
		$this->view->metas = array();
		
		if ($programa_id  || $this->getRequest ()->isPost ()) 
		{
		    $usuario_id = Zend_Auth::getInstance ()->getIdentity ()->id;
			$this->view->form->addElement('hidden','programa_id',array('value'=>$programa_id));
			$this->view->form->addElement('hidden','projeto_id',array('value'=>$projeto_id));
			$this->view->form->addDisplayGroup(array('id', 'programa_id','projeto_id'),'ident');
			
			if ($this->getRequest ()->isPost ()) {
				$formData = $this->getRequest ()->getPost ();
				if ($this->form->isValid ( $formData )) {
					$dados = $this->form->getDados ();
					$dados['programa_id']=$this->form->getValue ( 'programa_id' );
					if($this->form->getValue ( 'projeto_id' ) )
						$dados['projeto_id']=$this->form->getValue ( 'projeto_id' ) ;
					$projetos = new Model_Projetos ( );
					$id = $projetos->insert ( $dados );
					$projeto = $projetos->fetchRow('id='.$id);
					$subformularios->gravaObjetivos_e_Metas($projeto,$formData);
					$this->_redirect ( 'plano/projeto/projeto_id/'.$id);
					
				} else {
					$this->form->populate ( $formData );
				}
			}
			$this->renderScript ( 'form.phtml' );
		} else {
		/** caso não tenha sido passado o programa_id */
		}
	}
	
	public function editAction() {
		$this->view->title = "Editar";
		$this->view->headTitle($this->view->title, 'PREPEND') ;
		$subformularios = new Form_ObjetivosEMetas($this->getRequest());
		$this->form = new Form_Geral();
		$this->form->submit->setLabel('Salvar');
		$this->view->form = $this->form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($this->form->isValid($formData)) {
				$id = $this->form->getValue('id');
				$dados = $this->form->getDados ();
				
				$projetos = new Model_Projetos ( );;
				$projetos->update($dados, 'id='.$id );
				$projeto = $projetos->fetchRow('id='.$id );
				$subformularios->gravaObjetivos_e_Metas($projeto,$formData);
				
				$this->_redirect('plano/projeto/projeto_id/'.$id);
			} else {
				$this->form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$projetos = new Model_Projetos();
				$projeto = $projetos->fetchRow('id='.$id);
				$this->form->populate($projeto->toArray());
				
				$objetivos =$projeto->findDependentRowset('Model_ObjetivosProjeto');
				$metas  = $projeto->findDependentRowset('Model_MetasProjeto');

				$this->view->objetivos = $objetivos;
				$this->view->metas = $metas;
				
				$this->form->addSubForms($subformularios->getSubForms($objetivos,$metas));
				
			}
			
		}
		$this->view->form->addDisplayGroup(array('id', 'programa_id','projeto_id'),'ident');
		$this->renderScript ( 'form.phtml' );
		
	}

	
	
}



