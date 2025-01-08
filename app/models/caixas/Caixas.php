<?php

namespace app\models\caixas;

use app\core\Conexao;
use app\core\Validacao;
use app\models\service\Service;
use Exception;
use PDO;
use PDOException;

class Caixas
{
    protected $db;
    protected $tabela;

    public function __construct()
    {
        $this->db = Conexao::getConexao();
    }
    public function caixasNaoConferidos()
    {
        try {
            // Query SQL para selecionar os registros
            $sql = "SELECT * FROM caixaabre WHERE fechado = :fechado AND conferido = :conferido ORDER BY data_ab_caixa";

            // Preparar a query
            $stmt = $this->db->prepare($sql);

            // Definir os valores dos parâmetros
            $params = [
                ':fechado' => 's',
                ':conferido' => 'n',
            ];

            // Executar a query
            $stmt->execute($params);

            // Retornar os resultados
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            // Tratar erros
            echo "Erro: " . $e->getMessage();
            return [];
        }
    }
    public function caixasNaoConferidosSoma($id)
    {
        try {
            // Inicializar os tipos de pagamento com valor 0
            $resultados = [
                'Cartao' => 0,
                'Dinheiro' => 0,
                'Pix' => 0,
                'Outros' => 0,
                'credito' => 0
            ];

            // Query SQL
            $sql = "SELECT tipo_pg, SUM(valor) AS total 
                FROM pedido
                WHERE quant = '0'
                  AND cx_fechado = 'S'
                  AND cx_fechado_nao_conferido = 'N'
                  AND id_caixaabre = :id
                GROUP BY tipo_pg";

            // Preparar e executar
            $stmt = $this->db->prepare($sql);

            // Substituir o parâmetro
            $stmt->execute([':id' => $id]);

            // Buscar resultados
            $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Verificar se os dados são objetos e preencher no array
            if ($rows) {
                foreach ($rows as $row) {
                    if (is_object($row) && isset($row->tipo_pg)) {
                        // Preencher os resultados no array de tipos de pagamento
                        if (isset($resultados[$row->tipo_pg])) {
                            $resultados[$row->tipo_pg] = $row->total;
                        }
                    } else {
                        // Se a linha não for um objeto, você pode logar ou tratar o erro aqui
                        echo "Erro: linha inesperada não é um objeto. Valor: " . var_export($row, true);
                    }
                }
            } else {
                echo "Nenhum resultado encontrado.";
            }

            // Retornar os resultados já com valores zero para os tipos não encontrados
            return $resultados;
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();
        }
    }
}
