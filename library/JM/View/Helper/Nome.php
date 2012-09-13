<?php

/**
 * Description of Nome
 *
 * @author Gedvan
 */
class JM_View_Helper_Nome extends Zend_View_Helper_Abstract
{
    public function nome($nome)
    {
        echo '<div class="nome">'.strtoupper($nome).'</div>';
    }
}

