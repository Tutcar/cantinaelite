<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class DespesasValidacao
{
    public static function salvar($despesas)
    {
        $validacao = new Validacao();

        $validacao->setData("nome_desp", $despesas->nome_desp);
        if (!$_SESSION['UNICO']) {
            $unico = 0;
        } else {
            $unico = 1;
        }
        unset($_SESSION['UNICO']);
        //Fazendo a validação
        $validacao->getData("nome_desp")->isVazio()->isUnico($unico);

        return $validacao;
    }
}
