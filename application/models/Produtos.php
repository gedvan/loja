<?php

class Loja_Model_Produtos
{
    protected $_tbProdutos;
    
    public function __construct()
    {
        $this->_tbProdutos = new Loja_Model_DbTable_Produtos();
    }
    
    public function getListaDeProdutos()
    {
        return $this->_tbProdutos->fetchAll(null, 'nome'); 
    }
    
    public function getProdutoPorId($id)
    {
        return $this->_tbProdutos->find($id)->current();
    }
    
    public function getUsuarioProduto($produto)
    {
        return $produto->findParentRow('Loja_Model_DbTable_Usuarios', 'Criador');
    }
    
    public function insere($form)
    {
        $info = pathinfo($form->imagem->getFileName());
        $novoNome = 'teste.'.$info['extension'];
        $form->imagem->addFilter('Rename', $novoNome);

        if ($form->imagem->receive()) {
            $dados = $form->getValues();
            //var_dump($dados);
            $this->_tbProdutos->insert($dados);
            return true;
        }
        else return false;
    }
}

