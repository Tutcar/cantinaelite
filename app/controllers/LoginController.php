<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Conexao;
use app\core\Flash;
use app\models\service\RecsenhaService;
use app\models\service\Service;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class LoginController extends Controller
{
    protected $pdo;
    public function __construct()
    {
        $this->pdo = Conexao::getConexao();
    }
    public function index()
    {
        $dados["view"] = "login";
        $this->load("login", $dados);
    }
    public function logar()
    {
        $e_mail = $_POST["e_mail"];
        $senha = md5($_POST["senha"]);
        Flash::setForm($_POST);
        if (Service::logar("e_mail", $e_mail, $senha, "user")) {
            if ($_SESSION[SESSION_LOGIN]->id_user === 1) {
                $this->redirect(URL_BASE . "painel");
            } elseif ($_SESSION[SESSION_LOGIN]->tipo === "cliente") {
                $this->redirect(URL_BASE . "homepage");
            } elseif ($_SESSION[SESSION_LOGIN]->tipo === "funcionario") {
                $this->redirect(URL_BASE . "home");
            }
        } else {
            Flash::setMsg("Dados não conferem.", -1);
            $this->redirect(URL_BASE . "login");
        }
    }
    public function logoff()
    {
        unset($_SESSION['carrinho']);
        unset($_SESSION[SESSION_LOGIN]);
        unset($_SESSION["nr_ped"]);
        unset($_SESSION['qrcode_url']);
        $this->redirect(URL_BASE . "login");
    }
    public function recuperar_senha()
    {

        $this->load("recuperar_senha");
    }
    public function reset_senha()
    {

        $this->load("resetar_senha");
    }


    public function enviar_senha()
    {
        $tabela = "user";
        $campo = "id_user";

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            // Verifique se o e-mail existe no banco de dados
            $usuario = Service::get("user", "e_mail", $_POST["email"], false);

            if ($usuario) {
                $recsenha = new \stdClass();
                // Gera um token seguro
                $token = bin2hex(random_bytes(50));

                // Define a validade do token (por exemplo, 1 hora)
                $expira = date("Y-m-d H:i:s", strtotime('+1 hour'));

                // Armazena o token no banco de dados
                $recsenha->id_user = $usuario->id_user;
                $recsenha->token = $token;
                $recsenha->expira = $expira;

                Flash::setForm($recsenha);

                if (RecsenhaService::salvar($recsenha, $campo, $tabela)) {
                    Flash::setMsg("Verifique em sua caixa de e-mail.", 1);

                    // Enviar e-mail
                    if ($this->enviarEmailRecuperacao($email, $token)) {
                        Flash::setMsg("E-mail de recuperação foi enviado.", 1);
                    } else {
                        Flash::setMsg("Erro ao enviar e-mail.", -1);
                    }

                    $this->load("recuperar_senha");
                } else {
                    Flash::setMsg("Erro ao salvar token.", -1);
                    $this->load("recuperar_senha");
                }
            } else {
                Flash::setMsg("E-mail não encontrado.", -1);
                $this->load("recuperar_senha");
            }
        }
    }

    public function resetar_senha()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $token = $_POST['token'];
            $novaSenha = md5($_POST['senha']);

            // Verifica se o token é válido e não expirou
            $dadosToken = Flash::tokenValido($this->pdo, $token);
            $token = $dadosToken[0];
            if ($dadosToken) {
                // Atualiza a senha do usuário 
                $dadosToken = Flash::novaSenha($this->pdo, $novaSenha, $token);
                Flash::setMsg("Senha recuperada com sucesso.", 1);
                $this->load("login");
            } else {
                Flash::setMsg("Não foi possível recuperar a senha.", 1);
                $this->load("recuperar_senha");
            }
        }
    }
    function enviarEmailRecuperacao($email, $token)
    {
        // Configurações do PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configurações do servidor de e-mail (SMTP)
            $mail->isSMTP();
            $mail->Host       = 'mail.cantinaelite.store'; // Servidor SMTP correto
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contato@cantinaelite.store'; // Seu e-mail SMTP
            $mail->Password   = '&0284TFVzV5S';             // Senha da conta de e-mail
            $mail->SMTPSecure = 'ssl';                      // Usar SSL
            $mail->Port       = 465;                        // Porta SSL

            // Remetente e destinatário
            $mail->setFrom('noreply@cantinaelite.com', 'Cantina Elite');
            $mail->addAddress($email);

            // Conteúdo do e-mail
            $mail->isHTML(true);  // Definir e-mail como HTML
            $mail->Subject = 'Recuperação de Senha';
            $link = "https://cantinaelite.store/cantinaelite/login/reset_senha/token/$token";
            $mail->Body    = "Clique no link a seguir para redefinir sua senha: <a href='$link'>$link</a>";

            // Enviar e-mail
            return $mail->send();
        } catch (Exception $e) {
            // Registra o erro de envio do e-mail para fins de debugging
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }
}
