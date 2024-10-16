<?php

namespace app\models\service;

use app\models\validacao\CardapioValidacao;
use app\util\UtilService;

class CardapioService
{
    public static function salvar($Cardapio, $campo, $tabela)
    {
        global $config_upload;
        $validacao = CardapioValidacao::salvar($Cardapio);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Cardapio->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Cardapio->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Cardapio, $campo, $validacao->listaErros(),  $tabela);
    }
}
