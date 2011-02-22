<?php 

class Programacao_Form_AtividadesPacto extends Zend_Form
{

	public function __construct($options = null,$name='atividades_pacto' )
	{
            parent::__construct($options);
            $translate = Zend_Registry::get('translate');
            $this->setTranslator($translate);
            $this->setName('frmatividadespacto');
            $id= new Zend_Form_Element_Hidden('id');
            $id->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml'))));


                        
            $justificativa = new Zend_Form_Element_Textarea('justificativa');
            $justificativa	->setLabel('Justificativa')
            				->setAttrib('readonly', 'readonly')
		                    ->setAttrib('rows',4)
		                    ->setAttrib('class', 'ui-widget ui-widget-content ui-corner-all')            
            				->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml'))));;
                        
            $is_pactuado = new Zend_Form_Element_Radio('is_pactuado');
            $is_pactuado->setLabel('Aceita Dependência?')
            			->addMultiOptions(array(0 => 'Não', '1' => 'Sim'))
            			->setAttrib('class', 'ui-widget ui-widget-content ui-corner-all')
            			->setRequired(true)
            			->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formselect.phtml'))));	                        
                        
            
            $observacao= new Zend_Form_Element_Textarea('observacoes');
            $observacao->setLabel('Observações')
                    ->setRequired(true)
                    ->addFilter('StripTags')
                    ->addFilter('StringTrim')
                    ->addValidator('NotEmpty')
                    ->setAttrib('rows',4)
                    ->setAttrib('class', 'ui-widget ui-widget-content ui-corner-all')
                    ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml'))));
            
			
            $this->addElements(array($id, $justificativa,$is_pactuado,$observacao));


            $submit = new Zend_Form_Element_Submit('submit');
            $submit->setAttrib('id', 'submitbutton')
                            ->setLabel('Salvar')
                            ->setAttrib('class', 'by-ajax ui-widget ui-widget-content ui-corner-all');

            $close = new Zend_Form_Element_Button('cancelar');
            $close->setAttrib('class', 'dialog-form-close ui-widget ui-widget-content ui-corner-all')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($submit, $close));
		
	}


}