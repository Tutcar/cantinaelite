<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Conexao;
use app\core\Flash;
use app\models\service\ProdutosService;
use app\util\UtilService;


class ProdutosController extends Controller
{
    protected $db;
    private $tabela = "produtos";
    private $campo = "id_produtos";
    private $usuario = null;
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


        $dados["lista"] = Flash::produtosPrato($this->db);
        $dados["view"]  = "produtos/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["produtos"] = Flash::getForm();
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "produtos/create";
        $this->load("template", $dados);
    }


    public function edit($id)
    {

        $produtos = Service::get($this->tabela, $this->campo, $id);
        if (!$produtos) {
            $this->redirect(URL_BASE . "produtos");
        }
        $dados["produtos"] = $produtos;
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"]      = "produtos/create";
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
        $produtos->quant = $_POST["quant"];
        $produtos->nome = rmvCarctEsp($_POST["nome"]);
        $produtos->categorias = $_POST["categorias"];
        $produtos->descricao = rmvCarctEsp($_POST["descricao"]);
        $produtos->tipo = $_POST["tipo"];
        $get_custo = $_POST["custo"];
        $produtos->custo = str_replace($source, $replace, $get_custo);
        $get_venda = $_POST["venda"];
        $produtos->venda = str_replace($source, $replace, $get_venda);




        Flash::setForm($produtos);
        if (ProdutosService::salvar($produtos, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "produtos");
        } else {
            if (!$produtos->id_produtos) {
                $this->redirect(URL_BASE . "produtos/create");
            } else {
                $this->redirect(URL_BASE . "produtos/edit/" . $produtos->id_produtos);
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "produtos");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $nome = $_POST["nome"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $nome, true);
        $dados["view"]  = "produtos/index";
        $this->load("template", $dados);
    }
}
