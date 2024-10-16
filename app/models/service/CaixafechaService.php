<?php

namespace app\models\service;

use app\models\validacao\CaixafechaValidacao;
use app\util\UtilService;

class CaixafechaService
{
    public static function salvar($Caixafecha, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CaixafechaValidacao::salvar($Caixafecha);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Caixafecha->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Caixafecha->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Caixafecha, $campo, $validacao->listaErros(),  $tabela);
    }
}
