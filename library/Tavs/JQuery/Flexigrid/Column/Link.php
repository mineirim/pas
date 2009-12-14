<?php

/**
 * @see Tavs_JQuery_Column_Abstract
 */
require_once 'Tavs/JQuery/Flexigrid/Column/Abstract.php';

/**
 * Classe para gerar link na coluna do FlexGrid
 *
 * @author Tales Augusto <tales.augusto.santos@gmail.com>
 * 
 * @filesource
 */
class Tavs_JQuery_Flexigrid_Column_Link extends Tavs_JQuery_Flexigrid_Column_Abstract
{
	/**
	 * Recebe atributos do link
	 *
	 */ 
	protected $_linkAttribs = array();
	
	/**
	 * Conteudo do link 
	 *
	 */ 
	protected $_content;
	
	/**
	 * Seta o conteudo do link
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param string $content Valor do link
	 * 
	 * @return string
	 */
	public function setContent($content)
	{
		$this->_content = (string) $content;
		return $this;
	}
	
	/**
	 * Seta os atributos do link
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param array $attribs Array com atributos
	 * 
	 * @return object
	 */
	public function setLinkAttribs(array $attribs)
	{
		$this->_linkAttribs = $attribs;
		return $this;
	}
	
	
    /**
     * Converte um array associativo para string de atributos de tags.
     *
     * @param array $attribs Array a ser convertido.
     *
     * @return string The XHTML for the attributes.
     */
    protected function _htmlAttribs($attribs)
    {
        $xhtml = '';
        $view = $this->getView();
        foreach ((array) $attribs as $key => $val) {
            $key = $view->escape($key);

            if (('on' == substr($key, 0, 2)) || ('constraints' == $key)) {
                // Don't escape event attributes; _do_ substitute double quotes with singles
                if (!is_scalar($val)) {
                    // non-scalar data should be cast to JSON first
                    require_once 'Zend/Json.php';
                    $val = Zend_Json::encode($val);
                }
                $val = preg_replace('/"([^"]*)":/', '$1:', $val);
            } else {
                if (is_array($val)) {
                    $val = implode(' ', $val);
                }
                $val = $view->escape($val);
            }

            if ('id' == $key) {
                $val = $this->_normalizeId($val);
            }

            $xhtml .= " $key=\"$val\"";
        }
        return $xhtml;
    }
	
	/**
	 * @see Tavs_JQuery_Column_Abstract::render
	 *
	 * @param string $value
	 * @return string
	 */
	public function render($value)
	{
		$view = $this->getView();
		$value = $view->formatString()->normalizeUrl($value);
		if ( $value !== false )
		{
			$this->_linkAttribs['href'] = $value;
			$link = '<a ' . $this->_htmlAttribs($this->_linkAttribs) . '>' . $this->_content . '</a>';
		}
		else
		{ 
			$link = '-';
		}
		
		return (string) $link;
	}
}