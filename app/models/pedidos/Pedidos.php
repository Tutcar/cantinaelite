<?php

namespace app\models\pedidos;

use app\core\Conexao;
use app\core\Validacao;
use app\models\service\Service;
use Exception;

class Pedidos
{
    protected $db;
    protected $tabela;

    public function __construct()
    {
        $this->db = Conexao::getConexao();
    }
    public static function ItensPorPedido($db, $nr_pedido)
    {
        $sql = "SELECT * FROM pedido WHERE nr_pedido = :nr_pedido";
        $stmt = $db->prepare($sql);
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
