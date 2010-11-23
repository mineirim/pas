<?php

class Programacao_Form_Metas extends Zend_Form
{

	public $subform;
	public function __construct($options = null )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		
		
		$this->subform = new Zend_Form_SubForm('meta');
		$this->setName('frmmeta');
        $id = new Zend_Form_Element_Hidden('id');
		$objetivo_especifico_id = new Zend_Form_Element_Hidden('objetivo_especifico_id');
		$objetivo_especifico_id->setRequired(true)
					->addValidator('NotEmpty')
					->addValidator('Int')
					->addFilter('StringTrim');
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descrição da meta');
		$descricao->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',2);
			

		
		$this->subform->addElements(array($id, $descricao, $objetivo_especifico_id));
        $this->addSubForm($this->subform, 'meta');
        
        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'salvarmeta')
        		->setDecorators(array('ViewHelper', 'Errors'))
                ->setAttrib('class', 'by-ajax')->setLabel('Salvar');
        
        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')->setLabel('Cancelar')
        	  ->setDecorators(array('ViewHelper', 'Errors' ));
        
        $this->addElements(array($submit, $close));		
		
	}

}