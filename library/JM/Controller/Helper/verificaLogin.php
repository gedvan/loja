<?php

/**
 * Description of verificaLogin
 *
 * @author Gedvan
 */
class JM_Controller_Helper_VerificaLogin
    extends Zend_Controller_Action_Helper_Abstract
{
    public function direct()
    {
        var_dump('teste');
    }
    
    public function estaLogado()
    {
        
    }
    
    public function preDispatch()
    {
        parent::preDispatch();
    }
}

