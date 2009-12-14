<?php

/**
 * @see Tavs_JQuery_Column_Abstract
 */
require_once 'Tavs/JQuery/Flexigrid/Column/Abstract.php';

/**
 * Classe para gerar o texto nas colunas do Flexigrid.
 *
 * @author Tales Augusto <tales.augusto.santos@gmail.com>
 * 
 * @uses Tavs_JQuery_Column_Abstract
 * 
 * @filesource
 * 
 */
class Tavs_JQuery_Flexigrid_Column_Text extends Tavs_JQuery_Flexigrid_Column_Abstract
{
	/**
	 * @see Tavs_JQuery_Column_Abstract::render
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param string $value
	 * 
	 * @return string
	 */
	public function render($value)
	{
		return (string) $value;
	}
}