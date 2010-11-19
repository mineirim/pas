<?php
class Programacao_Form_Delete extends Zend_Form
{
	public function __construct($options = null,$name='delete' )
	{
            parent::__construct($options);
            $translate = Zend_Registry::get('translate');
            $this->setTranslator($translate);
            $this->setName($name);
            $id = new Zend_Form_Element_Hidden('id');

            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setAttrib('class', 'by-ajax')->setLabel('Confirmar')->setAttrib('id', 'submitbutton');
            $close = new Zend_Form_Element_Button('dialog_close');
            $close->setAttrib('class', 'dialog-form-close')
                    ->setLabel('Cancelar')
                    ->setDecorators(array('ViewHelper', 'Errors', 'Label'));;

            $this->addElement($id);
            $this->addElement($submit);
            $this->addElement($close);

	}
}