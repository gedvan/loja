<?php

class Loja_Form_Usuario extends Zend_Form
{

    public function init()
    {
        $nome = $this->createElement('text', 'nome', array(
            'label' => 'Nome',
            'required' => true,
            'filters' => array(
                'StripTags',
                'StringTrim',
            ),
            'validators' => array(
                array('StringLength', false, array(5, 100))
            ),
        ));
        
        $login = $this->createElement('text', 'login', array(
            'label' => 'Login',
            'required' => true,
            'filters' => array(
                'StripTags',
                'StringTrim',
            ),
            'validators' => array(
                'Alnum',
                array('StringLength', false, array(3, 50))
            ),
        ));
        
        $senha = $this->createElement('password', 'senha', array(
            'label' => 'Senha',
            'required' => false,
            'validators' => array(
                array('StringLength', false, array(3, 50))
            ),
        ));
        
        $submit = $this->createElement('submit', 'submit', array(
            'label' => 'Cadastrar',
        ));
        
        $this->addElements(array(
            $nome,
            $login,
            $senha,
            $submit,
        ));
        
        $this->setMethod('post');
    }

    public function setUsuario($dados)
    {
        //$id = $this->createElement('hidden', 'id_usuario');
        //$this->addElement($id);
        
        $this->getElement('submit')->setLabel('Salvar');
        $this->getElement('senha')->setRequired(false);
        
        $this->populate($dados);
    }
}

