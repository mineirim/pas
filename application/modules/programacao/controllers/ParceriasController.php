<?php

class Programacao_ParceriasController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->addActionContext('save', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
        $this->view->frmParceiro = new Programacao_Form_Parceiro();
    }

    public function indexAction()
    {
        
    }

    public function createAction()
    {
    	$objetivo_especifico_id = $this->_getParam('objetivo_especifico_id');
    	if($objetivo_especifico_id){
	        $this->view->title = "Adicionar parceria";
	        $this->view->headTitle($this->view->title, 'PREPEND');
	        $form = new Programacao_Form_Parceria();
	        $form->parceria->objetivo_especifico_id->setValue($objetivo_especifico_id);
	        $form->submit->setLabel('Adicionar Parceria');
	        $this->view->form = $form;
    	}
    }
    public function editAction()
    {
        $this->view->title = "Editar parceria";
        $this->view->headTitle($this->view->title, 'PREPEND');
        $form = new Programacao_Form_Parceria();
        $form->submit->setLabel('Salvar');
        

        $id = $this->_getParam('id', 0);
        if ($id > 0) {
            $tipos_ids = array();
            $model_parcerias = new Model_Parcerias();
            $parceria = $model_parcerias->fetchRow('id='.$id);
            
            if($parceria){
				foreach ($parceria->findModel_ParceriaTipos() as $parceria_tipo) {
					$tipos_ids[]=$parceria_tipo->tipo_parceria_id;
				}
				$this->view->parceiro = $parceria->findParentModel_Parceiros();
	            $form->tipo_parceria->getElement('tipos_parcerias_ids')->setValue($tipos_ids);
	            $form->parceria->populate($parceria->toArray());
	            $this->view->form = $form;
					
            }
            
            
        } else {
        	$this->view->errorMessage = 'Código não informado';
            $this->render('erro');
        }    	
    }
    
    public function updateAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }

    public function getAction()
    {
        $model_parcerias = new Model_Parcerias();
        $n_level = 0;
        if ($this->_getParam('nodeid')) {
            $setores = $model_parcerias->fetchAll("setor_id=" . $this->_getParam('nodeid'));
            $n_level = $this->_getParam('n_level') + 1;
        } else {
            $setores = $model_parcerias->fetchAll();
            $n_level = 0;
        }


        $this->view->dados = $setores;
    }

    public function saveAction()
    {
    	if ($this->getRequest ()->isPost ()) {
    		$this->form = new Programacao_Form_Parceria();
			$formData = $this->getRequest ()->getPost ();
			if ($this->form->isValid ( $formData )) {
				try {
					$dados = $this->form->getValue ( 'parceria' );
					$dados_tipos=$this->form->tipo_parceria->getValue ('tipos_parcerias_ids');
					unset ( $dados ['id'] );
					$id = $this->form->parceria->getValue ( 'id' );
					
					$model_parcerias = new Model_Parcerias();
					$model_parceria_tipos = new Model_ParceriaTipos();
					if ($id == '') {
						$id = $model_parcerias->insert ( $dados );
						$newid = $id;
					} else {
						$model_parcerias->update ( $dados, 'id=' . $id );
					}
					$parceria = $model_parcerias->fetchRow ( 'id=' . $id );
					
					$model_parceria_tipos->delete("parceria_id=$id");
					foreach ($dados_tipos as $tipo) {
						$arr = array('parceria_id'=>$id,'tipo_parceria_id'=>$tipo);
						$model_parceria_tipos->insert($arr);
					}
					
					$this->view->parceria = $parceria;
					$this->view->response = array ('dados' => $parceria->toArray (), 
											'notice' => 'Dados atualizados com sucesso', 
											'descricao' => $parceria->observacoes, 
											'keepOpened' => true, 'refreshPage' => true );
					if (isset ( $newid )) {
						$this->view->response ['newid'] = $newid;
					}
				} catch ( Exception $e ) {
					$this->getResponse ()->setHttpResponseCode ( 501 );
					$this->view->response = array ('notice' => 'Erro ao gravar dados', 
													'errormessage' => $e->getMessage () );
				}
			} else {
				$this->getResponse ()->setHttpResponseCode ( 501 );
				$this->view->response = array ('notice' => 'Erro ao gravar dados', 
												'errormessage' => 'Formulário com dados inválidos', 
												'errors' => $this->form->processAjax ( $formData ) );
			}
		} else {
			$this->view->response = array ('notice' => 'Erro ao gravar dados', 
			'errormessage' => 'Método esperado: POST' );
		}
    }
    public function get2gridAction() {
        $response = new stdClass();
        $this->_helper->layout->disableLayout ();
        $page = $this->_request->getParam ( "page", 1 );
        $limit = $this->_request->getParam ( "rows" );
        $sidx = $this->_request->getParam ( "sidx", 1 );
        $sord = $this->_request->getParam ( "sord" );
        $model_parcerias = new Model_Parcerias();
        $parcerias = $model_parcerias->fetchAll ();
        $count = count ( $parcerias );
        if ($count > 0) {
                $total_pages = ceil ( $count / $limit );
        } else {
                $total_pages = 0;
        }

        if ($page > $total_pages)
                $page = $total_pages;

        $parcerias = $model_parcerias->fetchAll ( null, "$sidx $sord", $limit, ($page * $limit - $limit) );

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = $count;

        foreach ( $parcerias as $parceria ) {
        	$parceiro = $parceria->findParentModel_Parceiros();
        	$parceria_tipos = $parceria->findManyToManyRowset('Model_TiposParcerias', 'Model_ParceriaTipos');
        	$str_tipo = "<ul class='ul-grid'>";
        	foreach ($parceria_tipos as $tipoParceria) {
        		$str_tipo .="<li>". $tipoParceria->descricao ."</li>";
        	}
        	$str_tipo .= "</ul>";
                $response->rows [] = array ('id' => $parceria->id, 
                								'nome' => $parceiro->nome, 
                								'sigla' => $parceiro->sigla,
                								'observacoes' => $parceria->observacoes,
                								'tipo_parceria'=>$str_tipo
                 );
        }

        $this->view->dados = $response;
    }

}













