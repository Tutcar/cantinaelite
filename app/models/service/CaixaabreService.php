<?php

namespace app\models\service;

use app\models\validacao\CaixaabreValidacao;
use app\util\UtilService;

class CaixaabreService
{
    public static function salvar($Caixaabre, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CaixaabreValidacao::salvar($Caixaabre);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Caixaabre->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Caixaabre->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Caixaabre, $campo, $validacao->listaErros(),  $tabela);
    }
}
