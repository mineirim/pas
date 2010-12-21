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
		
        $nome = new Zend_Form_Element_Text('nome');
        
        $nome->setLabel('Nome do Projeto')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('size', 70)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );
        $descritivo = new Zend_Form_Element_Textarea('descritivo');
        $descritivo->setLabel('Descrição do Projeto')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttrib('rows', 6)
                ->setAttrib('cols', 70)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );
                

        $menu = new Zend_Form_Element_Text('menu');
        $menu->setLabel('Descrição no menu')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('size', 20)
                ->setAttrib('maxlength', 20)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );;

                

        $this->subform->addElements(array($id,$nome, $descritivo, $menu,  $this->getSetores()));

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
    public function getSetores() {
        $setores = new Model_Setores();
        $form = new Zend_Form_Element_Select('setor_id');
        foreach ($setores->fetchAll('1=1', array('nome')) as $p)
            $form->addMultiOptions(array($p->id => " " . $p->nome. "(". $p->sigla . ")"));
        $form->setLabel("Setor Responsável:")
                ->setRequired(true)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formselect.phtml')))
                    );;
        return $form;
    }
    

}

?>