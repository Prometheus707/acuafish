<?php
 require_once __DIR__ . '/../Models/UsuarioModel.php';
 class UsuarioService {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function registrarUsuario($request) {
        $this->validarRegistroUsuario($request);
        $request['password'] = password_hash($request['password'], PASSWORD_BCRYPT); 
        $resultado = $this->usuarioModel->registrarUsuario($request);
        if ($resultado) {return "Usuario registrado con éxito";
        } else {
            throw new Exception("Error al registrar usuario");
        }
    }

    private function validarRegistroUsuario($request) {
        if (empty($request['nombre'])) {
            throw new Exception("El campo 'nombre' es obligatorio");
        }
        if (strlen($request['nombre']) > 50) {
             throw new Exception("El nombre no puede superar 50 caracteres");
        }
        if (empty($request['email'])) {
            throw new Exception("El campo 'correo' es obligatorio");
        }
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no tiene un formato válido");
        }
        if($this->usuarioModel->verificacionCorreo($request['email'])){
            throw new Exception("El correo ya está registrado");
        }
        if (empty($request['telefono'])) {
            throw new Exception("El campo 'telefono' es obligatorio");
        }
        if (strlen($request['telefono']) > 10 || strlen($request['telefono']) < 10) {
            throw new Exception("El número de teléfono debe tener 10 dígitos");
        }
        if (empty($request['password'])) {
            throw new Exception("El campo 'contrasena' es obligatorio");
        }
        if (strlen($request['password']) < 8) {
            throw new Exception("La contraseña debe tener al menos 8 caracteres");
        }
    }

    public function iniciarSesion($request){
        $this->validarDatosAtenticacion($request);
        $usuario = $this->usuarioModel->autenticarUsuario($request);
        if (!$usuario || !password_verify($request['password'], $usuario['password'])) {
            throw new Exception("Credenciales incorrectas");
        }
        if (session_status() === PHP_SESSION_NONE){session_start();} 
        session_regenerate_id(true);//Regenera id de sesion     
        $_SESSION['id'] = $usuario['id_usuario']; 
        $_SESSION['nombre'] = $usuario['nombre'];
        $_SESSION['email'] = $usuario['email']; 
        $_SESSION['rol'] = $usuario['rol_usuario'];
        return [
            'message' => 'Inicio de sesión exitoso',
            'rol' => $usuario['rol_usuario']
        ];
    }

    public function validarDatosAtenticacion($request){
        if (empty($request['email'])) {
            throw new Exception("El campo 'correo' es obligatorio");
        }
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no tiene un formato válido");
        }
        if (empty($request['password'])) {
            throw new Exception("El campo 'contraseña' es obligatorio");
        }
    }
 }
?> 