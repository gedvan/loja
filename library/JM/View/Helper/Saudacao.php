<?php

/**
 * Description of Saudacao
 *
 * @author Gedvan
 */
class JM_View_Helper_Saudacao extends Zend_View_Helper_Abstract
{
    public function saudacao($usuario)
    {
        return '<div class="saudacao">Olá, <strong>'.
                $this->view->escape($usuario).
                '</strong>! Seja bem vindo!</div>';
    }
}

