<?php

namespace app\public;

class ReqPagSeguroWebhook
{

  public static function webhookPix()
  {
    header("access-control-allow-origin: https://pagseguro.uol.com.br");
    // Configura o cabeçalho para permitir requisições CORS do PagSeguro
    if (isset($_POST['notificationCode'], $_POST['notificationType'])) {
      $payload = $_POST;
      $payloadJson = json_encode($_POST);

      $notificationCode = $_POST['notificationCode'];
      $token = '9027BDDEB627409AA2EB73E6E8C891ED';
      $credentials = "?email=contato@pantanaltubos.com&token={$token}";
      // https://alexandrecardoso-pagseguro.ultrahook.com
      $url = "https://sandbox.pagseguro.uol.com.br/v3/transactions/notifications/{$payload['notificationCode']}{$credentials}";

      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, $url);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
      curl_setopt($curl, CURLOPT_CAINFO, "C:/xampp/htdocs/cantinaelite/cacert.pem");
      curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type:application/json',
        'Authorization: Bearer 9027BDDEB627409AA2EB73E6E8C891ED'
      ]);

      $response = curl_exec($curl);
      $error = curl_error($curl);

      curl_close($curl);

      file_put_contents('logTransaction.txt', $response);
      file_put_contents('payload.txt', $payload);
      file_put_contents('url.txt', $url);
      file_put_contents('notification.txt', $payload['notificationCode']);
    } else {
      $payload = @file_get_contents('php://input');
      file_put_contents('C:/xampp/htdocs/cantinaelite/public/logPay.txt', $payload);
    }
  }
}
