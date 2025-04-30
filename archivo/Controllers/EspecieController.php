<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/EspecieService.php';
class EspecieController {

    private $especieService;

    public function __construct(EspecieService $especieService) {
        $this->especieService = $especieService;
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

    private function listarEspecie ($request) {
        $categorias = $this->especieService->listarEspecie();
        if ($categorias) {
            ResponseHandler::success($categorias, 'Lista obtenida con exito');
        } else {
            ResponseHandler::error('No se encontraron categorias');
        }
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$especieService = new EspecieService($pdo);
$controller = new EspecieController($especieService);
$controller->handleRequest($_POST);