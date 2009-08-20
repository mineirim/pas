<?php

/**
 * Grupos
 *  
 * @author PS00051
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Paginas extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'paginas';
	protected $_dependentTables = array('GruposPermissoes');
	
    public function insert(array $dados, array $grupos) {
		
		$this->getAdapter()->beginTransaction();
    	
    	
	    $id = parent::insert($dados);
		
	    
	    foreach($grupos as $g) {
			$grupoPermissao = new Model_GruposPermissoes();
			$pg=array (
			'grupo_id' => $g,
			'pagina_id' => $id
			);
			$grupoPermissao ->insert( $pg);
		}
		
    	$this->getAdapter()->commit();
    }
    
    public function update(array $dados, array $grupos, $where) {
    	
    	$grupoPermissao = new Model_GruposPermissoes();
    	
    	$pagina = $this->find($dados['id'])->current();
    	$pagina_id = $pagina->id;
    	
    	
    	$gruposBanco = array();
    	foreach($pagina->findModel_GruposViaModel_GruposPermissoesByModel_Paginas() as $grp)
    		$gruposBanco[] = $grp->id;

    	/* Se a área que está no banco não estiver mais selecionada no formulário, é deletada no banco */
   		foreach($gruposBanco as $g)
   			if (!in_array($g, $grupos)) {
    			$grupoPermissao->delete("grupo_id = ".$this->getAdapter()->quote($g)." and pagina_id = ".$this->getAdapter()->quote($pagina_id));
   			}
   		
  		/* Se a áreas do formulário não estiverem no banco, são inseridas */
    	foreach($grupos as $g)
    		if (!in_array($g, $gruposBanco)) 
    			$grupoPermissao->insert(array(
    			'pagina_id' => $pagina_id,
    			'grupo_id' => $g )
    			);
    	
    	parent::update($dados, $where);
    	   	   	    	
    }		

}
