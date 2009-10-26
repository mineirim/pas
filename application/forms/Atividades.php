<?php

class Form_Atividades extends Zend_Form
{
	public function __construct($options = null,$name='atividade' )
	{
		parent::__construct($options);
		
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		$operacao_id = new Zend_Form_Element_Hidden('operacao_id');
		
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		$responsavel = new Zend_Form_Element_Text('responsavel');
		$responsavel->setLabel('Responsavel')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');
		$intersecao = new Zend_Form_Element_Text('intersecao');
		$intersecao->setLabel('Intersecao')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('size','80');
		$valor = new Zend_Form_Element_Text('valor');
		$valor->setLabel('Valor');
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
		$this->addElements(array($id, $descricao, $responsavel, $intersecao, $valor, $operacao_id, $submit));
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