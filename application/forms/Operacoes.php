<?php

class Form_Operacoes extends Zend_Form
{
	public function __construct($options = null,$name='operacao' )
	{
		parent::__construct($options);
		
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		$meta_id = new Zend_Form_Element_Hidden('meta_id');
		$meta_id->removeDecorator('label');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$this->addElements(array($id, $descricao, $meta_id, $submit));
	}

	
	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'), 
						'meta_id'	=> $this->getValue('meta_id')
				);
		
		return $dados;
	}
}