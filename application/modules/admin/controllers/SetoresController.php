<?php

class Admin_SetoresController extends Zend_Controller_Action
{

    public function init()
    {
        $ajaxContext = $this->_helper->ajaxContext;
		$ajaxContext->addContext ( 'js', array ('suffix' => 'js' ) );
		$ajaxContext->setAutoJsonSerialization ( false );
		$ajaxContext->addActionContext ( 'index', array ('json', 'xml', 'js' ) )
					->addActionContext ( 'create', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'update', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'delete', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'get', array ('html', 'json', 'xml' ) )
					->addActionContext ( 'get2grid', array ('html', 'json', 'xml' ) )
					->initContext ();
    }

    public function indexAction()
    {
        // action body
    }

    public function createAction()
    {
        $setor = $this->_getParam ( 'setor' );
        $id = $this->_getParam ( 'id' );
        $model_setores = new Model_Setores();

        try {
                $model_setores->insert ( $setor );
                $this->view->response = array ('dados' => $setor,
                                                                                'notice' => 'Dados inseridos com sucesso',
                                                                                'descricao' => $setor ['nome'] );
        } catch ( Exception $e ) {
                $this->getResponse ()->setHttpResponseCode ( 501 );
                $this->getResponse()->setException($e);
                $this->view->response = array ('notice' => 'Erro ago gravar dados', 'erros' => $e->getMessage () );
        }
    }

    public function updateAction()
    {
        $setor = $this->_getParam('setor');
        $id = $this->_getParam('id');
        $model_setor = new Model_Setores();

        try{
            $model_setor->update($setor, array('id=?'=>$id));
            $this->view->response =  array('dados' => $setor,
                                    'notice'    =>  'Dados atualizados com sucesso',
                                    'descricao' =>  $setor['nome']);
        }catch (Exception $e){
            $this->getResponse ()->setHttpResponseCode ( 501 );
            $this->view->response =array('notice'=>'Erro ago gravar dados', 'erros' => $e->getMessage() );
        }
    }

    public function deleteAction()
    {
        // action body
    }

    public function getAction()
    {

    }

    public function get2gridAction()
    {
        $response = new stdClass ();
		$this->_helper->layout->disableLayout ();
		$page = $this->_request->getParam ( "page", 1 );
		$limit = $this->_request->getParam ( "rows" );
		$sidx = $this->_request->getParam ( "sidx", 1 );
		$sord = $this->_request->getParam ( "sord" );
		$model_setores = new Model_Setores ();
		$setores = $model_setores->fetchAll ();
		$count = count ( $setores );
		if ($count > 0) {
			$total_pages = ceil ( $count / $limit );
		} else {
			$total_pages = 0;
		}
		
		if ($page > $total_pages)
			$page = $total_pages;
		
		$setores = $model_setores->fetchAll ( null, "$sidx $sord", $limit, ($page * $limit - $limit) );
		
		$response->page = $page;
		$response->total = $total_pages;
		$response->records = $count;
		
		foreach ( $setores as $setor ) {
			$response->rows [] = array ('id' => $setor->id, 'nome' => $setor->nome, 'sigla' => $setor->sigla, 'descricao' => $setor->descricao );
		}
		
		$this->view->dados = $response;
    }


}











