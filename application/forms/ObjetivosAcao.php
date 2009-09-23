<?php

class Form_ObjetivosAcao extends Zend_Form
{
	public function __construct($options = null,$name='objetivosAcao' )
	{
		parent::__construct($options);
		
		
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		
		$acao_id = new Zend_Form_Element_Hidden('acao_id');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',2);

			
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_objetivos')
				->setLabel('Adicionar');
		
		$this->addElements(array($id,$acao_id, $descricao,  $submit));
		$this->addDisplayGroup(array('id', 'acao_id'),'ident');
	}

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'), 
					'acao_id'		=> $this->getValue('acao_id')
				);
		
		return $dados;

	}
}