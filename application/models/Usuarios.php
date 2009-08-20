<?php
class Model_Usuarios extends Zend_Db_Table_Abstract
{
	protected $_name = 'usuarios';
	protected $_dependentTables = array('Model_UsuariosGrupos');
	private $password_md5;
	private $salt;
	
	public function getUsuario($id)
	{
		$id = (int)$id;
		$row = $this->fetchRow('id = ' . $id);
		if (!$row) {
			throw new Exception("Count not find row $id");
		}
		return $row->toArray();
	}
	public function addUsuario($dados, array $grupos)
	{
		$this->getAdapter()->beginTransaction();
		

		$this->makePassword($dados['password']);

		$dados['password']=$this->password_md5;
		$dados['salt']=$this->salt;
		$id = parent::insert($dados);

	    foreach($grupos as $g) {
			$usuarioGrupo= new Model_UsuariosGrupos();
			$pg=array (
			'grupo_id' => $g,
			'usuario_id' => $id
			);
			$usuarioGrupo ->insert( $pg);
		}
		
    	$this->getAdapter()->commit();		
		
	}

	function updateUsuario(array $dados, array $grupos, $where)
	{
		$this->getAdapter()->beginTransaction();
		if( isset( $dados['password'])){
			$this->makePassword($password);
			$dados['password']=$this->password_md5;
		    $dados['salt']=$this->salt;
			
		}
	
	    	
    	$usuarioGrupo = new Model_UsuariosGrupos();
    	
    	$usuario = $this->find($dados['id'])->current();
    	$usuario_id = $usuario->id;
    	
    	
    	$gruposBanco = array();
    	foreach($usuario->findModel_GruposViaModel_UsuariosGruposByUsuarios() as $grp)
    		$gruposBanco[] = $grp->id;

    	/* Se a área que está no banco não estiver mais selecionada no formulário, é deletada no banco */
   		foreach($gruposBanco as $g)
   			if (!in_array($g, $grupos)) {
    			$usuarioGrupo->delete("grupo_id = ".$this->getAdapter()->quote($g)." and usuario_id = ".$this->getAdapter()->quote($usuario_id));
   			}
   		
  		/* Se a áreas do formulário não estiverem no banco, são inseridas */
    	foreach($grupos as $g)
    		if (!in_array($g, $gruposBanco)) 
    			$usuarioGrupo->insert(array(
    			'usuario_id' => $usuario_id,
    			'grupo_id' => $g )
    			);
    	
    	parent::update($dados, $where);
		$this->getAdapter()->commit();    	   	   	    	
    }	
	
	
	
	
	
	function deleteUsuario($id)
	{
		$this->delete('id =' . (int)$id);
	}
	private function makePassword($password){
		$this->salt = md5(time());
		$this->password_md5 = md5($password . $this->salt);
	}
}