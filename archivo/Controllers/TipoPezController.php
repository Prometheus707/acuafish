<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/TipoPezService.php';
class TipoPezController {

    private $TipoPezService;

    public function __construct(TipoPezService $TipoPezService) {
        $this->TipoPezService = $TipoPezService;
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

    private function listarTipoPez ($request) {
        $categorias = $this->TipoPezService->listarTipoPez();
        if ($categorias) {
            ResponseHandler::success($categorias, 'Lista obtenida con exito');
        } else {
            ResponseHandler::error('No se encontraron categorias');
        }
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$TipoPezService = new TipoPezService($pdo);
$controller = new TipoPezController($TipoPezService);
$controller->handleRequest($_POST);