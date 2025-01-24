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
    public function precosMarmitex($db, $id, $valor)
    {
        // Verifica qual campo deve ser atualizado
        if ($id == "Marmitex pequeno") {
            $query = "UPDATE produtos SET venda = :valor WHERE  categorias = :categorias";
        } elseif ($id == "Marmitex grande") {
            $query = "UPDATE produtos SET venda_g = :valor WHERE  categorias = :categorias";
        } else {
            return false; // ID inválido, nenhuma atualização necessária
        }

        // Prepara e executa a query
        $stmt = $db->prepare($query);
        $stmt->bindParam(':valor', $valor, PDO::PARAM_STR);
        $stmt->bindValue(':categorias', 'prato', \PDO::PARAM_STR);

        return $stmt->execute(); // Retorna true se a execução for bem-sucedida, false caso contrário
    }

    public function novoPedido($db, $nrPedido)
    {
        try {
            $sql = "INSERT INTO nr_pedido (nr_cli) VALUES (:nr_cli)";
            $stmt = $db->prepare($sql);
            $stmt->bindValue(':nr_cli', $nrPedido);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }
        return false;
    }
    public function marmitexDia($db)
    {
        try {
            // Consulta SQL para selecionar pedidos
            $sql = "SELECT * FROM pedido 
                WHERE obs_cardapio != :obs_cardapio 
                  AND data_ab_pedido = :data_ab_pedido 
                  AND id_produto != :id_produto 
                ORDER BY cli_p";

            $stmt = $db->prepare($sql);

            // Parâmetros com valores definidos
            $stmt->bindValue(':obs_cardapio', '.', \PDO::PARAM_STR);
            $stmt->bindValue(':id_produto', '', \PDO::PARAM_STR);

            // Data atual
            $dataAtual = date('Y-m-d');
            $stmt->bindValue(':data_ab_pedido', $dataAtual, \PDO::PARAM_STR);

            // Executa a consulta
            $stmt->execute();

            // Retorna todos os registros encontrados como objetos
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            // Lança exceção em caso de erro no banco
            throw new \Exception($e->getMessage());
        }
    }

    public function marmitexDiaImp($db)
    {
        try {
            // Query SQL ajustada
            $sql = "SELECT * 
                FROM pedido 
                WHERE obs_cardapio != :obs_cardapio 
                  AND data_ab_pedido = :data_ab_pedido 
                  AND id_produto IS NOT NULL
                  ORDER BY cli_p";

            $stmt = $db->prepare($sql);

            // Define os valores para os parâmetros
            $stmt->bindValue(':obs_cardapio', '.', \PDO::PARAM_STR); // Verifica registros diferentes de 'N'

            // Data atual
            $dataAtual = date('Y-m-d');
            $stmt->bindValue(':data_ab_pedido', $dataAtual, \PDO::PARAM_STR);

            $stmt->execute();

            // Retorna os registros encontrados como objetos
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return false;
    }
    public function mamitexPeqGde($db)
    {
        try {
            // Query para encontrar o menor valor ("Marmitex pequeno") e o maior valor ("Marmitex grande")
            $sql = "SELECT 
                    MIN(venda) AS menor_valor, 
                    MAX(venda) AS maior_valor 
                FROM produtos 
                WHERE categorias = :categorias";

            $stmt = $db->prepare($sql);

            // Bind do parâmetro para categoria
            $stmt->bindValue(':categorias', 'pratodia', \PDO::PARAM_STR);

            $stmt->execute();

            // Obtendo os resultados
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            // Retornando o menor e maior valores, caso existam
            if ($result) {
                return [
                    'marmitex_pequeno' => $result->menor_valor,
                    'marmitex_grande' => $result->maior_valor,
                ];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return false;
    }


    public function marmitexDiaContar($db)
    {
        try {
            // Query SQL ajustada para incluir contagem separada por tipo de marmitex
            $sql = "SELECT 
                    COUNT(*) as total_registros, 
                    SUM(valor) as soma_total,
                    SUM(CASE WHEN nome = 'Marmitex pequeno' THEN 1 ELSE 0 END) as total_pequeno,
                    SUM(CASE WHEN nome = 'Marmitex grande' THEN 1 ELSE 0 END) as total_grande
                FROM pedido 
                WHERE obs_cardapio != :obs_cardapio 
                AND data_ab_pedido = :data_ab_pedido 
                AND id_produto != :id_produto";

            $stmt = $db->prepare($sql);

            // Valor para obs_cardapio ('N')
            $stmt->bindValue(':obs_cardapio', '.', \PDO::PARAM_STR);

            // Valor para id_produto
            $stmt->bindValue(':id_produto', '', \PDO::PARAM_STR);

            // Data atual
            $dataAtual = date('Y-m-d');
            $stmt->bindValue(':data_ab_pedido', $dataAtual, \PDO::PARAM_STR);

            $stmt->execute();

            // Obtendo o resultado
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            // Retorna um array com os dados necessários
            if ($result) {
                return [
                    'total_registros' => $result->total_registros,
                    'soma_total' => $result->soma_total,
                    'total_pequeno' => $result->total_pequeno,
                    'total_grande' => $result->total_grande,
                ];
            }
        } catch (\PDOException $e) {
            throw new \Exception($e->getMessage());
        }

        return false;
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
