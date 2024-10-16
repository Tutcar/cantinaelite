<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Conexao;
use app\core\Flash;
use app\models\service\CompromissoService;
use app\util\UtilService;

class CompromissoController extends Controller
{
    protected $db;
    private $tabela = "compromisso";
    private $campo = "id_compromisso";
    private $usuario = "";
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
        $dados["lista"] = Flash::compromissos($this->db);
        $dados["view"]  = "compromisso/index";
        $this->load("template", $dados);
    }
    public function pedidosDia()
    {
        $dados["lista"] = Flash::compromissosDia($this->db);
        $dados["view"]  = "compromisso/pedidosdia";
        $this->load("template", $dados);
    }

    public function create()
    {

        $dados["compromisso"] = Flash::getForm();
        $dados["view"] = "compromisso/create";
        $this->load("template", $dados);
    }

    public function edit($id)
    {

        $compromisso = Service::get($this->tabela, $this->campo, $id);

        if (!$compromisso) {
            $this->redirect(URL_BASE . "compromisso");
        }
        $dados["compromisso"] = $compromisso;
        $dados["view"]      = "compromisso/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $compromisso = new \stdClass();
        if ($_POST["id_compromisso"] || "") {
            $compromisso->id_compromisso = ($_POST["id_compromisso"]);
        } else {
            $compromisso->id_compromisso = null;
        }

        $compromisso->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $compromisso->descricao = $_POST["descricao"];
        $compromisso->data_comp = $_POST["data_comp"];


        Flash::setForm($compromisso);
        if (CompromissoService::salvar($compromisso, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "compromisso");
        } else {
            if (!$compromisso->id_jg) {
                $this->redirect(URL_BASE . "compromisso/create");
            } else {
                $this->redirect(URL_BASE . "compromisso/edit/" . $compromisso->id_compromisso);
            }
        }
    }
    public function confEntrega($id)
    {

        Flash::confEnt($this->db, $id);
        $this->redirect(URL_BASE . "compromisso/pedidosDia");
    }

    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "compromisso");
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $valor = $_POST["valorfiltro"];


        if ($campo === "data_compM") {
            $campo = "data_comp";
            $valor1 = $_POST["valorfiltro"];
            $valor2 = dataEN(date('01-01-9999'));
            $dados["lista"] = Service::getEntre($this->tabela, $campo, $valor1, $valor2, true);
        } else {
            $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        }

        $dados["view"]  = "compromisso/index";
        $this->load("template", $dados);
    }
}
