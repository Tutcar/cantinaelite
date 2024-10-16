<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CompromissoValidacao
{
    public static function salvar($compromisso)
    {

        $validacao = new Validacao();
        $validacao->setData("descricao", $compromisso->descricao);
        $validacao->setData("data_comp", $compromisso->data_comp);

        //Fazendo a validação
        $validacao->getData("descricao")->isVazio();
        $validacao->getData("data_comp")->isVazio();

        return $validacao;
    }
}