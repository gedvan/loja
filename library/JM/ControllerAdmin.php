<?php

/**
 * Description of Controller
 *
 * @author Gedvan
 */
class JM_ControllerAdmin extends Zend_Controller_Action
{
    public function init()
    {
        parent::init();
        
        $this->_helper->layout()->setLayout('admin');
        
        $this->view->headScript()->appendFile($this->view->baseUrl('js/jquery-1.8.0.min.js'));
        $this->view->headScript()->appendFile($this->view->baseUrl('js/jquery.ui/js/jquery-ui-1.8.23.custom.min.js'));
        $this->view->headScript()->appendFile($this->view->baseUrl('js/scripts.js'));
        
        $this->view->addHelperPath('JM/View/Helper', 'JM_View_Helper');
    }
    public function preDispatch()
    {
        parent::preDispatch();
        
        $request = $this->getRequest();
        $action = $request->getActionName();
        
        // if ($acl->isAlowed($action)) ...
    }
    
    public function postDispatch()
    {
        parent::postDispatch();
        
        
    }
}

