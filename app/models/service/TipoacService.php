<?php

namespace app\models\service;

use app\models\validacao\TipoacValidacao;
use app\util\UtilService;

class TipoacService
{
    public static function salvar($tipoac, $campo, $tabela)
    {
        $validacao = TipoacValidacao::salvar($tipoac);
        return Service::salvar($tipoac, $campo, $validacao->listaErros(),  $tabela);
    }
}
