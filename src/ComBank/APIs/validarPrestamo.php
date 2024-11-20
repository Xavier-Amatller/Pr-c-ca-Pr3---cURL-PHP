<?php
// validarPrestamo.php
header('Content-Type: application/json');

// Obtener los datos enviados
$requestData = json_decode(file_get_contents("php://input"), true);

$balance = $requestData['balance'];
$currency = $requestData['currency'];
$transacciones = $requestData['transacciones'];
$cantidadPrestamo = $requestData['cantidadPrestamo'];

// Validar el préstamo basado en las transacciones y el balance
$saldoTransacciones = 0;

// Sumar todas las cantidades de las transacciones
foreach ($transacciones as $transaccion) {
    $saldoTransacciones += $transaccion['amount']; // Usamos el campo 'amount'
}

// Regla para aprobar el préstamo: 
// 1. Las transacciones deben superar el monto solicitado.
// 2. El balance actual debe ser mayor que 0.
if ($saldoTransacciones >= $cantidadPrestamo && $balance > 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Préstamo aprobado',
        'interestRate' => 5, // Por ejemplo, un interés del 5%
        'monthlyPayment' => calcularPagoMensual($cantidadPrestamo, 5, 12), // Pago mensual en 12 meses
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Préstamo no aprobado. Insuficientes transacciones o saldo negativo.'
    ]);
}

// Función para calcular el pago mensual
function calcularPagoMensual($cantidad, $interes, $duracionMeses) {
    return ($cantidad * (1 + $interes / 100)) / $duracionMeses;
}
