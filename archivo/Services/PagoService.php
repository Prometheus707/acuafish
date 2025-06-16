<?php
include_once __DIR__ . '/../Models/PagoModel.php';
include_once __DIR__. '/../Models/CarritoModel.php';
// Incluye las clases necesarias del SDK de Mercado Pago
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/MercadoPagoConfig.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Client/MercadoPagoClient.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Client/Preference/PreferenceClient.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/MPHttpClient.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/HttpRequest.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/CurlRequest.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/MPDefaultHttpClient.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/MPRequest.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/MPResponse.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/HttpMethod.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Client/Common/RequestOptions.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Net/MPResource.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Serialization/Mapper.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Resources/Preference.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Serialization/Serializer.php';
require_once __DIR__ . '/../Libs/sdk-php-master/src/MercadoPago/Exceptions/MPApiException.php';

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

 class PagoService{
    private $pagoModel;
    private $carritoModel;

    public function __construct($pdo) {
        $this->pagoModel = new PagoModel($pdo);
        $this->carritoModel = new CarritoModel($pdo);
        // Configura tu access token de prueba
        MercadoPagoConfig::setAccessToken("TEST-980683454262230-051514-3f878ad69b6000f88f033583a8a63cc4-508877378");
    }

    public function crearPreferenciaPago($datosPedido) {
        $client = new PreferenceClient();
        // Obtener el monto real del carrito usando el modelo
        $monto = $this->carritoModel->obtenerMontoCarrito($datosPedido['id_carrito']);
        try {
            $preference = $client->create([
                "items" => [
                    [
                        "title" => $datosPedido['titulo'],
                        "quantity" => 1,
                        "unit_price" => (float)$monto // Usar el monto real aquí
                    ]
                ],
                "external_reference" => $datosPedido['id_carrito']
            ]);
            return $preference->init_point;
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            echo "MercadoPago API Error: " . $e->getMessage();
            if (method_exists($e, 'getApiResponse')) {
                echo "\nAPI Response: " . print_r($e->getApiResponse(), true);
            }
            exit;
        }
    }
}
?>