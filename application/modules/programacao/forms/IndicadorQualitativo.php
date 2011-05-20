<?php

class Programacao_Form_IndicadorQualitativo extends Zend_Form {

    public function __construct($options = null) {
        parent::__construct($options);

        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
        
        $this->setName('frmindicadorqualitativo'); 
        
        $id = new Zend_Form_Element_Hidden('id');
        $id->removeDecorator('label');

        $indicador_id = new Zend_Form_Element_Hidden('indicador_id');
        $indicador_id->removeDecorator('label');

        $opcao_qualitativo_id = new Zend_Form_Element_Select('opcao_qualitativo_id');
        $opcao_qualitativo_id->setLabel('Categoria');

        
        $opcoes_qualitativos = new Model_OpcoesQualitativos();
        foreach ($opcoes_qualitativos->fetchAll('indicador_id = '. $options['indicador_id']) as $opcao) {
            $opcao_qualitativo_id->addMultiOption($opcao->id, $opcao->descricao);
        }        
        

        $submit = new Zend_Form_Element_Submit('submit');
        $submit->setAttrib('id', 'submit_indicadorqualitativo')
                ->setLabel('Adicionar')
                ->setAttrib('class', 'submit_indicadorqualitativo');
        
        
        $close = new Zend_Form_Element_Button('cancelar');
        $close->setAttrib('class', 'dialog-form-quali-close')->setLabel('Cancelar')
        	  ->setDecorators(array('ViewHelper', 'Errors' ));        


        $this->addElements(array($id, $indicador_id, $opcao_qualitativo_id, $submit, $close));

	       
    }

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array (
		              'indicador_id'=>$this->getValue('indicador_id'),
		              'opcao_qualitativo_id'=>$this->getValue('opcao_qualitativo_id')
		              );
		
		return $dados;
	}
    
    
}