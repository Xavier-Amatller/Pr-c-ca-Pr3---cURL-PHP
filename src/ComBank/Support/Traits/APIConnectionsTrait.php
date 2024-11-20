<?php

namespace ComBank\Support\Traits;

use ComBank\Exceptions\FraudulentTransactionException;
use ComBank\Transactions\Contracts\BankTransactionInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use ComBank\Bank\BankAccount;

require 'c:\xampp_daw2\htdocs\DAW2\Backend\PHP\PrácƟca Pr3 – cURL PHP\vendor\autoload.php';

trait APIConnectionsTrait
{
    public function validateEmail(string $email): bool
    {
        // $headers = array(
        //     "Accept" => "aplication/json",
        //     "x-api-key" => "sk_74f60d4417604652a2bab763abcfa1e8"
        // );

        // $request_body = array(
        //     "email" => $email,
        // );

        // $client = new Client();

        // try {
        //     $response = $client->request("GET", "https://api.manyapis.com/v1-get-email", array(
        //         "headers" => $headers,
        //         "query" => $request_body
        //     ));
        // } catch (GuzzleException $e) {
        //     pl($e->getMessage());
        // }

        // $content = json_decode($response->getBody()->getContents(), true);

        // return !$content["isDisposable"] && $content["validFormat"];
        return true;
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

    // ApiRequestTrait.php
    public function validarPrestamo(BankAccount $cuenta, float $cantidad): array {
        $url = 'http://localhost/DAW2/Backend/PHP/Pr%c3%a1c%c6%9fca%20Pr3%20%e2%80%93%20cURL%20PHP/src/ComBank/APIs/validarPrestamo.php';

        // Extraer la información necesaria de la cuenta
        $data = [
            'balance' => $cuenta->getBalance(),
            'currency' => $cuenta->getCURRENCY(),
            'transacciones' => $cuenta->getTransactionHistory()->getTransactions(), // Usamos getTransactions
            'cantidadPrestamo' => $cantidad,
        ];

        // Convertir los datos a JSON
        $jsonData = json_encode($data);

        // Configurar cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        // Ejecutar la solicitud y obtener la respuesta
        $response = curl_exec($ch);
        curl_close($ch);

        // Decodificar la respuesta JSON
        return json_decode($response, true);
    }
}
