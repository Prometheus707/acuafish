<?php
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Helpers/ResponseHandler.php';
require_once __DIR__ . '/../Services/UsuarioService.php';
class UsuarioController {

private $usuarioService;
//inyeccion de dependencias
    public function __construct(UsuarioService $usuarioService) {
        $this->usuarioService = $usuarioService;
    }

    //patron command
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

    private function cerrarSesion($request) {
        try {
            $this->usuarioService->cerrarSesion();
            ResponseHandler::success(null, 'Sesión cerrada con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function listarUsuarios($request) {
        try {
            $usuarios = $this->usuarioService->listarUsuarios();
            ResponseHandler::success($usuarios, 'Usuarios listados con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function buscarUsuarios($request){
        try {
            $usuarios = $this->usuarioService->buscarUsuarios($request);
            ResponseHandler::success($usuarios, 'Usuarios listados con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function cambiarRol($request){
        try {
            $this->usuarioService->cambiarRol($request);
            ResponseHandler::success(null, 'Rol cambiado con éxito');
        } catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }

    private function recuperarContrasena($request){
        try {
            $this->usuarioService->recuperarContrasena($request);
            ResponseHandler::success(null, 'Contraseña recuperada con éxito');            
        }
        catch (Exception $e) {
            ResponseHandler::error($e->getMessage());
            return;
        }
    }
}
$pdo = Database::getInstance()->getConnection();
$usuarioService = new UsuarioService($pdo);
$controller = new UsuarioController($usuarioService);
$controller->handleRequest($_POST);