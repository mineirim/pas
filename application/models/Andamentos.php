<?php

class Model_Andamentos extends App_DefaultModel 
{
	
	protected $_name = 'andamentos';
	
	protected $_dependentTables = array('Model_AtividadesHistorico');
}

