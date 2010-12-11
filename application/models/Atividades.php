<?php

/**
 * Atividades
 *  
 * @author hugo
 * @version 
 */

require_once 'Zend/Db/Table/Abstract.php';

class Model_Atividades extends App_DefaultModel {

	protected $_rowClass = "Model_Row_Atividade";
	/**
	 * The default table name 
	 */
	
	
	protected $_name = 'atividades';
	protected $_referenceMap = array (
	                     		'Operacoes' => array ( 'columns' => 'operacao_id', 
	                     							  'refTableClass' => 'Model_Operacoes', 
	                     							  'refColumns' => 'id' ) 							
								);
									
	public function update($dados, $where){
		
		$auth = Zend_Auth::getInstance();
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_data']=date('Y/m/d h:i:s', time());

		
		return parent::update($dados,$where);
		
	}
	public function insert($dados){
		
		$auth = Zend_Auth::getInstance();
		$dados['inclusao_usuario_id']= $auth->getIdentity()->id;
		$dados['alteracao_usuario_id']= $auth->getIdentity()->id;

	
		
		return parent::insert($dados);
	}
	
	/*
	 * Numerador / Denominador dos valores das atividades por nível
	 * Uso: $variavel = $atividades->calculovalor(nivel,id,tipo);
	 * Niveis:
	 * 1 = Programa
	 * 2 = Projeto
	 * 3 = SubProjeto
	 * 4 = Objetivo Específico
	 * 5 = Metas
	 * 6 = Operações
	 * 
	 * Tipos:
	 * 1 = numerador (soma dos valores das atividades concluidas)
	 * 2 = denominador (soma dos valores de todas as atividades)
	 */
	public function calculovalor($nivel, $id, $tipo){
		$sc = "poa2010"; // schema

		$select = $this->select()
					->setIntegrityCheck(false)
					->from(array("a" => "$sc.atividades"), array("SUM(valor) as total"));
		if ($tipo == 2){			
			$select->where("a.operacao_id = o.id and a.situacao_id = 1"); // denominador
		} else {
			$select->where("a.operacao_id = o.id and a.situacao_id = 1 and a.conclusao_data is not null"); // numerador
		}
					
		// Operação
		if ($nivel == 6){
			$select->join(array("o" => "$sc.operacoes"),
								"o.situacao_id = 1 and o.id = $id", array());
		}
		// Meta
		if ($nivel == 5){
			$select->join(array("m" => "$sc.metas"),
								"m.situacao_id = 1 and m.id = $id", array())
					->join(array("o" => "$sc.operacoes"),
								"o.meta_id = m.id and o.situacao_id = 1", array());
		}
		// Objetivo Específico
		if ($nivel == 4){
			$select->join(array("oe" => "$sc.objetivos_especificos"),
								"oe.situacao_id = 1 and oe.id = $id", array())
						->join(array("m" => "$sc.metas"),
								"m.objetivo_especifico_id = oe.id and m.situacao_id = 1", array())
						->join(array("o" => "$sc.operacoes"),
								"o.meta_id = m.id and o.situacao_id = 1", array());
		}
		// subprojeto
		if ($nivel == 3){
			$select->joinleft(array("spj" => "$sc.projetos"),
								"spj.projeto_id is not null and spj.situacao_id = 1 and spj.id = $id", array())
						->join(array("oe" => "$sc.objetivos_especificos"),
								"oe.projeto_id = spj.id and oe.situacao_id = 1", array())
						->join(array("m" => "$sc.metas"),
								"m.objetivo_especifico_id = oe.id and m.situacao_id = 1", array())
						->join(array("o" => "$sc.operacoes"),
								"o.meta_id = m.id and o.situacao_id = 1", array());
		}
		// projeto
		if ($nivel == 2){
			$select->join(array("pj" => "$sc.projetos"),
								"pj.projeto_id is null and pj.situacao_id = 1 and pj.id = $id", array())
						->joinleft(array("spj" => "$sc.projetos"),
								"spj.projeto_id = pj.id and spj.projeto_id is not null and spj.situacao_id = 1", array())
						->join(array("oe" => "$sc.objetivos_especificos"),
								"((oe.projeto_id = pj.id) or (oe.projeto_id = spj.id)) and oe.situacao_id = 1", array())
						->join(array("m" => "$sc.metas"),
								"m.objetivo_especifico_id = oe.id and m.situacao_id = 1", array())
						->join(array("o" => "$sc.operacoes"),
								"o.meta_id = m.id and o.situacao_id = 1", array());
		}
		// programa
		if ($nivel == 1){
			$select->join(array("pr" => "$sc.programas"),
								"pr.situacao_id = 1 and pr.id = $id", array())
						->join(array("pj" => "$sc.projetos"),
								"pj.programa_id = pr.id and pj.projeto_id is null and pj.situacao_id = 1", array())
						->joinleft(array("spj" => "$sc.projetos"),
								"spj.projeto_id = pj.id and spj.projeto_id is not null and spj.situacao_id = 1", array())
						->join(array("oe" => "$sc.objetivos_especificos"),
								"((oe.projeto_id = pj.id) or (oe.projeto_id = spj.id)) and oe.situacao_id = 1", array())
						->join(array("m" => "$sc.metas"),
								"m.objetivo_especifico_id = oe.id and m.situacao_id = 1", array())
						->join(array("o" => "$sc.operacoes"),
								"o.meta_id = m.id and o.situacao_id = 1", array());
		}

		$resultado = $this->fetchRow($select);
		return $resultado["total"];
		
	} // end function

}


