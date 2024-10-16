<?php

namespace app\models\service;

use app\models\validacao\ClienteValidacao;
use app\util\UtilService;

class ClienteService
{
    public static function salvar($Cliente, $campo, $tabela)
    {
        global $config_upload;
        $validacao = ClienteValidacao::salvar($Cliente);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Cliente->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Cliente->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Cliente, $campo, $validacao->listaErros(),  $tabela);
    }
}
