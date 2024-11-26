<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\RelatoriosService;
use app\util\UtilService;

class RelatoriosController extends Controller
{
    protected $db;
    private $tabela = "caixaabre";
    private $campo = "id_caixaabre";
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
        $dados["vendaTotal"] = Service::getSoma("pedidoTotal", "dinheiro", "tipo_pg", null, true);
        $dados["custoTotal"] = Service::getSoma("custoTotal", "dinheiro", "tipo_pg", null, true);
        $dados["lista"] = Service::lista("relatorios");
        $dados["view"]  = "relatorios/index";
        $this->load("template", $dados);
    }


    public function areceber()
    {
        $dados["vendaTotal"] = Service::getSoma("pedidoAreceber", "dinheiro", "tipo_pg", null, true);
        $dados["custoTotal"] = Service::getSoma("custoAreceber", "dinheiro", "tipo_pg", null, true);
        $dados["lista"] = Service::lista("pedidosAreceber");
        $dados["view"]  = "relatorios/areceber";
        $this->load("template", $dados);
    }
    public function areceberCli($pd)
    {

        $dados["vendaTotal"] = Service::getSoma("pedidoAreceberCli", null, null, $pd, false);
        $dados["custoTotal"] = Service::getSoma("custoAreceberCli", null, null, $pd, false);
        $dados["lista"] = Service::get("pedidoAreceberClilt", null, $pd, true);
        $dados["view"]  = "relatorios/arecebercli";
        $this->load("template", $dados);
    }

    public function relatDia($id)
    {

        $dados["relatDia"] = Service::get("pedidoD", "id_caixaabre", $id, true);
        $dados["view"]  = "relatorios/relatdia";
        $this->load("template", $dados);
    }
    public function itensPedido($id, $cli, $dat, $extrato = null)
    {
        $dados["relatItem"] = Service::get("pedidodia", "nr_pedido", $id, true);
        $dados["cliente"] = $cli;
        $dados["data_pd"] = $dat;
        foreach ($dados["relatItem"] as $key => &$value) {
            $value->cliente = $cli;
        }
        usort(

            $dados["relatItem"],

            function ($a, $b) {

                if ($a->cliente  == $b->cliente) return 0;

                return (($a->cliente > $b->cliente) ? -1 : 1);
            }
        );
        foreach ($dados["relatItem"] as $key => &$value) {
            $value->data_ab_pedido = $dat;
        }
        usort(

            $dados["relatItem"],

            function ($a, $b) {

                if ($a->data_ab_pedido  == $b->data_ab_pedido) return 0;

                return (($a->data_ab_pedido > $b->data_ab_pedido) ? -1 : 1);
            }
        );
        $dados["relatItem"];
        if ($extrato == "ext") {
            $dados["view"]  = "relatorios/itensextrato";
        } else {
            $dados["view"]  = "relatorios/itenspedido";
        }

        $this->load("template", $dados);
    }
    public function todosItens($cli, $extrato = null)
    {
        $dados["todosItens"] = Service::get("pedido", "cli_p", $cli, true);
        if ($extrato == "ext") {
            $dados["view"]  = "relatorios/itensclienteExt";
        } else {
            $dados["view"]  = "relatorios/itenscliente";
        }


        $dados["view"]  = "relatorios/itenscliente";
        $this->load("template", $dados);
    }
    public function filtro()
    {
        $_SESSION["dataIn"] = $_POST["dataIn"];
        $_SESSION["dataFim"] = $_POST["dataFim"];
        $dados["vendaTotal"] = Service::getSoma("pedidoTotal2", "dinheiro", "tipo_pg", null, true);
        $dados["custoTotal"] = Service::getSoma("custoTotal2", "dinheiro", "tipo_pg", null, true);
        $dados["lista"] = Service::lista("relatorios3");
        $dados["view"]  = "relatorios/cxentredata";
        $this->load("template", $dados);
    }
    public function listadia($id)
    {
        $dados["datap"] = $id;

        $nome = "";

        $dados["nomeP"] = flash::produzirItem($this->db, $id, $nome);

        $resultado = array();

        foreach ($dados["nomeP"] as $nome) {

            $quantidade = flash::produzirItens($this->db, $id, $nome->nome);

            $quantidade->nome = $nome->nome;

            $resultado[] = $quantidade;
        }

        $dados['lista'] = $resultado;

        $dados["view"]  = "relatorios/listadia";
        $this->load("template", $dados);
    }
}
