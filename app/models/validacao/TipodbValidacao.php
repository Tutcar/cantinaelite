<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class TipodbValidacao
{
    public static function salvar($tipodb)
    {
        $validacao = new Validacao();

        $validacao->setData("db_tipo", $tipodb->db_tipo);
        if (!$_SESSION['UNICO']) {
            $unico = 0;
        } else {
            $unico = 1;
        }
        unset($_SESSION['UNICO']);
        //Fazendo a validação
        $validacao->getData("db_tipo")->isVazio()->isUnico($unico);

        return $validacao;
    }
}
