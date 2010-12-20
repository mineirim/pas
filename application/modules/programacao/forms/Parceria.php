<?php

class Programacao_Form_Parceria extends Zend_Form
{
	/**
	 * @var Zend_Form_SubForm subform
	 */
	public $subform,$subform2 ;
	public function __construct($options = null)
	{
		parent::__construct($options);
		$translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        
        $this->subform = new Zend_Form_SubForm('parceria');
		$this->setName('frmparceria');
		$id = new Zend_Form_Element_Hidden('id');
	
		$parceiro_id = new Zend_Form_Element_Hidden('parceiro_id');
		$parceiro_id->setRequired(true);
		$parceiro_text = new Zend_Form_Element_Text('parceiro_text');
		$parceiro_text->setLabel('Parceiro')->setAttrib('size', 59);
								
		$objetivo_especifico_id = new Zend_Form_Element_Hidden('objetivo_especifico_id');
		$objetivo_especifico_id->setRequired(true)
					->addValidator('NotEmpty')
					->addValidator('Int');
								
		$observacoes = new Zend_Form_Element_Textarea('observacoes');
		$observacoes->setLabel('Observações/comentários sobre a parceria')
			->addFilter('StripTags')
			->addFilter('StringTrim')
			->setAttrib('rows',4)
			->setAttrib('cols',58);
		$this->subform->addElements(array($id,$parceiro_id, $objetivo_especifico_id, $observacoes ));
		$this->subform->addDisplayGroup(array('id', 'parceiro_id', 'objetivo_especifico_id'),'ident');
		$this->addSubForm($this->subform, 'parceria');

		$tipos_parcerias_ids = new Zend_Form_Element_MultiCheckbox('tipos_parcerias_ids');
		$tipos_parcerias_ids->setRequired(true);
		$model_tipos_parcerias = new Model_TiposParcerias();
		$tipos_parcerias = $model_tipos_parcerias->fetchAll('situacao_id=1');
		
		foreach ($tipos_parcerias as $tipo_parceria) {
			$tipos_parcerias_ids->addMultiOption($tipo_parceria->id, $tipo_parceria->descricao);
		}
		$this->subform2 = new Zend_Form_SubForm('frmtipos_parcerias');
		$this->subform2->addElement($tipos_parcerias_ids);
		$this->addSubForm($this->subform2, 'tipo_parceria');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submitbutton')
				->setDecorators(array('ViewHelper', 'Errors'))
				->setLabel('Salvar')->setAttrib('class', 'by-ajax');
		
		$close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-close')
              ->setDecorators(array('ViewHelper', 'Errors'));        
        
        $this->addElements(array($parceiro_text,$submit, $close));
	}
}