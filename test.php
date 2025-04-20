<?php

$apiKey = 'api_key_anda';

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_FRESH_CONNECT  => true,
  CURLOPT_URL            => 'https://tripay.co.id/api-sandbox/merchant/payment-channel',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HEADER         => false,
  CURLOPT_HTTPHEADER     => ['Authorization: Bearer '.$apiKey],
  CURLOPT_FAILONERROR    => false,
  CURLOPT_IPRESOLVE      => CURL_IPRESOLVE_V4
));

$response = curl_exec($curl);
$error = curl_error($curl);

curl_close($curl);

// show response code
echo curl_getinfo($curl, CURLINFO_RESPONSE_CODE). "\n";

echo empty($error) ? $response : $error;