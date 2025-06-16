<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/PagoService.php';
class PagoController {

    private $pagoService;

    public function __construct(PagoService $PagoService) {
        $this->pagoService = $PagoService;
    }

    public function handleRequest($request) {
        $action = $request['action'] ?? null;
        if (!$action) {
            ResponseHandler::error('Acción no especificada');
            return;
        }
        $method = $action;
        if (method_exists($this, $method)) {
            $this->$method($request);
        } else {
            ResponseHandler::error('Acción no válida');
        }
    }

    public function crearPago($request) {
        $titulo = $request['titulo'] ?? 'Pedido de prueba';
        $id_carrito = $request['id_carrito']?? null;
        if (!$id_carrito) {
            ResponseHandler::error('ID de carrito no especificado');
            return;
        }
        $init_point = $this->pagoService->crearPreferenciaPago([
            'titulo' => $titulo,
            'id_carrito' => $id_carrito
        ]);
        echo json_encode(['init_point' => $init_point]);
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$pagoService = new pagoService($pdo);
$controller = new pagoController($pagoService);
$controller->handleRequest($_POST);