<?php

namespace app\models\service;

use app\models\validacao\ItensnfValidacao;
use app\util\UtilService;

class ItensnfService
{
    public static function salvar($itensnf, $campo, $tabela)
    {
        global $config_upload;
        $validacao = ItensnfValidacao::salvar($itensnf);
        return Service::salvar($itensnf, $campo, $validacao->listaErros(),  $tabela);
    }
}
