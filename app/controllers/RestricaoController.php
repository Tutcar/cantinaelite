<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\RestricoesService;

class RestricaoController extends Controller
{
    private $tabela = "restricoes";
    private $campo = "id_restricao";
    private $usuario = "";
    protected $db;
    public function __construct()
    {
        $this->db = Conexao::getConexao();
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
        i($prod = Flash::restricaoAluno($this->db, 1));
        $dados["produtos"] = Service::lista("produtos");
        $dados["clientes"] = Service::lista("cliente");
        $dados["view"]  = "restricao/index";
        $this->load("template", $dados);
    }
    public function salvar()
    {
        $restricoes = new \stdClass();
        if ($_POST["id_restricoes"] || "") {
            $restricoes->id_restricoes = ($_POST["id_restricoes"]);
        } else {
            $restricoes->id_restricoes = null;
        }
        $restricoes->id_produtos = $_POST["id_produtos"];
        $restricoes->id_cliente = $_POST["id_cliente"];
        Flash::setForm($restricoes);
        if (RestricoesService::salvar($restricoes, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "restricao");
        } else {
            if (!$restricoes->id_jg) {
                $this->redirect(URL_BASE . "restricao");
            } else {
                $this->redirect(URL_BASE . "restricao" . $restricoes->id_restricoes);
            }
        }
    }
}
