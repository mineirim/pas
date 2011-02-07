<?php

class Model_CargoUsuarios extends App_DefaultModel {


    /**
     * The default table name
     */
    protected $_name = 'cargo_usuarios';
    protected $_referenceMap = array(
        'Cargo' => array('columns' => 'cargo_id',
            'refTableClass' => 'Model_Setores',
            'refColumns' => 'id'),
        'Usuario' => array ( 'columns' => 'usuario_id',
                                  'refTableClass' => 'Model_Usuarios',
                                  'refColumns' => 'id' ),
        'Situacao' => array ( 'columns' => 'situacao_id',
                              'refTableClass' => 'Model_Situacoes',
                              'refColumns' => 'id' )
    );
    public function init(){
            parent::init();
            $this->_schema = "public";
    }

    /**
     *sobrescrever o método para evitar que tenham dois registros no histórico com a situacao_id=1
     * alterar para a situacao_id=3 (histórico)
     * @param <array> $dados
     * @return <int>
     */
    public function insert($dados){

        $this->getAdapter()->beginTransaction();

        $auth = Zend_Auth::getInstance();

        $tmp = $this->fetchRow('situacao_id=1 and usuario_id='.$dados['usuario_id']);
        try{
            if($tmp){
                $dados_update =array('situacao_id'=>3);
                /**
                 * TODO exigir data de início, final e justificativa de lotação no setor anterior
                 */
                parent::update($dados_update, 'id='.$tmp->id);
            }
            $dados['data_inicio'] = isset($dados['data_inicio'])?$dados['data_inicio']:date('Y/m/d h:i:s', time());
            $id = parent::insert($dados);
            $this->getAdapter()->commit();
            return $id;
        }  catch (Exception $e){
            $this->getAdapter()->rollBack();
            echo $e->__toString();exit;
        }


    }

    public function fetchCurrentCargo($usuario_id){
        $where = 'situacao_id = 1 AND usuario_id='.$usuario_id;
        $ret = parent::fetchRow($where);
        return $ret;
    }
}

