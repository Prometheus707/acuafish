<?php
    class UsuarioModel{

        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }

        public function registrarUsuario($request){
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare("
                INSERT INTO usuarios(nombre, email, password, telefono, fecha_creacion) 
                VALUES (:nombre, :email, :password, :telefono, NOW())");
                $query->bindParam(':nombre', $request['nombre'], PDO::PARAM_STR);
                $query->bindParam(':email', $request['email'], PDO::PARAM_STR);
                $query->bindParam(':password', $request['password'], PDO::PARAM_STR);
                $query->bindParam(':telefono', $request['telefono'], PDO::PARAM_STR);
                $query->execute();
                $this->pdo->commit();
                return True;
            } catch (PDOException $e) {
                $this->pdo->rollBack();
                error_log("Registro fallido: " . $e->getMessage());
                throw $e; 
            }
        }

        public function verificacionCorreo($email){
            try{
                $query = $this->pdo->prepare("SELECT 1 FROM usuarios WHERE email = :correo LIMIT 1");
                $query->bindParam(':correo', $email, PDO::PARAM_STR);
                $query->execute();
                $filas = $query->fetchColumn();
                return (bool) $filas;
            }catch(PDOException $e){
                throw new Exception("Error al verificar disponibilidad del correo"); 
            }
        }

        public function autenticarUsuario($request){
            try{
                $query = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :correo LIMIT 1");
                $query->bindParam(':correo', $request['email'], PDO::PARAM_STR);
                $query->execute();
                return $query->fetch(PDO::FETCH_ASSOC); 
            }catch(PDOException $e){
                throw new Exception("Error al autenticar usuario"); 
            }
        }
    }
?>