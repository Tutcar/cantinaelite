<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Conexao;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\CompService;
use app\util\UtilService;

class CompController extends Controller
{
    private $usuario = "";
    private $db = "";
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
    public function index($id)
    {
        $operador = " = ";
        $tabela = "corrente";
        $campo = "id_corrente";
        $dados["compr"] = Service::get($tabela, $campo, $id);
        $tabela = "comp";
        $valor = $id;
        $dados["comp"] = Service::getGeral($tabela, $campo, $operador, $valor, $lista = true);
        $dados["view"]  = "comp/index";
        $this->load("template", $dados);
    }
    public function lerArq($id)
    {
        $tabela = "comp";
        $campo = "id_comp";
        $dados["comp"] = Service::get($tabela, $campo, $id);
        $dados["view"]  = "comp/lerarq";
        $this->load("template", $dados);
    }
    public function salvar()
    {

        $tabela = "comp";
        $campo = "id_comp";
        $comp = new \stdClass();
        $comp->foto = null;
        $comp->id_comp = null;
        $comp->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $comp->id_corretora = $_POST["id_corretora"];
        $comp->id_corrente = $_POST["id_corrente"];
        $comp->nome_arq = $_FILES["arquivo"]["name"];



        Flash::setForm($comp);

        $id = $_SESSION["id_cor"];

        if (CompService::salvar($comp, $campo, $tabela)) {
            $this->redirect(URL_BASE . "comp/index/" . $id);
        } else {
            if (!$comp->comp) {
                $this->redirect(URL_BASE . "comp/index/" . $id);
            } else {
                $this->redirect(URL_BASE . "comp/edit/" . $comp->id_comp);
            }
        }
    }
    public function excluir($id)
    {
        $tabela = "comp";
        $campo = "id_comp";
        $dados["compr"] = Service::get($tabela, $campo, $id);
        $foto = $dados["compr"]->foto;
        $caminho    =  realpath('./') . '/fotos/' . $foto;

        if (file_exists($caminho)) {
            @unlink($caminho);
        }
        Service::excluir($tabela, $campo, $id);
        $id = $_SESSION["id_cor"];
        $this->redirect(URL_BASE . "comp/index/" . $id);
    }
}
