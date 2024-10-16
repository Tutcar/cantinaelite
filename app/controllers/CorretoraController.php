<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\CorretoraService;
use app\util\UtilService;

class CorretoraController extends Controller
{
    private $tabela = "corretora";
    private $campo = "id_corretora";
    private $usuario = "";
    protected $db;
    public function __construct()
    {
        $this->usuario = UtilService::getUsuario();
        if (!$this->usuario) {
            $this->redirect(URL_BASE . "login");
            exit();
        } elseif ($_SESSION[SESSION_LOGIN]->tipo === "cliente") {
            $this->redirect(URL_BASE . "homepage");
        }
    }
    public function index()
    {
        $dados["lista"] = Service::lista($this->tabela);
        $dados["view"]  = "corretora/index";
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["corretora"] = Flash::getForm();
        $dados["view"] = "corretora/create";
        $this->load("template", $dados);
    }

    public function edit($id)
    {


        $corretora = Service::get($this->tabela, $this->campo, $id);

        if (!$corretora) {
            $this->redirect(URL_BASE . "corretora");
        }
        $dados["corretora"] = $corretora;
        $dados["view"]      = "corretora/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $corretora = new \stdClass();
        if ($_POST["id_corretora"] || "") {
            $corretora->id_corretora = ($_POST["id_corretora"]);
        } else {
            $corretora->id_corretora = null;
        }

        $corretora->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $corretora->nome = $_POST["nome"];
        $corretora->nr_banco = $_POST["nr_banco"];
        $corretora->nr_agencia = $_POST["nr_agencia"];
        $corretora->nr_conta = $_POST["nr_conta"];


        Flash::setForm($corretora);
        if (CorretoraService::salvar($corretora, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "corretora");
        } else {
            if (!$corretora->id_jg) {
                $this->redirect(URL_BASE . "corretora/create");
            } else {
                $this->redirect(URL_BASE . "corretora/edit/" . $corretora->id_corretora);
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "corretora");
    }
    public function filtro()
    {
        $campo = $_POST["campo"];
        $valor = $_POST["valorfiltro"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "corretora/index";
        $this->load("template", $dados);
    }
}
