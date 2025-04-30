<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/CategoriaService.php';
class CategoriaController {

    private $CategoriaService;

    public function __construct(CategoriaService $CategoriaService) {
        $this->CategoriaService = $CategoriaService;
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

    private function listarCategorias ($request) {
        $categorias = $this->CategoriaService->listarCategorias();
        if ($categorias) {
            ResponseHandler::success($categorias, 'Lista obtenida con exito');
        } else {
            ResponseHandler::error('No se encontraron categorias');
        }
    }
}
// Inicialización del controlador
$pdo = Database::getInstance()->getConnection();
$categoriaService = new CategoriaService($pdo);
$controller = new CategoriaController($categoriaService);
$controller->handleRequest($_POST);