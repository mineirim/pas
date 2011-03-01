<?php

class Programacao_Form_Indicador extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);

        $this->subform = new Zend_Form_SubForm('indicador');
        $this->setName('frmindicador');

        $id = new Zend_Form_Element_Hidden('id');
        $id->removeDecorator('label');

        $descricao = new Zend_Form_Element_Textarea('descricao');
        $descricao->setRequired(true)->setLabel('Descrição')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('cols', 60)
                ->setAttrib('rows', 2);

        $tipo_indicador_id = new Zend_Form_Element_Radio('tipo_indicador_id');

        $tipo_indicador_id->setLabel('Classificação quanto ao tipo');
        $tiposIndicadores = new Model_TiposIndicadores();

        foreach ($tiposIndicadores->fetchAll(null, 'id') as $tipoIndicador) {
            $tipo_indicador_id->addMultiOption($tipoIndicador->id, $tipoIndicador->descricao);
        }
        $tipo_indicador_id->addDecorator('HtmlTag', array('tag' => 'div', 'style' => 'padding:0;border:none;margin:0;float:left;'));


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'salvarindicador')
                ->setDecorators(array('ViewHelper', 'Errors'))
                ->setAttrib('class', 'by-ajax')->setLabel('Salvar');
        
        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')->setLabel('Cancelar')
        	  ->setDecorators(array('ViewHelper', 'Errors' ));

        $this->subform->addElements(array($id, $descricao, $tipo_indicador_id));
        $this->addSubForm($this->subform, 'indicador');

        $this->addElements(array($submit, $close));	


        }



}