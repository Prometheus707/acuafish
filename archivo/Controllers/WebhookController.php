<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Services/PedidoService.php';

// Registrar la notificación para debug
$input = file_get_contents('php://input');
file_put_contents('webhook_log.txt', $input . PHP_EOL, FILE_APPEND);

$data = json_decode($input, true);

if (isset($data['type']) && $data['type'] === 'payment') {
    $payment_id = $data['data']['id'];

    // Consultar el estado real del pago usando la API de Mercado Pago
    $access_token = 'TEST-980683454262230-051514-3f878ad69b6000f88f033583a8a63cc4-508877378'; // Reemplaza esto por tu access token de pruebas de Mercado Pago
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.mercadopago.com/v1/payments/$payment_id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer $access_token"
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    // Registrar la respuesta de la API de Mercado Pago para depuración
    file_put_contents('webhook_log.txt', "Respuesta de la API: $response\n", FILE_APPEND);

    $payment = json_decode($response);

    // Registrar el objeto $payment para depuración
    file_put_contents('webhook_log.txt', "Objeto payment: " . print_r($payment, true) . "\n", FILE_APPEND);

    if ($payment && isset($payment->status) && $payment->status === 'approved') {
        file_put_contents('webhook_log.txt', "Entró a pago aprobado\n", FILE_APPEND);
        $id_carrito = $payment->external_reference ?? 'sin referencia';
        file_put_contents('webhook_log.txt', "external_reference: $id_carrito\n", FILE_APPEND);
        $pdo = Database::getInstance()->getConnection();
        $pedidoService = new PedidoService($pdo);
        $pedidoService->realizarPedido(['id_carrito' => $id_carrito]);
        file_put_contents('webhook_log.txt', "Pago aprobado para carrito: $id_carrito\n", FILE_APPEND);
    } else {
        file_put_contents('webhook_log.txt', "Pago recibido pero no aprobado. Estado: " . (isset($payment->status) ? $payment->status : 'desconocido') . "\n", FILE_APPEND);
    }
}