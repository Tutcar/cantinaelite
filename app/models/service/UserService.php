<?php

namespace app\models\service;

use app\models\validacao\UserValidacao;
use app\util\UtilService;

class UserService
{
    public static function salvar($User, $campo, $tabela)
    {
        global $config_upload;
        $validacao = UserValidacao::salvar($User);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $User->foto = UtilService::upload("arquivo", $config_upload);
                if (!$User->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($User, $campo, $validacao->listaErros(),  $tabela);
    }
}
