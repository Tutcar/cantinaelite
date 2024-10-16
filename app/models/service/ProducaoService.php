<?php

namespace app\models\service;

use app\models\validacao\ProducaoValidacao;
use app\util\UtilService;

class ProducaoService
{
    public static function salvar($producao, $campo, $tabela)
    {
        global $config_upload;
        $validacao = ProducaoValidacao::salvar($producao);
        return Service::salvar($producao, $campo, $validacao->listaErros(),  $tabela);
    }
}
