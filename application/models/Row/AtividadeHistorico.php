<?php

require_once ('Zend/Acl/Role/Interface.php');
require_once ('Zend/Db/Table/Row/Abstract.php');

/**
 * @author marcone
 *
 *
 */
class Model_Row_AtividadeHistorico extends Zend_Db_Table_Row_Abstract {

    public function toArray() {
        $data = parent::toArray();
        $dt = new Zend_Date($data['data_inicio'], Zend_Date::ISO_8601);
        $data['data_inicio'] = $dt->get(Zend_Date::DATE_MEDIUM);
        ;

        $dt = new Zend_Date($data['data_prazo'], Zend_Date::ISO_8601);
        $data['data_prazo'] = $dt->get(Zend_Date::DATE_MEDIUM);
        if($data['data_conclusao']){
            $dt = new Zend_Date($data['data_conclusao'], Zend_Date::ISO_8601);
            $data['data_conclusao'] = $dt->get(Zend_Date::DATE_MEDIUM);
        }
        return $data;
    }

    public function data_inicio() {
        $dt = new Zend_Date($this->data_inicio, Zend_Date::ISO_8601);

        return $dt->get(Zend_Date::DATE_MEDIUM);
    }

    public function data_prazo() {
        $dt = new Zend_Date($this->data_prazo, Zend_Date::ISO_8601);
        return $dt->get(Zend_Date::DATE_MEDIUM);
    }

    public function data_conclusao() {
        $dt = new Zend_Date($this->data_conclusao, Zend_Date::ISO_8601);
        return $dt->get(Zend_Date::DATE_MEDIUM);
    }

}

?>