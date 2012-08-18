<?php

class Loja_Model_DbTable_Usuarios extends Zend_Db_Table_Abstract
{

    protected $_name = 'usuarios';

    /**
     * Retorna um array associativo com todos os usuários para ser
     * inserido em um select (form)
     */
    public function getUsuariosSelect()
    {
        $select = $this->select()
            ->from($this->_name, array('id_usuario', 'nome'))
            ->order('nome');
        
        return $this->getAdapter()->fetchPairs($select);
    }
}

