<?php

class Programacao_IndicadoresController extends Zend_Controller_Action {

    /**
     * @var Model_Indicadores $indicadores Model_Indicadores()
     *
     */
    private $indicadores = null;
    /**
     * @var Model_IndicadoresConfiguracoes $indicadores_configs
     * Model_IndicadoresConfiguracoes()
     *
     */
    private $indicadores_configs = null;
    private $arr_campos = array();
    private $form = null;
    private $indicador = null;
    private $indicadorconfig = null;
    private $indicadorqualitativo = null;

    public function init() {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('save', array('html', 'json', 'xml'))
                ->addActionContext('configurar', array('html', 'json', 'xml'))
                ->addActionContext('configurarqualitativos', array('html', 'json', 'xml'))
                ->addActionContext('deleteconfiguracao', array('html', 'json', 'xml'))
                ->addActionContext('deletecategoria', array('html', 'json', 'xml'))
                ->addActionContext('add', array('json', 'xml'))
                ->addActionContext('saveresultadosquali', array('html', 'json', 'xml'))
                ->addActionContext('localizar', 'json')
                ->initContext();
        $this->indicadores = new Model_Indicadores ( );
        $this->arr_campos = array('n' => 'Numerador', 'd' => 'Denominador', 'r' => 'Resultado');

        if ($this->_request->isXmlHttpRequest())
            $this->_helper->layout()->disableLayout();
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $this->view->frmindicador = new Programacao_Form_Indicador ();
        $this->view->meta_id = $this->_getParam('meta_id');
    }

    public function updateAction() {
        // action body
    }

    public function deleteAction() {
        // action body
        $this->form = new Programacao_Form_Delete ();
        $model_indicadores = new Model_Indicadores ();
        if ($this->getRequest()->isPost()) {
            if ($this->form->isValid($this->getRequest()->getPost())) {
                $id = $this->form->getValue('id');
                $this->view->response = array();
                try {
                    /*
                     * Indicador recebe status 2
                     */
                    $model_indicadores->update(array('situacao_id' => 2), 'id=' . $id);
                    $this->indicador = $model_indicadores->fetchRow('id = ' . $id);

                    /*
                     * Indicador Meta é excluído
                     */
                    $model_indicadores_meta = new Model_IndicadoresMeta ();
                    $model_indicadores_meta->delete('indicador_id = ' . $id);
                    $this->view->response = array('dados' => $this->indicador->toArray(), 'notice' => 'Indicador apagado com sucesso', 'descricao' => $this->indicador->descricao, 'keepOpened' => false, 'refreshPage' => true);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos', 'errors' => $this->form->getErrors());
                }
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $this->indicador = $model_indicadores->fetchRow('id=' . $id);
            $this->view->indicador = $this->indicador;
            $this->form->populate($this->indicador->toArray());
            $this->view->form = $this->form;
        }
    }

    public function getAction() {
        // action body
    }

    public function editAction() {
        $this->form = new Programacao_Form_Indicador ();
        $id = $this->_getParam('id');
        $model_indicadores = new Model_Indicadores ();
        $this->indicador = $model_indicadores->fetchRow('id=' . $id);
        $this->form->populate($this->indicador->toArray());
        $this->view->indicador = $this->indicador;
        $this->view->frmindicador = $this->form;
        /**
         * verifica se o indicador é quantitativo ou qualitativo para carregar o form correto
         */
        if ($this->indicador->tipo_indicador_id == 1) {
            $this->view->frmconfiguracao = new Programacao_Form_IndicadorConfig ();
            $this->view->frmconfiguracao->indicador_id->setValue($this->indicador->id);
        } elseif ($this->indicador->tipo_indicador_id == 2) {
            $this->view->frmconfigquali = new Programacao_Form_OpcoesQualitativos ();
            $this->view->frmconfigquali->indicador_id->setValue($this->indicador->id);
        }
    }

    /**
     * Salva as alterações na tabela indicadores
     * 
     * 
     *
     */
    public function saveAction() {
        $this->form = new Programacao_Form_Indicador ();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = $this->form->getValues();
                    unset($dados ['id']);
                    $id = $this->form->getValue('id');
                    $meta_id = $this->_getParam('meta_id');
                    $model_indicadores = new Model_Indicadores ();

                    if ($id == '') {
                        $id = $model_indicadores->insert($dados);
                        $newid = $id;
                    } else {
                        $model_indicadores->update($dados, 'id=' . $id);
                    }
                    if ($meta_id) {
                        $model_indicadores_meta = new Model_IndicadoresMeta ();
                        $arr = array('meta_id' => $meta_id, 'indicador_id' => $id);
                        if (!$model_indicadores_meta->fetchRow("indicador_id=$id and meta_id=$meta_id"))
                            $model_indicadores_meta->insert($arr);
                    }
                    $this->indicador = $model_indicadores->fetchRow('id=' . $id);
                    $this->view->indicador = $this->indicador;
                    $this->view->response = array('dados' => $this->indicador->toArray(), 'notice' => 'Dados atualizados com sucesso', 'descricao' => $this->indicador->descricao, 'keepOpened' => true, 'refreshPermissions' => true, 'nextTab' => 'tabs-1', 'refreshPage' => true);
                    if (isset($newid)) {
                        $this->view->response ['newid'] = $newid;
                    }
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $erro);
            }
        } else {
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Método esperado: POST');
        }
    }

    public function autocompleteAction() {
        // action body
    }

    public function configurarAction() {
        $this->form = new Programacao_Form_IndicadorConfig ();
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $dados = array('indicador_id' => $this->form->getValue('indicador_id'),
                                   'tipo_periodo_id' => $this->form->getValue('tipo_periodo_id'), 
                                   'base' => $this->form->getValue('base'), 
                                   'campos' => $this->form->getValue('campos'), 
                                   'inicio_preenchimento' => $this->form->getValue('ano') . $this->form->getValue('mes'));
                    $id = $this->form->getValue('id');
                    $model_indicadoresconfig = new Model_IndicadoresConfiguracoes ();

                    if ($id == '') {
                        $id = $model_indicadoresconfig->insert($dados);
                        $newid = $id;
                    } else {
                        $model_indicadoresconfig->update($dados, 'id=' . $id);
                    }

                    $this->indicadorconfig = $model_indicadoresconfig->fetchRow('id=' . $id);

                    $tiposperiodo = new Model_TiposPeriodos ();
                    $descTipo = $tiposperiodo->fetchRow('id=' . $this->indicadorconfig->tipo_periodo_id);

                    $this->view->response = array('dados' => $this->indicadorconfig->toArray(), 'notice' => 'Dados atualizados com sucesso', 'descricao' => $descTipo->descricao, 'keepOpened' => true, 'refreshPermissions' => true, 'refreshPage' => false);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $erro);
            }
        } else {
            try {

                $id = $this->_getParam('id');
                $indicador_id = $this->_getParam('indicador_id');
                if ($this->_getParam('format') == 'json') {
                    $model_indicadoresconfig = new Model_IndicadoresConfiguracoes ();
                    $this->indicadorconfig = $model_indicadoresconfig->fetchRow('id=' . $id);
                    $this->view->response = $this->indicadorconfig->toArray();
                } else {
                    $model_indicadores = new Model_Indicadores ();
                    $this->indicador = $model_indicadores->fetchRow('id=' . $indicador_id);
                    $this->view->frmconfiguracao = new Programacao_Form_IndicadorConfig ();
                    $this->view->frmconfiguracao->indicador_id->setValue($this->indicador->id);
                }
            } catch (Exception $e) {
                $this->getResponse()->setHttpResponseCode(501);
                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
            }
        }
    }

    public function deleteconfiguracaoAction() {
        // action body
        $this->form = new Programacao_Form_Delete ();
        $model_indicadoresconfiguracoes = new Model_IndicadoresConfiguracoes ();
        if ($this->getRequest()->isPost()) {
            if ($this->form->isValid($this->getRequest()->getPost())) {
                $id = $this->form->getValue('id');
                $this->view->response = array();
                try {
                    $model_indicadoresconfiguracoes->delete('id=' . $id); // update(array('situacao_id' => 2), );
                    $this->view->response = array('dados' => array('id' => $id), 'notice' => 'Configuração apagada com sucesso', 'descricao' => 'zz', 'keepOpened' => true, 'refreshPage' => false);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos', 'errors' => $form->getErrors());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $erro);
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $indicadoresconfiguracoes = $model_indicadoresconfiguracoes->fetchRow('id=' . $id);
            $this->view->indicadoresconfiguracoes = $indicadoresconfiguracoes;
            $this->form->populate($indicadoresconfiguracoes->toArray());
            $this->form->submit->setAttrib('class', 'submit_excluir');
            $this->form->dialog_close->setAttrib('class', 'dialog-close');
            $this->view->form = $this->form;
        }
    }

    public function configurarqualitativosAction() {

        $indicadores = new Model_Indicadores ();
        $this->form = new Programacao_Form_OpcoesQualitativos ();
        $indicador_id = $this->_getParam('indicador_id', null);

        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                try {
                    $id = $this->form->getValue('id');

                    $dados = $this->form->getDados();

                    $opcoes_qualitativos = new Model_OpcoesQualitativos ();

                    if ($id == '') {
                        $id = $opcoes_qualitativos->insert($dados);
                    } else {
                        $opcoes_qualitativos->update($dados, 'id=' . $id);
                    }
                    $this->indicadorqualitativo = $opcoes_qualitativos->fetchRow('id=' . $id);

                    $this->view->response = array('dados' => $this->indicadorqualitativo->toArray(), 'notice' => 'Dados atualizados com sucesso', 'descricao' => $this->indicadorqualitativo->descricao, 'keepOpened' => true, 'refreshPermissions' => true, 'refreshPage' => false);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $erro);
            }
        } else {

            $this->view->indicador = $indicadores->find($indicador_id)->current();
            $this->form->indicador_id->setValue($indicador_id);
            $this->view->frmconfigquali = $this->form;
        }
    }

    public function deletecategoriaAction() {
        // action body
        $this->form = new Programacao_Form_Delete ();
        $model_opcoesqualitativos = new Model_OpcoesQualitativos ();
        if ($this->getRequest()->isPost()) {
            if ($this->form->isValid($this->getRequest()->getPost())) {
                $id = $this->form->getValue('id');
                $this->view->response = array();
                try {
                    $model_opcoesqualitativos->delete('id=' . $id); // update(array('situacao_id' => 2), );
                    $this->view->response = array('dados' => array('id' => $id), 'notice' => 'Categoria apagada com sucesso', 'keepOpened' => true, 'refreshPage' => false);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Dados inválidos', 'errors' => $form->getErrors());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => 'Formulário com dados inválidos', 'errors' => $erro);
            }
        } elseif ((int) $this->_getParam('id', 0) > 0) {
            $this->view->title = "Excluir";
            $this->view->headTitle($this->view->title, 'PREPEND');
            $id = $this->_getParam('id', 0);
            $opcoesqualitativos = $model_opcoesqualitativos->fetchRow('id=' . $id);
            $this->view->opcoesqualitativos = $opcoesqualitativos;
            $this->form->populate($opcoesqualitativos->toArray());
            $this->form->submit->setAttrib('class', 'submit_excluir');
            $this->form->dialog_close->setAttrib('class', 'dialog-close');
            $this->view->form = $this->form;
        }
    }

    public function resultadosAction() {
        // action body
        $id = $this->_getParam('id');
        if (!$id) {
            $msg = "id não informado";
            $this->_redirect('/error/notfound/msg/' . $msg);
        }
        $indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');
        if (!$indicador_configuracao_id) {
            $msg = "indicador_configuracao_id não informado";
            $this->_redirect('/error/notfound/msg/' . $msg);
        }
        $this->view->indicador = $this->indicadores->find($id)->current();
        $this->view->indicador_configuracao_id = $indicador_configuracao_id;
        $indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
        $indicador_configuracao = $indicadores_configuracoes->fetchRow("id=$indicador_configuracao_id");


        $this->view->campos = array();
        $this->view->colnames = "";
        $this->view->colmodels = "";
        $campos = explode(",", $indicador_configuracao->campos);
        foreach ($campos as $k) {
            $nomecampo = strtolower($this->arr_campos[$k]);
            $this->view->campos[$k] = $this->arr_campos[$k];
            $this->view->colnames .=",'" . ucfirst($nomecampo) . "'";
            $model = ",{name:'" . $nomecampo . "',index:'" . $nomecampo . "', width:80, align:'right', editable:true, editrules:{number:true}}";
            $this->view->colmodels .=$model;
        }
        if (!in_array('r', $campos) && in_array('d', $campos)) {
            $this->view->colnames .=",'Resultado'";
            $model = ",{name:'resultado',index:'resultado', width:80, align:'right', editable:false}";
            $this->view->colmodels .=$model;
        }
        $this->view->indicador_configuracao = $indicador_configuracao;
    }

    public function localizarAction() {
        // action body
        $indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $resultados = new Model_IndicadoresResultados();

        $indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
        $indicador_configuracao = $indicadores_configuracoes->fetchRow('id=' . $indicador_configuracao_id);

        $response = array();
        $response['page'] = 1;
        $response['total'] = 1;
        $response['records'] = 10;

        $campos = explode(",", $indicador_configuracao->campos);
        $i = 0;
        foreach ($resultados->fetchAll('indicador_configuracao_id=' . $indicador_configuracao_id, 'competencia') as $row) {

            $response['rows'][$i]['id'] = $row->id;

            if ($indicador_configuracao->tipo_periodo_id == 1) {
                $competencia = substr($row->competencia, 4, 2) . "/" . substr($row->competencia, 0, 4);
            } else {
                $competencia = $row->competencia;
            }


            $cell = array($row->id, $competencia);
            foreach ($campos as $k) {
                $nomecampo = strtolower($this->arr_campos[$k]);
                $cell[] = $row->$nomecampo;
            }

            if (!in_array('r', $campos) && in_array('d', $campos)) {
                $cell[] = $row->resultado;
            }

            $response['rows'][$i]['cell'] = $cell;
            $i++;
        }

        $this->_helper->json($response);
    }

    public function saveresultadoAction() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $resultados = new Model_IndicadoresResultados();

        $dados = array("competencia" => $this->_getParam('competencia'));
        try {
            if ($this->getRequest()->isPost()) {
                $oper = $this->_getParam('oper');
                $id = $this->_getParam('id');
                if ($oper === 'del') {
                    $resultado = $resultados->delete('id = ' . $id);
                } else {
                

                    if ($id != '_empty') {
                        $resultado = $resultados->find($id)->current();
                        $indicador_configuracao_id = $resultado->indicador_configuracao_id;
                    } else {
                        $indicador_configuracao_id = $this->_getParam('indicador_configuracao_id');
                    }

                    $indicadores_configuracoes = new Model_IndicadoresConfiguracoes();
                    $indicador_configuracao = $indicadores_configuracoes->find($indicador_configuracao_id)->current();
                    $campos = explode(",", $indicador_configuracao->campos);
                    foreach ($campos as $k) {
                        $nomecampo = strtolower($this->arr_campos[$k]);
                        $dados[$nomecampo] = $this->_getParam($nomecampo);
                    }
                    if (!in_array('r', $campos)) {
                        $dados['resultado'] = ($dados['numerador'] / $dados['denominador']) * $indicador_configuracao->base;
                    }

                    if ($id == '_empty') {
                        $dados['indicador_configuracao_id'] = $this->_getParam('indicador_configuracao_id');
                        $id = $resultados->insert($dados);
                    } else {
                        $resultados->update($dados, "id=" . $id);
                    }// action body
                }
                $dados['id'] = $id;
                $ret = array('status' => 'Ok', $dados);
            }
        } catch (Zend_Db_Statement_Exception $e) {


            $ret = array('status' => 'error', 'message' => $e->getMessage(),
                'file' => $e->getFile(), 'code' => $e->getCode());
        }
        echo $this->_helper->json($ret);
    }

    
    public function saveresultadosqualiAction() {
        
        $id = $this->_getParam('id');
        $indicador_id = $this->_getParam('indicador_id');
        
        $this->form = new Programacao_Form_IndicadorQualitativo(array('indicador_id'=>$indicador_id));
       
        if ($this->getRequest()->isPost()) {
            $formData = $this->getRequest()->getPost();
            if ($this->form->isValid($formData)) {
                
                try {
                    $id = $this->form->getValue('id');
                    $dados = $this->form->getDados();
                    $indicadores_qualitativos = new Model_IndicadoresQualitativos();
                    if ($id == '') {
                        $id = $indicadores_qualitativos->insert($dados);
                    } else {
                        $indicadores_qualitativos->update($dados, 'id=' . $id);
                    }
                    $this->indicadorqualitativo = $indicadores_qualitativos->fetchRow('id=' . $id);

                    $this->view->response = array(  'dados' => $this->indicadorqualitativo->toArray(), 
                                                    'notice' => 'Dados atualizados com sucesso', 
                                                    'keepOpened' => false, 
                                                    'refreshPermissions' => true, 
                                                    'refreshPage' => true);
                } catch (Exception $e) {
                    $this->getResponse()->setHttpResponseCode(501);
                    $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
                }
            } else {
                $this->getResponse()->setHttpResponseCode(501);
                $erro = '';
                foreach ($this->form->getMessages(true) as $key => $val) {
                    $err = "";
                    foreach ($val as $k => $v) {
                        $err .= "<br>$v";
                    }
                    $erro .= "$key : $err";
                }

                $this->view->response = array('notice' => 'Erro ao gravar dados', 
                                              'errormessage' => 'Formulário com dados inválidos', 
                                              'errors' => $erro);
            }
        } else {

            if ($id != ''){
               $this->indicadorqualitativo = new Model_IndicadoresQualitativos;
               $this->form->populate($this->indicadorqualitativo->fetchRow("id =  $id")->toArray());
            } else {
               $this->form->indicador_id->setValue($indicador_id);
            }
            $this->view->indicador = $this->indicadores->find($indicador_id)->current();        
            $this->view->form = $this->form;
        }
        
        
    }
    
    
}

