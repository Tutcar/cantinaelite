<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class EncomendasValidacao
{
    public static function salvar($encomendas)
    {
        $validacao = new Validacao();
        $validacao->setData("fone", $encomendas->fone);
        $validacao->setData("nome", $encomendas->nome);
        $validacao->setData("dados", $encomendas->dados);
        //Fazendo a validação
        $validacao->getData("fone")->isVazio();
        $validacao->getData("nome")->isVazio();
        $validacao->getData("dados")->isVazio();
        return $validacao;
    }
}
