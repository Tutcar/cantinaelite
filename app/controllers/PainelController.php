<?php

namespace app\controllers;

use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\util\UtilService;
use app\core\Controller;

class PainelController extends Controller
{
   protected $db;
   private $usuario = "";
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

      unset($_SESSION["nr_ped"]);
      $_SESSION["verifCx"] =  Flash::maximo($this->db, "caixaabre", "fechado", "N");
      $dados["compromisso"] = Flash::compromissos($this->db);
      if ($_SESSION[SESSION_LOGIN]->id_user == 1) {
         $dados["view"]       = "homep";
      } elseif ($_SESSION[SESSION_LOGIN]->tipo === "cliente") {
         $this->redirect(URL_BASE . "homepage");
      } else {
         $this->redirect(URL_BASE . "home");
      }

      $this->load("template", $dados);
   }
}
