<?php

class Form_ObjetivosEspecificos extends Zend_Form
{
	public function __construct($options = null,$name='acao' )
	{
		parent::__construct($options);
		
		
		$this->setName($name);
		$id = new Zend_Form_Element_Hidden('id');
		
		$projeto_id = new Zend_Form_Element_Hidden('projeto_id');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		$menu = new Zend_Form_Element_Text('menu');
		$menu->setLabel('Menu')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');

		$recursos = new Zend_Form_Element_Textarea('recursos');
		$recursos->setLabel('Recursos')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		
		$cronograma = new Zend_Form_Element_Textarea('cronograma');
		$cronograma->setLabel('Cronograma')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4);
			
			
			
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar');
		
		$this->addElements(array($id,$projeto_id, $descricao, $menu,$recursos, $cronograma,  $submit));
		$this->addDisplayGroup(array('id', 'projeto_id'),'ident');
	}

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('descricao' 	=> $this->getValue('descricao'), 
					'menu'				=> $this->getValue('menu'),
					'recursos'			=> $this->getValue('recursos'),
					'cronograma' 		=> $this->getValue('cronograma'),
					'projeto_id'		=> $this->getValue('projeto_id')
				);
		
		return $dados;

	}
}