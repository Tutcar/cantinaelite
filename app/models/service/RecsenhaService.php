<?php

namespace app\models\service;

use app\models\validacao\RecsenhaValidacao;
use app\util\UtilService;

class RecsenhaService
{
    public static function salvar($recsenha, $campo, $tabela)
    {
        global $config_upload;
        $validacao = RecsenhaValidacao::salvar($recsenha);
        return Service::salvar($recsenha, $campo, $validacao->listaErros(),  $tabela);
    }
}
