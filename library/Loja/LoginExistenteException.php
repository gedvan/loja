<?php

/**
 * Description of LoginExistenteException
 *
 * @author Gedvan
 */
class Loja_LoginExistenteException extends Exception
{
    protected $_login;
    
    public function __construct($login)
    {
        $this->_login = $login;
    }
    
    public function getLogin()
    {
        return $this->_login;
    }
}
