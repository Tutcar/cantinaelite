<?php

namespace app\models\service;

use app\models\validacao\CorrenteValidacao;
use app\util\UtilService;

class CorrenteService
{
    public static function salvar($corrente, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CorrenteValidacao::salvar($corrente);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            // if ($_FILES["arquivo"]["name"]) {
            //     $corrente->foto = UtilService::upload("arquivo", $config_upload);
            //     if (!$corrente->foto) {
            //         return false;
            //     }
            // }
        }
        return Service::salvar($corrente, $campo, $validacao->listaErros(),  $tabela);
    }
}
