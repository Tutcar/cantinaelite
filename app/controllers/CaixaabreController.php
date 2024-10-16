<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\core\Conexao;
use app\models\service\CaixaabreService;
use app\util\UtilService;

class CaixaabreController extends Controller
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

        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        if ($dados["idAbre"] > 0) {
            Flash::setMsg("Exite caixa aberto, feche antes de abrir outro.", -1);
        }
        $dados["lista"] = Service::lista($this->tabela);
        $dados["view"]  = "caixaabre/index";
        $this->load("template", $dados);
    }

    public function create()
    {

        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "S");
        $ultimoCx = $dados["idAbre"];
        $dados["idAbreValor"] = Flash::soma($this->db, "caixaabre", "entrada - retirada", "id_caixaabre ", $ultimoCx);
        $dados["caixaabre"] = Flash::getForm();
        $dados["view"] = "caixaabre/create";
        $this->load("template", $dados);
    }
    public function edit($id)
    {
        $caixaabre = Service::get($this->tabela, $this->campo, $id);
        if (!$caixaabre) {
            $this->redirect(URL_BASE . "caixaabre");
        }
        $dados["caixaabre"] = $caixaabre;
        $dados["view"]      = "caixaabre/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $caixaabre = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');

        if ($_POST["id_caixaabre"] || "") {
            $caixaabre->id_caixaabre = ($_POST["id_caixaabre"]);
        } else {
            $caixaabre->id_caixaabre = null;
        }

        $caixaabre->data_ab_caixa = $_POST["data_ab_caixa"];
        $get_entrada = $_POST["entrada"];
        $caixaabre->entrada = str_replace($source, $replace, $get_entrada);
        $get_retirada = $_POST["retirada"];
        $caixaabre->retirada = str_replace($source, $replace, $get_retirada);

        Flash::setForm($caixaabre);
        if (CaixaabreService::salvar($caixaabre, $this->campo, $this->tabela)) {
            if (!$caixaabre->id_caixaabre) {
                $_SESSION["verifCx"] =  Flash::maximo($this->db, "caixaabre", "fechado", "N");
                $this->redirect(URL_BASE . "painel");
            } else {
                $this->redirect(URL_BASE . "caixaabre/edit/" . $caixaabre->id_caixaabre);
            }
        }
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "caixaabre");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "caixaabre/index";
        $this->load("template", $dados);
    }
}
