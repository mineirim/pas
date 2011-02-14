<?php

class Admin_SetoresController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->ajaxContext;
        $ajaxContext->addContext('js', array('suffix' => 'js'));
        $ajaxContext->setAutoJsonSerialization(false);
        $ajaxContext->addActionContext('index', array('json', 'xml', 'js'))
                ->addActionContext('create', array('html', 'json', 'xml'))
                ->addActionContext('update', array('html', 'json', 'xml'))
                ->addActionContext('delete', array('html', 'json', 'xml'))
                ->addActionContext('get', array('html', 'json', 'xml'))
                ->addActionContext('get2grid', array('html', 'json', 'xml'))
                ->initContext();
        if ($this->_request->isXmlHttpRequest()) {
            $this->_helper->layout()->disableLayout();
        }
    }

    public function indexAction() {
        // action body
    }

    public function createAction() {
        $setor = $this->_getParam('setor');
        $id = $this->_getParam('id');
        $model_setores = new Model_Setores();

        $chefia = array('usuario_id'=>$setor['chefia_id']);
        unset($setor['chefia_id']);
        $model_setor_chefia = new Model_SetorChefias();
        try {
            $setor['id'] = $model_setores->insert($setor);
            $chefia['setor_id']= $setor['id'];
            $model_setor_chefia->insert($chefia);
            $this->view->response = array('dados' => $setor,
                'notice' => 'Dados inseridos com sucesso',
                'descricao' => $setor ['nome']);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->getResponse()->setException($e);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function updateAction() {
        $setor = $this->_getParam('setor');
        $id = $this->_getParam('id');
        if ($setor['setor_id'] == '')
            unset($setor['setor_id']);

        $chefia = array('usuario_id'=>$setor['chefia_id'], 'setor_id'=>$id);
        unset($setor['chefia_id']);
        
        $model_setor = new Model_Setores();
        $model_setor_chefia = new Model_SetorChefias();
        try {
            $model_setor->update($setor, array('id=?' => $id));
            $model_setor_chefia->insert($chefia);

            $this->view->response = array('dados' => $setor,
                'notice' => 'Dados atualizados com sucesso',
                'descricao' => $setor['nome']);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function deleteAction() {
        $id = $this->_getParam('id');
        $model_setor = new Model_Setores();
        try {
            $setor = $model_setor->fetchRow('id=' . $id);
            $setor->situacao_id = 2;
            $setor->save();
            $this->view->response = array('dados' => $setor,
                'notice' => 'Setor apagado com sucesso',
                'descricao' => $setor->nome);
        } catch (Exception $e) {
            $this->getResponse()->setHttpResponseCode(501);
            $this->view->response = array('notice' => 'Erro ao gravar dados', 'errormessage' => $e->getMessage());
        }
    }

    public function getAction() {
        $model_setores = new Model_Setores();
        $n_level = 0;
        if ($this->_getParam('nodeid')) {
            $setores = $model_setores->fetchAll("setor_id=" . $this->_getParam('nodeid'));
            $n_level = $this->_getParam('n_level') + 1;
        } else {
            $setores = $model_setores->fetchAll();
            $n_level = 0;
        }


        $this->view->dados = $setores;
    }

    public function get2gridAction() {
        $response = new stdClass ();
        $model_setores = new Model_Setores();
        $this->_helper->layout->disableLayout();
        $page = $this->_request->getParam("page", 1);
        $limit = $this->_request->getParam("rows");
        $sidx = $this->_request->getParam("sidx", 1);
        $sord = $this->_request->getParam("sord");
        $nodeid = $this->_getParam('nodeid');



        $n_level = 0;
        if ($nodeid) {
            $setores = $model_setores->fetchAll("situacao_id=1 and setor_id=" . $nodeid);
            $n_level = $this->_getParam('n_level') + 1;
        } else {
            $setores = $model_setores->fetchAll('situacao_id=1 and setor_id is null');
            $n_level = 0;
        }

$db = Zend_Registry::get('db');
$sql = "WITH RECURSIVE path(nome,sigla,descricao, path, parent, id, setor_id, chefia_id, lvl, leaf) AS (
          SELECT nome,sigla,descricao,'/' , NULL  , setores.id, setores.setor_id, c.usuario_id as chefia_id,
		0 as lvl ,
		(select count(*) from setores s where s.setor_id=setores.id and situacao_id=1) as leaf
          FROM setores left join setor_chefias c on c.setor_id=setores.id
          WHERE setores.setor_id is null and (c.situacao_id=1 or c.situacao_id is null)
		and setores.situacao_id=1
          UNION
          SELECT
            fs.nome,fs.sigla,fs.descricao,
            parentpath.path ||
              CASE parentpath.path
                WHEN '/' THEN ''
                ELSE '/'
              END || fs.nome,
            parentpath.path, fs.id, fs.setor_id, c.usuario_id as chefia_id,  parentpath.lvl+1 as lvl,
            (select count(*) from setores where setor_id=fs.id and situacao_id=1) as leaf
          FROM setores fs inner join path as parentpath on fs.setor_id = parentpath.id
           left join setor_chefias c on fs.id=c.setor_id
          WHERE  c.situacao_id=1   or c.situacao_id is null
		and fs.situacao_id=1
          )
        SELECT * FROM path order by path ";
$setores = $db->query($sql);


        $response->page = 1;
        $response->total = 1;
        $response->records = count($setores);
        $model_usuarios = new Model_Usuarios();

        foreach ($setores as $setor) {
            $nome_chefia = '';
            if($setor['chefia_id']){
                $usuario = $model_usuarios->fetchRow('id='.$setor['chefia_id']);
                $nome_chefia = $usuario->nome;
            }

            /**
             * @todo implementar filtro para verificar no isleaf somente os setores com situacao_id =1
             */
            $leaf = $setor['leaf']==0?true:false;//count($setor->findModel_Setores()) == 0;
            $response->rows [] = array('id' => $setor['id'],
                'nome' => $setor['nome'],
                'sigla' => $setor['sigla'],
                'descricao' => $setor['descricao'],
                'chefia'    =>$nome_chefia,
                'setor_id' => $setor['setor_id'],
                'chefia_id' => $setor['chefia_id'],
                'level' => isset( $setor['lvl'])? $setor['lvl']:0,
                'isLeaf' => $leaf,
                'parent' => $setor['setor_id'],
                'colapsed' => false,
                'expanded'  => true
            );
        }

        $this->view->dados = $response;
    }

}

