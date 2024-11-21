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

    public function index($id = null)
    {
        Flash::restricoesAluno($this->db, $id);
        $selectedCliente = null;
        if (isset($id)) {
            $selectedCliente = $id;
            $dados["restricoes"]  = Flash::restricoesAluno($this->db, $id);
        }

        $dados["selectedCliente"] = $selectedCliente;
        if ($id == null) {
            $dados["produtos"] = Service::lista("produtos");
            $dados["restricoes"] = Flash::restricoesAluno($this->db, 0);
        } else {
            $dados["produtos"]  = Flash::restricaoAluno($this->db, $id);
        }

        $dados["clientes"] = Service::lista("cliente");
        $dados["view"]  = "restricao/index";
        $this->load("template", $dados);
    }
    public function salvar()
    {
        $dados["selectedCliente"] = $_POST['id_cliente'] ?? null;
        $restricoes = new \stdClass();
        if ($_POST["id_restricoes"] || "") {
            $restricoes->id_restricoes = ($_POST["id_restricoes"]);
        } else {
            $restricoes->id_restricoes = null;
        }
        $restricoes->id_produtos = $_POST["id_produtos"];
        $restricoes->id_cliente = $_POST["id_cliente"];
        $jaCad = Flash::restricoesAlunoCad($this->db, $restricoes->id_cliente, $restricoes->id_produtos);
        if ($jaCad == 1) {
            Flash::setMsg("Restrição ja cadastrada para este aluno!", 1);
            $this->redirect(URL_BASE . "restricao/index/" . $dados["selectedCliente"]);
        } else {
            Flash::setForm($restricoes);
            if (RestricoesService::salvar($restricoes, $this->campo, $this->tabela)) {
                $this->redirect(URL_BASE . "restricao/index/" . $dados["selectedCliente"]);
            }
        }
    }
}
