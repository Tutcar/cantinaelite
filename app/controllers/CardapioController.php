<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Conexao;
use app\core\Flash;
use app\models\service\ProdutosService;
use app\models\service\UserService;
use app\util\UtilService;

class CardapioController extends Controller
{
    protected $db;
    private $tabela = "produtos";
    private $campo = "id_produtos";
    private $usuario = null;
    private $diasDaSemana = [
        0 => "Domingo",
        1 => "Segunda-feira",
        2 => "Terça-feira",
        3 => "Quarta-feira",
        4 => "Quinta-feira",
        5 => "Sexta-feira",
        6 => "Sábado"
    ];
    public function __construct()
    {
        $this->db = Conexao::getConexao();
        $this->tabela;
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
        if ($_SESSION[SESSION_LOGIN]->tipo === "cliente") {
            $dados["saldoAluno"] = Flash::saldoCantina($this->db, $_SESSION['CLIENTE']->nr_cpf_cnpj);
        }
        $dados["dias"] = $this->diasDaSemana;
        $dados["lista"] = Service::get("produtos", "categorias", "prato", true);
        $dados["view"]  = "cardapio/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["dias"] = $this->diasDaSemana;
        $dados["cardapio"] = Flash::getForm();
        $dados["view"] = "cardapio/create";
        $this->load("template", $dados);
    }


    public function edit($id)
    {
        $dados["dias"] = $this->diasDaSemana;
        $cardapio = Service::get($this->tabela, $this->campo, $id);
        if (!$cardapio) {
            $this->redirect(URL_BASE . "cardapio");
        }
        $dados["cardapio"] = $cardapio;
        $dados["view"]      = "cardapio/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $produtos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');

        if ($_POST["id_produtos"] || "") {
            $produtos->id_produtos = ($_POST["id_produtos"]);
        } else {
            $produtos->id_produtos = null;
        }
        $produtos->quant = 0;
        $produtos->nome = rmvCarctEsp($_POST["nome"]);
        $produtos->dia = $_POST["dia"];
        $produtos->categorias = "prato";
        $produtos->descricao = rmvCarctEsp($_POST["descricao"]);
        $produtos->tipo = "Produção";
        $produtos->custo = $_POST["custo"];
        $get_venda = $_POST["venda"];
        $produtos->venda = str_replace($source, $replace, $get_venda);
        $get_venda_g = $_POST["venda_g"];
        $produtos->venda_g = str_replace($source, $replace, $get_venda_g);


        Flash::setForm($produtos);
        if (ProdutosService::salvar($produtos, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "cardapio");
        } else {
            if (!$produtos->id_produtos) {
                $this->redirect(URL_BASE . "cardapio/create");
            } else {
                $this->redirect(URL_BASE . "cardapio/edit/" . $produtos->id_produtos);
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "cardapio");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $nome = $_POST["nome"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $nome, true);
        $dados["view"]  = "cardapio/index";
        $this->load("template", $dados);
    }
    public function editCarda($id)
    {
        $user = Service::get("user", "id_user", $id);
        if (!$user) {
            $this->redirect(URL_BASE . "user");
        }
        $dados['num_visitas'] = Flash::contador($this->db);
        $dados["user"] = $user;
        $dados["view"]       = "cardapio/usercarda";
        $this->load("homepage", $dados);
    }
}
