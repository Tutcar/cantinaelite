<?php

namespace app\controllers;

use app\core\Controller;
use PDOException;
use app\core\Flash;
use app\core\Conexao;
use app\models\pagseguro\ReqPagSeguroPix;
use app\models\service\PedidosService;
use app\models\service\Service;
use app\util\UtilService;

class HomepageController extends Controller
{
   private $tabela = "pedido";
   private $campo = "id_pedidos";
   private $usuario = "";
   protected $db;
   private $diasDaSemana = [
      0 => "Domingo",
      1 => "Segunda-feira",
      2 => "Terça-feira",
      3 => "Quarta-feira",
      4 => "Quinta-feira",
      5 => "Sexta-feira",
      6 => "Sábado"
   ];
   public function __construct()
   {
      $this->db = Conexao::getConexao();
      $this->usuario = UtilService::getUsuario();
      if (!$this->usuario) {
         $this->redirect(URL_BASE . "login");
         exit();
      }
   }

   public function index()
   {

      if ($_SESSION[SESSION_LOGIN]->tipo === "cliente") {
         $dados["saldoAluno"] = Flash::saldoCantina($this->db, $_SESSION['CLIENTE']->nr_cpf_cnpj) + $_SESSION['CLIENTE']->limite;
         $dados["limiteAluno"] = $_SESSION['CLIENTE']->limite;
         if ($dados["saldoAluno"] == "") {
            $dados["saldoAluno"] = 0;
         };
      }

      $dados["carrinho"] = isset($_SESSION['carrinho']) ? $_SESSION['carrinho'] : [];
      $dados["salgados"] = Service::get("produtos", "categorias", "salgados", true);
      $dados["outros"] = Service::get("produtos", "categorias", "outros", true);
      $dados["bebidas"] = Service::get("produtos", "categorias", "bebidas", true);
      $dados["dia"] = diasemanaExtenso(date(hoje()));
      $dados["pratos"] = Service::get("produtos", "dia", $diaSemanaNumero = date('w', strtotime(hoje())), true);
      $dados["pratoss"] = Service::get("produtos", "categorias", "prato", true);
      // Loop para processar cada dia
      foreach ($dados["pratoss"] as $dia) {
         if (array_key_exists($dia->dia, $this->diasDaSemana)) {
            // Adiciona o nome do dia por extenso ao objeto $dia
            $dia->diaPorExtenso = $this->diasDaSemana[$dia->dia];
         } else {
            $dia->diaPorExtenso = "Dia desconhecido"; // Caso o número não esteja no mapeamento
         }
      }
      $dados["produtos"] = Service::lista("produtos");
      $dados['num_visitas'] = Flash::contador($this->db);
      $dados["view"]       = "homecarda";
      $this->load("homepage", $dados);
   }
   public function salvar_carrinho()
   {

      // Configura o cabeçalho para JSON
      header('Content-Type: application/json');

      // Recebe os dados do carrinho enviado via AJAX
      $data = json_decode(file_get_contents('php://input'), true);

      // Verifica se a conversão do JSON foi bem-sucedida
      if (json_last_error() === JSON_ERROR_NONE) {
         // Salva os dados do carrinho na sessão
         $_SESSION['carrinho'] = $data;
         // Retorna uma resposta de sucesso
         echo json_encode(['status' => 'success', 'message' => 'Carrinho salvo com sucesso.']);
      } else {
         // Retorna uma resposta de erro se o JSON não for válido
         echo json_encode(['status' => 'error', 'message' => 'Dados do carrinho inválidos.']);
      }
   }
   public function obter_total_carrinho()
   {
      // Configura o cabeçalho para JSON
      header('Content-Type: application/json');

      // Verifica se o carrinho existe e calcula o total
      if (isset($_SESSION['total_carrinho'])) {
         echo json_encode(['total' => $_SESSION['total_carrinho']]);
      } else {
         echo json_encode(['total' => 0]);
      }
   }

   public function cadastrar_carrinho()
   {
      $total_p = 0;
      $get_valor = 0;
      if (isset($_SESSION['carrinho'])) {
         $carrinho = $_SESSION['carrinho'];
         foreach ($carrinho as $item) {
            // Captura o preço direto do item atual do carrinho
            $get_valor = isset($item['preco']) ? $item['preco'] : 0;
            $get_valor = str_replace(',', '.', $get_valor);

            $total_p += (float) $get_valor; // Soma o valor ao total
         }
         $saldoAluno = Flash::saldoCantina($this->db, $_SESSION['CLIENTE']->nr_cpf_cnpj) + $_SESSION['CLIENTE']->limite;
         if ($_GET['saldo'] == 1) {
            if ($saldoAluno < $total_p) {
               Flash::setMsg("Sem saldo para comprar de:." . moedaBr($total_p), -1);
               $this->redirect(URL_BASE . "homepage", $carrinho);
            }
         }
      }

      $dados["idAbre2"] = Flash::maximo2($this->db, "caixaabre", "fechado", "N");
      if ($dados["idAbre2"] == "") {
         $_SESSION["verifCx"] = 0;
         Flash::setMsg("Cantina fechada, aguarde abertura para fazer o pedido.", -1);
         $carrinho = $_SESSION['carrinho'];
         $this->redirect(URL_BASE . "homepage", $carrinho);
         exit();
      }
      if (isset($_SESSION['carrinho'])) {
         $campo = null;
         $valor = null;
         //Cadastrar pedido
         $dados["idAbre"] = Flash::maximo($this->db, "caixaabre", "fechado", "N");
         $pedidos = new \stdClass();
         $nrPedido = $dados["nr_pedido"] = Service::getMaximo("pedido", "nr_pedido", $campo, $valor) + 1;
         $pedidos->id_pedidos = null;
         $pedidos->cliente = $_SESSION[SESSION_LOGIN]->login;
         $pedidos->nr_pedido = $nrPedido;
         if ($_GET['saldo'] == 1) {
            $pedidos->pago = "S";
            $pedidos->tipo_pg = "saldo";
            $pedidos->id_cliente = $_SESSION['CLIENTE']->id_cliente;
         } elseif ($_GET['saldo'] == 2) {
            $pedidos->pago = "N";
            $pedidos->tipo_pg = "pix";
            $pedidos->id_cliente = $_SESSION['CLIENTE']->id_cliente;
         } elseif ($_GET['saldo'] == 3) {
            $pedidos->pago = "N";
            $pedidos->tipo_pg = "cartao";
            $pedidos->id_cliente = $_SESSION['CLIENTE']->id_cliente;
         } else {
            $pedidos->pago = "N";
         }

         $today = date("Y-m-d H:i:s");
         $pedidos->data_ab_pedido = $today;
         $pedidos->id_caixaabre = $dados["idAbre"];
         $pedidos->encomendas = "S";
         $pedidos->data_encomendas = $today;
         Flash::setForm($pedidos);
         if (PedidosService::salvar($pedidos, $this->campo, $this->tabela)) {
            if ($pedidos->encomendas == "S") {
               $id_user = $_SESSION['CLIENTE']->id_cliente;
               $descricao = "Pedido Site nr:" . $nrPedido . " - Cliente:" . $_SESSION[SESSION_LOGIN]->login;
               $data_comp = $today;
               Flash::salvaEncomendas($this->db, $id_user, $nrPedido, $descricao, $data_comp);
            }
         }

         // Itera sobre os itens do carrinho e grava no banco de dados
         $texto = "";
         $texto .= "Nr. Pedido: {$nrPedido}\n";
         foreach ($carrinho as $item) {
            $id = $item['id'];
            $Cli_p = Service::get("pedidoCli_p", "nr_pedido", $nrPedido);
            $produtos = new \stdClass();
            $source = array('.', ',');
            $replace = array('', '.');
            $produtos = Service::get("produtos", "id_produtos", $id);

            $pedidos = new \stdClass();
            $pedidos->id_pedidos = null;
            $pedidos->nr_pedido = $nrPedido;
            $pedidos->id_produto = $id;
            $pedidos->cli_p = $Cli_p->cliente;
            $pedidos->data_ab_pedido = $Cli_p->data_ab_pedido;
            $pedidos->nome = $produtos->nome;
            $pedidos->quant = 1;
            //se for por saldo
            if ($_GET['saldo'] == 1) {
               $pedidos->pago = "S";
            } else {
               $pedidos->pago = "N";
            }

            $pedidos->encomendas = "S";
            $pedidos->data_encomendas = $today;

            // Captura o custo do produto
            $get_custo = moedaBr($produtos->custo ?? 0);
            $pedidos->custo = str_replace($source, $replace, $get_custo);

            // Captura o preço direto do item atual do carrinho
            $get_valor = isset($item['preco']) ? $item['preco'] : 0;
            $get_valor = str_replace(',', '.', $get_valor);

            $pedidos->valor = (float) $get_valor;
            $total_p = ++$produtos->venda;

            Flash::setForm($pedidos);
            PedidosService::salvar($pedidos, $this->campo, $this->tabela);

            // Concatena informações sobre o item
            $pedidos->valor = moedaBr($pedidos->valor);
            $texto .= "{$pedidos->id_produto},{$pedidos->nome}, ";
            $texto .= "Valor: {$pedidos->valor}\n";
         }

         $get_valor = moedaBr($_POST["saldoal"] ?? 0);
         $saldoAldos = str_replace($source, $replace, $get_valor);
         $get_valor = moedaBr(Flash::totalPedido($this->db, $nrPedido));
         $total_p = str_replace($source, $replace, $get_valor);
         $texto .= "Total: {$total_p}\n";
         $id_user = 1;
         $id_corretora = 1;
         $nr_doc_banco = "Cli-" . $_SESSION['CLIENTE']->id_cliente;
         $cod_despesa = $_SESSION['CLIENTE']->nr_cpf_cnpj;
         $data_cad = date('Y-m-d');
         $descricao = $_SESSION['CLIENTE']->nm_nome;
         $nr_doc_pg =  $nrPedido;
         $valor_credito = 0;
         $get_valor = moedaBr($total_p ?? 0);
         $valor_debito = str_replace($source, $replace, $get_valor);
         $data_confirma = date('Y-m-d');
         if ($_GET['saldo'] == 1) {
            $confirma = "S";
         } else {
            $confirma = "N";
         }
         $obs = $texto;
         $tipo = null;
         try {
            // Limpa a sessão após salvar no banco de dados
            unset($_SESSION['carrinho']);
            if ($_GET['saldo'] == 1) {
               $cadDebPedido = Flash::debitoAl($this->db, $id_user, $id_corretora, $nr_doc_banco, $cod_despesa, $data_cad, $descricao, $nr_doc_pg, $valor_credito, $valor_debito, $data_confirma, $confirma, $obs, $tipo);
               $this->redirect(URL_BASE . "homepage", $carrinho);
               header("Refresh: 0"); // Adiciona o refresh
               exit;
            } else {
               $source = array('.', ',');
               $replace = array('', '.');
               // Redireciona para a página inicial
               $valorpag = new \stdClass();
               $valorpag->id_cliente = $_SESSION['CLIENTE']->id_cliente;
               $id = $valorpag->id_cliente;
               $valorpag->produto = "Credito";
               $valorpag->quantidade = 1;
               $valorpag->valor_credito = $total_p;
               $alunopag = dadosAluno();
               // if ($_GET['saldo'] == 1) {
               //    $nr_doc_pg = $nr_doc_pg."CTD";
               // }
               $response = ReqPagSeguroPix::createOrder($alunopag, $valorpag, $nr_doc_pg);

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

               //Verifica se a URL foi capturada corretamente
               if (empty($qrcode_png_url)) {
                  $this->redirect(URL_BASE . "homepage", $carrinho);
               } else {
                  //Exibe a página HTML com o modal e o QR Code
                  //Redireciona para a página de confirmação de pagamento, passando o link do QR Code
                  $_SESSION['qrcode_url'] = $qrcode_png_url;
                  $this->redirect(URL_BASE . "homepage", $carrinho);
               }
            }
         } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
         }
      }
   }
}
