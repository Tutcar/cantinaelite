<?php

namespace app\models\pedidos;

use app\core\Conexao;
use app\core\Validacao;
use app\models\service\Service;
use Exception;
use PDO;

class CaixasNaoConferidos
{
    protected $db;
    protected $tabela;

    public function __construct()
    {
        $this->db = Conexao::getConexao();
    }
}
