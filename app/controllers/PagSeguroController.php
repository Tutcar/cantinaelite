<?php

namespace App\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class PagSeguroController
{
    public function criarPedido($cliente, $valor, $id)
    {
        $client = new Client([
            'base_uri' => 'https://sandbox.api.pagseguro.com/',
        ]);

        $logFile = 'pagseguro.log'; // Caminho para o arquivo de log

        try {
            $response = $client->request('POST', 'orders', [
                'headers' => [
                    'Authorization' => 'd32af9ff-e799-44e8-a48d-615b7937089ce79dc2a447f28ffbe0907e72be974f7ab8d4-5cde-44c8-a0fc-df7d41907a41',
                    'Content-Type'  => 'application/json',
                    'x-idempotency-key' => uniqid($id), // chave idempotente para evitar duplicidade
                ],
                'json' => [
                    'reference_id' => $cliente->id_cliente,
                    'customer' => [
                        'name' => $cliente->NomeCliente,
                        'email' => $cliente->email,
                        'tax_id' => $cliente->nrCpf,
                        'phones' => [
                            [
                                'country' => '55',
                                'area'    => $cliente->ddd,
                                'number'  => $cliente->nr_fone,
                                'type'    => 'MOBILE'
                            ]
                        ]
                    ],
                    'items' => [
                        [
                            'name' => $valor->produto,
                            'quantity' => $valor->quantidade,
                            'unit_amount' => (int)$valor->valorLimpo, // valor em centavos
                            'currency' => 'BRL' // A moeda, geralmente BRL para Real Brasileiro
                        ]
                    ],
                    'qr_codes' => [
                        'amount' => [
                            'value' => (int)$valor->valorLimpo, // valor total em centavos
                            'currency' => 'BRL' // Adicione a moeda aqui também
                        ],
                        // Opcional: pode incluir configurações adicionais para qr_codes
                        'expire' => [
                            'enabled' => true,
                            'date' => '2024-09-30T10:00:00-03:00' // Data e hora de expiração (opcional)
                        ]
                    ],
                ],
            ]);

            // Exibir o código de status da resposta
            echo "Código de Status: " . $response->getStatusCode() . "\n";

            // Decodificar a resposta
            $responseBody = json_decode($response->getBody(), true); // decodifica a resposta para um array associativo
            print_r($responseBody); // exibe a estrutura da resposta

            // Logar a resposta
            file_put_contents($logFile, "Resposta: " . print_r($responseBody, true) . "\n", FILE_APPEND);
        } catch (RequestException $e) {
            // Logar erros
            file_put_contents($logFile, "Erro: " . $e->getMessage() . "\n", FILE_APPEND);
            if ($e->hasResponse()) {
                $errorResponseBody = $e->getResponse()->getBody();
                file_put_contents($logFile, "Resposta de Erro: " . $errorResponseBody . "\n", FILE_APPEND);
                echo "Resposta de Erro: " . $errorResponseBody . "\n";
            }
        }
    }
}
