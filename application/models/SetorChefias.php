<?php

class Model_SetorChefias extends App_DefaultModel {

    /**
     * The default table name 
     */
    protected $_name = 'setor_chefias';
    protected $_referenceMap = array(
        'Setores' => array('columns' => 'setor_id',
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
        // se o dados inserido jah é do usuário atual como chefe então sai da função sem executar a inserção
        if($this->fetchRow('situacao_id=1 and setor_id='.$dados['setor_id'].' and usuario_id='.$dados['usuario_id']))
                return;

        $tmp = $this->fetchRow('situacao_id=1 and setor_id='.$dados['setor_id']);
        try{
            if($tmp){
                $dados_update =array('situacao_id'=>3, 'data_final'=>new Zend_Date());
                /**
                 * TODO exigir data de início, final e justificativa de lotação no setor anterior
                 */
                parent::update($dados_update, 'id='.$tmp->id);
            }
            
            $id = parent::insert($dados);
            $this->getAdapter()->commit();
            return $id;
        }  catch (Exception $e){
            $this->getAdapter()->rollBack();
            echo $e->__toString();exit;
        }
        

    }

    public function fetchCurrentChefe($usuario_id){
        $where = 'situacao_id = 1 AND usuario_id='.$usuario_id;
        $ret = parent::fetchRow($where);
        return $ret;
    }
}

