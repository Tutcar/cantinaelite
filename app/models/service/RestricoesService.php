<?php

namespace app\models\service;

use app\models\validacao\RestricoesValidacao;
use app\util\UtilService;

class RestricoesService
{
    public static function salvar($restricoes, $campo, $tabela)
    {
        global $config_upload;
        $validacao = RestricoesValidacao::salvar($restricoes);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $restricoes->foto = UtilService::upload("arquivo", $config_upload);
                if (!$restricoes->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($restricoes, $campo, $validacao->listaErros(),  $tabela);
    }
}
