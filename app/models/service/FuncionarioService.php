<?php

namespace app\models\service;

use app\models\validacao\FuncionarioValidacao;
use app\util\UtilService;

class FuncionarioService
{
    public static function salvar($Funcionario, $campo, $tabela)
    {
        global $config_upload;
        $validacao = FuncionarioValidacao::salvar($Funcionario);
        if ($validacao->qtdeErro() <= 0) {
            /// fazendo o upload do arquivo
            if ($_FILES["arquivo"]["name"]) {
                $Funcionario->foto = UtilService::upload("arquivo", $config_upload);
                if (!$Funcionario->foto) {
                    return false;
                }
            }
        }
        return Service::salvar($Funcionario, $campo, $validacao->listaErros(),  $tabela);
    }
}
