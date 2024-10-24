<?php

namespace app\models\pagseguro;

class ReqPagSeguroCartaoCredito
{
    public static function createCreditCardOrder($alunopag, $valorpag, $id, $cardDetails)
    {
        $endpoint = 'https://sandbox.api.pagseguro.com/orders';
        $token = '9027BDDEB627409AA2EB73E6E8C891ED';

        $body = [
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
                    "reference_id" => "item_ref_" . $id,
                    "name" => $valorpag->produto,
                    "quantity" => $valorpag->quantidade,
                    "unit_amount" => (int)($valorpag->valor_credito * 100) // Em centavos
                ]
            ],
            "shipping" => [
                "address" => [
                    "street" => $alunopag->endereco->rua,
                    "number" => $alunopag->endereco->numero,
                    "complement" => $alunopag->endereco->complemento,
                    "locality" => $alunopag->endereco->bairro,
                    "city" => $alunopag->endereco->cidade,
                    "region_code" => $alunopag->endereco->estado,
                    "country" => "BRA",
                    "postal_code" => $alunopag->endereco->cep
                ]
            ],
            "charges" => [
                [
                    "reference_id" => "charge_ref_" . $id,
                    "description" => "Pagamento com cartão de crédito",
                    "amount" => [
                        "value" => (int)($valorpag->valor_credito * 100),
                        "currency" => "BRL"
                    ],
                    "payment_method" => [
                        "type" => "CREDIT_CARD",
                        "installments" => 1,  // Ou quantidade de parcelas
                        "capture" => true,
                        "card" => [
                            "brand" => $cardDetails->brand,
                            "first_digits" => substr($cardDetails->number, 0, 6),
                            "last_digits" => substr($cardDetails->number, -4),
                            "exp_month" => $cardDetails->exp_month,
                            "exp_year" => $cardDetails->exp_year,
                            "holder" => [
                                "name" => $cardDetails->holder_name,
                                "tax_id" => $cardDetails->holder_tax_id
                            ],
                            "store" => false
                        ],
                        "soft_descriptor" => "cantinaelite.store"
                    ]
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
