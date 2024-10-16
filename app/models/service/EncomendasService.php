<?php

namespace app\models\service;

use app\models\validacao\EncomendasValidacao;
use app\util\UtilService;

class EncomendasService
{
    public static function salvar($encomendas, $campo, $tabela)
    {
        global $config_upload;
        $validacao = EncomendasValidacao::salvar($encomendas);
        return Service::salvar($encomendas, $campo, $validacao->listaErros(),  $tabela);
    }
}
