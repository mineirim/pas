<?php

/**
 * Grupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Funcoes extends App_DefaultModel {
	/**
	 * The default table name 
	 */
	protected $_name = 'public.funcoes';
	protected $_dependentTables = array('AcaoFuncoes');

	
	public function init(){
		parent::init();
		$this->_schema = "public";
	}									
	
	
	
    public function insert(array $dados, array $paginas) {
		
		$this->getAdapter()->beginTransaction();
    	
    	
	    $id = parent::insert($dados);
		
	    $acaoFuncoes = new Model_AcaoFuncoes();
	    foreach($paginas as $p) {
			
			$pg=array (
			'pagina_id' => $p,
			'funcao_id' => $id
			);
			$acaoFuncoes->insert( $pg);
		}
		
    	$this->getAdapter()->commit();
    }
    
    public function update(array $dados, array $paginas, $where) {
    	
    	$acaoFuncoes = new Model_AcaoFuncoes();
    	
    	$funcao = $this->find($dados['id'])->current();
    	$funcao_id = $funcao->id;
    	
    	
    	$paginasBanco = array();
    	foreach($funcao->findModel_PaginasViaModel_AcaoFuncoesByModel_Funcoes() as $pg)
    		$paginasBanco[] = $pg->id;

    	/* Se a área que está no banco não estiver mais selecionada no formulário, é deletada no banco */
   		foreach($paginasBanco as $g)
   			if (!in_array($g, $paginas)) {
    			$acaoFuncoes->delete("pagina_id = ".$this->getAdapter()->quote($g)." and funcao_id = ".$this->getAdapter()->quote($funcao_id));
   			}
   		
  		/* Se a áreas do formulário não estiverem no banco, são inseridas */
    	foreach($paginas as $g)
    		if (!in_array($g, $paginasBanco)) 
    			$acaoFuncoes->insert(array(
    			'funcao_id' => $funcao_id,
    			'pagina_id' => $g )
    			);
    	
    	parent::update($dados, $where);
    	   	   	    	
    }		

}
