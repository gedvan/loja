<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initViewOptions()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->headTitle('Zend Store');
    }
    
    protected function _initSessao()
    {
        Zend_Session::start(); // PHPSESSID
        //Zend_Session::regenerateId();
    }
    
    protected function _initAcl()
    {
        $acl = new Zend_Acl();
        
        // define os recursos
        $acl->addResource('usuarios');
        $acl->addResource(new Zend_Acl_Resource('posts'));
        $acl->addResource('tags', 'posts');
        $acl->addResource('imagens', 'posts');
        
        // define os papéis
        $acl->addRole('administrador');
        $acl->addRole('usuario');
        $acl->addRole('editor');
        $acl->addRole('gerente', 'editor');
        
        // define as regras
        $acl->deny();
        $acl->allow('administrador');
        
        $acl->allow('editor', 'posts', 'ver');
        $acl->allow('editor', 'posts', 'editar');
        $acl->allow('editor', 'posts', 'inserir');
        
        $acl->allow('gerente', 'posts', 'excluir');
        $acl->allow('gerente', 'usuarios');
        
        $acl->allow('usuario', 'posts', 'ver');
        
        Zend_Registry::set('acl', $acl);
    }
}

