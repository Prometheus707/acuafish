<?php
 require_once __DIR__ . '/../Models/UsuarioModel.php';
 require_once __DIR__ . '/../Libs/PHPMailer-master/src/PHPMailer.php';
 require_once __DIR__ . '/../Libs/PHPMailer-master/src/SMTP.php';
 require_once __DIR__ . '/../Libs/PHPMailer-master/src/Exception.php';
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\Exception;
 
 class UsuarioService {
    private $usuarioModel;

    public function __construct($pdo) {
        $this->usuarioModel = new UsuarioModel($pdo);
    }

    public function cambiarRol($request){
        $usuario = $this->usuarioModel->cambiarRol($request);
    }

    public function listarUsuarios() {
        $usuarios = $this->usuarioModel->listarUsuarios();
        return $usuarios;
    }

    public function buscarUsuarios($request) {
        $usuarios = $this->usuarioModel->buscarUsuarios($request);
        return $usuarios;
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

    public function cerrarSesion() {
        try {
            $sessionStatus = session_status();
            
            // Si las sesiones están deshabilitadas en el servidor
            if ($sessionStatus === PHP_SESSION_DISABLED) {
                throw new Exception('Las sesiones están deshabilitadas en esta configuración');
            }
    
            // Si la sesión no está iniciada, iniciarla
            if ($sessionStatus === PHP_SESSION_NONE) {
                session_start();
            }
    
            // Limpiar datos de sesión
            $_SESSION = [];
    
            // Eliminar cookie de sesión
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(), 
                    '', 
                    time() - 42000,
                    $params["path"], 
                    $params["domain"],
                    $params["secure"], 
                    $params["httponly"]
                );
            }
    
            // Destruir sesión
            if (!session_destroy()) {
                throw new Exception('Falló al destruir la sesión');
            }
    
            return true;
    
        } catch (Exception $e) {
            error_log('Error en cerrarSesion: ' . $e->getMessage());
            return false;
        }
    }

    public function recuperarContrasena($request){
        $this->validarRecuperarContrasena($request);
        $usuario = $this->usuarioModel->recuperarContrasena($request);
        if (!$usuario) {
            throw new Exception("No se encontró un usuario con ese correo");
        }
        $nuevaContrasena = $this->generarContrasenaAleatoria();
        $nuevaContrasenaHash = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
        $this->usuarioModel->actualizarContrasena([
            'password' => $nuevaContrasenaHash,
            'email' => $usuario['email']
        ]);
        $this->enviarCorreoRecuperacion($usuario['email'], $nuevaContrasena);
        return "Se ha enviado una nueva contraseña a tu correo";    
    }

    public function validarRecuperarContrasena($request){
        if (empty($request['email'])) {
            throw new Exception("El campo 'correo' es obligatorio");
        }
        if (!filter_var($request['email'], FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El correo no tiene un formato válido");
        }
    }

    private function generarContrasenaAleatoria(){
        return bin2hex(random_bytes(4)); // 8 caracteres hexadecimales aleatorios
    }

    private function enviarCorreoRecuperacion($email, $nuevaContrasena){
        $mail = new PHPMailer(true);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'alexis.once.rcsj@gmail.com'; // Cambia por tu correo real
            $mail->Password = 'eexa tite xldh nubb'; // Cambia por tu contraseña de aplicación de Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;
    
            // Remitente y destinatario
            $mail->setFrom('TU_CORREO@gmail.com', 'Soporte Peces');
            $mail->addAddress($email);
    
            // Contenido del correo
            $mail->isHTML(true); // Cambiado a HTML
            $mail->Subject = 'Recuperación de contraseña';
            $mail->Body    = '
                <div style="font-family: Arial, sans-serif; background: #f4f4f4; padding: 30px;">
                    <div style="max-width: 500px; margin: auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 30px;">
                        <h2 style="color: #007bff; text-align: center;">Recuperación de contraseña</h2>
                        <p>Hola,</p>
                        <p>Hemos recibido una solicitud para restablecer tu contraseña. Tu nueva contraseña es:</p>
                        <div style="background: #e9ecef; border-radius: 5px; padding: 15px; text-align: center; font-size: 1.3em; letter-spacing: 2px; margin: 20px 0;">
                            <strong>' . htmlspecialchars($nuevaContrasena) . '</strong>
                        </div>
                        <p>Te recomendamos cambiar esta contraseña después de iniciar sesión.</p>
                        <p style="color: #888; font-size: 0.9em;">Si no solicitaste este cambio, puedes ignorar este correo.</p>
                        <hr>
                        <p style="text-align: center; color: #aaa; font-size: 0.9em;">&copy; ' . date('Y') . ' Soporte Peces</p>
                    </div>
                </div>
            ';
    
            $mail->send();
        } catch (Exception $e) {
            throw new Exception('No se pudo enviar el correo. Error: ' . $mail->ErrorInfo);
        }
    }
 }
?>