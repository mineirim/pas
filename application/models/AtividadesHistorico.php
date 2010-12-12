<?php

class Model_AtividadesHistorico extends App_DefaultModel {

    protected $_rowClass = "Model_Row_AtividadeHistorico";
    /**
     * The default table name 
     */
    protected $_name = 'atividades_historico';
    protected $_referenceMap = array(
        'Atividades' => array('columns' => 'atividade_id',
            'refTableClass' => 'Model_Atividades',
            'refColumns' => 'id'),
        'Andamento' => array('columns' => 'andamento_id',
            'refTableClass' => 'Model_Andamentos',
            'refColumns' => 'id'),
        'Responsavel' => array ( 'columns' => 'responsavel_id',
                                  'refTableClass' => 'Model_Usuarios',
                                  'refColumns' => 'id' ),
        'Situacao' => array ( 'columns' => 'situacao_id',
                              'refTableClass' => 'Model_Situacoes',
                              'refColumns' => 'id' )
    );


    /**
     *sobrescrever o método para evitar que tenham dois registros no histórico com a situacao_id=1
     * alterar para a situacao_id=3 (histórico)
     * @param <array> $dados
     * @return <int> 
     */
    public function insert($dados){

        $auth = Zend_Auth::getInstance();
        $dados['inclusao_usuario_id']= $auth->getIdentity()->id;
        $dados['alteracao_usuario_id']= $auth->getIdentity()->id;

        $tmp = $this->fetchRow('situacao_id=1 and atividade_id='.$dados['atividade_id']);
        
        if($tmp){
            /**
            $a_tmp=array();
            $a_tmp['data_inicio'] = $dados['data_inicio'];
            $a_tmp['data_prazo'] = $dados['data_prazo'];
            $a_tmp['data_conclusao'] = isset($dados['data_conclusao'])  ?   $dados['data_conclusao']:'';
            $a_tmp['andamento_id'] = isset($dados['andamento_id'])      ?   $dados['andamento_id']:'';
            $a_tmp['avaliacao'] = isset($dados['avaliacao'])    ?   $dados['avaliacao']:'';
            $a_tmp['percentual'] = isset($dados['percentual'])  ?   $dados['percentual']:'';
            $a_tmp['responsavel_id'] = $dados['responsavel_id'];
            
            $arr_atual = $tmp->toArray();
            $arr_tmp=array();
            $arr_tmp['data_inicio'] = $arr_atual['data_inicio'];
            $arr_tmp['data_prazo'] = $arr_atual['data_prazo'];
            $arr_tmp['data_conclusao'] = $arr_atual['data_conclusao']?$arr_atual['data_conclusao']:'';
            $arr_tmp['andamento_id'] = $arr_atual['andamento_id']?$arr_atual['andamento_id']:'';
            $arr_tmp['avaliacao'] = $arr_atual['avaliacao']?$arr_atual['avaliacao']:'';
            $arr_tmp['percentual'] = $arr_atual['percentual']?$arr_atual['percentual']:'';
            $arr_tmp['responsavel_id'] = $arr_atual['responsavel_id'];
            var_dump($a_tmp);var_dump($arr_tmp);exit;
            
             * se não foram feitas alterações, então não se deve inserir outro registro
            
            if($a_tmp==$arr_tmp)
            	return $tmp->id;
            */
            parent::update(array('situacao_id'=>3), 'id='.$tmp->id);
        }
        return parent::insert($dados);
    }
}

