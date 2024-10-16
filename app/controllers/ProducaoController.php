<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;

class ProducaoController extends Controller
{
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
        $tabela = "producao";
        $dados["valorProdTot"] = flash::produzirTot($this->db);
        $dados["valorProdTot"] = $dados["valorProdTot"]->soma;
        $dados["lista"] = Service::lista($tabela);
        $dados["view"]       = "producao/index";
        $this->load("template", $dados);
    }

    public function ver($data_encomendas)
    {
        $dados["datap"] = $data_encomendas;
        $dados["lista"] = flash::producao($this->db, $data_encomendas);
        $dados["view"]       = "producao/producao";
        $this->load("template", $dados);
    }

    public function produzir($id)
    {
        $dados["datap"] = $id;
        $nome = "";
        $dados["nomeP"] = flash::produzirNome($this->db, $id, $nome);
        $resultado = array();
        foreach ($dados["nomeP"] as $nome) {
            $quantidade = flash::produzirQuant($this->db, $id, $nome->nome);
            $quantidade->nome = $nome->nome;
            $resultado[] = $quantidade;
        }
        $dados['lista'] = $resultado;
        $dados["valorProd"] = flash::produzir($this->db, $id);
        $dados["valorProd"] = $dados["valorProd"]->soma;
        $dados["view"]       = "producao/produzir";
        $this->load("template", $dados);
    }
}
