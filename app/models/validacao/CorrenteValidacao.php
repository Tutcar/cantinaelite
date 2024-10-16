<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class CorrenteValidacao
{
    public static function salvar($corrente)
    {

        $validacao = new Validacao();
        $validacao->setData("id_corretora", $corrente->id_corretora);
        $validacao->setData("nr_doc_banco", $corrente->nr_doc_banco);
        $validacao->setData("cod_despesa", $corrente->cod_despesa);
        $validacao->setData("data_cad", $corrente->data_cad);
        $validacao->setData("descricao", $corrente->descricao);
        $validacao->setData("nr_doc_pg", $corrente->nr_doc_pg);

        //Fazendo a validação
        $validacao->getData("id_corretora")->isVazio();
        $validacao->getData("nr_doc_banco")->isVazio();
        $validacao->getData("cod_despesa")->isVazio();
        $validacao->getData("data_cad")->isVazio();
        $validacao->getData("descricao")->isVazio();
        $validacao->getData("nr_doc_pg")->isVazio();

        return $validacao;
    }
}