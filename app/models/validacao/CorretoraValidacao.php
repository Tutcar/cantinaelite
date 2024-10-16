<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CorretoraValidacao
{
    public static function salvar($corretora)
    {

        $validacao = new Validacao();
        $validacao->setData("nome", $corretora->nome);
        $validacao->setData("nr_banco", $corretora->nr_banco);
        $validacao->setData("nr_agencia", $corretora->nr_agencia);
        $validacao->setData("nr_conta", $corretora->nr_conta);

        //Fazendo a validação
        $validacao->getData("nome")->isVazio();
        $validacao->getData("nr_banco")->isVazio();
        $validacao->getData("nr_agencia")->isVazio();
        $validacao->getData("nr_conta")->isVazio();

        return $validacao;
    }
}