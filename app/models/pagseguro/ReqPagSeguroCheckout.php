<?php

namespace app\models\pagseguro;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ReqPagSeguroCheckout
{
    public static function checkoutPag($alunopag, $valorpag, $id)
    {
        // Ponto de depuração inicial
        echo "Iniciando requisição...\n";

        // Criar um cliente HTTP
        $client = new Client();

        try {
            // Configurar o corpo da requisição
            $body = [
                "reference_id" => $id, // Identificador único do pedido
                "customer" => [
                    "name" => $alunopag->NomeCliente,
                    "email" => $alunopag->email,
                    "tax_id" => $alunopag->nrCpf,
                    "phones" => [
                        [
                            "country" => "55",
                            "area" => $alunopag->ddd,
                            "number" => $alunopag->nr_fone,
                            "type" => "MOBILE"
                        ]
                    ]
                ],
                "customer_modifiable" => false,
                "items" => [
                    [
                        "id" => $id,
                        "description" => $valorpag->produto,
                        "quantity" => $valorpag->quantidade,
                        "amount" => (int)($valorpag->valor_credito * 100)
                    ]
                ],
                "expiration_date" => date('Y-m-d\TH:i:sP', strtotime('+2 hours')),
                "additional_amount" => 0,
                "discount_amount" => 0,
                "shipping" => [
                    "address" => [
                        "street" => "Rua Exemplo",
                        "number" => "123",
                        "complement" => "Apto 101",
                        "locality" => "Bairro",
                        "city" => "Cidade",
                        "region_code" => "SP",
                        "country" => "BRA",
                        "postal_code" => "12345678"
                    ],
                    "amount" => (int)($valorpag->valor_credito * 100),
                    "description" => "Entrega padrão"
                ],
                "payment_methods" => [
                    ["type" => "CREDIT_CARD"],
                    ["type" => "DEBIT_CARD"]
                ],
                "soft_descriptor" => "CantinaElite",
                "redirect_url" => "https://tutcar-stripe.ultrahook.com/cantinaelite/Aluno/webhookPix",
                "notification_urls" => [
                    "https://tutcar-stripe.ultrahook.com/cantinaelite/Aluno/webhookPix"
                ],
                "payment_notification_urls" => [
                    "https://tutcar-stripe.ultrahook.com/cantinaelite/Aluno/webhookPix"
                ]
            ];

            // Exibir o corpo da requisição para verificar os dados
            echo "Corpo da requisição: \n";
            var_dump($body);

            // Enviar a requisição POST
            $response = $client->request('POST', 'https://sandbox.api.pagseguro.com/checkouts', [
                'headers' => [
                    'Authorization' => 'Bearer 9027BDDEB627409AA2EB73E6E8C891ED',
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => $body,
                'verify' => false // Desabilitar verificação SSL temporariamente
            ]);

            // Verificar o código de status da resposta HTTP
            $httpCode = $response->getStatusCode();
            echo "Status code: " . $httpCode . "\n"; // Deve ser 200 para sucesso

            // Exibir a resposta completa
            echo "Resposta da API: \n";
            var_dump($response->getBody()->getContents());
        } catch (RequestException $e) {
            echo "Erro na requisição: \n"; // Depuração de erros
            // Captura e exibe o erro, se houver
            if ($e->hasResponse()) {
                echo "Erro de resposta da API: \n";
                echo $e->getResponse()->getBody()->getContents();
            } else {
                echo "Erro geral: \n";
                echo $e->getMessage();
            }
        }

        echo "Finalizando requisição...\n"; // Ponto de verificação final
    }
}
