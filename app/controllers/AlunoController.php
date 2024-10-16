<?php

namespace app\controllers;

use App\Controllers\PagSeguro as ControllersPagSeguro;
use app\core\Controller;
use app\core\Conexao;
use app\core\Flash;
use app\models\pagseguro\ReqPagSeguro;
use app\models\pagseguro\ReqPagSeguroCheckout;
use app\models\pagseguro\ReqPagSeguroPix;
use app\models\pagseguro\ReqPagSeguroPay;
use app\models\pagseguro\ReqPagSeguroPix2;
use app\public\ReqPagSeguroWebhook;
use app\models\service\CorrenteService;
use app\models\service\Service;
use app\util\UtilService;
use PDOException;

class AlunoController extends Controller
{
    private $tabela = "corrente";
    private $campo = "id_corrente";
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
        }
    }
    public function index() {}
    public function simularPay()
    {

        $response = ReqPagSeguroPay::simulaPay();
    }
    public function webhookPix()
    {

        $response = ReqPagSeguroWebhook::webhookPix();
    }
    public function salvarAl()
    {

        $tamanho = 6;
        $caracteres = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+<>?';
        $token_credito_al = md5(substr(str_shuffle($caracteres), 0, $tamanho). $dataHora = date('YmdHis'));
        $source = array('.', ',');
        $replace = array('', '.');
        //Dados do credito pag seguro
        $valorpag = new \stdClass();
        $valorpag->id_cliente = $_SESSION['CLIENTE']->id_cliente;
        $id = $valorpag->id_cliente;
        $valorpag->produto = "Credito";
        $valorpag->quantidade = 1;
        $get_valor_credito = preg_replace('/[^\d,]/', '', $_POST["valor_credito"]);
        $valorpag->valor_credito = str_replace($source, $replace, $get_valor_credito);
        $valorpag->valorLimpo = preg_replace('/[,.]/', '', $valorpag->valor_credito);
        //Dados aluno credido
        $alunopag = new \stdClass();
        $alunopag->id_cliente = $_SESSION['CLIENTE']->id_cliente;
        $alunopag->NomeCliente = $_SESSION['CLIENTE']->nm_nome;
        $alunopag->email = $_SESSION['CLIENTE']->e_mail;
        $alunopag->ddd = substr($_SESSION['CLIENTE']->nr_fone, 0, 2);
        $alunopag->nr_fone = substr($_SESSION['CLIENTE']->nr_fone, 2);
        $alunopag->tipoDoc = "CPF";
        $alunopag->nrCpf = $_SESSION['CLIENTE']->nr_cpf_cnpj;

        $alunopag->nm_rua = $_SESSION['CLIENTE']->nm_rua;
        $alunopag->nr_numero = $_SESSION['CLIENTE']->nr_numero;
        $alunopag->nm_bairro = $_SESSION['CLIENTE']->nm_bairro;
        $alunopag->nm_cidade = $_SESSION['CLIENTE']->nm_cidade;
        $alunopag->sg_estado = $_SESSION['CLIENTE']->sg_estado;
        $alunopag->complemento = "Centro";
        $alunopag->nr_cep = "13471-410";
        $alunopag->pais = "BRA";
        $alunopag->localizacao = "Mato Grosso do Sul";
        //req pag seguro
        //Cadastrar credito conta corrente aluno
        $corrente = new \stdClass();

        $corrente->id_corrente = null;

        $corrente->id_user = 1;
        $corrente->id_corretora = 1;
        $corrente->nr_doc_banco = "Cli - " . $_SESSION[SESSION_LOGIN]->id_user;
        $cdesp = $_SESSION['CLIENTE']->nr_cpf_cnpj;
        $corrente->cod_despesa = $cdesp;
        $corrente->data_cad = date('Y-m-d');
        $corrente->descricao = $_SESSION['CLIENTE']->nm_nome;
        $corrente->nr_doc_pg = $token_credito_al;

        if ($_POST["valor_credito"] != null) {
            $get_valor_credito = preg_replace('/[^\d,]/', '', $_POST["valor_credito"]);
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
        $corrente->confirma = "N";

        $corrente->obs = "Crédito para :" . $_SESSION['CLIENTE']->nm_nome;
        $corrente->tipo = "";

        Flash::setForm($corrente);

        try {
            if (CorrenteService::salvar($corrente, $this->campo, $this->tabela)) {
                Flash::setMsg("Crédito efetuado com sucesso!", 1);
                // $response = ReqPagSeguroCheckout::checkoutPag($alunopag, $valorpag, $token_credito_al);
                $response = ReqPagSeguroPix::createOrder($alunopag, $valorpag, $token_credito_al);

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

                    $this->redirect(URL_BASE);
                }
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
