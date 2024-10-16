<?php

namespace app\models\service;

use app\models\validacao\ProdutosValidacao;
use app\util\UtilService;

class ProdutosService
{
    public static function salvar($Produtos, $campo, $tabela)
    {
        global $config_upload;
        $validacao = ProdutosValidacao::salvar($Produtos);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Produtos->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Produtos->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Produtos, $campo, $validacao->listaErros(),  $tabela);
    }
}
