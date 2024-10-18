<?php

namespace app\controllers;

use PDO;
use PDOException;


if (isset($_POST['notificationCode'], $_POST['notificationType'])) {
    // $payload = $_POST;
    // $payloadJson = json_encode($_POST);

    // $notificationCode = $_POST['notificationCode'];
    // $token = '9027BDDEB627409AA2EB73E6E8C891ED';
    // $credentials = "?email=contato@pantanaltubos.com&token={$token}";
    // $url = "https://sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$payload['notificationCode']}{$credentials}";

    // $curl = curl_init();
    // curl_setopt($curl, CURLOPT_URL, $url);
    // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
    // curl_setopt($curl, CURLOPT_CAINFO, "C:/xampp/htdocs/cantinaelite/cacert.pem");
    // curl_setopt($curl, CURLOPT_HTTPHEADER, [
    //     'Content-Type:application/json',
    //     'Authorization: Bearer ' . $token
    // ]);

    // $response = curl_exec($curl);
    // $error = curl_error($curl);

    // curl_close($curl);

    // file_put_contents('logTransaction.txt', $response);
    // file_put_contents('payload.txt', $payload);
    // file_put_contents('url.txt', $url);
    // file_put_contents('notification.txt', $payload['notificationCode']);
} else {
    $payload = @file_get_contents('php://input'); // Captura o payload bruto
    file_put_contents('logPay.txt', $payload); // Loga o payload para referência

    // Converte o JSON para um array associativo
    $payloadData = json_decode($payload, true);

    // Verifica se o campo 'reference_id' existe no array
    if (isset($payloadData['reference_id'])) {
        $referenceId = $payloadData['reference_id'];
        echo "Reference ID: " . $referenceId; // Exibe o valor de reference_id
    } else {
        echo "Reference ID não encontrado no payload.";
    }
    try {
        $crdPed = "";
        // Conexão com o banco de dados
        $pdo = new PDO('mysql:host=localhost;dbname=cantinamace', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // Prepara o SQL para inserir o payload no banco de dados
        $sql = "INSERT INTO log_pay (logPay) VALUES (:logPay)";

        // Prepara a consulta
        $stmt = $pdo->prepare($sql);

        // Executa a consulta passando o valor do payload
        $stmt->execute([':logPay' => $payload]);
        $string = $referenceId;
        $ultimos_tres_digitos = substr($string, -3);
        $crdPed = $ultimos_tres_digitos; // Saída: CRD
        // Definir os valores a serem usados
        if ($crdPed == "CRD") {

            $confirma = "S";
            $nr_doc_pg = $referenceId; // Valor com letras e números, pois é VARCHAR

            // Verificar se o registro existe antes de atualizar
            $stmt = $pdo->prepare("SELECT * FROM corrente WHERE nr_doc_pg = :nr_doc_pg");
            $stmt->bindParam(':nr_doc_pg', $nr_doc_pg, PDO::PARAM_STR); // PDO::PARAM_STR garante que seja tratado como string
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // O registro existe, então faz o UPDATE
                $stmt = $pdo->prepare("UPDATE corrente SET confirma = :confirma WHERE nr_doc_pg = :nr_doc_pg");
                $stmt->bindParam(':confirma', $confirma);
                $stmt->bindParam(':nr_doc_pg', $nr_doc_pg, PDO::PARAM_STR); // PDO::PARAM_STR novamente
                $stmt->execute();

                // Mensagem de sucesso
                echo "Dados atualizados com sucesso!";
                error_log("Dados atualizados com sucesso!"); // Exibe no console
            } else {
                // Registro não encontrado
                echo "Nenhum registro encontrado com nr_doc_pg = " . $nr_doc_pg;
                error_log("Nenhum registro encontrado com nr_doc_pg = " . $nr_doc_pg); // Exibe no console
            }
        } else {
            $confirma = "S";
            $nr_doc_pg = $referenceId; // Valor com letras e números, pois é VARCHAR

            // Verificar se o registro existe antes de atualizar
            $stmt = $pdo->prepare("SELECT * FROM corrente WHERE nr_doc_pg = :nr_doc_pg");
            $stmt->bindParam(':nr_doc_pg', $nr_doc_pg, PDO::PARAM_STR); // PDO::PARAM_STR garante que seja tratado como string
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // O registro existe, então faz o UPDATE
                $stmt = $pdo->prepare("UPDATE corrente SET confirma = :confirma WHERE nr_doc_pg = :nr_doc_pg");
                $stmt->bindParam(':confirma', $confirma);
                $stmt->bindParam(':nr_doc_pg', $nr_doc_pg, PDO::PARAM_STR); // PDO::PARAM_STR novamente
                $stmt->execute();

                //quita pedido
                $stmt = $pdo->prepare("UPDATE pedido SET pago = :pago WHERE nr_pedido = :nr_pedido");
                $stmt->bindParam(':pago', $confirma);
                $stmt->bindParam(':nr_pedido', $nr_doc_pg, PDO::PARAM_STR); // PDO::PARAM_STR novamente
                $stmt->execute();

                // Mensagem de sucesso
                echo "Dados atualizados com sucesso!";
                error_log("Dados atualizados com sucesso!"); // Exibe no console
            } else {
                // Registro não encontrado
                echo "Nenhum registro encontrado com nr_doc_pg = " . $nr_doc_pg;
                error_log("Nenhum registro encontrado com nr_doc_pg = " . $nr_doc_pg); // Exibe no console
            }
        }
    } catch (PDOException $e) {
        // Exibe erros no console e na tela
        error_log("Erro ao atualizar: " . $e->getMessage());
        echo "Erro ao atualizar: " . $e->getMessage();
    }
}
