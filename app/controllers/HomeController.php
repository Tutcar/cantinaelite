<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\pagseguro\ReqPagSeguroWebhook;

class HomeController extends Controller
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
      $dados["datacxab"] = service::get("caixaabre", "fechado", "N", false);
      $_SESSION["verifCx"] = 1000;
      $dados["clientes"] = Flash::clientes($this->db);
      $dados["idAbre2"] = Flash::maximo2($this->db, "caixaabre", "fechado", "N");
      if ($dados["idAbre2"] == "") {
         $_SESSION["verifCx"] = 0;
      }
      $campo = null;
      $valor = null;
      $dados["nr_pedido"] = Service::getMaximo("pedido", "nr_pedido", $campo, $valor);
      $dados["lista"] = Service::lista("produtos");
      $operador = " = ";
      $dados["pedidos"] = Service::lista("pedidoo");
      $valor = $dados["nr_pedido"] + 1;
      $operador = " = ";
      $dados["saldoAluno"] = 0;

      if (isset($_SESSION["nr_ped"])) {
         $valor = $_SESSION["nr_ped"];
         if ($valor > 0) {
            $clienteNome = Service::get("pedido", "nr_pedido", $_SESSION["nr_ped"], false);
            if ($clienteNome != "") {
               $primeirosCinco = substr($clienteNome->cliente, 0, 5);
               if ($primeirosCinco <> "Cli -") {
                  $clienteCpf = Service::get("cliente", "nm_nome", $clienteNome->cliente, false);
                  $saldoAlunos = Flash::CreditoAluno($this->db, $clienteNome->cliente);
                  $dados["saldoAluno"] =  floatval($saldoAlunos->soma + $clienteCpf->limite);
               }
            }
         }
         $dados["somaPedido"] = Service::getSoma("pedido", "quant * valor", "nr_pedido", null, true);
      } else {
         $_SESSION["nr_ped"] = 0;
         $dados["somaPedido"] = 0;
      }
      $dados["itens"] = Service::getGeral("pedidoa", "nr_pedido", $operador, $valor, $lista = true);
      if ($_SESSION["verifCx"] == 0) {
         $dados["view"]       = "homesemcx";
      } else {
         $dados["view"]       = "home";
      }

      $this->load("template", $dados);
   }
}
