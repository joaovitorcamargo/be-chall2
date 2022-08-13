<?php

namespace App\Helpers;
use GuzzleHttp\Client;

class OriginCurrencyMoney extends Client{
  public function convertMoney(string $from = 'USD', string $to = 'BRL', string $uri = '')
  {
    $moneyConversor = $this->request('GET', $uri, ['query' => [
      'api_key' => env('FAST_FOREX_KEY', ''),
      'from' => $from,
      'to' => $to]]);

    $response = json_decode($moneyConversor->getBody()->getContents(), true);

    return $response['result'][$to];
  }
}