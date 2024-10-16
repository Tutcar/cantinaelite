<?php

namespace app\models\service;

use app\models\validacao\TipodbValidacao;
use app\util\UtilService;

class TipodbService
{
    public static function salvar($tipodb, $campo, $tabela)
    {

        $validacao = TipodbValidacao::salvar($tipodb);
        return Service::salvar($tipodb, $campo, $validacao->listaErros(),  $tabela);
    }
}
