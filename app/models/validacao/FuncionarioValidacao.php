<?php

namespace app\models\validacao;

use app\core\Validacao;
use app\models\service\Service;

class FuncionarioValidacao
{
    public static function salvar($funcionario)
    {
        $qu = Service::get("funcionario", "nr_cpf_cnpj", $funcionario->nr_cpf_cnpj);
        if ($qu == "") {
            $quant = 0;
        } else {
            $quant = 1;
        }
        $validacao = new Validacao();
        $validacao->setData("nm_nome", $funcionario->nm_nome);
        $validacao->setData("nr_cpf_cnpj", $funcionario->nr_cpf_cnpj);
        //Fazendo a validação
        $validacao->getData("nm_nome")->isVazio();
        if (strlen($_POST["nr_cpf_cnpj"]) === 11) {
            if ($_POST["id_funcionario"] == "") {
                $validacao->getData("nr_cpf_cnpj")->isVazio()->isCPF()->isUnico($quant);
            } else {
                $validacao->getData("nr_cpf_cnpj")->isVazio()->isCPF();
            }
        } else if (strlen($_POST["nr_cpf_cnpj"]) === 14) {
            if ($_POST["id_funcionario"] == "") {
                $validacao->getData("nr_cpf_cnpj")->isVazio()->isCNPJ()->isUnico($quant);
            } else {
                $validacao->getData("nr_cpf_cnpj")->isVazio()->isCNPJ();
            }
        } else {
            $validacao->getData("nr_cpf_cnpj")->isVazioCnpj();
        }
        return $validacao;
    }
}
