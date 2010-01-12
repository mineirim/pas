<?php

class Form_Relatoriosplano extends Zend_Form
{
	public function __construct($options = null,$name='relatoriosplano' )
	{
		parent::__construct($options);
		$this->setName($name);
		
		$tabela = new Zend_Form_Element_Hidden('tabela');

		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('tabela', 'submitbutton')
				->setLabel('Salvar');
		$this->addElements(array($tabela, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'),
						'responsavel'	=> $this->getValue('responsavel'), 
						'intersecao'	=> $this->getValue('intersecao'), 
						'valor'			=> $this->getValue('valor'),
						'operacao_id'	=> $this->getValue('operacao_id')
		);
		
		return $dados;
	}
}