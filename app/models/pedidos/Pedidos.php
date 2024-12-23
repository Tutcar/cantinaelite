<?php

namespace app\models\pedidos;

use app\core\Conexao;
use app\core\Validacao;
use app\models\service\Service;
use Exception;
use PDO;

class Pedidos
{
    protected $db;
    protected $tabela;

    public function __construct()
    {
        $this->db = Conexao::getConexao();
    }
    public function pedidosImp($pago = null)
    {
        if ($pago !== null) {
            $pgsn = "AND pago = 'N'";
        } else {
            $pgsn = "AND pago = 'S'";
        }
        // Query para buscar os registros
        $sql = "SELECT * 
            FROM pedido 
            WHERE cliente <> ''
              AND encomendas = 'N'
              $pgsn
              AND DATE(data_cad) = CURDATE()";

        // Executar a query
        $stmt = $this->db->query($sql);

        // Verificar se há resultados
        $pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Retornar os registros ou array vazio
        return $pedidos ?: [];
    }
    public function pedidosImpDia($dataDia = null)
    {

        // Construir a cláusula de data com base no valor de $dataDia
        if ($dataDia === null) {
            $clausulaData = "AND DATE(data_cad) = CURDATE()";
        } else {
            $clausulaData = "AND DATE(data_cad) = :dataDia";
        }

        // Query para buscar os registros
        $sql = "SELECT * 
            FROM pedido 
            WHERE cliente <> ''
              AND encomendas = 'N'
              AND pago = 'S'
              $clausulaData";

        // Preparar a query
        $stmt = $this->db->prepare($sql);

        // Vincular o parâmetro se necessário
        if ($dataDia !== null) {
            $stmt->bindValue(':dataDia', $dataDia);
        }

        // Executar a query
        $stmt->execute();

        // Verificar se há resultados
        $pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Retornar os registros ou array vazio
        return $pedidos ?: [];
    }
    public function pedidosImpNr($nr_pedido = null)
    {
        // Query para buscar os registros
        $sql = "SELECT * 
            FROM pedido 
            WHERE cliente <> ''
              AND encomendas = 'N'
              AND pago = 'S'
              AND nr_pedido = :nr_pedido";

        // Preparar a query
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':nr_pedido', $nr_pedido, PDO::PARAM_INT); // Use PDO::PARAM_INT ou PDO::PARAM_STR, dependendo do tipo do valor

        // Executar a query
        $stmt->execute();

        // Verificar se há resultados
        $pedidos = $stmt->fetchAll(PDO::FETCH_OBJ);

        // Retornar os registros ou array vazio
        return $pedidos ?: [];
    }



    public function imprimirPedido($nr_pedido = null)
    {
        $printerName = "\\\\TutaTeixeira/POS-80";
        // Recupera os dados do pedido
        $array = new Pedidos();
        $array = $array->ItensPorPedido($nr_pedido);
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
    public function ItensPorPedido($nr_pedido)
    {
        $sql = "SELECT * FROM pedido WHERE nr_pedido = :nr_pedido";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nr_pedido', $nr_pedido, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_ASSOC); // Retorna os itens do pedido
    }
    /**
     * Converte uma imagem para comandos ESC/POS.
     * Aceita apenas imagens em preto e branco.
     */
    public static function imageToEscPos($imagePath)
    {

        // Carrega a imagem
        $image = imagecreatefromwebp($imagePath);
        if (!$image) {
            throw new Exception("Não foi possível carregar a imagem: {$imagePath}");
        }

        // Converte para preto e branco
        imagefilter($image, IMG_FILTER_GRAYSCALE);
        imagefilter($image, IMG_FILTER_CONTRAST, -100);

        // Obtém dimensões
        $width = imagesx($image);
        $height = imagesy($image);

        // Inicia o comando ESC/POS
        $escPos = "\x1D\x76\x30\x00" . pack('v', $width) . pack('v', $height);

        // Percorre os pixels da imagem
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($image, $x, $y);
                $r = ($color >> 16) & 0xFF;
                $g = ($color >> 8) & 0xFF;
                $b = $color & 0xFF;
                $gray = ($r + $g + $b) / 3;
                $escPos .= ($gray < 128) ? "\x01" : "\x00";
            }
        }

        imagedestroy($image);
        return $escPos;
    }
}
