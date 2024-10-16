<?php

namespace app\models\pagseguro;

class ReqPagSeguroPix
{
    public static function createOrder($alunopag, $valorpag, $id)
    {
        $endpoint = 'https://sandbox.api.pagseguro.com/orders';
        $token = '9027BDDEB627409AA2EB73E6E8C891ED';

        $body =
            [
                "reference_id" => $id,
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
                "items" => [
                    [
                        "name" => $valorpag->produto,
                        "quantity" => $valorpag->quantidade,
                        "unit_amount" => (int)($valorpag->valor_credito * 100) // Multiplicar por 100 para centavos
                    ]
                ],
                "qr_codes" => [
                    [
                        "amount" => [
                            "value" => (int)($valorpag->valor_credito * 100) // O mesmo valor para o QR code
                        ],
                        "expiration_date" => date('Y-m-d\TH:i:sP', strtotime('+2 days')) // Exemplo de data de expiração
                    ]
                ],
                "notification_urls" => [
                    "https://tutcar-pagseguro.ultrahook.com"
                ]
            ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $endpoint);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_CAINFO, "C:/xampp/htdocs/cantinaelite/cacert.pem");
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization: Bearer ' . $token
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if ($error) {
            var_dump($error);
            die();
        }

        $data = json_decode($response, true);
        return $data;
    }
}
