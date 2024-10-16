<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Conexao;
use app\models\service\Service;
use app\core\Flash;
use app\models\service\ClienteService;
use app\models\service\UserService;
use app\util\UtilService;

class ClienteController extends Controller
{
    private $tabela = "cliente";
    private $campo = "id_cliente";
    protected $db;
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

        $tabela = "cliente";
        $dados["lista"] = Service::lista($tabela);
        $dados["view"]  = "cliente/index";
        $this->load("template", $dados);
    }
    public function create()
    {
        $tabela = "cliente";
        $dados["cliente"] = Service::lista($tabela);
        $dados["cliente"] = Flash::getForm();
        $dados["view"] = "cliente/create";
        $this->load("template", $dados);
    }
    public function edit($id)
    {

        $dados["cliente"] = Service::lista($this->tabela);
        $cliente = Service::get($this->tabela, $this->campo, $id);

        if (!$cliente) {
            $this->redirect(URL_BASE . "cliente");
        }
        $dados["cliente"] = $cliente;
        $dados["view"]      = "cliente/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {
        $source = array('.', ',');
        $replace = array('', '.');
        $cliente = new \stdClass();
        if ($_POST["id_cliente"] || "") {
            $cliente->id_cliente = ($_POST["id_cliente"]);
        } else {
            $cliente->id_cliente = null;
        }
        $cliente->nm_nome = $_POST["nm_nome"];
        $cliente->nm_short = $_POST["nm_short"];
        $cliente->serie = $_POST["serie"];
        $cliente->nr_fone = $_POST["nr_fone"];
        $cliente->nr_cpf_cnpj = $_POST["nr_cpf_cnpj"];
        $cliente->dat_niver = $_POST["dat_niver"];
        $cliente->nr_cep = $_POST["nr_cep"];
        $cliente->nm_rua = $_POST["nm_rua"];
        $cliente->nr_numero = $_POST["nr_numero"];
        $cliente->nm_bairro = $_POST["nm_bairro"];
        $cliente->nm_cidade = $_POST["nm_cidade"];
        $cliente->sg_estado = $_POST["sg_estado"];
        $get_limite = $_POST["limite"];
        $cliente->limite = str_replace($source, $replace, $get_limite);
        $cliente->e_mail = $_POST["e_mail"];

        Flash::setForm($cliente);


        if (ClienteService::salvar($cliente, $this->campo, $this->tabela)) {
            if ($_POST["id_cliente"] == null) {
                $tabela = "user";
                $campo = "id_user";
                $idcli = Service::get("cliente", "e_mail", $_POST["e_mail"], false);
                $user = new \stdClass();
                $user->id_user = null;
                $user->id_cliente = $idcli->id_cliente;
                $user->tipo = "cliente";
                $user->e_mail = $_POST["e_mail"];
                $user->login = $_POST["nm_nome"];
                $tamanho = 12;
                $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+<>?';
                $user->senha = md5(substr(str_shuffle($caracteres), 0, $tamanho));
                Flash::setForm($user);
                UserService::salvar($user, $campo, $tabela);
            }
            $this->redirect(URL_BASE . "cliente");
        } else {
            if (!$cliente->cliente) {
                $this->redirect(URL_BASE . "cliente/create");
            } else {
                $this->redirect(URL_BASE . "cliente/edit/" . $cliente->id_cliente);
            }
        }
    }
    public function filtro()
    {
        $campo = $_POST["campo"];
        $valor = $_POST["pesqFiltrar"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "cliente/index";
        $this->load("template", $dados);
    }
    public function excluir($id)
    {

        $tabela = "cliente";
        $campo = "id_cliente";
        Service::excluir($tabela, $campo, $id);
        Service::excluir("user", "id_cliente", $id);
        $this->redirect(URL_BASE . "cliente");
    }
}
