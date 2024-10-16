<?php

namespace app\models\service;

use app\models\validacao\CompValidacao;
use app\util\UtilService;

class CompService
{
    public static function salvar($user, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CompValidacao::salvar($user);

        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $user->foto = UtilService::upload("arquivo", $config_upload);
                if (!$user->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($user, $campo, $validacao->listaErros(),  $tabela);
    }
}
