<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/ProductoService.php';
class ProductoController {

    private $ProductoService;

    public function __construct(ProductoService $ProductoService) {
        $this->ProductoService = $ProductoService;
    }

    public function handleRequest($request) {
        $action = $request['action'] ?? null;
        if (!$action) {
            ResponseHandler::error('Acción no especificada');
            return;
        }
        if (method_exists($this, $action)) {
            $this->$action($request);
        } else {
            ResponseHandler::error('Acción no válida');
        }
    }

    private function RegistrarProducto($request) {
        try {
            $response = $this->ProductoService->registrarProducto($request);
            ResponseHandler::success($response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function listarProductos($request){
        try {
            $response = $this->ProductoService->listarProductos($request);
            ResponseHandler::success($response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function obtenerProducto($request){
        try {
            $response = $this->ProductoService->obtenerProducto($request);
            ResponseHandler::success($response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function actualizarProducto($request){
        try {
            $response = $this->ProductoService->actualizarProducto($request);
            ResponseHandler::success($response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function eliminarProducto($request){
        try {
            $response = $this->ProductoService->eliminarProducto($request);
            ResponseHandler::success("producto eliminado con exito", $response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }
}
$pdo = Database::getInstance()->getConnection();
$productoService = new ProductoService($pdo);
$controller = new ProductoController($productoService);
$controller->handleRequest($_POST);