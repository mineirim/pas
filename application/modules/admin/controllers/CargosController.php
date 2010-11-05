<?php

class Admin_CargosController extends Zend_Controller_Action
{

    public function init() {
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
        
    }

    public function createAction()
    {
        $cargo = $this->_getParam ( 'cargo' );
        $id = $this->_getParam ( 'id' );
        $model_cargos = new Model_Cargos ();

        try {
                $model_cargos->insert ( $cargo );
                $this->view->response = array ('dados' => $cargo,
                                                                                'notice' => 'Dados inseridos com sucesso',
                                                                                'descricao' => $cargo ['nome'] );
        } catch ( Exception $e ) {
                $this->getResponse ()->setHttpResponseCode ( 501 );
                $this->view->response = array ('notice' => 'Erro ago gravar dados', 'erros' => $e->getMessage () );
        }
    }

    public function updateAction()
    {
        $cargo = $this->_getParam('cargo');
        $id = $this->_getParam('id');
        $model_cargos = new Model_Cargos();

        try{
            $model_cargos->update($cargo, array('id=?'=>$id));
            $this->view->response =  array('dados' => $cargo,
                                    'notice'    =>  'Dados atualizados com sucesso',
                                    'descricao' =>  $cargo['nome']);
        }catch (Exception $e){
            $this->getResponse ()->setHttpResponseCode ( 501 );
            $this->view->response =array('notice'=>'Erro ago gravar dados', 'erros' => $e->getMessage() );
        }
    }

    public function deleteAction()
    {
        $id = $this->_getParam('id');
        $model_cargos = new Model_Cargos ();
		
		try {
			$model_cargos->delete ( array ('id=?' => $id ) );
			$this->view->response = array ('notice' => 'Dados apagados com sucesso', 'descricao' => "apagado" );
		} catch ( Exception $e ) {
			$this->getResponse ()->setHttpResponseCode ( 501 );
			$this->view->response = array ('notice' => 'Erro ao apagar os dados', 'erros' => $e->getMessage () );
		}
    }

    public function getAction()
    {

    }

    public function get2gridAction()
    {
        $response = new stdClass();
        $this->_helper->layout->disableLayout ();
        $page = $this->_request->getParam ( "page", 1 );
        $limit = $this->_request->getParam ( "rows" );
        $sidx = $this->_request->getParam ( "sidx", 1 );
        $sord = $this->_request->getParam ( "sord" );
        $model_cargos = new Model_Cargos ();
        $cargos = $model_cargos->fetchAll ();
        $count = count ( $cargos );
        if ($count > 0) {
                $total_pages = ceil ( $count / $limit );
        } else {
                $total_pages = 0;
        }

        if ($page > $total_pages)
                $page = $total_pages;

        $cargos = $model_cargos->fetchAll ( null, "$sidx $sord", $limit, ($page * $limit - $limit) );

        $response->page = $page;
        $response->total = $total_pages;
        $response->records = $count;

        foreach ( $cargos as $cargo ) {
                $response->rows [] = array ('id' => $cargo->id, 'nome' => $cargo->nome, 'descricao' => $cargo->descricao );
        }

        $this->view->dados = $response;
    }


}



