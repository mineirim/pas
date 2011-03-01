<?php

class Programacao_IndicadoresController extends Zend_Controller_Action
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
                ->addActionContext('save', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();
    }

    public function indexAction()
    {
        // action body
    }

    public function createAction()
    {
        $this->view->form = new Programacao_Form_Indicador();
        $this->view->meta_id = $this->_getParam('meta_id');
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
        // action body
    }

    public function editAction()
    {
        $this->view->form = new Programacao_Form_Indicador();
    }
    /**
     * Salva as alterações na tabela indicadores
     */
    public function saveAction()
    {
        $this->form = new Programacao_Form_Indicador();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValue('indicador');
                    unset($dados['id']);
                    $id = $this->form->indicador->getValue('id');
                    $model_indicadores = new Model_Indicadores( );
                    if ($id == '') {
                        $id = $model_indicadores->insert($dados);
                        $newid = $id;
                    } else {
                        $model_indicadores->update($dados, 'id=' . $id);
                    }
                    $meta_id = $this->form->getValue('meta_id');
                    if($meta_id){
                        $model_indicadores_meta = new Model_IndicadoresMeta();
                        $arr = array('meta_id'=>$meta_id, 'indicador_id'=>$id);
                        if(!$model_indicadores_meta->fetchRow("indicador_id=$id and meta_id=$meta_id"))
                            $model_indicadores_meta->insert ($arr);

                    }



                    $indicador = $model_indicadores->fetchRow('id=' . $id);
                    $this->view->indicador = $indicador;
                    $this->view->response = array('dados' => $indicador->toArray(),
                        'notice' => 'Dados atualizados com sucesso',
                        'descricao' => $indicador->descricao,
                        'keepOpened' => true,
                        'nextTab'   =>1,
                        'refreshPermissions'=>true,
                        'refreshPage' => true
                    );
                    if(isset($newid)){
                    	$this->view->response['newid']=$newid;
                    }
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados',
                    								'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos',
                    'errors' => $this->form->processAjax($formData) );
            }
        } else {
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

    public function autocompleteAction()
    {
        // action body
    }


}















