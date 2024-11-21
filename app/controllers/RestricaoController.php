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
    private $campo = "id_restricoes";
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
    public function listar($id_cliente)
    {
        // Substitua pelo método que busca as restrições no banco de dados
        $restricoes = $dados["restricoes"]  = Flash::restricoesAluno($this->db, $id_cliente);

        echo json_encode($restricoes);
    }
    public function listarRestricoes()
    {
        header('Content-Type: application/json; charset=utf-8'); // Define o cabeçalho como JSON

        // Verifica se clienteId está presente na requisição
        if (!isset($_GET['clienteId']) || empty($_GET['clienteId'])) {
            echo json_encode(['error' => 'ID do cliente não foi fornecido.']);
            return;
        }

        // Obtém o cliente
        $cliente = Service::get("cliente", "nm_nome", $_GET["clienteId"], false);

        if (!$cliente) {
            echo json_encode(['error' => 'Cliente não encontrado.']);
            return;
        }

        // Busca as restrições no banco de dados
        $id = $cliente->id_cliente;
        $restricoes = Flash::restricaoAluno($this->db, $id);

        // Converte para JSON e retorna
        echo json_encode($restricoes);
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
    public function excluir($id)
    {
        $id2 = Service::get($this->tabela, $this->campo, $id, false);
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "restricao/index/" . $id2->id_cliente);
    }
}
