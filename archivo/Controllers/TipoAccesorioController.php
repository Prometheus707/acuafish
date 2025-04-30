<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/TipoAccesorioService.php';
class TipoAccesorioController {

    private $TipoAccesorioService;

    public function __construct(TipoAccesorioService $TipoAccesorio) {
        $this->TipoAccesorioService = $TipoAccesorio;
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

    private function listarTipoAccesorio ($request) {
        $tipoAccesorios = $this->TipoAccesorioService->listarTipoAccesorio();
        if ($tipoAccesorios) {
            ResponseHandler::success($tipoAccesorios, 'Lista obtenida con exito');
        } else {
            ResponseHandler::error('No se encontraron categorias');
        }
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$especieService = new TipoAccesorioService($pdo);
$controller = new TipoAccesorioController($especieService);
$controller->handleRequest($_POST);