<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CompValidacao
{
    public static function salvar($comp)
    {

        $validacao = new Validacao();

        $validacao->setData("nome_arq", $comp->nome_arq);
        //Fazendo a validação

        $validacao->getData("nome_arq")->isArquivo();

        return $validacao;
    }
}
