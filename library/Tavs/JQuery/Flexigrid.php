<?php

/**
 * Classe para gerar tabela estilizada pelo plugin Flexigrid do jQuery
 *
 * @author Tales Santos <tales.augusto.santos@gmail.com>
 * 
 * @filesource
 * 
 */
class Tavs_JQuery_Flexigrid
{
	/**
	 * Tipos de ordenacao das colunas
	 */
	const SORT_ASC  = 'asc';
	const SORT_DESC = 'desc';
	
	/**
	 * Tipos de retorno do ajax
	 */
	const DATA_TYPE_JSON = 'json';
	const DATA_TYPE_XML = 'xml';
	
	/**
	 * Array com as opções do Flexigrid
	 * 
	 * @access private
	 *
	 * @var array
	 */
	private $_data = array(
		'dataType' => self::DATA_TYPE_JSON,
	);
	
	/**
	 * Colunas do datagrid
	 * 
	 * @access private
	 *
	 * @var array
	 */
	private $_cols = array();
	
	/**
	 * Botoes do flexigrid
	 * 
	 * @access private
	 *
	 * @var array
	 */
	private $_buttons = array();
	
	/**
	 * Campos para busca
	 * 
	 * @access private
	 *
	 * @var array
	 */
	private $_search = array();
	
	/**
	 * Objeto de renderização
	 * 
	 * @access private
	 *
	 * @var Zend_View_Interface
	 */
	private $_view;
	
	/**
	 * Seletor para renderizar o flexigrid
	 * 
	 * @access private
	 *
	 * @var string
	 */
	private $_selector = '#jQuery-Flexigrid';
	
	/**
	 * Atributos da tabela
	 * 
	 * @access private
	 *
	 * @var array
	 */
	private $_tableAttribs = array();
	
	/**
	 * Quantidade de registros por pagina
	 * 
	 * @access private
	 *
	 * @var integer
	 */
	private $_itemCountPerPage = 15;
	
	/**
	 * Pagina atual
	 * 
	 * @access private
	 *
	 * @var integer
	 */
	private $_currentPageNumber = 1;

	/**
	 * Construtor.
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @param string $url Url para requisicao ajax
	 * 
	 * @return void
	 */
	public function __construct($url, array $options = array())
	{
		$this->setUrl($url);
		
		if ( isset($options['url']) )
		{
			unset($options['url']);
		}
		
		if ( !isset($options['buttonSeparator']) )
		{
			$options['buttonSeparator'] = true;
		}
		
		$this->setOptions($options);
		$this->configPaginator(15, 1);
	}
	
	/**
	 * Seta as configurações
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @param array $options Opções do flexigrid
	 * 
	 * @return Tavs_JQuery_Flexigrid
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
	 * Seta a url do flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $url
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function setUrl($url)
	{
		$this->_data['url'] = (string) $url;
		return $this;
	}
	
	/**
	 * Seta o datatype do flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $dataType
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function setDataType($dataType)
	{
		$this->_data['dataType'] = (string) $dataType;
		return $this;
	}
	
	/**
	 * Define a ordem da listagem
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $colName Nome da coluna
	 * @param string $type Tipo de ordenagem
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function orderBy($colName, $type = self::SORT_ASC)
	{
		$this->_data['sortname'] = (string) $colName;
		$this->_data['sortorder'] = (string) $type;
		return $this;
	}
	
	/**
	 * Define a ordem da listagem
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $colName Nome da coluna
	 * @param string $type Tipo de ordenagem
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function setTitle($title)
	{
		$this->_data['title'] = (string) $title;
		return $this;
	}

	/**
	 * Seta as dimensões do Flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param integer $width Largura do Flexigrid
	 * @param integer $height Altura do Flexigrid
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function setDimension($width, $height)
	{
		$this->_data['width'] = (integer) $width;
		$this->_data['height'] = (integer) $height;
		return $this;
	}

	/**
	 * Configura a paginação do Flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param integer $itemsPerPage Registros por pagina
	 * @param boolean $addSelectBox Mostrar select box com as paginas?
	 * @param array $selectBoxOptions Valores mostrados no select box da paginacao
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
	public function configPaginator($itemCountPerPage, $currentPageNumber, $addSelectBox = true, array $selectBoxOptions = array(10, 15, 20, 25, 40))
	{
		//paginacao?
		$this->_data['usepager'] = true;
		
		//registros por pagina
		$this->_data['rp'] = (integer) $itemCountPerPage;
		$this->_itemCountPerPage = (integer) $itemCountPerPage;
		
		//pagina atual
		$this->_currentPageNumber = (integer) $currentPageNumber;
		
		$this->_data['useRp'] = $addSelectBox;
		$this->_data['rpOptions'] = $selectBoxOptions;
		
		return $this;
	}

	/**
     * Seta o objeto de visualizao
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
	 * Adiciona uma nova coluna no flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 *
	 * @param string $name Nome da coluna
	 * @param string $display Display da coluna
	 * @param integer $width Largura da coluna
	 * @param boolean $sorteable Será ordenável?
	 * @param string $align Alinhamento da coluna
	 * 
	 * @return Tavs_JQuery_Flexigrid
	 */
    public function addColumn($type, $name = null, array $options = array())
    {
    	if ( $type instanceof Tavs_JQuery_Flexigrid_Column_Abstract )
    	{
    		$column = $type;
    		unset($type);
    	}
    	elseif ( is_string($name) )
    	{
    		$class_name = 'Tavs_JQuery_Flexigrid_Column_' . ucfirst($type);
    		$column = new $class_name($name, $options);
    	}
    	
    	$this->_cols[$column->getName()] = $column;
    	if ( $column->getSearchable() )
    	{
    		$this->addSearch($column->getName(), $column->getLabel());
    	}

    	return $this;
    }
    
    /**
     * Retorna as colunas do grid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @return array
     */
    public function getCols()
    {
    	return $this->_cols;
    }
    
    /**
     * Selecao de uma unica linha?
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param boolean $bool
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function setSingleSelect($bool = true)
    {
    	$this->_data['singleSelect'] = (bool) $bool;
    	return $this;
    }
   
    /**
     * Remove uma coluna do flexgrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $name Nome da coluna
     * 
     * @return Tavs_JQuery_Flexigrid
     */
	public function removeColumn($name)
    {
    	if ( array_key_exists($name, $this->_cols) )
    	{
    		unset($this->_cols[$name]);
    	}
    	
    	return $this;
    }
    
    /**
     * Adiciona um botão ao grid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $name Label do botao
     * @param string $className Classe do botao
     * @param string $onPress Funcao a ser chamada quando o botao for clicado
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function addButton($name, $className = null, $onPress = null, $separator = true)
    {
    	$new_button = array();
    	
    	$new_button['name'] = (string) $name;
    	
    	if ( null !== $className )
    	{
			$new_button['bclass']  = (string) $className;
    	}
    	
    	if ( null !== $onPress )
    	{
			$new_button['onpress']  = (string) $onPress;
    	}
    	
    	$this->_buttons[strtolower((string) $name)] = $new_button;
    	
    	if ( true === (bool) $separator )
    	{
    		$this->_buttons[] = array('separator' => true);
    	}

    	return $this;
    }
    
    /**
     * Grid estilo zebra?
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $bool
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function setStriped($bool)
    {
    	$this->_data['striped'] = (bool) $bool;
    	return $this;
    }

    /**
     * Seta o seletor de acesso para gerar o flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $selector
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function setSelector($selector)
    {
    	if ( empty($selector) )
    	{
    		throw new Tavs_Exception('É obrigatorio o uso do seletor');
    	}

    	$this->_selector = (string) $selector;
    	return $this;
    }
    
    /**
     * Retorna o seletor
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @return Tavs_JQuery_Flexigrid
     */
    public function getSelector()
    {
    	return $this->_selector;
    }
    
    /**
     * Adiciona um atributo na tabela
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $attrib Nome do atributo
     * @param value $value Valor do atributo
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function addTableAttrib($attrib, $value)
    {
    	$this->_tableAttribs[(string) $attrib] = (string) $value;
    	return $this;
    }
    
    /**
     * Retorna o objeto de renderização
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * Se não estiver setada o objeto, cria-o
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
     * Seta uma propriedade no flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $attrib Nome da propriedade
     * @param string $value Valor da propriedade
     * 
     * @return void
     */
    public function __set($attrib, $value)
    {
    	$method_name = 'set' . ucfirst($attrib);
    	
    	if ( method_exists($this, $method_name) )
    	{
    		$this->$method_name($value);
    	}
    	else
    	{
    		$this->_data[(string) $attrib] = (string) $value;
    	}
    }

    /**
     * Remove uma propriedade do flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $attrib Propriedade a ser removida
     * 
     * @return void
     */
    public function __unset($attrib)
    {
    	if ( array_key_exists($attrib, $this->_data) )
    	{
    		unset($this->_data[$attrib]);
    	}
    }
    
    /**
     * Renderiza o flexigrid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @return string
     */
    public function render(Zend_View_Interface $view = null)
    {
    	if (null !== $view)
    	{
            $this->setView($view);
        }

        if ( empty($this->_cols) )
        {
        	throw new Tavs_JQuery_Flexigrid_Exception('Nenhuma coluna adicionada ao flexigrid');
        }
        else
        {
	    	$this->_data['colModel'] = array();
	    	foreach ( $this->_cols as $column )
	    	{
	    		$this->_data['colModel'][] = $column->__toArray();
	    	}
        }

    	$this->_data['buttons'] = array();
    	foreach ( $this->_buttons as $button )
    	{
    		$this->_data['buttons'][] = $button;
    	}

    	$this->_data['searchitems'] = array();
    	foreach ( $this->_search as $search )
    	{
    		$this->_data['searchitems'][] = $search;
    	}

    	//renderiza o flexigrid
    	$view = $this->getView();
    	$view->addHelperPath('Tavs/View/Helper/', 'Tavs_View_Helper_');
    	
    	$content = $view->flexigrid($this->_selector, $this->_data, $this->_tableAttribs);

    	return $content;
    }
    
    /**
     * Adiciona um campo para busca
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param string $name Nome do input
     * @param string $display Display do input
     * @param string $isDefault Input aparece como default?
     * 
     * @return Tavs_JQuery_Flexigrid
     */
    public function addSearch($fieldName, $display, $isDefault = false)
    {
    	$this->_search[(string) $fieldName] = array(
    		'name' => (string) $fieldName,
    		'display' => (string) $display,
    		'isdefault' => (bool) $isDefault
    	);
    	return $this;
    }
    
    /**
     * Objeto em string
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @return string
     */
    public function __toString()
    {
    	try {
    		$content = $this->render();
    		return $content;
    	}
    	catch (Exception $e) {
    		trigger_error($e->getMessage(), E_USER_ERROR);
    		return '';
    	}
    }
    
    /**
     * Gera o JSON usado na listagem dos dados
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
     *
     * @param mixed $data Registro a ser listado
     * @param string $pk Nome da coluna que é chave primaria
     * 
     * @return string Json codificado
     */
	public function generateRows($data, $pk = null)
	{
		try
		{
			if ( isset($this->_data['sortname']) && $data instanceof Zend_Db_Select )
			{
				/**
				 * @see Zend_Db_Select
				 */
				require_once 'Zend/Db/Select.php';
				$select_order = $data->getPart(Zend_Db_Select::ORDER);

				if ( empty($select_order) )
				{
					$data->order($this->_data['sortname'] . ' ' . $this->_data['sortorder']);
				}
			}

			/**
			 * @see Zend_Paginator
			 */
			require_once 'Zend/Paginator.php';
			
			//configura a paginacao
			$paginator = Zend_Paginator::factory($data);
			$paginator
				->setCurrentPageNumber($this->_currentPageNumber)
				->setItemCountPerPage($this->_itemCountPerPage);
				
			//monta o resultado
			$result = $paginator->getIterator();
			
			$json = array(
	    		'page' => (integer) $this->_currentPageNumber,
	    		'total' => (integer) $paginator->getPages()->totalItemCount,
	    		'rows' => array()
	    	);

	    	if ( !empty($result) )
	    	{
		    	//chave primaria
		    	if ( null !== $pk )
		    	{
		    		$pk = (string) $pk;
		    	}
		    	
				$colsGrid = $this->getCols();
	
		    	foreach ( $result as $row )
		    	{
		    		$newRowJson = array('cell' => array());
		    		
		    		if ( array_key_exists($pk, $row) )
		    		{
		    			$newRowJson['id'] = $row[$pk];
		    		}

		    		foreach ( $colsGrid as $column )
		    		{
		    			//seta as informacoes da linha que esta sendo renderizada
		    			$column->setRowData($row);
		    			$column_name = $column->getName();
		    			if ( array_key_exists($column_name, $row) )
		    			{
		    				$value = trim($row[$column_name]);
		    				if ( empty($value) || is_null($value) )
		    				{
		    					$value = $column->getDefaultValue();
		    				}
		    				$newRowJson['cell'][] = $column->render($value);
		    			}
		    			else
		    			{
		    				$newRowJson['cell'][] = '-';
		    			}
		    		}
	
		    		$json['rows'][] = $newRowJson;
		    	}
	    	}
	    	
	    	return Zend_Json::encode($json);
		}
		catch (Zend_Paginator_Exception $e)
		{
			throw new Tavs_JQuery_Flexigrid_Exception('Tipo de informacao nao suportado');
		}
		return false;
	}
	
	/**
	 * Passa uma funcao para o onSuccess do grid
	 * 
	 * @author Tales Augusto <tales.augusto.santos@gmail.com>
	 * 
	 * @access public
	 * 
	 * @param string $function_name Nome da funcao
	 * 
	 * @return string
	 */
	public function onSuccess($function_name)
	{
		$function_name = str_replace(' ', '', trim($function_name));
		$this->_data['onSuccess'] = (string) $function_name;
		return $this;
	}

}