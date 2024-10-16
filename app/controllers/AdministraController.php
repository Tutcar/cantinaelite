<?php

namespace app\controllers;

use app\core\Controller;
use app\util\UtilService;
use app\models\service\Service;
use app\core\Flash;

class AdministraController extends Controller
{
   private $usuario = null;
   public function __construct()
   {
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
      $dados["view"]       = "painel/index";
      $this->load("template", $dados);
   }
}
