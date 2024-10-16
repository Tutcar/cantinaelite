<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Conexao;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\ItensnfService;
use app\util\UtilService;

class ItensnfController extends Controller
{
    private $tabela = "itensnf";
    private $campo = "id_itensnf";
    protected $db;
    private $usuario = null;
    private $tipos = array("Despesas", "Produção", "Compras");
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
    public function index($id)
    {
        $dados["compras"] = Service::get("comprasIt", "id_compras", $id);
        $tabela = "itensnf";
        $dados["lista"] = Service::get("itensnf", "id_compras", $id, true);
        $dados["view"]  = "itensnf/index";
        $this->load("template", $dados);
    }
    public function create($idc, $idf)
    {


        $dados["id_compras"] = $idc;
        $dados["id_fornecedor"] = $idf;
        $dados["tipos"] = $this->tipos;
        $tabela = "itensnf";
        $dados["itensnf"] = Service::lista($tabela);
        $dados["itensnf"] = Flash::getForm();
        $dados["view"] = "itensnf/create";
        $this->load("template", $dados);
    }
    public function edit($id)
    {

        $dados["tipos"] = $this->tipos;
        $itensnf = Service::get("itensnf", $this->campo, $id);

        if (!$itensnf) {
            $this->redirect(URL_BASE . "itensnf");
        }
        $dados["itensnf"] = $itensnf;
        $dados["view"]      = "itensnf/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $itensnf = new \stdClass();

        $source = array('.', ',');
        $replace = array('', '.');
        if ($_POST["id_itensnf"] || "") {
            $itensnf->id_itensnf = ($_POST["id_itensnf"]);
            $itensnf->data_nf = $_POST["data_nf"];
        } else {
            $dados["compras"] = Service::get("compras", "id_compras", $_POST["id_compras"]);
            $itensnf->data_nf = $dados["compras"]->data_nf;
            $itensnf->id_itensnf = null;
        }

        $itensnf->id_fornecedor = $_POST["id_fornecedor"];
        $itensnf->id_compras = $_POST["id_compras"];
        $itensnf->nf_nome = $_POST["nf_nome"];
        $itensnf->nf_tipo = $_POST["nf_tipo"];
        $itensnf->nf_quant = $_POST["nf_quant"];
        $get_nf_preco = $_POST["nf_preco"];
        $itensnf->nf_preco = str_replace($source, $replace, $get_nf_preco);
        $get_nf_desc = $_POST["nf_desc"];
        $itensnf->nf_desc = str_replace($source, $replace, $get_nf_desc);
        Flash::setForm($itensnf);


        if (ItensnfService::salvar($itensnf, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "compras/edit/" . $itensnf->id_compras);
        } else {
            if (!$itensnf->itensnf) {
                $this->redirect(URL_BASE . "itensnf/create/" . $itensnf->id_compras . "/" . $itensnf->id_fornecedor);
            } else {
                $this->redirect(URL_BASE . "itensnf/edit/" . $itensnf->id_itensnf);
            }
        }
    }
    public function filtro()
    {
        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "itensnf/index";
        $this->load("template", $dados);
    }
    public function excluiritem($id, $idc)
    {
        $tabela = "itensnf";
        $campo = "id_itensnf";
        Service::excluiritem($tabela, $campo, $id, $idc);
        $this->redirect(URL_BASE . "itensnf/index/" . $idc);
    }
}
