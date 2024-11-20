<?php

namespace ComBank\Support\Traits;

use ComBank\Exceptions\FraudulentTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

require 'c:\xampp_daw2\htdocs\DAW2\Backend\PHP\PrácƟca Pr3 – cURL PHP\vendor\autoload.php';

trait APIConnectionsTrait
{
    public function validateEmail(string $email): bool
    {
        $headers = array(
            "Accept" => "aplication/json",
            "x-api-key" => "sk_74f60d4417604652a2bab763abcfa1e8"
        );

        $request_body = array(
            "email" => $email,
        );

        $client = new Client();

        try {
            $response = $client->request("GET", "https://api.manyapis.com/v1-get-email", array(
                "headers" => $headers,
                "query" => $request_body
            ));
        } catch (GuzzleException $e) {
            pl($e->getMessage());
        }

        $content = json_decode($response->getBody()->getContents(), true);

        return !$content["isDisposable"] && $content["validFormat"];
        // return true;
    }

    public function convertBalance(float $balance): float
    {

        // $headers = array(
        //     "Accept" => "aplication/json",
        //     "x-api-key" => "sk_74f60d4417604652a2bab763abcfa1e8"
        // );

        // $request_body = array(
        //     "amount" => $balance,
        //     "from" => "EUR",
        //     "to" => "USD"
        // );

        // $client = new Client();

        // try {
        //     $response = $client->request("GET", "https://api.manyapis.com/v1-convert-currency", array(
        //         "headers" => $headers,
        //         "query" => $request_body
        //     ));
        // } catch (GuzzleException $e) {
        //     pl($e->getMessage());
        // }

        // $content = json_decode($response->getBody()->getContents(), true);

        // return $content["convertedAmount"];
        return 1.1;
    }

    public function detectFraud(BankTransactionInterface $transaction): bool
    {
        $headers = array(
            "Accept" => "aplication/json"
        );

        $client = new Client();

        $response = $client->request("GET", "https://6734fc3a5995834c8a919aa6.mockapi.io/v1-fraud-detection/Movements");

        $content = json_decode($response->getBody()->getContents(), true);

        foreach ($content as $key => $value) {

            if ($transaction->getTransactionInfo() == $value["movement"]) {

                if ($transaction->getAmount() <= $value["amount"])
                    return !$value["action"];
            }
        }
        return true;
    }
}
