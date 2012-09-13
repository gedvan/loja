<?php

class UsuariosController extends JM_ControllerAdmin
{

    protected $_tbUsuarios = null;

    /**
     * @var Zend_Acl
     *
     *
     *
     *
     */
    protected $_acl = null;

    public function init()
    {
        parent::init();
        $this->_tbUsuarios = new Loja_Model_DbTable_Usuarios();
        $this->_acl = Zend_Registry::get('acl');
    }

    protected function _validaLogin()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_helper->redirector('login');
        }
    }

    /**
     * Configura o adaptador de autenticação usando o banco
     *
     * @return \Zend_Auth_Adapter_DbTable 
     *
     *
     */
    protected function _getAuthAdapter()
    {
        $adapter = new Zend_Auth_Adapter_DbTable();
        $adapter->setTableName('usuarios')
                ->setIdentityColumn('login')
                ->setCredentialColumn('senha');
                //->setCredentialTreatment('MD5(?)');
        return $adapter;
    }

    public function indexAction()
    {
        $this->_forward('list');
    }

    public function listAction()
    {
        $this->_validaLogin();
        
        $this->_helper->verificaLogin->estaLogado();
        
        // pega o papel do usuário logado
        $papel = Zend_Auth::getInstance()->getStorage()->read()->papel;
        
        // verifica se tem permissão para a lista de usuários
        if (!$this->_acl->isAllowed($papel, 'usuarios')) {
            $this->_helper->redirector('index', 'index');
        }
        
        $this->view->messages = $this->_helper->flashMessenger->getMessages();
        
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('paginador.phtml');
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        
        $select = $this->_tbUsuarios->select();
        $paginator = Zend_Paginator::factory($select);
        $paginator->setItemCountPerPage(2);
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $this->view->paginator = $paginator;
        
        $this->view->usuarioLogado = Zend_Auth::getInstance()->getIdentity();
    }

    public function novoAction()
    {
        $form = new Loja_Form_Usuario(array(
            'action' => $this->_helper->url('novo')
        ));
        
        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost()))
        {
            $dados = $form->getValues();
            try {
                $this->_tbUsuarios->insert($dados);
                $this->_helper->flashMessenger('Usuário cadastrado com sucesso!');
                $this->_helper->redirector('list');
            }
            catch (Zend_Db_Exception $e) {
                $this->view->erro = 'Erro ao cadastrar o usuário';
            }
        }
        
        $this->view->form = $form;
    }

    public function editarAction()
    {
        $id = (int) $this->getRequest()->getParam('id');

        $form = new Loja_Form_Usuario(array(
            'action' => $this->view->baseUrl('usuarios/editar/id/'.$id)
        ));
        
        $usuario = $this->_tbUsuarios->find($id)->current();
        $form->setUsuario($usuario->toArray());
        
        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost()))
        {
            $dados = $form->getValues();
            try {
                $usuario->nome = $dados['nome'];
                $usuario->login = $dados['login'];
                if ($dados['senha']) {
                    $usuario->senha = $dados['senha'];
                }
                $usuario->save();
                $this->_helper->flashMessenger('Usuário alterado com sucesso!');
                $this->_helper->redirector('list');
            }
            catch (Zend_Db_Exception $e) {
                $this->view->erro = 'Erro ao editar o usuário';
            }
        }
        
        $this->view->form = $form;
    }

    public function excluirAction()
    {
        $id = (int) $this->getRequest()->getParam('id');

        $usuario = $this->_tbUsuarios->find($id)->current();
        $this->view->usuario = $usuario;
        
        if ($this->getRequest()->isPost())
        {
            try {
                $usuario->delete();
                $this->_helper->flashMessenger('Usuário excluído com sucesso!');
                $this->_helper->redirector('list');
            }
            catch (Zend_Db_Exception $e) {
                $this->view->erro = 'Erro ao excluir o usuário';
            }
        }
    }

    public function loginAction()
    {
        $form = new Zend_Form(array(
            'method' => 'post',
            'action' => $this->_helper->url('login')
        ));
        
        $form->addElement('text', 'login', array(
            'label' => 'Usuário',
            'required' => true,
        ));
        
        $form->addElement('password', 'senha', array(
            'label' => 'Senha',
            'required' => true,
        ));
        
        $form->addElement('submit', 'submit', array(
            'label' => 'Entrar',
        ));
        
        $request = $this->getRequest();
        if ($request->isPost() && $form->isValid($request->getPost()))
        {
            // pega o adaptador de autenticação configurado
            $adapter = $this->_getAuthAdapter();
            
            // põe os dados que serão autenticados
            $adapter->setIdentity($form->getValue('login'));
            $adapter->setCredential($form->getValue('senha'));
            
            // realiza a autenticação em si
            $auth = Zend_Auth::getInstance();
            $result = $auth->authenticate($adapter); // Zend_Auth_Result
            //$result = $adapter->authenticate();

            // verifica se deu certo
            if ($result->isValid()) {
                // se der certo, pega o registro da tabela
                $usuario = $adapter->getResultRowObject();
                
                // grava o registro autenticado na sessão
                $auth->getStorage()->write($usuario);
                
                // redireciona para o action interno
                $this->_helper->redirector('interno');
            }
            else {
                // se não deu certo, ver qual foi o erro
                $code = $result->getCode();
                if ($code == Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND) {
                    $this->view->mensagem = 'Login inválido';
                }
                elseif ($code == Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID) {
                    $this->view->mensagem = 'Senha errada';
                }
                else {
                    $this->view->mensagem = 'Erro no login';
                }
            }
        }
        
        $this->view->form = $form;
    }

    public function internoAction()
    {
        $this->_validaLogin();
        
        $this->view->mensagem = "Mensagem secreta!";
    }

    public function testeAction()
    {
        // editor tem permissão sobre usuários?
        if ($this->_acl->isAllowed('usuario', 'posts', 'ver')) {
            var_dump('sim');
        } else {
            var_dump('não');
        }
    }

    public function sairAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('login');
    }

    public function detalhesAction()
    {
        $request = $this->getRequest();
        $id = (int) $request->getParam('id');
        
        $usuario = $this->_tbUsuarios->find($id)->current();
        $this->view->usuario = $usuario;
        
        if ($request->isXmlHttpRequest()) {
            // desabilita o layout
            $this->_helper->layout()->disableLayout();
            //$this->getHelper('layout')->disableLayout();
        }
        
        //$this->getHelper('ViewRenderer')->setNoRender();
    }

    public function consultaAction()
    {
        $form = new Zend_Form();
        $form->setMethod('get')
             ->setAction($this->_helper->url('consulta'))
             ->setAttrib('id', 'form-consulta');
        
        $form->addElement('text', 'nome', array(
            'label' => 'Nome',
        ));
        
        $this->view->form = $form;
        
        $this->_helper->layout()->setLayout('novo');
    }

    public function autocompleteAction()
    {
        $s = $this->getRequest()->getParam('term');
        
        $select = $this->_tbUsuarios->select();
        $select->where('nome LIKE ? OR login LIKE ?', "%$s%", "%$s%");
        
        $usuarios = $this->_tbUsuarios->fetchAll($select);
        
        $nomes = array();
        foreach ($usuarios as $usuario) {
            $nomes[] = "$usuario->nome ($usuario->login)";
        }
        
        $this->_helper->json($nomes);
    }

    public function mudaStatusAction()
    {
        $request = $this->getRequest();
        $id = (int) $request->getParam('id');
        
        $usuario = $this->_tbUsuarios->find($id)->current();
        if ($usuario->ativo) {
            $usuario->ativo = 0;
        } else {
            $usuario->ativo = 1;
        }
        $usuario->save();
        
        $this->_helper->json(array('ativo' => $usuario->ativo));
    }

    
}




