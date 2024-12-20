<?php

namespace app\controllers;

use app\core\Controller;
use app\models\service\Service;
use app\core\Conexao;
use app\core\Flash;
use app\models\pagseguro\ReqPagSeguroPix;
use app\models\pedidos\Pedidos;
use app\models\service\PedidosService;
use app\util\UtilService;
use Exception;

class PedidosController extends Controller
{
    protected $db;
    private $tabela = "pedido";
    private $campo = "id_pedidos";
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


        $dados["lista"] = Service::lista($this->tabela);
        $dados["view"]  = "pedidos/index";
        $dados["tipo"] = Service::lista("tipo");
        $this->load("template", $dados);
    }
    public function impPedido()
    {
        $pedidosImp = new Pedidos();
        $dados["pedidosImp"] = $pedidosImp->pedidosImp();
        $dados["view"] = "pedidos/impPedido";
        $this->load("template", $dados);
    }
    public function impPedidoVia2($nr_pedido = null)
    {
        $impVia2 = new Pedidos();
        $impVia = $impVia2->imprimirPedido($nr_pedido);
        $this->redirect(URL_BASE . "pedidos/impPedido");
    }
    public function create()
    {
        $dados["pedidos"] = Flash::getForm();
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"] = "pedidos/create";
        $this->load("template", $dados);
    }


    public function edit($id)
    {

        $pedidos = Service::get($this->tabela, $this->campo, $id);
        if (!$pedidos) {
            $this->redirect(URL_BASE . "pedidos");
        }
        $dados["pedidos"] = $pedidos;
        $dados["tipo"] = Service::lista("tipo");
        $dados["view"]      = "pedidos/create";
        $this->load("template", $dados);
    }

    public function salvar()
    {

        $pedidos = new \stdClass();
        if ($_POST["id_pedidos"] || "") {
            $pedidos->id_pedidos = ($_POST["id_pedidos"]);
        } else {
            $pedidos->id_pedidos = null;
        }
        $pedidos->quant = $_POST["quant"];
        $pedidos->nome = $_POST["nome"];
        $pedidos->descricao = $_POST["descricao"];
        $pedidos->tipo = $_POST["tipo"];
        $pedidos->custo = $_POST["custo"];
        $pedidos->venda = $_POST["venda"];




        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            if (!$pedidos->id_pedidos) {
                $this->redirect(URL_BASE . "pedidos/create");
            } else {
                $this->redirect(URL_BASE . "pedidos/edit/" . $pedidos->id_pedidos);
            }
        }
    }
    public function excluir($id)
    {
        Service::excluir($this->tabela, $this->campo, $id);
        $this->redirect(URL_BASE . "home");
    }
    public function verPedido($id_pedido)
    {
        // Verifica se o ID do pedido é um número válido
        if (!is_numeric($id_pedido)) {
            echo json_encode(['erro' => 'ID do pedido inválido']);
            return;
        }

        $itens = Flash::getItensPorPedido($this->db, $id_pedido);

        if ($itens) {
            echo json_encode($itens);
        } else {
            echo json_encode(['erro' => 'Itens não encontrados']);
        }
    }
    public function filtro()
    {

        $campo = $_POST["campo"];
        $valor = $_POST["valor"];
        $dados["lista"] = Service::getLike($this->tabela, $campo, $valor, true);
        $dados["view"]  = "pedidos/index";
        $this->load("template", $dados);
    }
    public function salvarJson()
    {
        $cliente = Service::get("cliente", "nm_nome", $_POST["cliente"], false);
        $pedidos = new \stdClass();
        $pedidos->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $nrPedido = Flash::maximo3($this->db, "nr_pedido", "id_nr") + 1;
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        if ($_POST["cliente"] == "") {
            $pedidos->cliente = "Cli - " . $nrPedido;
            $pedidos->nr_pedido = $_POST["nr_pedido"];
            Flash::novoPedido($this->db, $nrPedido);
        } else {
            $pedidos->cliente = $_POST["cliente"];
            $pedidos->nr_pedido = $_POST["nr_pedido"];
        }
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        $pedidos->id_cliente = $cliente->id_cliente;
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function salvarJsoncr()
    {
        $cliente = Service::get("cliente", "nm_nome", $_POST["cliente"], false);
        $pedidos = new \stdClass();
        $pedidos->id_user = $_SESSION[SESSION_LOGIN]->id_user;
        $nrPedido = Flash::maximo3($this->db, "nr_pedido", "id_nr") + 1;
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        if ($_POST["cliente"] == "") {
            $pedidos->cliente = "Cli - " . $nrPedido;
            $pedidos->nr_pedido = $_POST["nr_pedido"];
            Flash::novoPedido($this->db, $nrPedido);
        } else {
            $pedidos->cliente = $_POST["cliente"];
            $pedidos->nr_pedido = $_POST["nr_pedido"];
        }
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $pedidos->id_cliente = $cliente->id_cliente;
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            //itens

            if ($cliente <> "") {
                $id_cli = $cliente->id_cliente;
            } else {
                $id_cli = -1;
            }
            $source = array('.', ',');
            $replace = array('', '.');
            $pedidos = new \stdClass();
            $pedidos->id_pedidos = null;
            $pedidos->nr_pedido = $_POST["nr_pedido"];
            $pedidos->id_produto = 10000;
            $pedidos->cli_p = $_POST["cliente"];
            $pedidos->data_ab_pedido = $today;
            $pedidos->nome = "Crédito direto no caixa feito por : " . $_SESSION[SESSION_LOGIN]->login_cli;
            $pedidos->quant = 1;
            $pedidos->pago = "S";
            $pedidos->custo = 0;
            $get_valor = $_POST["valor_credito"];
            $valor_credito = str_replace($source, $replace, $get_valor);
            $pedidos->valor = $valor_credito;
            Flash::setForm($pedidos);
            if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            }
            //fim itens
            //quitar
            $id_caixaAbre = Service::get("caixaabre", "fechado", "N");
            $pedidos = Service::get("pedido", "pago", $_SESSION["nr_ped"]);
            $pedidos = new \stdClass();
            $pedidos->id_caixaabre  = $id_caixaAbre->id_caixaabre;
            $source = array('.', ',');
            $replace = array('', '.');
            $pedidos->id_pedidos = Service::getMinimo2("pedido", "id_pedidos", "nr_pedido", $_SESSION["nr_ped"]);
            if ($_POST["valor_credito"] > 0) {
                $get_valor = $_POST["valor_credito"];
                $valor_credito = str_replace($source, $replace, $get_valor);
            } else {
                $get_valor = $_POST["valor_credito"];
                $valor_credito = str_replace($source, $replace, $get_valor);
            }
            $pedidos->valor = $valor_credito;
            $pedidos->custo = 0;
            $pedidos->tipo_pg = "credito";
            $pedidos->pago = "S";
            $pedidos->quant = 0;
            $today = date("Y-m-d H:i:s");
            $pedidos->data_fch_pedido = $today;
            Flash::setForm($pedidos);
            if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            }
            //fim
            //corrente
            $aluno = Service::get("cliente", "nm_nome", $_POST["cliente"]);
            $id_user = 1;
            $id_corretora = 1;
            $nr_doc_banco = "Cli-" . $aluno->id_cliente;
            $cod_despesa = $aluno->nr_cpf_cnpj;
            $data_cad = date("Y-m-d H:i:s");
            $descricao = $aluno->nm_nome;
            $nr_doc_pg =  $_SESSION["nr_ped"];
            $get_valor = $_POST["valor_credito"];
            $valor_credito = str_replace($source, $replace, $get_valor);
            $valor_debito = 0;
            $data_confirma = dateTime(hoje());
            $confirma = "S";
            $obs = "Crédito direto no caixa feito por : " . $_SESSION[SESSION_LOGIN]->login_cli;
            $tipo = null;
            Flash::debitoAl($this->db, $id_user, $id_corretora, $nr_doc_banco, $cod_despesa, $data_cad, $descricao, $nr_doc_pg, $valor_credito, $valor_debito, $data_confirma, $confirma, $obs, $tipo);
            //fim
            $_SESSION["nr_ped"] = 0;
            $dados["somaPedido"] = 0;
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function salvarJson2()
    {
        $pedidos = new \stdClass();
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        $pedidos->cliente = $_POST["cliente"];
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $_POST["data_encomendas"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            if ($_POST["encomendas"] == "S") {
                $id_user = $_SESSION[SESSION_LOGIN]->id_user;
                $descricao = "Encomenda nr:" . $_POST["nr_pedido"] . " - Cliente:" . $_POST["cliente"];
                $data_comp = $_POST["data_encomendas"];
                Flash::salvaEncomendas($this->db, $id_user, $pedidos->nr_pedido, $descricao, $data_comp);
            }
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function salvarJson3($carrinho)
    {
        $pedidos = new \stdClass();
        $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $pedidos->id_pedidos = null;
        $pedidos->cliente = $_POST["cliente"];
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->pago = "N";
        $today = date("Y-m-d H:i:s");
        $pedidos->data_ab_pedido = $today;
        $pedidos->id_caixaabre = $dados["idAbre"];
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $today;
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedido";
            $dados["lista"] = Service::lista($tabela);
            if ($_POST["encomendas"] == "S") {
                $id_user = $_SESSION[SESSION_LOGIN]->id_user;
                $descricao = "Encomenda nr:" . $_POST["nr_pedido"] . " - Cliente:" . $_POST["cliente"];
                $data_comp = $_POST["data_encomendas"];
                Flash::salvaEncomendas($this->db, $id_user, $pedidos->nr_pedido, $descricao, $data_comp);
            }
            echo json_encode('Pedido cadastrado.');
        } else {
            echo json_encode('Pedido não cadastrado.');
        }
    }
    public function CadPedidoJson()
    {
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $Cli_p = Service::get("pedidoCli_p", "nr_pedido", $_POST["nr_pedido"]);
        $cliente = Service::get("cliente", "nm_nome", $Cli_p->cliente, false);
        if ($cliente <> "") {
            $id_cli = $cliente->id_cliente;
        } else {
            $id_cli = -1;
        }
        $produtos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $produtos = Service::get("produtos", "id_produtos", $_POST["id_produto"]);
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = null;
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->id_produto = $_POST["id_produto"];
        $pedidos->cli_p = $Cli_p->cliente;
        $pedidos->data_ab_pedido = $Cli_p->data_ab_pedido;
        $pedidos->nome = $produtos->nome;
        $pedidos->quant = 1;
        $pedidos->pago = "N";
        $get_custo = moedaBr($produtos->custo);
        $pedidos->custo = str_replace($source, $replace, $get_custo);
        $get_valor = moedaBr($produtos->venda);
        $pedidos->valor = str_replace($source, $replace, $get_valor);
        $restricaoAlunoPedido = Flash::restricaoAlunoPedido($this->db, $id_cli, $pedidos->id_produto);
        if ($restricaoAlunoPedido > 0) {
            Flash::setMsg("Produto com restrição de venda.!", -1);
            echo json_encode('Produto com restrição de venda.');
            die();
        }
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedidoo";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Item cadastrado.');
        } else {
            echo json_encode('Item não cadastrado.');
        }
    }
    public function CadPedidoJson2()
    {
        $_SESSION["nr_ped"] = $_POST["nr_pedido"];
        $Cli_p = Service::get("pedidoCli_p", "nr_pedido", $_POST["nr_pedido"]);
        $produtos = new \stdClass();
        $source = array('.', ',');
        $replace = array('', '.');
        $produtos = Service::get("produtos", "id_produtos", $_POST["id_produto"]);
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = null;
        $pedidos->nr_pedido = $_POST["nr_pedido"];
        $pedidos->id_produto = $_POST["id_produto"];
        $pedidos->cli_p = $Cli_p->cliente;
        $pedidos->data_ab_pedido = $Cli_p->data_ab_pedido;
        $pedidos->nome = $produtos->nome;
        $pedidos->quant = 1;
        $pedidos->pago = "N";
        $pedidos->encomendas = "S";
        $pedidos->data_encomendas = $_SESSION["data_encomendas"];
        $get_custo = moedaBr($produtos->custo);
        $pedidos->custo = str_replace($source, $replace, $get_custo);
        $get_valor = moedaBr($produtos->venda);
        $pedidos->valor = str_replace($source, $replace, $get_valor);
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            $tabela = "pedidoo";
            $dados["lista"] = Service::lista($tabela);
            echo json_encode('Item cadastrado.');
        } else {
            echo json_encode('Item não cadastrado.');
        }
    }
    public function CardapioJson()
    {

        $dados["lista"] = Service::lista("produtos");
    }
    public function AtualizaPedJson($id)
    {
        $_SESSION["nr_ped"] = $id;

        $this->redirect(URL_BASE . "home");
        echo json_encode('Item cadastrado.');
    }
    public function AtualizaPedJson2($id)
    {
        $_SESSION["nr_ped"] = $id;

        $this->redirect(URL_BASE . "encomendas/index");
        echo json_encode('Item cadastrado.');
    }
    public function salvarFechaPedido()
    {

        $id_caixaAbre = Service::get("caixaabre", "fechado", "N");
        // $dados["pedidos"] = Flash::fechaCx($this->db);
        $pedidos = Service::get("pedido", "pago", $_SESSION["nr_ped"]);
        $pedidos = new \stdClass();
        $pedidos->id_caixaabre  = $id_caixaAbre->id_caixaabre;
        $source = array('.', ',');
        $replace = array('', '.');
        $pedidos->id_pedidos = Service::getMinimo2("pedido", "id_pedidos", "nr_pedido", $_SESSION["nr_ped"]);
        if ($_POST["vLiquido"] > 0) {
            $pedidos->valor = $_POST['vLiquido'];
        } else {
            $get_valor = $_POST['valor'];
            $pedidos->valor = str_replace($source, $replace, $get_valor);
        }
        $pedidos->custo = Service::getSoma2("pedidos", "quant * custo", "nr_pedido", null, true);
        $pedidos->tipo_pg = $_POST["tipo_pg"];
        $pedidos->pago = "S";
        $pedidos->quant = 0;
        $today = date("Y-m-d H:i:s");
        $pedidos->data_fch_pedido = $today;

        if ($pedidos->tipo_pg == "Outros") {

            $saldoAluno = 0;
            $saldoTotalAluno = 0;
            $pedido = Service::get("pedidoSaldo", "nr_pedido", $_SESSION["nr_ped"], false);
            $saldoAlunos = Flash::CreditoAluno($this->db, $pedido->cliente);
            $saldoAlunos =  floatval($saldoAlunos->soma);
            $cliente = $pedido->cliente;
            $aluno = Service::get("cliente", "nm_nome", $cliente, false);
            $alunoNaoInfo = substr($cliente, 0, 5);
            if ($alunoNaoInfo == "Cli -") {
                Flash::setMsg("O pedido tem que estar com o nome do aluno.", -1);
                echo json_encode('O pedido tem que estar com o nome do aluno.');
                exit();
            }
            $saldoAluno = floatval(Service::getSoma("corrente", "valor_credito - valor_debito", "cod_despesa", $aluno->nr_cpf_cnpj));
            $saldoTotalAluno = $aluno->limite + $saldoAlunos;
            if ($pedidos->valor > $saldoTotalAluno) {
                Flash::setMsg("Saldo insuficiente : " . moedaBr($saldoTotalAluno), -1);
                echo json_encode('Sem saldo para esta comprar.');
                exit();
            } else {
                $id_user = 1;
                $id_corretora = 1;
                $nr_doc_banco = "Cli-" . $aluno->id_cliente;
                $cod_despesa = $aluno->nr_cpf_cnpj;
                $data_cad = dateTime(hoje());
                $descricao = $aluno->nm_nome;
                $nr_doc_pg =  $_SESSION["nr_ped"];
                $valor_credito = 0;
                $valor_debito = $pedidos->valor;
                $data_confirma = dateTime(hoje());
                $confirma = "S";
                $obs = "Compra com saldo direto no caixa, pedido Nr. " . $nr_doc_pg;
                $tipo = null;
                Flash::debitoAl($this->db, $id_user, $id_corretora, $nr_doc_banco, $cod_despesa, $data_cad, $descricao, $nr_doc_pg, $valor_credito, $valor_debito, $data_confirma, $confirma, $obs, $tipo);
            }
        }
        if ($pedidos->tipo_pg == "Pix") {
            $token_credito_al = $_SESSION["nr_ped"];
            $confirma = "N";
            $pedidos->pago = "N";
            $valorpag = new \stdClass();
            $valorpag->produto = "Credito";
            $valorpag->quantidade = 1;
            $valorpag->valor_credito = $pedidos->valor;
            $pedido = Service::get("pedido", "nr_pedido", $_SESSION["nr_ped"], false);
            $cliente = $pedido->cliente;
            $_SESSION['CLIENTE'] = Service::get("cliente", "nm_nome", $cliente);
            $alunoNaoInfo = substr($cliente, 0, 5);
            if ($alunoNaoInfo == "Cli -") {
                $alunopag = new \stdClass();
                $alunopag->id_cliente = 952;
                $alunopag->NomeCliente = "Danilo Mandetta Junior";
                $alunopag->email = "contato@cantinaelite.com.br";
                if (substr("67997861668", 0, 2) == "67") {
                    $alunopag->ddd = substr("67997861668", 0, 2);
                    $alunopag->nr_fone = substr("67997861668", 2);
                } else {
                    $alunopag->ddd = "67";
                    $alunopag->nr_fone = "991285454";
                }
                $alunopag->tipoDoc = "CPF";
                $alunopag->nrCpf = "33739544104";

                $alunopag->nm_rua = "Rua Ari Coelho de Oliveira";
                $alunopag->nr_numero = "105";
                $alunopag->nm_bairro = "Vila Progresso";
                $alunopag->nm_cidade = "Campo Grande";
                $alunopag->sg_estado = "MS";
                $alunopag->complemento = "Centro";
                $alunopag->nr_cep = "13471-410";
                $alunopag->pais = "BRA";
                $alunopag->localizacao = "Mato Grosso do Sul";
            } else {
                $alunopag = dadosAluno();
            }

            $response = ReqPagSeguroPix::createOrder($alunopag, $valorpag, $_SESSION["nr_ped"]);

            // Verifique se a resposta contém o QR Code
            $qrcode_png_url = '';
            $qrcode = '';

            if (isset($response['qr_codes'][0]['links'])) {
                // Seu array de exemplo

                // Armazena o valor do ID na sessão
                $_SESSION['id'] = $response['qr_codes'][0]['id'];



                foreach ($response['qr_codes'][0]['links'] as $link) {
                    if ($link['rel'] === 'QRCODE.PNG') {
                        $qrcode_png_url = $link['href'];
                        break;
                    }
                }
            }
            // Verifica se a URL foi capturada corretamente
            if (empty($qrcode_png_url)) {
                echo "Erro: QR Code não disponível.";
            } else {
                // Exibe a página HTML com o modal e o QR Code


                // Redireciona para a página de confirmação de pagamento, passando o link do QR Code
                $_SESSION['qrcode_url'] = $qrcode_png_url;
                $_SESSION['formapix'] = "pix";
                $nr_doc_pg = $token_credito_al;
                $_SESSION['webhook'] = $nr_doc_pg;
            }
        }
        if ($pedidos->tipo_pg == "Pix") {
            $pedidos->pago = "N";
        }
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            if ($pedidos->tipo_pg <> "Pix") {
                $dados["pedidos"] = Flash::fechaCx($this->db);
            }

            //Imprimir


            // //Fim imprimir
            $_SESSION["impPedido"] = $_SESSION["nr_ped"];
            $impPedido = new Pedidos();
            $onfImp = $impPedido->imprimirPedido($nr_pedido = $_SESSION["impPedido"]);
            unset($_SESSION["nr_ped"]);
            echo json_encode('Pedido fechado.');
        } else {
            echo json_encode('Pedido não fechado.');
        }
    }

    public function alteraPedidoJson()
    {
        $pedidos = new \stdClass();
        $source = ['.', ','];
        $replace = ['', '.'];

        $pedidos->id_pedidos = $_POST["id_pedidos"];
        $pedidos->nome = $_POST["nome"];
        $pedidos->quant = $_POST["quant"];
        $get_valor = moedaBr($_POST["valor"]);
        $pedidos->valor = str_replace($source, $replace, $get_valor);

        Flash::setForm($pedidos);

        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            echo json_encode('Item alterado.');
        } else {
            echo json_encode('Item não alterado.');
        }
    }
    public function alteraPedido2Json()
    {
        $pedidos = new \stdClass();
        $pedidos->id_pedidos = $_POST["id_pedidos"];
        $pedidos->quant = $_POST["quant"];
        Flash::setForm($pedidos);
        if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            echo json_encode('Item alterado.');
        } else {
            echo json_encode('Item não alterado.');
        }
    }

    public function imprimirPedido()
    {
        $printerName = "\\\\TutaTeixeira/POS-80";
        $_SESSION["impPedido"] = $_SESSION["nr_ped"];

        // Recupera os dados do pedido
        $array = new Pedidos();
        $array = $array->ItensPorPedido($nr_pedido = $_SESSION["impPedido"]);
        unset($_SESSION["impPedido"]);

        if (!$array || !isset($array[0])) {
            return;
        }

        // Função para gerar texto estilizado
        function gerarTextoEstilizado()
        {
            $texto = "\n\n";
            $texto .= "\x1B\x61\x01"; // Centraliza o texto
            $texto .= "\x1D\x21\x9"; // Aumenta o tamanho da fonte
            $texto .= "##############################\n";
            $texto .= "#        CANTINA ELITE       #\n";
            $texto .= "##############################\n";
            $texto .= "\x1D\x21\x00"; // Retorna ao tamanho normal
            $texto .= "\x1B\x61\x00"; // Retorna ao alinhamento padrão
            $texto .= "\n\n";
            return $texto;
        }

        // Prepara o texto para impressão
        $texto = "\x1B\x74\x10"; // Define tabela de caracteres Latin-1 (ISO-8859-1)
        // Prepara o texto para impressão
        $texto = gerarTextoEstilizado();

        // Adiciona os detalhes do pedido
        $texto .= "\x1B\x61\x01"; // Centraliza o texto
        $texto .= "\x1D\x21\x11"; // Aumenta o tamanho da fonte
        $texto .= "Pedido: {$array[0]['nr_pedido']}\n\n";
        $texto .= "\x1D\x21\x00"; // Retorna ao tamanho normal
        $texto .= "\x1B\x61\x00"; // Retorna ao alinhamento padrão
        $texto .= "Cliente: {$array[0]['cliente']}\n";
        $texto .= "Data: {$array[0]['data_cad']}\n";
        $texto .= str_repeat("-", 40) . "\n";

        foreach ($array as $index => $item) {
            if ($index === 0) continue;
            $texto .= "Quantidade: {$item['quant']}\n";
            $texto .= "Produto: {$item['nome']}\n";
            $texto .= "Valor: R$ " . moedaBr($item['valor']) . "\n";
            $texto .= str_repeat("-", 40) . "\n";
        }

        // Finaliza com comandos ESC/POS
        $texto .= "\x1B\x64\x04"; // Avança 2 linhas
        $texto .= "\x1B\x69";     // Corta o papel

        // Substituir caracteres não suportados explicitamente
        $mapaCaracteres = [
            'á' => "\xA0",
            'é' => "\x82",
            'í' => "\xA1",
            'ó' => "\xA2",
            'ú' => "\xA3",
            'Á' => "\xB5",
            'É' => "\x90",
            'Í' => "\xD6",
            'Ó' => "\xE0",
            'Ú' => "\xE9",
            'ã' => "\xC6",
            'õ' => "\xD5",
            'ç' => "\x87",
            'Ã' => "\xC7",
            'Õ' => "\xD6",
            'Ç' => "\x80"
        ];

        $texto = strtr($texto, $mapaCaracteres);

        // Envia o texto para a impressora
        try {
            $fp = fopen($printerName, "w");
            if (!$fp) {
                throw new Exception("Erro ao abrir a impressora: {$printerName}");
            }
            fwrite($fp, $texto);
            fclose($fp);
            return;
        } catch (Exception $e) {
            error_log("Erro na impressão: " . $e->getMessage());
        }
    }
}
