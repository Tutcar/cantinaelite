<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class ItensnfValidacao
{
    public static function salvar($itensnf)
    {
        $validacao = new Validacao();
        $validacao->setData("nf_nome", $itensnf->nf_nome);
        $validacao->setData("nf_tipo", $itensnf->nf_tipo);
        $validacao->setData("nf_quant", $itensnf->nf_quant);
        $validacao->setData("nf_preco", $itensnf->nf_preco);
        //Fazendo a validação
        $validacao->getData("nf_nome")->isVazio();
        $validacao->getData("nf_tipo")->isVazio();
        $validacao->getData("nf_quant")->isVazio();
        $validacao->getData("nf_preco")->isVazio();
        return $validacao;
    }
}
