<?php

class Model_Andamentos extends App_DefaultModel 
{
	
	protected $_name = 'andamentos';
	
	protected $_dependentTables = array('Model_AtividadesHistorico');
	public function init(){
		parent::init();
		$this->_schema = "public";
	}	
}

