<?php

namespace app\models\pagseguro;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class ReqPagSeguroPay
{
  public static function simulaPay()
  {
    $curl = curl_init();
    // i($_SESSION['id']);
    $qrCode = 'QRCO_E5411C98-E5F4-4F2D-A51A-8D71E2AB91F3';
    curl_setopt_array($curl, [
      CURLOPT_URL => "https://sandbox.api.pagseguro.com/pix/pay/{$qrCode}",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => true,
      CURLOPT_CAINFO => "C:/xampp/htdocs/cantinaelite/cacert.pem",
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        'content-type: application/json',
        'Authorization: Bearer 9027BDDEB627409AA2EB73E6E8C891ED'  // Coloque o token correto aqui
      ),
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }
  }
}
