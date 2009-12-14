<?php

/**
 * Classe para gerar o select nas colunas do Flexigrid.
 *
 * @author Tales Augusto <tales.augusto.santos@gmail.com>
 * 
 * @uses Tavs_JQuery_Column_Abstract
 * 
 * @filesource
 * 
 */
abstract class Tavs_JQuery_Flexigrid_Column_Abstract
{
	/**
	 * Alinhamento das colunas
	 */
	const ALIGN_LEFT   = 'left';
	const ALIGN_CENTER = 'center';
	const ALIGN_RIGHT  = 'right';
	
	/**
	 * Nome da coluna
	 * 
	 * @access protected
	 *
	 * @var string
	 */
	protected $_name;
	
	/**
	 * Label da coluna
	 * 
	 * @access protected
	 *
	 * @var string
	 */
	protected $_label = 'Column';
	
	/**
	 * Largura da coluna
	 * 
	 * @access protected
	 *
	 * @var integer
	 */
	protected $_width = 100;
	
	/**
	 * Coluna é ordenavel?
	 * 
	 * @access protected
	 *
	 * @var string
	 */
	protected $_sortable = true;
	
	/**
	 * Alinhamento da coluna
	 * 
	 * @access protected
	 *
	 * @var string
	 */
	protected $_align = self::ALIGN_LEFT;
	
	/**
	 * Aparece no formulario de busca?
	 * 
	 * @access protected
	 *
	 * @var boolean
	 */
	protected $_searchable = true;
	
	/**
	 * Objeto para fazer a renderizacao dos campos.
	 * 
	 * Usa acessa os helpers de criacao de elementos.
	 * 
	 * @access protected
	 *
	 * @var Zend_View_Interface
	 */
	protected $_view;
	
	/**
	 * Atributos do elemento
	 * 
	 * @access protected
	 *
	 * @var string
	 */
	protected $_elementAttribs = array();
	
	/**
	 * Valor a ser mostrado como padrão
	 *
	 * @var string
	 */
	protected $_defaultValue = '-';
	
	/**
	 * Cont�m as informacoes da linha que est� sendo renderizada
	 *
	 * @var array
	 */
	protected $_rowData = array();
	
	/**
	 * Construtor
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $name Nome da coluna
	 * 
	 * @return void
	 */
	public function __construct($name, array $options = array())
	{
		$this->_name = (string) $name;
		$this->setOptions($options);
	}
	
	/**
	 * Seta as configurações.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param array $options Opções da coluna
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 * 
	 */
	public function setOptions(array $options)
	{
		foreach ( $options as $opt => $value )
		{
			$method_name = 'set' . ucfirst($opt);
			if ( method_exists($this, $method_name) )
			{
				$this->$method_name($value);
			}
		}
		return $this;
	}
	
	/**
	 * Retorna o nome da coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}
	
	/**
	 * Seta o texto da coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $label
	 * 
	 * @return Tavs_JQuery_Column_Abstract
	 */
	public function setLabel($label)
	{
		$this->_label = (string) $label;
		return $this;
	}
	
	
	/**
	 * Retorna o label da coluna
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function getLabel()
	{
		return $this->_label;
	}
	
	/**
	 * Seta o texto da coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $label
	 * 
	 * @return Tavs_JQuery_Column_Abstract
	 */
	public function setWidth($width)
	{
		$this->_width = (integer) $width;
		return $this;
	}
	
	/**
	 * Seta o texto da coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $label
	 * 
	 * @return Tavs_JQuery_Column_Abstract
	 */
	public function setSortable($bool)
	{
		$this->_sortable = (bool) $bool;
		return $this;
	}

	/**
	 * Seta o texto da coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $label
	 * 
	 * @return Tavs_JQuery_Column_Abstract
	 */
	public function setAlign($align)
	{
		$this->_align = (string) $align;
		return $this;
	}
	
	/**
	 * Define se o campo sera pesquisavel
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param boolen $boolean
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function setSearchable($bool = true)
	{
		$this->_searchable = (bool) $bool;
		return $this;
	}
	
	/**
	 * Retorna true se o campo for pesquisavel
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @return boolen
	 */
	public function getSearchable()
	{
		return $this->_searchable;
	}
	
	/**
     * Seta o objeto de visualizao.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     * 
     * @param Zend_View_Interface $view 
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function setView(Zend_View_Interface $view = null)
    {
        $this->_view = $view;
        return $this;
    }
	
    /**
     * Seta o valor padrão
     *
     * @param string $value
     * 
     * @return Tavs_JQuery_Column_Abstract
     */
    public function setDefaultValue($value)
    {
    	$this->_defaultValue = (string) $value;
    	return $this;
    }
    
    /**
     * Retorna o valor padrão
     *
     * @return String
     */
    public function getDefaultValue()
    {
    	return $this->_defaultValue;
    }
    
    /**
     * Retorna o objeto de renderização
     *
     * Se não estiver setada o objeto, cria-o.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     * 
     * @return Zend_View_Interface
     */
    public function getView()
    {
        if ( null === $this->_view )
        {
            require_once 'Zend/Controller/Action/HelperBroker.php';
            $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
            $this->setView($viewRenderer->view);
        }

        return $this->_view;
    }
    
    /**
     * Seta as informacoes da linha que esta sendo renderizada
     *
     * @param array $data
     * @return Tavs_JQuery_Flexigrid_Column_Abstract
     */
    public function setRowData(array $data = array())
    {
    	$this->_rowData = $data;
    	return $this;
    }
    
    /**
     * Retorna as informa��es da linha que est� sendo renderizada.
     *
     * @return array
     */
    public function getRowData()
    {
    	return $this->_rowData;
    }
    
    /**
     * Retorna o array com as propriedados dos campos.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     * 
     * @return array
     */
    public function __toArray()
    {
    	$array = array(
    		'name' => $this->_name,
    		'display' => $this->_label,
    		'width' => $this->_width,
    		'align' => $this->_align,
    		'sortable' => $this->_sortable
    	);
    	
    	return $array;
    }
	
	/**
	 * Renderiza a coluna.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string Valor a ser renderizado pela coluna
	 */
	abstract public function render($value);
}