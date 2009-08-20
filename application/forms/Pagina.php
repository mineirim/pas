<?php

class Form_Pagina extends Zend_Form
{
	public function __construct($options = null)
	{
		parent::__construct($options);
		$this->setName('pagina');
		$id = new Zend_Form_Element_Hidden('id');
		$pagina = new Zend_Form_Element_Text('pagina');
		$pagina->setLabel('Pagina')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty');
		$acao = new Zend_Form_Element_Text('acao');
		$acao->setLabel('Acao')
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
		$this->addElements(array($id, $pagina,$acao, $descricao, $this->getGrupos(), $submit));
	}
	public function getGrupos() {

		
		$grupos = new Model_Grupos();
		
		$formGrupos = new Zend_Form_Element_MultiCheckbox('grupos');
		foreach($grupos->fetchAll(null,array('grupo')) as $g) 
			$formGrupos->addMultiOptions(array($g->id => " ".$g->descricao));
		$formGrupos->setLabel ( "Permissão para:" )
		->setRequired ( true );
		return $formGrupos;
	}
}