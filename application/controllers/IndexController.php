<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
    }

    public function indexAction()
    {
        /*
        Zend_Session::rememberMe(10);
        //Zend_Session::forgetMe();
        
        $s = new Zend_Session_Namespace('usuario');
        $s->id = 10;
        $s->nome = 'Fulano';
        //$s->setExpirationSeconds(10);
        
        $this->view->mensagem = "Sessão gravada!";
         */
    }

    public function sessaoAction()
    {
        $s = new Zend_Session_Namespace('usuario');
        $this->view->usuario = $s;
    }

    public function fimAction()
    {
        Zend_Session::namespaceUnset('usuario');
    }


}





