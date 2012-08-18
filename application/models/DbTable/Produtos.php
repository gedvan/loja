<?php

class Loja_Model_DbTable_Produtos extends Zend_Db_Table_Abstract
{

    protected $_name = 'produtos';

    protected $_referenceMap = array(
        'Criador' => array(
            'columns' => 'fk_usuario',
            'refTableClass' => 'Loja_Model_DbTable_Usuarios',
            'refColumns' => 'id_usuario',
        ),
        'AlteradoPor' => array(
            'columns' => 'fk_usuario',
            'refTableClass' => 'Loja_Model_DbTable_Usuarios',
            'refColumns' => 'id_usuario',
        ),
    );
}

