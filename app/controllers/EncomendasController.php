<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;

class EncomendasController extends Controller
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
        $dados["clientes"] = Service::lista("cliente");
        $dados["idAbre2"] = Flash::maximo2($this->db, "caixaabre", "fechado", "N");
        if ($dados["idAbre2"] == "") {
            $_SESSION["verifCx"] = 0;
            Flash::setMsg("Abra o caixa para fazer encomendas.", -1);
            $this->redirect(URL_BASE . "Painel");
            exit();
        }
        $campo = null;
        $valor = null;
        $dados["nr_pedido"] = Service::getMaximo("pedido", "nr_pedido", $campo, $valor);
        $dados["lista"] = Service::lista("produtos");
        $operador = " = ";
        $dados["pedidos"] = Service::lista("pedidoe");
        $valor = $dados["nr_pedido"] + 1;
        $operador = " = ";
        if (isset($_SESSION["nr_ped"])) {
            $valor = $_SESSION["nr_ped"];
            $dados["somaPedido"] = Service::getSoma("pedidoe", "quant * valor", "nr_pedido", null, true);
        } else {
            $_SESSION["nr_ped"] = 0;
            $dados["somaPedido"] = 0;
        }
        $dados["itens"] = Service::getGeral("pedidoe", "nr_pedido", $operador, $valor, $lista = true);

        $dados["view"]       = "encomendas/index";
        $this->load("template", $dados);
    }
    public function excluir($id)
    {
        Service::excluir("pedido", "id_pedidos", $id);
        $this->redirect(URL_BASE . "encomendas");
    }
}
