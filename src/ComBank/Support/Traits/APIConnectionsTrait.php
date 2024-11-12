<?php

namespace ComBank\Support\Traits;

use ComBank\Transactions\Contracts\BankTransactionInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

require 'c:\xampp_daw2\htdocs\DAW2\Backend\PHP\PrácƟca Pr3 – cURL PHP\vendor\autoload.php';

trait APIConnectionsTrait
{
    public function validateEmail(string $email): bool
    {
        return false;
    }

    public function convertBalance(float $balance): float
    {

        $headers = array(
            "Accept" => "aplication/json",
            "x-api-key" => "sk_74f60d4417604652a2bab763abcfa1e8"
        );

        $request_body = array(
            "amount" => $balance,
            "from" => "EUR",
            "to" => "USD"
        );

        $client = new Client();

        try {
            $response = $client->request("GET","https://api.manyapis.com/v1-convert-currency",array(
                "headers" => $headers,
                "query" => $request_body
            ));

        } catch (GuzzleException $e) {
            pl($e->getMessage());
        }

        $content = json_decode($response->getBody()->getContents(),true);

        // return $content->getConvertedAmount();
        
        return $content["convertedAmount"];
    }

    public function detectFraud(BankTransactionInterface $transaction): bool
    {
        return false;
    }
}
