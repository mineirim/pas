<?php

class Programacao_Form_ObjetivoEspecifico extends Zend_Form {

    /**
     * @var Zend_Form_SubForm subform
     */
    public $subform;

    public function __construct($options = null) {
        parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);

        $this->subform = new Zend_Form_SubForm('objetivoespecifico');
        $this->setName('frmobjetivo');
        $id = new Zend_Form_Element_Hidden('id');
        $projeto_id = new Zend_Form_Element_Hidden('projeto_id');
        $projeto_id->setRequired(true)
                ->addValidator('NotEmpty')
                ->addValidator('Int')
                ->addFilter('StringTrim');

        $validatamanho = new Zend_Validate_StringLength(0, 2000);
        $validatamanho->setMessage("A descrição deve deve conter entre %min% e %max% caracteres");
        $validatamanho->setDisableTranslator(true);
        $descricao = new Zend_Form_Element_Textarea('descricao');

        $descricao->setLabel('Descrição')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->addValidator($validatamanho)
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 70);

        $menu = new Zend_Form_Element_Text('menu');
        $menu->setLabel('Menu')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('size', '20')
                ->setAttrib('maxlength', '20')
                ->addErrorMessage('Menu não pode ficar vazio');

        $recursos = new Zend_Form_Element_Textarea('recursos');
        $recursos->setLabel('Recursos')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 70)
                ->addErrorMessage('Recursos não pode ficar vazio');

        $this->subform->addElements(array($id, $projeto_id, $descricao, $menu, $recursos, $this->getSetores()));
        $this->subform->addDisplayGroup(array('id', 'projeto_id'), 'ident');
        $this->addSubForm($this->subform, 'objetivoespecifico');


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel('Salvar')->setAttrib('class', 'by-ajax');

        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
                ->setDecorators(array('ViewHelper', 'Errors'));

        $this->addElements(array($submit, $close));
    }

    public function getSetores() {
        $setores = new Model_Setores();
        $form = new Zend_Form_Element_Select('setor_id');
        foreach ($setores->fetchAll('1=1', array('nome')) as $p)
            $form->addMultiOptions(array($p->id => " " . $p->nome . "(" . $p->sigla . ")"));
        $form->setLabel("Setor Responsável:")
                ->setRequired(true)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formselect.phtml')))
        );
        ;
        return $form;
    }

}