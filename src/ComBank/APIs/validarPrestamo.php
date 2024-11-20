<?php
header('Content-Type: application/json');

$requestData = json_decode(file_get_contents("php://input"), true);

$balance = $requestData['balance'];
$currency = $requestData['currency'];
$transacciones = $requestData['transacciones'];
$cantidadPrestamo = $requestData['cantidadPrestamo'];

$saldoTransacciones = 0;

foreach ($transacciones as $transaccion) {
    $saldoTransacciones += $transaccion['amount']; 
}


if ($saldoTransacciones >= $cantidadPrestamo && $balance > 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Préstamo aprobado',
        'interestRate' => 5, 
        'monthlyPayment' => calcularPagoMensual($cantidadPrestamo, 5, 12), 
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Préstamo no aprobado. Insuficientes transacciones o saldo negativo.'
    ]);
}

function calcularPagoMensual($cantidad, $interes, $duracionMeses) {
    return ($cantidad * (1 + $interes / 100)) / $duracionMeses;
}
