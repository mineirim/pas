<?php

require_once ('Zend/Acl/Role/Interface.php');
require_once ('Zend/Db/Table/Row/Abstract.php');

/**
 * @author marcone
 *
 *
 */
class Model_Row_Projeto extends Zend_Db_Table_Row_Abstract {
    public $objetivos = array();

}

?>