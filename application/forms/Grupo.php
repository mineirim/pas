<?php

class Form_Grupo extends Zend_Form
{
	public function __construct($options = null )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->setName('grupo');
		$id = new Zend_Form_Element_Hidden('id');
		$grupo = new Zend_Form_Element_Text('grupo');
		$grupo->setLabel('Grupo')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$descricao = new Zend_Form_Element_Text('descricao');
		$descricao->setLabel('Descricao')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton');
		$this->addElements(array($id, $grupo, $descricao,$this->getPaginas(), $submit));
	}
	public function getPaginas() {

		
		$paginas = new Model_Paginas();
		
		$formPaginas = new Zend_Form_Element_MultiCheckbox('paginas');
		foreach($paginas->fetchAll() as $p) 
			$formPaginas->addMultiOptions(array($p->id => " ".$p->descricao));
		$formPaginas->setLabel ( "Permissões:" )
		->setRequired ( true );
		return $formPaginas;
	}
}