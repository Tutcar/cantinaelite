<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\CorrenteService;
use app\util\UtilService;
use PDOException;
use stdClass;

class CorrenteController extends Controller
{
    private $tabela = "corrente";
    private $campo = "id_corrente";
    private $usuario = "";
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
        $dados = array(
            'saldo' => "",
            'compenssar' => "",
            'saldoLq' => ""
        );

        $id_corretora = $_GET['id_corretora'];
        $tabela = "corrente";
        $campoAgregacao = "data_confirma";
        $campo = "";
        $valor = "";
        $dados['compensado'] = Service::getCompensado($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $tabela = "corrente";
        $campo = "id_corrente";
        $campoAgregacao = "valor_credito";
        $valor = "";
        $credito = Service::getCredito($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $campoAgregacao = "valor_debito";
        $debito = Service::getDebito($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $compensar = Service::getAcompensar($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $tabela = "corretora";
        $campo = "id_corretora";
        $dados['saldo'] = $credito->soma - $debito->soma;
        $dados['compensar'] =  $compensar->soma;
        $dados['saldoLq'] = $credito->soma - $compensar->soma - $debito->soma;
        $dados['corretoras'] = Service::get($tabela, $campo, $id_corretora);
        $dados["lista"] = Service::listaCorr($this->tabela, $id_corretora);
        $dados["view"]  = "corrente/index";
        $this->load("template", $dados);
    }

    public function create()
    {

        $id_corretora = $_GET['id_corretora'];
        $campo = "id_corretora";
        $tabela = "corretora";
        $dados['corretoras'] = Service::get($tabela, $campo, $id_corretora);
        $tabela = "despesa";
        $dados['despesas'] = Service::lista($tabela);
        $dados["corrente"] = Flash::getForm();
        $dados["view"] = "corrente/create";
        $this->load("template", $dados);
    }

    public function edit($id, $id_corretora)
    {

        $campo = "id_corretora";
        $tabela = "corretora";
        $dados['corretoras'] = Service::get($tabela, $campo, $id_corretora);
        $tabela = "despesa";
        $dados['despesas'] = Service::lista($tabela);

        $corrente = Service::get($this->tabela, $this->campo, $id);

        if (!$corrente) {
            $this->redirect(URL_BASE . "corrente");
        }
        $dados["corrente"] = $corrente;
        $dados["view"]      = "corrente/create";
        $this->load("template", $dados);
    }
    public function quitar($id, $id_corretora)
    {

        $campo = "id_corretora";
        $tabela = "corretora";
        $dados['corretoras'] = Service::get($tabela, $campo, $id_corretora);

        $corrente = Service::get($this->tabela, $this->campo, $id);

        if (!$corrente) {
            $this->redirect(URL_BASE . "corrente");
        }
        $dados["corrente"] = $corrente;
        $dados["view"]      = "corrente/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $corrente = new \stdClass();
        if ($_POST["id_corrente"] || "") {
            $corrente->id_corrente = ($_POST["id_corrente"]);
        } else {
            $corrente->id_corrente = null;
        }

        $corrente->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $corrente->id_corretora = $_POST["id_corretora"];
        $corrente->nr_doc_banco = $_POST["nr_doc_banco"];
        $cdesp = $_POST["cod_despesa"];
        $corrente->cod_despesa = $cdesp;
        $corrente->data_cad = $_POST["data_cad"];
        $corrente->descricao = $_POST["descricao"];
        if ($_POST["nr_doc_pg"] == "") {
            $corrente->nr_doc_pg = $_POST["nr_doc_banco"];
        } else {
            $corrente->nr_doc_pg = $_POST["nr_doc_pg"];
        }
        $source = array('.', ',');
        $replace = array('', '.');
        if ($_POST["valor_credito"] != null) {
            $get_valor_credito = $_POST["valor_credito"];
            $corrente->valor_credito = str_replace($source, $replace, $get_valor_credito);
        } else {
            $corrente->valor_credito = 0;
        }
        if ($_POST["valor_debito"] != null) {
            $get_valor_debito = $_POST["valor_debito"];
            $corrente->valor_debito = str_replace($source, $replace, $get_valor_debito);
        } else {
            $corrente->valor_debito = 0;
        }
        if ($_POST["confirma"] === "") {
            $corrente->confirma = "N";
        } else {
            $corrente->confirma = $_POST["confirma"];
            $corrente->data_confirma = date('Y-m-d');
        }
        $corrente->obs = $_POST["obs"];
        $corrente->tipo = $_POST["tipo"];

        Flash::setForm($corrente);
        if (CorrenteService::salvar($corrente, $this->campo, $this->tabela)) {
            $this->redirect(URL_BASE . "corrente/index/?id_corretora=" . $corrente->id_corretora);
        } else {
            if (!$corrente->id_corrente) {
                $this->redirect(URL_BASE . "corrente/create/?id_corretora=" . $corrente->id_corretora);
            } else {
                $this->redirect(URL_BASE . "corrente/edit/" . $corrente->id_corrente . "/" . $corrente->id_corretora);
            }
        }
    }


    public function excluir($id, $id_corretora)
    {

        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "corrente/index/?id_corretora=" . $id_corretora);
    }
    public function filtro()
    {

        $dados = array(
            'saldo' => "",
            'compensar' => "",
            'saldoLq' => ""
        );
        $id_corretora = $_POST["id_corretora"];
        $tabela = "corrente";
        $campoAgregacao = "data_confirma";
        $campo = "";
        $valor = "";
        $dados['compensado'] = Service::getCompensado($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $tabela = "corrente";
        $campo = "id_corrente";
        $campoAgregacao = "valor_credito";
        $valor = "";
        $credito = Service::getCredito($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $campoAgregacao = "valor_debito";
        $debito = Service::getDebito($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $compensar = Service::getAcompensar($tabela, $campoAgregacao, $campo, $valor, $id_corretora);
        $tabela = "corretora";
        $campo = "id_corretora";
        $dados['saldo'] = $credito->soma - $debito->soma;
        $dados['compensar'] =  $compensar->soma;
        $dados['saldoLq'] = $credito->soma - $compensar->soma - $debito->soma;
        $dados['corretoras'] = Service::get($tabela, $campo, $id_corretora);
        //Parametros para consulta
        $campo = $_POST["campo"];
        $valor = $_POST["valorfiltro"];
        if ($_POST["valor2"] > 0) {
            $valor = moedaEN($_POST['valor2']);
        }
        if ($_POST["campo"] === "confirmaN") {
            $campo = "confirma";
        }
        if ($_POST["campo"] === "confirmaU") {
            $campo = "data_confirma";
        }

        if ($valor <> "") {
            $dados["lista"] = Service::getLikeC($this->tabela, $campo, $valor, $id_corretora, true);
        } else {
            $dados["lista"] = Service::listaCorr($this->tabela, $id_corretora);
        }
        $dados["view"]  = "corrente/index";
        $this->load("template", $dados);
    }
    public function search_despesas()
    {
        $dados = array();
        $tabela = "despesas2";
        $campo = "nome_desp";
        $data = array();

        if (isset($_POST['q']) && !empty($_POST['q'])) {

            $q = addslashes($_POST['q']);
            $dados['despesas'] = Service::get($tabela, $campo, $q);

            foreach ($dados['despesas'] as $citem) {
                $data[] = array(
                    'name' => $citem->nome_desp
                );
            }
        }

        echo json_encode($data);
    }
}
