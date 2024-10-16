<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\UserService;
use app\util\UtilService;

class UserController extends Controller
{
    private $tabela = "user";
    private $campo = "id_user";
    private $usuario = null;
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit();
        }
    }
    public function index()
    {
        $dados["lista"] = Service::lista("userAdm");
        $dados["view"]  = "user/index";
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["user"] = Flash::getForm();
        $dados["view"] = "user/cadUser";
        $this->load("template", $dados);
    }


    public function edit($id)
    {

        $user = Service::get($this->tabela, $this->campo, $id);
        if (!$user) {
            $this->redirect(URL_BASE . "user");
        }
        $dados["user"] = $user;
        $dados["view"]      = "user/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $user = new \stdClass();
        if ($_POST["id_user"] || "") {
            $user->id_user = ($_POST["id_user"]);
        } else {
            $user->id_user = null;
        }
        $user->login = $_POST["login"];
        if ($_POST["senha"] || "") {
            $user->senha = md5($_POST['senha']);
        }
        Flash::setForm($user);
        if (UserService::salvar($user, $this->campo, $this->tabela)) {

            if ($_SESSION[SESSION_LOGIN]->id_user === '59') {
                $this->redirect(URL_BASE . "user");
            } else {
                $this->redirect(URL_BASE . "home");
            }
        } else {
            if (!$user->id_user) {

                $this->redirect(URL_BASE . "user/create");
            } else {
                $this->redirect(URL_BASE . "user/edit/" . $user->id_user);
            }
        }
    }
    public function salvarUser()
    {
        $user = new \stdClass();
        // Alteração pelo usuario
        $user->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $user->login = $_SESSION[SESSION_LOGIN]->login;
        $senha =  $_POST["senha"];
        $confirmPassword =  $_POST["confirmPassword"];
        $user->senha = md5($senha);
        if ($senha == "" or $confirmPassword == "") {
            Flash::setMsg("A senha não pode estar em branco", -1);
            $this->redirect(URL_BASE);
        }
        if ($senha) {
            if ($confirmPassword == $senha) {
                $user->senha = md5($senha);
            } else {
                Flash::setMsg("As senha não são iguais.", -1);
                $this->redirect(URL_BASE);
            }
        }

        Flash::setForm($user);

        if (UserService::salvar($user, "id_user", "user")) {
            Flash::setMsg("Senha salva com sucesso!", 1);
            $this->redirect(URL_BASE);
        } else {
            Flash::setMsg("A senha não foi salva.", -1);
            $this->redirect(URL_BASE);
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "user");
    }
    public function filtro()
    {
        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "user/index";
        $this->load("template", $dados);
    }
}
