<?php

namespace app\models\service;

use app\models\validacao\CompromissoValidacao;
use app\util\UtilService;

class CompromissoService
{
    public static function salvar($compromisso, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CompromissoValidacao::salvar($compromisso);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $compromisso->foto = UtilService::upload("arquivo", $config_upload);
                if (!$compromisso->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($compromisso, $campo, $validacao->listaErros(),  $tabela);
    }
}