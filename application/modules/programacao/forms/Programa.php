<?php
require_once ('Zend/Form.php');
/**
 * @author Marcone Costa
 */
class Programacao_Form_Programa extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options = null);

        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $this->setName($name);
        $id = new Zend_Form_Element_Hidden('id');

        $descricao = new Zend_Form_Element_Textarea('descricao');
        $descricao->setLabel('Descrição')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 70);

        $menu = new Zend_Form_Element_Text('menu');
        $menu->setLabel('Descrição no menu')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttrib('size', 20)
                ->setAttrib('maxlength', 20);

        $interfaces = new Zend_Form_Element_Textarea('interfaces');
        $interfaces->setLabel('Interfaces')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 70);


        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setAttrib('class', 'by-ajax');
        $close = new Zend_Form_Element_Button('dialog_close');
        $close->setAttrib('class', 'dialog-form-close')
              ->setLabel('Cancelar')
              ->setDecorators(array('ViewHelper', 'Errors', 'Label'));
        $this->addElements(array($id, $descricao, $menu, $interfaces, $this->getResponsaveis(), $submit, $close));
    }

    public function getResponsaveis() {


        $usuarios = new Model_Usuarios();
        $form = new Zend_Form_Element_Select('responsavel_id');
        foreach ($usuarios->fetchAll('1=1', array('nome')) as $p)
            $form->addMultiOptions(array($p->id => " " . $p->nome));
        $form->setLabel("Responsável:")
                ->setRequired(true);
        return $form;
    }

}

?>