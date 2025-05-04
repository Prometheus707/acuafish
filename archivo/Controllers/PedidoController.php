<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/PedidoService.php';
class PedidoController {

    private $pedidoService;

    public function __construct(PedidoService $pedidoService) {
        $this->pedidoService = $pedidoService;
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

    private function realizarPedido ($request) {
        try{
            $pedido = $this->pedidoService->realizarPedido($request);
            ResponseHandler::success($pedido, 'Pedido realizado con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function listarPedidos () {
        try{
            $pedidos = $this->pedidoService->listarPedidos();
            ResponseHandler::success($pedidos, 'Pedidos listados con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$pedidoService = new PedidoService($pdo);
$controller = new PedidoController($pedidoService);
$controller->handleRequest($_POST);