<?php

namespace app\models\service;

use app\models\validacao\CorretoraValidacao;
use app\util\UtilService;

class CorretoraService
{
    public static function salvar($corretora, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CorretoraValidacao::salvar($corretora);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $corretora->foto = UtilService::upload("arquivo", $config_upload);
                if (!$corretora->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($corretora, $campo, $validacao->listaErros(),  $tabela);
    }
}