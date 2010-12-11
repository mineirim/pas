<?php

class Programacao_Form_Operacao extends Zend_Form
{
	 /**
	  *  @var Zend_Form_SubForm subform
	 */
	public $subform;
	public function __construct($options = null,$name='operacao' )
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$this->subform = new Zend_Form_SubForm('operacao');
		$this->setName('frmoperacao');
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		$meta_id = new Zend_Form_Element_Hidden('meta_id');
		$meta_id->removeDecorator('label');
		
		$descricao = new Zend_Form_Element_Textarea('descricao');
		$descricao->setLabel('Descrição')
			->setRequired(true)
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->addValidator('NotEmpty')
			->setAttrib('rows',4);
		
		
		$this->subform->addElements(array($id, $descricao, $meta_id));
		$this->subform->addDisplayGroup(array('id', 'meta_id'),'ident');
		$this->addSubForm($this->subform, 'operacao');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setLabel('Salvar')->setAttrib('class', 'by-ajax');
		
		$close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($submit, $close));		
	}


}