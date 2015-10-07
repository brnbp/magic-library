<?php

use Phalcon\Mvc\Controller;

class SignController extends \Phalcon\Mvc\Controller
{
    private $signModel;

    /**
     * Construtor define instancia da classe Model Sign
     */
    public function onConstruct()
    {
        $this->signModel = new Sign();
        $this->signModel->setDb($this->db);
    }

    /**
     * Verifica se formulario de cadastro foi clicado
     * caso sim, chama metodo responsavel pela ação decidida
     */
    public function indexAction()
    {
        if ($this->request->hasPost('form_up')) {
            $this->registerUser();
        }
    }

    /**
     * Responsavel por chamar metodos para autenticar e entao
     * logar usuario no site e iniciar sessão
     * @param array | null $user
     * @return redirect para index
     */
    public function inAction($user = null)
    {
        if ($this->request->isPost() || (is_null($user) == false)) {
            if (is_null($user)) {
                $login['login_email'] = addslashes($this->request->getPost('login_email'));
                $login['password'] = md5(addslashes($this->request->getPost('password')));
                $user = $this->signModel->getUsuarioByLoginSenha($login);
            }

            if ($user && is_array($user)) {
                $this->signModel->setUserLogged($user['id']);
                $this->session->set("user_id", $user['id']);
                $this->session->set("user_email", $user['email']);
                $this->session->set("user_login", $user['login']);
                $this->session->set("user_name", $user['name']);
            }
        }
        
        return header("Location: ../");
    }

    /**
     * Responsavel por destruir sessão e suas informações
     * ao deslogar usuario do site
     * @return redirect para index
     */
    public function outAction()
    {
        $user_id = $this->session->get('user_id');
        $this->signModel->setUserUnlogged($user_id);
        $this->session->remove("user_id");
        $this->session->remove("user_email");
        $this->session->remove("user_login");
        $this->session->remove("user_name");
        $this->session->destroy();
        unset($this->session);
        return header("Location: ../");
    }

    /**
     * chama a view para registrar novo usuario
     */
    public function upAction(){}

    /**
     * responsavel por inserir usuario novo na tabela usuarios da database
     * @return redirect para refazer cadastro, caso ja exista usuario
     *  ou chama metodo inAction para iniciar sessao e ja logar usuario no site
     */
    private function registerUser()
    {
        $user['login'] = addslashes($this->request->getPost('login'));
        $user['password'] = md5(addslashes($this->request->getPost('password')));
        $user['email'] = addslashes($this->request->getPost('email', 'email'));
        $user['name'] = addslashes($this->request->getPost('name'));

        $user_id = $this->signModel->registerUser($user);

        if ($user_id == 'exists' || $user_id == 'temporary_error') {
            return header("Location: ../sign/up");
        }
        $user['id'] = $user_id;
        unset($user['password']);

        $this->inAction($user);
    }

}