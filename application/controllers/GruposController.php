<?php

class GruposController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    	if ($this->_request->isXmlHttpRequest()) {
       		$this->_helper->layout()->disableLayout();
    	}
    }

    public function indexAction()
    {
        $this->view->title = "Usuários";
        
		$this->view->headTitle($this->view->title, 'PREPEND');
        
		$grupos = new Model_Grupos();
        
		$this->view->grupos = $grupos->fetchAll(null,array('grupo'));
    }

    public function addAction()
    {
        
    	$this->view->title = "Adicionar Grupo";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Grupo();
		$form->submit->setLabel('Adicionar');
		$this->view->form = $form;
		
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$grupo = $form->getValue('grupo');
				$descricao = $form->getValue('descricao');
				$dados =array('grupo'=> $grupo, 'descricao'=> $descricao);
				$paginas = $form->getValue('paginas');
				
				$grupos = new Model_Grupos();
				$grupos->insert($dados,$paginas);
				$this->_redirect('grupos');
			} else {
				
				$form->populate($formData);
			}
		}
    }
    public function editAction()
    {
    	
        $this->view->title = "Editar Grupo";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Grupo();
		
		$form->submit->setLabel('Salvar');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$id = (int)$form->getValue('id');
				$grupo = $form->getValue('grupo');
				$descricao = $form->getValue('descricao');
				$dados =array('id'=>$id, 'grupo'=> $grupo, 'descricao'=> $descricao);
				
				$paginas = $form->getValue('paginas');
				$grupos = new Model_Grupos();
				$grupos->update($dados,$paginas, 'id='.$id );
				$this->_redirect('grupos');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$valores = array ( );
				$permissoes = new Model_GruposPermissoes();
				foreach($permissoes->fetchAll("grupo_id=$id") as $p)
					$valores [] = $p->pagina_id;
				
				$form->getElement('paginas')->setValue($valores);
				$grupos = new Model_Grupos();
				$form->populate($grupos->fetchRow('id='.$id)->toArray());
			}
		}
    }
     /**
      * adaptar ao grupo
      * @return unknown_type
      */
	public function salvarAction() {
		
		if (! $this->getRequest ()->isPost ()) {
			return $this->_forward ( 'index' );
		}
	
		$params = new Zend_Filter_Input(null, null, $this->getRequest()->getParams());
		
		$dados = array(
		'id' => $params->id,
		'titulo' => $params->titulo,
		'descricao' => $params->descricao,
		'texto' => $params->texto,
		'data' => Zend_Date::now()->getDate()->get(),
		'id_usuario' => $this->usuario->id,
		'tags' => trim($params->tags),
		'areas' => $params->areas
		);
		
		if ($params->id)  
			$this->textosDAO->update($dados, "id = $params->id");
		else
			$this->textosDAO->insert($dados);
									
		$this->_redirect('./admin/textos/');
		
	}
}



