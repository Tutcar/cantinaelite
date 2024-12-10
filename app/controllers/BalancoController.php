<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\BalancoService;
use app\util\UtilService;

class BalancoController extends Controller
{
    protected $db;
    private $usuario = null;
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
        $dataBala = Flash::balancoData($this->db);
        $balancoMes = array();
        foreach ($dataBala as $balanco) {
            $_SESSION["dataIn"] = $balanco->ano . "-" . $balanco->mes . "-" . 1;
            $dia = ultimoDiaMes($balanco->ano . "-" . $balanco->mes);
            $_SESSION["dataFim"] = $balanco->ano . "-" . $balanco->mes . "-" . $dia;
            $salarioTotal = Service::getSoma("salarioTotalData", "", "", null, false);
            $vendaTotal = Service::getSoma("pedidoTotalData", "dinheiro", "tipo_pg", null, false);
            $comprasTotal = Service::getSoma("comprasTotalData", "dinheiro", "tipo_pg", null, false);
            $despesasTotal = Service::getSoma("despesasTotalData", "dinheiro", "tipo_pg", null, false);
            $producaoTotal = Service::getSoma("producaoTotalData", "dinheiro", "tipo_pg", null, false);
            $terceirosTotal = Service::getSoma("terceirosTotalData", "dinheiro", "tipo_pg", null, false);
            $balanco->salarioTotal = $salarioTotal;
            $balanco->vendaTotal = $vendaTotal;
            $balanco->comprasTotal = $comprasTotal;
            $balanco->despesasTotal = $despesasTotal;
            $balanco->producaoTotal = $producaoTotal;
            $balanco->terceirosTotal = $terceirosTotal;
            $balancoMes[] = $balanco;
        }
        $dados['balaMes'] = $balancoMes;
        $dados["salarioTotal"] = Service::getSoma("salarioTotal", "", "", null, false);
        $dados["vendaTotal"] = Service::getSoma("pedidoTotal", "dinheiro", "tipo_pg", null, false);
        $dados["comprasTotal"] = Service::getSoma("comprasTotal", "dinheiro", "tipo_pg", null, false);
        $dados["despesasTotal"] = Service::getSoma("despesasTotal", "dinheiro", "tipo_pg", null, false);
        $dados["producaoTotal"] = Service::getSoma("producaoTotal", "dinheiro", "tipo_pg", null, false);
        $dados["terceirosTotal"] = Service::getSoma("terceirosTotal", "dinheiro", "tipo_pg", null, false);
        $dados["view"]  = "balanco/index";
        $this->load("template", $dados);
    }
    public function filtro()
    {
        $_SESSION["dataIn"] = $_POST["dataIn"];
        $_SESSION["dataFim"] = $_POST["dataFim"];
        $dados["salarioTotal"] = Service::getSoma("salarioTotalData", "", "", null, false);
        $dados["vendaTotal"] = Service::getSoma("pedidoTotalData", "dinheiro", "tipo_pg", null, false);
        $dados["comprasTotal"] = Service::getSoma("comprasTotalData", "dinheiro", "tipo_pg", null, false);
        $dados["despesasTotal"] = Service::getSoma("despesasTotalData", "dinheiro", "tipo_pg", null, false);
        $dados["producaoTotal"] = Service::getSoma("producaoTotalData", "dinheiro", "tipo_pg", null, false);
        $dados["terceirosTotal"] = Service::getSoma("terceirosTotalData", "dinheiro", "tipo_pg", null, false);

        $dados["view"]  = "balanco/index";
        $this->load("template", $dados);
    }
    public function vandasDia()
    {
        i($dados["vendasDia"] = Flash::vendasDia($this->db));
        $dados["view"]  = "balanco/vandasDia";
        $this->load("template", $dados);
    }
}
