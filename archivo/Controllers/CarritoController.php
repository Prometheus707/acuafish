<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/CarritoService.php';
class CarritoController {

    private $carritoService;

    public function __construct(CarritoService $carritoService) {
        $this->carritoService = $carritoService;
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

    private function listarCarrito($request) {
        try {
            $response = $this->carritoService->listarCarrito($request);
            ResponseHandler::success($response, 'Carrito listado con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function disminuirCarrito($request) {
        try {
            $response = $this->carritoService->disminuirCarrito($request);
            ResponseHandler::success($response, 'Producto disminuido del carrito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function agregarCarrito($request) {
        try {
            $response = $this->carritoService->agregarCarrito($request);
            ResponseHandler::success($response, 'Producto agregado al carrito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$carritoService = new CarritoService($pdo);
$controller = new CarritoController($carritoService);
$controller->handleRequest($_POST);