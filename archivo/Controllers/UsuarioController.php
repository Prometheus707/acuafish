<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/UsuarioService.php';
class UsuarioController {

    private $usuarioService;

    public function __construct(UsuarioService $usuarioService) {
        $this->usuarioService = $usuarioService;
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

    private function registrarUsuario($request) {
        try {
            $response = $this->usuarioService->registrarUsuario($request);
            ResponseHandler::success(null, $response);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function loginUsuario($request) {
        try {
            $response = $this->usuarioService->iniciarSesion($request);
            ResponseHandler::success(['rol' => $response['rol']], $response['message']);
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }
}
$pdo = Database::getInstance()->getConnection();
$usuarioService = new UsuarioService($pdo);
$controller = new UsuarioController($usuarioService);
$controller->handleRequest($_POST);