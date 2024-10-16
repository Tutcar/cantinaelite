<?php

namespace app\models\pagseguro;

class ReqPagSeguroPix2
{
    public static function createOrder2($alunopag, $valorpag, $id)
    {
        $curl = curl_init();
        $url_ambiente = '1';

        if ($url_ambiente === '1') {
            $url_transacao = 'https://sandbox.api.pagseguro.com/orders'; //TESTES
        } else {
            $url_transacao = 'https://api.pagseguro.com/orders'; //PRODUCAO
        }

        //ID da transacao (pode ser o ID do seu banco de dados)
        $dados["reference_id"]    = $id;

        //DADOS CLIENTE
        $dados["customer"]["name"]    = $alunopag->id_cliente;
        $dados["customer"]["email"]    = $alunopag->email;
        $dados["customer"]["tax_id"]    = $alunopag->nrCpf;

        //TELEFONE CLIENTE
        $dados["customer"]["phones"][0]["country"]    = "55";
        $dados["customer"]["phones"][0]["area"]    = $alunopag->ddd;
        $dados["customer"]["phones"][0]["number"]    = $alunopag->nr_fone;
        $dados["customer"]["phones"][0]["type"]    = "MOBILE";

        //PRODUTOS
        $dados["items"][0]["name"]    = $valorpag->produto;
        $dados["items"][0]["quantity"]    = $valorpag->quantidade;
        $dados["items"][0]["unit_amount"]    = (int)($valorpag->valor_credito * 100);

        //qrcode
        $dados["qr_codes"][0]["amount"]["value"]    = (int)($valorpag->valor_credito * 100);
        //ENDERECO CLIENTE
        $dados["shipping"]["address"]["street"]    = $alunopag->nm_rua;
        $dados["shipping"]["address"]["number"]    = $alunopag->nr_numero;
        $dados["shipping"]["address"]["complement"]    = $alunopag->complemento;
        $dados["shipping"]["address"]["locality"]    = $alunopag->localizacao;
        $dados["shipping"]["address"]["city"]    = $alunopag->nm_cidade;
        $dados["shipping"]["address"]["region_code"]    = $alunopag->sg_estado;
        $dados["shipping"]["address"]["country"]    = $alunopag->pais;
        $dados["shipping"]["address"]["postal_code"]    = $alunopag->nr_cep;

        //URL DE NOTIFICACAO
        $dados["notification_urls"][0]    = "https://tutcar-pagseguro.ultrahook.com ";


        curl_setopt_array($curl, array(
            CURLOPT_URL => $url_transacao,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($dados),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_CAINFO => "C:/xampp/htdocs/cantinaelite/cacert.pem",
            CURLOPT_HTTPHEADER => array(
                'content-type: application/json',
                'Authorization: Bearer 9027BDDEB627409AA2EB73E6E8C891ED'
            ),
        ));
        $response = curl_exec($curl);
        $resultado = json_decode($response);
        //var_dump($response);
        //echo '<br><br>';

        foreach ($resultado->qr_codes as $linhas) {
            echo $linhas->text;
            foreach ($linhas->links as $url) {
                if ($url->rel == "QRCODE.PNG") {
                    echo '<img src="' . $url->href . '" />';
                }
            }
        }
        if ($resultado->id <> '') {
            echo 'dados para solicitar homologação:';
            echo '<br><br>dados enviados:<br>';
            var_dump($dados);
            echo '<br><br>retorno da api:<br>';
            var_dump($response);
        } else {
            echo 'erro, tente verificar o token ou ambiente, faça os teste em sandbox';
        }
        //$resultado->id; -> gravar essa ID em seu banco de dados para consultar status no notification.php
        curl_close($curl);
    }
}
