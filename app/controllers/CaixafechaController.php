<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\caixas\Caixas;
use app\models\service\CaixaabreService;
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
        $dados["creditos"] = Service::getSoma("caixafechaCrCx", "credito", "tipo_pg", null, true);
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["creditos"] + $dados["pedidos_ab"];
        $dados["cxfuncionarios"] = Flash::ContarCxFuncionarios($this->db);
        $dados["view"]  = "caixafecha/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }
    public function indexNaoConferido($id = null)
    {

        $dados["idAbre"] = $id;
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $ultimoCx = $id;
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["dinheiro"] = Service::getSoma("caixafechaD", "dinheiro", "tipo_pg", null, true);
        $dados["cartao"] = Service::getSoma("caixafechaC", "cartao", "tipo_pg", null, true);
        $dados["pix"] = Service::getSoma("caixafechaP", "pix", "tipo_pg", null, true);
        $dados["outros"] = Service::getSoma("caixafechaO", "outros", "tipo_pg", null, true);
        $dados["creditos"] = Service::getSoma("caixafechaCrCx", "credito", "tipo_pg", null, true);
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["creditos"] + $dados["pedidos_ab"];
        $dados["cxfuncionarios"] = Flash::ContarCxFuncionariosNaoConferido($this->db, $ultimoCx);
        $dados["view"]  = "caixafecha/indexnaoconferido";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }
    public function naoConferido()
    {
        $caixasNaoConferidos = new Caixas();
        $dados["caixasNaoConferidos"] = $caixasNaoConferidos->caixasNaoConferidos();
        $dados["view"]  = "caixafecha/caixanaoconferido";
        $this->load("template", $dados);
    }
    public function createNaoConferido($id = null)
    {
        $dados["idAbre"] = $id;
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $caixasnaoconferidossoma = new Caixas();
        $caixasnaoconferidossomaResult = $caixasnaoconferidossoma->caixasNaoConferidosSoma($id);
        $dados["dinheiro"] = $caixasnaoconferidossomaResult["Dinheiro"];
        $dados["cartao"] = $caixasnaoconferidossomaResult["Cartao"];
        $dados["pix"] = $caixasnaoconferidossomaResult["Pix"];
        $dados["outros"] = $caixasnaoconferidossomaResult["Outros"];
        $dados["credito"] = $caixasnaoconferidossomaResult["credito"];
        $ultimoCx =  $id;
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["pedidos_ab"] = 0; //Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["cxInicial"] = count(Flash::ContarCxFuncionariosNaoConferido($this->db, $id)) * 30;
        $dados["view"]  = "caixafecha/indexnaoconferido";
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "caixafecha/createnaoconferido";
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
        $dados["creditos"] = Service::getSoma("caixafechaCrCx", "credito", "tipo_pg", null, true);
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["cxInicial"] = count(Flash::ContarCxFuncionarios($this->db)) * 30;
        $dados["view"]  = "caixafecha/index";
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "caixafecha/create";
        $this->load("template", $dados);
    }
    public function caixaFuncionarios($id_user)
    {
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $ultimoCx = $dados["idAbre"];
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["cxfuncionarios"] = Flash::ContarCxFuncionarios($this->db);
        $funcionarioEncontrado = array_filter($dados["cxfuncionarios"], function ($funcionario) use ($id_user) {
            return $funcionario->id_user == $id_user;
        });
        $funcionario = $funcionarioEncontrado ? reset($funcionarioEncontrado) : null;
        $dados["dinheiro"] = $funcionario->total_dinheiro;
        $dados["cartao"] = $funcionario->total_cartao;
        $dados["pix"] = $funcionario->total_pix;
        $dados["outros"] = $funcionario->total_outros;
        $dados["creditos"] = $funcionario->total_creditos;
        $dados["funcionario"] = $funcionario->login_cli;
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["view"]  = "caixafecha/index";
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "caixafecha/create";
        $this->load("template", $dados);
    }
    public function caixaFuncionariosNaoConferido($id_user, $id = null)
    {

        $dados["idAbre"] = $id;
        $dados["dataCx"] = Service::get("caixaabre", "id_caixaabre ", $dados["idAbre"]);
        if ($dados["idAbre"] == 0) {
            Flash::setMsg("Não exite caixa aberto, abra antes de fechar.", -1);
        }
        $ultimoCx  = $id;
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["cxfuncionarios"] = Flash::ContarCxFuncionariosNaoConferido($this->db, $ultimoCx);
        $funcionarioEncontrado = array_filter($dados["cxfuncionarios"], function ($funcionario) use ($id_user) {
            return $funcionario->id_user == $id_user;
        });
        $funcionario = $funcionarioEncontrado ? reset($funcionarioEncontrado) : null;
        $dados["dinheiro"] = $funcionario->total_dinheiro;
        $dados["cartao"] = $funcionario->total_cartao;
        $dados["pix"] = $funcionario->total_pix;
        $dados["outros"] = $funcionario->total_outros;
        $dados["creditos"] = $funcionario->total_creditos;
        $dados["funcionario"] = $funcionario->login_cli;
        $dados["pedidos_ab"] = Service::getSoma("caixafechaA", "outros", "tipo_pg", null, true);
        $dados["saldo"] = $dados["dinheiro"] + $dados["cartao"] + $dados["pix"] + $dados["outros"] + $dados["pedidos_ab"];
        $dados["view"]  = "caixafecha/indexnaoconferido";
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "caixafecha/createnaoconferido";
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
        $caixafecha->data_fecha = dateTime(hoje());
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['acao']) && $_POST['acao'] === 'Fechar Caixa') {
                $caixafecha->conferido = "S";
            } elseif (isset($_POST['acao']) && $_POST['acao'] === 'Fechar Caixa a conferir') {
                $caixafecha->conferido = "N";
            }
        }

        $id = $_POST['id_caixaabre'];
        $caixafecha->id_caixaabre = $id;
        $dt = $_POST['data_fch_caixa'];
        Flash::setForm($caixafecha);
        if (CaixafechaService::salvar($caixafecha, $this->campo, $this->tabela)) {
            if (!$caixafecha->id_caixafecha) {
                Flash::caixaFecha($this->db, $caixafecha->conferido, $id);
                Flash::fechaItens($this->db, $dt, $id);
                unset($_SESSION["verifCx"]);

                $caixaabre = new \stdClass();
                $source = array('.', ',');
                $replace = array('', '.');
                $caixaabre->id_caixaabre = null;
                $caixaabre->data_ab_caixa = dateTime(hoje());
                $get_entrada = 30.00;
                $caixaabre->entrada = str_replace($source, $replace, $get_entrada);
                $get_retirada = 0.00;
                $caixaabre->retirada = str_replace($source, $replace, $get_retirada);
                $tabela = "caixaabre";
                $campo = "id_caixaabre";
                Flash::setForm($caixaabre);
                if (CaixaabreService::salvar($caixaabre, $campo, $tabela)) {
                    if (!$caixaabre->id_caixaabre) {
                        $_SESSION["verifCx"] =  Flash::maximo($this->db, "caixaabre", "fechado", "N");
                    }
                }

                $this->redirect(URL_BASE . "painel");
            }
        }
    }
    public function salvarNaoConferido($dataCxAbre = null, $id = null)
    {
        $salvarNaoConferido = new Caixas();
        $salvarNaoConferido->salvarCxNaoConferido($dataCxAbre, $id);
        $this->naoConferido();
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
