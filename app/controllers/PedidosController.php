<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\PedidosService;
use app\models\service\CompromissoService;
use app\util\UtilService;

class PedidosController extends Controller
{
    protected $db;
    private $tabela = "pedido";
    private $campo = "id_pedidos";
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
        i('ok');
        $dados["lista"] = Service::lista($this->tabela);
        $dados["view"]  = "pedidos/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }
    public function create()
    {
        $dados["pedidos"] = Flash::getForm();
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "pedidos/create";
        $this->load("template", $dados);
    }


    public function edit($id)
    {

        $pedidos = Service::get($this->tabela, $this->campo, $id);
        if (!$pedidos) {
            $this->redirect(URL_BASE . "pedidos");
        }
        $dados["pedidos"] = $pedidos;
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"]      = "pedidos/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $pedidos = new \stdClass();
        if ($_POST["id_pedidos"] || "") {
            $pedidos->id_pedidos = ($_POST["id_pedidos"]);
        } else {
            $pedidos->id_pedidos = null;
        }
        $pedidos->quant = $_POST["quant"];
        $pedidos->nome = $_POST["nome"];
        $pedidos->descricao = $_POST["descricao"];
        $pedidos->tipo = $_POST["tipo"];
        $pedidos->custo = $_POST["custo"];
        $pedidos->venda = $_POST["venda"];




        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            if (!$pedidos->id_pedidos) {
                $this->redirect(URL_BASE . "pedidos/create");
            } else {
                $this->redirect(URL_BASE . "pedidos/edit/" . $pedidos->id_pedidos);
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "home");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "pedidos/index";
        $this->load("template", $dados);
    }
    public function salvarJson()
    {
        $pedidos = new \stdClass();
        $nrPedido = Flash::maximo3($this->db, "nr_pedido", "id_nr") + 1;
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        if ($_POST["cliente"] == "") {
            $pedidos->cliente = "Cli - " . $nrPedido;
            $pedidos->nr_pedido = $_POST["nr_pedido"];
            Flash::novoPedido($this->db, $nrPedido);
        } else {
            $pedidos->cliente = $_POST["cliente"];
            $pedidos->nr_pedido = $_POST["nr_pedido"];
        }
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function salvarJson2()
    {
        $pedidos = new \stdClass();
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        $pedidos->cliente = $_POST["cliente"];
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $_POST["data_encomendas"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            if ($_POST["encomendas"] == "S") {
                $id_user = $_SESSION[SESSION_LOGIN]->id_user;
                $descricao = "Encomenda nr:" . $_POST["nr_pedido"] . " - Cliente:" . $_POST["cliente"];
                $data_comp = $_POST["data_encomendas"];
                Flash::salvaEncomendas($this->db, $id_user, $pedidos->nr_pedido, $descricao, $data_comp);
            }
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function salvarJson3($carrinho)
    {
        $pedidos = new \stdClass();
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        $pedidos->cliente = $_POST["cliente"];
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $today;
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            if ($_POST["encomendas"] == "S") {
                $id_user = $_SESSION[SESSION_LOGIN]->id_user;
                $descricao = "Encomenda nr:" . $_POST["nr_pedido"] . " - Cliente:" . $_POST["cliente"];
                $data_comp = $_POST["data_encomendas"];
                Flash::salvaEncomendas($this->db, $id_user, $pedidos->nr_pedido, $descricao, $data_comp);
            }
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function CadPedidoJson()
    {
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $Cli_p = Service::get("pedidoCli_p", "nr_pedido", $_POST["nr_pedido"]);
        $produtos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $produtos = Service::get("produtos", "id_produtos", $_POST["id_produto"]);
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = null;
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->id_produto = $_POST["id_produto"];
        $pedidos->cli_p = $Cli_p->cliente;
        $pedidos->data_ab_pedido = $Cli_p->data_ab_pedido;
        $pedidos->nome = $produtos->nome;
        $pedidos->quant = 1;
        $pedidos->pago = "N";
        $get_custo = moedaBr($produtos->custo);
        $pedidos->custo = str_replace($source, $replace, $get_custo);
        $get_valor = moedaBr($produtos->venda);
        $pedidos->valor = str_replace($source, $replace, $get_valor);
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedidoo";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Item cadastrado.');
        } else {
            echo json_encode('Item não cadastrado.');
        }
    }
    public function CadPedidoJson2()
    {
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $Cli_p = Service::get("pedidoCli_p", "nr_pedido", $_POST["nr_pedido"]);
        $produtos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $produtos = Service::get("produtos", "id_produtos", $_POST["id_produto"]);
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = null;
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->id_produto = $_POST["id_produto"];
        $pedidos->cli_p = $Cli_p->cliente;
        $pedidos->data_ab_pedido = $Cli_p->data_ab_pedido;
        $pedidos->nome = $produtos->nome;
        $pedidos->quant = 1;
        $pedidos->pago = "N";
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $_SESSION["data_encomendas"];
        $get_custo = moedaBr($produtos->custo);
        $pedidos->custo = str_replace($source, $replace, $get_custo);
        $get_valor = moedaBr($produtos->venda);
        $pedidos->valor = str_replace($source, $replace, $get_valor);
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedidoo";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Item cadastrado.');
        } else {
            echo json_encode('Item não cadastrado.');
        }
    }
    public function CardapioJson()
    {

        $dados["lista"] = Service::lista("produtos");
    }
    public function AtualizaPedJson($id)
    {
        $_SESSION["nr_ped"] = $id;

        $this->redirect(URL_BASE . "home");
        echo json_encode('Item cadastrado.');
    }
    public function AtualizaPedJson2($id)
    {
        $_SESSION["nr_ped"] = $id;

        $this->redirect(URL_BASE . "encomendas/index");
        echo json_encode('Item cadastrado.');
    }
    public function salvarFechaPedido()
    {
        $id_caixaAbre = Service::get("caixaabre", "fechado", "N");
        $dados["pedidos"] = Flash::fechaCx($this->db);
        $pedidos = Service::get("pedido", "pago", $_SESSION["nr_ped"]);
        $pedidos = new \stdClass();
        $pedidos->id_caixaabre  = $id_caixaAbre->id_caixaabre;
        $source = array('.', ',');
        $replace = array('', '.');
        $pedidos->id_pedidos = Service::getMinimo2("pedido", "id_pedidos", "nr_pedido", $_SESSION["nr_ped"]);
        if ($_POST["vLiquido"] > 0) {
            $pedidos->valor = $_POST['vLiquido'];
        } else {
            $get_valor = $_POST['valor'];
            $pedidos->valor = str_replace($source, $replace, $get_valor);
        }
        $pedidos->custo = Service::getSoma2("pedidos", "quant * custo", "nr_pedido", null, true);
        $pedidos->tipo_pg = $_POST["tipo_pg"];
        $pedidos->pago = "S";
        $pedidos->quant = 0;
        $today = date("Y-m-d H:i:s");
        $pedidos->data_fch_pedido = $today;
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            unset($_SESSION["nr_ped"]);
            echo json_encode('Pedido fechado.');
        } else {
            echo json_encode('Pedido não fechado.');
        }
    }

    public function alteraPedidoJson()
    {
        $pedidos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $pedidos->id_pedidos = $_POST["id_pedidos"];
        $pedidos->nome = $_POST["nome"];
        $pedidos->quant = $_POST["quant"];
        $get_valor = moedaBr($_POST["valor"]);
        $pedidos->valor = str_replace($source, $replace, $get_valor);
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            echo json_encode('Item alterado.');
        } else {
            echo json_encode('Item não alterado.');
        }
    }

    public function alteraPedido2Json()
    {
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = $_POST["id_pedidos"];
        $pedidos->quant = $_POST["quant"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            echo json_encode('Item alterado.');
        } else {
            echo json_encode('Item não alterado.');
        }
    }
}
