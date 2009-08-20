<?php

class PaginasController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $this->view->title = "Páginas";
        
		$this->view->headTitle($this->view->title, 'PREPEND');
        
		$paginas = new Model_Paginas();
        
		$this->view->paginas = $paginas->fetchAll(null,array('pagina','acao'));
    }

    public function addAction()
    {
        $this->view->title = "Adicionar Pagina";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Pagina();
		$form->submit->setLabel('Add');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				$pagina	= $form->getValue('pagina');
				$acao	= $form->getValue('acao');
				$descricao = $form->getValue('descricao');
				
				$dados =array('pagina'=> $pagina,'acao'=>$acao, 'descricao'=> $descricao);
				$grupos = $form->getValue('grupos');
				
				$paginas = new Model_Paginas();
				$paginas->insert($dados,$grupos);
				$this->_redirect('paginas');
			} else {
				$form->populate($formData);
			}
		}
		$this->renderScript('formulario.phtml');
    }
    public function editAction()
    {
    	$paginas = new Model_Paginas();
        $this->view->title = "Editar Pagina";
		$this->view->headTitle($this->view->title, 'PREPEND');
		$form = new Form_Pagina();
		$form->submit->setLabel('Salvar');
		$this->view->form = $form;
		if ($this->getRequest()->isPost()) {
			$formData = $this->getRequest()->getPost();
			if ($form->isValid($formData)) {
				
				$id = (int)$form->getValue('id');
				$pagina = $form->getValue('pagina');
				$acao = $form->getValue('acao');
				$descricao = $form->getValue('descricao');
				
				$dados =array('id'=>$id, 'pagina'=> $pagina,'acao'=>$acao, 'descricao'=> $descricao);
				
				$grupos = $form->getValue('grupos');
				$paginas = new Model_Paginas();
				$paginas->update($dados,$grupos , 'id='.$id );
				$this->_redirect('paginas');
			} else {
				$form->populate($formData);
			}
		} else {
			$id = $this->_getParam('id', 0);
			if ($id > 0) {
				$valores = array ( );
				$permissoes = new Model_GruposPermissoes();
				foreach($permissoes->fetchAll("pagina_id=$id") as $p)
					$valores [] = $p->grupo_id;
				
				$form->getElement('grupos')->setValue($valores);
				
				$form->populate($paginas->fetchRow('id='.$id)->toArray());
			}
			
					
				
						
		}
    }
    
}

