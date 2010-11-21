<?php
require_once ('Zend/Form.php');
/**
 * @author Marcone Costa
 */
class Programacao_Form_Projeto extends Zend_Form {
	/**
	 * @var Zend_Form_SubForm subform
	 */
	public $subform;
    public function __construct($options = null) {
        parent::__construct($options = null);
		$this->subform = new Zend_Form_SubForm('projeto');
		$this->setName('frmprograma');
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
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
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('size', 20)
                ->setAttrib('maxlength', 20);

        $interfaces = new Zend_Form_Element_Textarea('interfaces');
        $interfaces->setLabel('Interfaces')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttrib('rows', 4)
                ->setAttrib('cols', 70);
                

        $this->subform->addElements(array($id, $descricao, $menu, $interfaces, $this->getResponsaveis()));

		$this->subform->addElement('hidden','programa_id');
		$this->subform->addElement('hidden','projeto_id');
		$this->subform->addDisplayGroup(array('id', 'programa_id','projeto_id'),'ident');        
        
        
        $this->addSubForm($this->subform, 'projeto');

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setAttrib('class', 'by-ajax');
        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($submit, $close));
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