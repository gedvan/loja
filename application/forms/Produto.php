<?php

class Loja_Form_Produto extends Zend_Form
{
    protected $_tbUsuarios;
    
    public function init()
    {
        $this->_tbUsuarios = new Loja_Model_DbTable_Usuarios();
        
        $nome = $this->createElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => true,
        ));
        
        $descricao = $this->createElement('textarea', 'descricao', array(
            'label' => 'Descrição',
            'rows' => 5,
        ));
        
        $preco = $this->createElement('text', 'preco', array(
            'label' => 'Preço',
            'required' => true,
        ));
        
        $imagem = $this->createElement('file', 'imagem', array(
            'label' => 'Imagem',
            'required' => true,
            //'multiple' => 'multiple',
            //'isArray' => true,
        ));
        $imagem->setDestination(realpath(APPLICATION_PATH.'/../public/imagens'));
        $imagem->addValidator('Size', false, 2000000);
        $imagem->addValidator('Extension', false, 'jpg,png,gif');
        
        //$t = new Zend_File_Transfer_Adapter_Http();
        //$t->set
        
        $usuario = $this->createElement('select', 'fk_usuario', array(
            'label' => 'Usuário',
            'required' => true,
            'multiOptions' => $this->_tbUsuarios->getUsuariosSelect(),
        ));
        
        $submit = $this->createElement('submit', 'submit', array(
            'label' => 'Cadastrar',
        ));
        
        $this->addElements(array(
            $nome,
            $descricao,
            $preco,
            $imagem,
            $usuario,
            $submit,
        ));
    }


}

