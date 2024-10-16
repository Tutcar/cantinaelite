<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\CaixafechaService;
use app\util\UtilService;

class CaixafechaController extends Controller
{
    protected $db;
    private $tabela = "caixafecha";
    private $campo = "id_caixafecha";
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

        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $ultimoCx = $dados["idAbre"];
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["dinheiro"] = Service::getSoma("caixafechaD", "dinheiro", "tipo_pg", null, true);
        $dados["cartao"] = Service::getSoma("caixafechaC", "cartao", "tipo_pg", null, true);
        $dados["pix"] = Service::getSoma("caixafechaP", "pix", "tipo_pg", null, true);
        $dados["outros"] = Service::getSoma("caixafechaO", "outros", "tipo_pg", null, true);
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["view"]  = "caixafecha/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }

    public function create()
    {
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $ultimoCx = $dados["idAbre"];
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["dinheiro"] = Service::getSoma("caixafechaD", "dinheiro", "tipo_pg", null, true);
        $dados["cartao"] = Service::getSoma("caixafechaC", "cartao", "tipo_pg", null, true);
        $dados["pix"] = Service::getSoma("caixafechaP", "pix", "tipo_pg", null, true);
        $dados["outros"] = Service::getSoma("caixafechaO", "outros", "tipo_pg", null, true);
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["view"]  = "caixafecha/index";
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "caixafecha/create";
        $this->load("template", $dados);
    }


    public function edit($id)
    {

        $caixafecha = Service::get($this->tabela, $this->campo, $id);
        if (!$caixafecha) {
            $this->redirect(URL_BASE . "caixafecha");
        }
        $dados["caixafecha"] = $caixafecha;
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"]      = "caixafecha/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $caixafecha = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $caixafecha->id_caixafecha = null;
        $caixafecha->data_fecha = date("Y-m-d");
        $get_dinheiro = $_POST["dinheiro"];
        $caixafecha->dinheiro = str_replace($source, $replace, $get_dinheiro);
        $get_cartao = $_POST["cartao"];
        $caixafecha->cartao = str_replace($source, $replace, $get_cartao);
        $get_pix = $_POST["pix"];
        $caixafecha->pix = str_replace($source, $replace, $get_pix);
        $get_outros = $_POST["outros"];
        $caixafecha->outros = str_replace($source, $replace, $get_outros);
        $get_pedidos_ab = $_POST["pedidos_ab"];
        $caixafecha->pedidos_ab = str_replace($source, $replace, $get_pedidos_ab);
        $get_retirada = $_POST["retirada"];
        $caixafecha->retirada = str_replace($source, $replace, $get_retirada);
        $get_saldo_cx = $_POST["saldo_cx"];
        $caixafecha->saldo_cx = str_replace($source, $replace, $get_saldo_cx);
        $get_entrada = $_POST["entrada"];
        $caixafecha->entrada = str_replace($source, $replace, $get_entrada);
        $get_conferencia = $_POST["conferencia"];
        $caixafecha->conferencia = str_replace($source, $replace, $get_conferencia);
        $get_diferenca = $_POST["diferenca"];
        $caixafecha->diferenca = str_replace($source, $replace, $get_diferenca);
        $get_total_dia = $_POST["total_dia"];
        $caixafecha->total_dia = str_replace($source, $replace, $get_total_dia);
        $caixafecha->fechado = "S";
        $id = $_POST['id_caixaabre'];
        $dt = $_POST['data_fch_caixa'];
        Flash::setForm($caixafecha);
        if (CaixafechaService::salvar($caixafecha, $this->campo, $this->tabela)) {
            if (!$caixafecha->id_caixafecha) {
                Flash::caixaFecha($this->db, $id);
                Flash::fechaItens($this->db, $dt);
                unset($_SESSION["verifCx"]);
                $this->redirect(URL_BASE . "painel");
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "caixafecha");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "caixafecha/index";
        $this->load("template", $dados);
    }
}
