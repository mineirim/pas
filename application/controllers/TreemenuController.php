<?php

class TreemenuController extends Zend_Controller_Action {

    public function init() {
        $ajaxContext = $this->_helper->ajaxContext;


        $ajaxContext->addActionContext('index', array('json', 'xml'))
                ->initContext();
    }

    public function indexAction() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $menus = array();
        $mysession = new Zend_Session_Namespace('menu');
        
        if (!isset($mysession->treemenu)) {

            $mysession->treemenu = array(array('data' => 'Administração', 'state' => 'closed',
                    "attr" => array("id" => "li-admin"),
                    "children" => array(
                        array('data' => array('title' => "Alterar Senha",
                                "attr" => array("href" => $this->_helper->url('changepassword', 'usuarios','admin'))
                        )),
                        array('data' => array('title' => "Usuários",
                            "attr" => array("href" => $this->_helper->url('index', 'usuarios','admin')))),
                        array('data' => array('title' => "Grupos",
                            "attr" => array("href" => $this->_helper->url('index', 'grupos','admin')))),
                        array('data' => array('title' => "Cargos",
                            "attr" => array("href" => $this->_helper->url('index', 'cargos','admin')))),
                        array('data' => array('title' => "Setores",
                            "attr" => array("href" => $this->_helper->url('index', 'setores','admin'))))
                    )
                ),
                array(
                    "attr" => array("id" => "plano-root"),
                    "state" => "closed",
                    "data" => array(
                        "title" => "Plano",
                        "attr" => array("href" => $this->_helper->url('index', 'instrumentos'))
                    ),
                    "children" => $this->getArray(array('root'))
                ),
                array(
                    "attr" => array("id" => "li-indicadores"),
                    "data" => array(
                        "title" => "Indicadores",
                        "attr" => array("href" => "/public/indicadores")
                    )
                ),
                array(
                    "attr" => array("id" => "li-relatorios"),
                    "data" => array(
                        "title" => "Relatorios",
                        "attr" => array("href" => "/public/relatorios")
                    )
                )
            );
        }

        echo $this->_helper->json($mysession->treemenu);
    }

    private function getArray($arr_node) {

        $menus = array();
        if ($arr_node[0] == 'root') {
            $model_programas = new Model_Programas();
            $programas = $model_programas->fetchAll("situacao_id=1", 'ordem');
            foreach ($programas as $programa) {
                $url = $this->_helper->url('programa', 'instrumentos', 'default', array('programa_id' => $programa->id));
                $parent = array("attr" => array("id" => "programa-" . $programa->id . "-json"), 'data' => array('title' => $programa->menu, 'attr' => array('href' => $url)), 'state' => 'closed');

                $path = array('programa', $programa->id, 'json');
                $child = $this->getArray($path);
                $parent['children'] = $child;

                $menus[] = $parent;
            }
        } elseif ($arr_node[0] == 'programa') {
            $model = new Model_Projetos();
            $objetos = $model->fetchAll("situacao_id=1 AND projeto_id is null AND programa_id=" . $arr_node[1], 'ordem');
            foreach ($objetos as $objeto) {
                $url = $this->_helper->url('projeto', 'instrumentos', 'default', array('projeto_id' => $objeto->id));
                $parent = array("attr" => array("id" => "projeto-" . $objeto->id . "-json"), 'data' => array('title' => $objeto->menu, 'attr' => array('href' => $url)), 'state' => 'closed');
                $path = array('projeto', $objeto->id, 'json');
                $child = $this->getArray($path);
                $parent['children'] = $child;

                $menus[] = $parent;
            }
        } elseif ($arr_node[0] == 'projeto') {
            $model_projetos = new Model_Projetos();
            $subprojetos = $model_projetos->fetchAll("situacao_id=1 AND projeto_id=" . $arr_node[1], 'ordem');
            if (count($subprojetos) > 0) {
                $objetos = $subprojetos;
                foreach ($objetos as $objeto) {
                    $url = $this->_helper->url('projeto', 'instrumentos', 'default', array('projeto_id' => $objeto->id));
                    $parent = array("attr" => array("id" => "projeto-" . $objeto->id . "-json"), 'data' => array('title' => $objeto->menu, 'attr' => array('href' => $url)), 'state' => 'closed');
                    $path = array('objetivo', $objeto->id, 'json');
                    $child = $this->getArray($path);
                    $parent['children'] = $child;
                    $menus[] = $parent;
                }
            } else {
                $model = new Model_ObjetivosEspecificos();
                $objetos = $model->fetchAll("situacao_id=1 AND projeto_id =" . $arr_node[1], 'ordem');
                foreach ($objetos as $objeto) {
                    $url = $this->_helper->url('objetivos-especificos', 'instrumentos', 'default', array('objetivo_especifico_id' => $objeto->id));
                    $parent = array("attr" => array("id" => "objetivo-" . $objeto->id . "-json"), 'data' => array('title' => $objeto->menu, 'attr' => array('href' => $url)), 'state' => 'closed');
                    $path = array('meta', $objeto->id, 'json');
                    $child = $this->getArray($path);
                    $parent['children'] = $child;
                    $menus[] = $parent;
                }
            }
        } elseif ($arr_node[0] == 'objetivo') {
            $model = new Model_Metas();
            $objetos = $model->fetchAll("situacao_id=1 AND objetivo_especifico_id=" . $arr_node[1], 'id');
            foreach ($objetos as $objeto) {
                $url = $this->_helper->url('meta', 'instrumentos', 'default', array('meta_id' => $objeto->id));
                $parent = array("attr" => array("id" => "meta-" . $objeto->id . "-json"), 'data' => array('title' => substr($objeto->descricao, 0, 15) . "...", 'attr' => array('href' => $url)), 'state' => 'closed');
                /* não mostra operações no menu
                  $path = array('operacao',$objeto->id,'json');
                  $child = $this->getArray($path);
                  $parent['children'] = $child;
                 */
                $menus[] = $parent;
            }
        } elseif ($arr_node[0] == 'meta') {
            $model = new Model_Operacoes();
            $objetos = $model->fetchAll("situacao_id=1 AND meta_id=" . $arr_node[1], 'id');
            foreach ($objetos as $objeto) {
                $url = $this->_helper->url('operacao', 'instrumentos', 'default', array('operacao_id' => $objeto->id));
                $menus[] = array("attr" => array("id" => "operacao-" . $objeto->id . "-json"), 'data' => array('title' => substr($objeto->descricao, 0, 15) . "...", 'attr' => array('href' => $url)));
            }
        }
        return $menus;
    }

}

