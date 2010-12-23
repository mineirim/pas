<?php
require_once ('Zend/Form.php');
/**
 * @author Marcone Costa
 */
class Programacao_Form_Parceiro extends Zend_Form {
	/**
	 * @var Zend_Form_SubForm subform
	 */
    public $subform;
    public $nome;
    public $sigla;
    public $observacoes;
    public function __construct($options = null) {
        parent::__construct($options = null);
        $this->subform = new Zend_Form_SubForm('parceiro');
        $this->setName('frmpparceiro');
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        $id = new Zend_Form_Element_Hidden('id');

        $nome = new Zend_Form_Element_Text('nome');
        $nome->setLabel('Nome da instituição')
                ->setRequired(true)
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->addValidator('NotEmpty')
                ->setAttrib('size', 70)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );
        $observacoes = new Zend_Form_Element_Textarea('observacoes');
        $observacoes->setLabel('Observações sobre o parceiro')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setAttrib('rows', 6)
                ->setAttrib('cols', 70)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );
                
        $sigla = new Zend_Form_Element_Text('sigla');
        $sigla->setLabel('Sigla')
                ->addFilter('StripTags')
                ->addFilter('StringTrim')
                ->setRequired(true)
                ->addValidator('NotEmpty')
                ->setAttrib('size', 20)
                ->setAttrib('maxlength', 20)
                ->setDecorators(
                        array(array('ViewScript', array('viewScript' => '_formtext.phtml')))
                    );

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submitbutton')
                ->setLabel('Salvar')
                ->setAttrib('class', 'by-ajax');

        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));
        $this->subform->addElements(array( $nome,$observacoes, $sigla));
        $this->addSubForm($this->subform, 'parceiro');
        $this->addElements(array($id, $submit, $close));
    }

}

?>