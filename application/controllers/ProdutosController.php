<?php

class ProdutosController extends Zend_Controller_Action
{

    protected $_modelProdutos = null;

    public function init()
    {
        $this->_modelProdutos = new Loja_Model_Produtos();
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        $this->view->produtos = $this->_modelProdutos->getListaDeProdutos();
    }

    public function novoAction()
    {
        $form = new Loja_Form_Produto();
        $form->setAction($this->_helper->url('novo'));
        
        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost()))
        {
            $inserido = $this->_modelProdutos->insere($form);
            if ($inserido) {
                $this->_helper->flashMessenger('Produto cadastrado com sucesso');
                $this->_helper->redirector('index');
            }
            else {
                $this->view->erro = 'Erro no upload da imagem';
            }
        }
        
        $this->view->form = $form;
    }

    public function verAction()
    {
        $id = (int) $this->getRequest()->getParam('id');
        
        $produto = $this->_modelProdutos->getProdutoPorId($id);
        $usuario = $this->_modelProdutos->getUsuarioProduto($produto);
        
        $this->view->produto = $produto;
        $this->view->usuario = $usuario;
    }


}







