<?php

/**
 * Grupos
 *  
 * @author Marcone Costa
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Grupos extends Zend_Db_Table_Abstract {
	/**
	 * The default table name 
	 */
	protected $_name = 'grupos';
	protected $_dependentTables = array('UsuariosGrupos');

	
    public function insert(array $dados, array $paginas) {
		
		$this->getAdapter()->beginTransaction();
    	
    	
	    $id = parent::insert($dados);
		
	    
	    foreach($paginas as $p) {
			$grupoPermissao = new Model_GruposPermissoes();
			$pg=array (
			'grupo_id' => $id,
			'pagina_id' => $p
			);
			$grupoPermissao ->insert( $pg);
		}
		
    	$this->getAdapter()->commit();
    }
    
    public function update(array $dados, array $paginas, $where) {
    	
    	$grupoPermissao = new Model_GruposPermissoes();
    	
    	$grupo = $this->find($dados['id'])->current();
    	$grupo_id = $grupo->id;
    	
    	
    	$paginasBanco = array();
    	foreach($grupo->findModel_PaginasViaModel_GruposPermissoesByModel_Grupos() as $pag)
    		$paginasBanco[] = $pag->id;

    	/* Se a área que está no banco não estiver mais selecionada no formulário, é deletada no banco */
   		foreach($paginasBanco as $p)
   			if (!in_array($p, $paginas)) {
    			$grupoPermissao->delete("pagina_id = ".$this->getAdapter()->quote($p)." and grupo_id = ".$this->getAdapter()->quote($grupo_id));
   			}
   		
  		/* Se a áreas do formulário não estiverem no banco, são inseridas */
    	foreach($paginas as $p)
    		if (!in_array($p, $paginasBanco)) 
    			$grupoPermissao->insert(array(
    			'pagina_id' => $p,
    			'grupo_id' => $grupo_id )
    			);
    	
    	parent::update($dados, $where);
    	   	   	    	
    }	
}
