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
		$this->form = new Form_Geral ( );
		
		$this->form->submit->setLabel ( 'Adicionar' );
		
		$this->view->form = $this->form;
		$subform= new Form_Objetivos();
		$this->form->addSubForm($subform,"novo");

		if ($this->getRequest ()->isPost ()) {
			
			$formData = $this->getRequest ()->getPost ();
			
			if ($this->form->isValid ( $formData )) {
				
				$dados = $this->form->getDados();
				
				$programas = new Model_Programas ( );
				
				$programas->insert ( $dados );
				
				$this->_redirect ( 'programas' );
			
			} else {
				
				$this->form->populate ( $formData );
			
			}
		
		}
		
		$this->renderScript('formulario.phtml');
	}
	
	
	public function editAction() {
		
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
				
				$f = new Form_Descritivo();
				$obj_programa = new Model_ObjetivosPrograma();
				foreach ($formData as $key=>$value){
					if(substr($key,0,8)=='objetivo'){
						$subpost = $this->getRequest()->getPost($key, false);
						if($f->isValid($subpost) || $subpost['remover']){
							$dados = $f->getDados();
							$dados['programa_id']=$id;
							if($f->getValue("id") && $subpost['remover'] ){
								$obj_programa->delete('id='.$f->getValue("id"));
							}elseif($f->getValue("id")){
								$obj_programa->update($dados,'id='.$f->getValue("id"));
							}elseif($f->isValid($subpost)){
								$obj_programa->insert($dados);
							}
							
						}
					}
				}
				$this->form->populate($formData);
				$this->addSubForms($programas->fetchRow('id='.$id ));
			
				//$this->_redirect('plano/programas');
			} else {
				
				$this->form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$programas = new Model_Programas();
				$programa = $programas->fetchRow('id='.$id);
				
				$this->form->populate($programa->toArray());
				$this->addSubForms($programa);
				
			}
		}

		$this->renderScript('form.phtml');
	}
	private function addSubForms($programa){
		$objetivos = $programa->findDependentRowset('Model_ObjetivosPrograma');
		$order = 2;
		$i=1;
		foreach ($objetivos  as $objetivo){
			$subform= new Form_Descritivo();
			$subform->populate($objetivo->toArray());
			$subform->removeDecorator('label');
			$this->form->addSubForm($subform,"objetivo_$i",$order++);
			$i++;
		}
		
		$this->view->objetivos = $objetivos;
		$subform= new Form_Descritivo();
		$this->form->addSubForm($subform,"objetivo_0", $order++);
		
	}

}







