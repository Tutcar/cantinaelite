<?php

namespace app\models\service;

use app\models\validacao\PedidosValidacao;
use app\util\UtilService;

class PedidosService
{
    public static function salvar($pedidos, $campo, $tabela)
    {
        global $config_upload;
        $validacao = PedidosValidacao::salvar($pedidos);
        if ($validacao->qtdeErro() <= 0) {
            /*fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $pedidos->foto = UtilService::upload("arquivo", $config_upload);
                if (!$pedidos->foto) {
                    return false;
                }
            }*/
        }
        return Service::salvar($pedidos, $campo, $validacao->listaErros(),  $tabela);
    }
}
