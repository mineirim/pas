<?php

class Form_IndicadorConfig extends Zend_Form_SubForm
{
	public function __construct($options = null )
	{
		parent::__construct($options);
        $translate = Zend_Registry::get('translate');
        $this->setTranslator($translate);
		$id = new Zend_Form_Element_Hidden('id');
		$id->removeDecorator('label');
		
		$indicador_id = new Zend_Form_Element_Hidden('indicador_id');
		$indicador_id->removeDecorator('label');
		
		$base = new Zend_Form_Element_Select('base');
		$base->setLabel('Base');
		$arr_bases = array(1 =>'Nº absoluto',100=>'100',1000=>'1.000', 10000=>'10.000',100000=>'100.000');
		$base->setMultiOptions($arr_bases);
		
		$campos = new Zend_Form_Element_Radio('campos');
        $arr_campos = array('n,d' =>'Numerador e Denominador','r'=>'Resultado');
        $campos->setMultiOptions($arr_campos)
          ->removeDecorator('label')
          ->removeDecorator('HtmlTag');
		
		$tipo_periodo_id = new Zend_Form_Element_Select('tipo_periodo_id');
		$tipo_periodo_id ->setLabel('Periodicidade de atualização');
		$tiposperiodo = new Model_TiposPeriodos();
		
		foreach ($tiposperiodo->fetchAll() as $tipo ){
			$tipo_periodo_id->addMultiOption($tipo->id,$tipo->descricao);
		}
        
		$date = new Zend_Date();
        $monthOptions = array();
        for ($i = 1; $i < 13; $i ++)
        {
            $date->set($i, Zend_Date::MONTH);
            $idx = str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthOptions[$idx] = $date->toString('MMMM');
        }
		
		$mes = new Zend_Form_Element_Select('mes');
		$mes->addMultiOptions($monthOptions)
		  ->removeDecorator('label')
          ->removeDecorator('HtmlTag');
		
		
		$ano = new Zend_Form_Element_Text('ano');
		$ano->removeDecorator('label')
          ->removeDecorator('HtmlTag')
          ->setAttrib('size','4');
		
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setAttrib('id', 'submit_descritivo')
				->setLabel('Adicionar')
				->setAttrib('class','submit_descritivo');
		
		
		$this->addElements(array($id, $indicador_id, $base,$campos, $mes,$ano,$tipo_periodo_id,$submit ));
	
	}

	/**
	 * retorna um array associativo para inserção dos dados na tabela
	 * @param $form
	 * @param array $array_add campos adicionais que serão persistidos com o objeto  
	 * @return array
	 */
	public function getDados($array_add=false) {
		
		$dados = array ('base' 	=> $this->getValue('base'), 
		              'indicador_id'=>$this->getValue('indicador_id'),
				      'tipo_periodo_id'=>$this->getValue('tipo_periodo_id'),
		              'campos'=>  $this->getValue('campos'),
		              'inicio_preenchimento'=> $this->getValue('ano').$this->getValue('mes')				
		              );
		
		return $dados;
	}
}
