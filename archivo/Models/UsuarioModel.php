<?php
    class UsuarioModel{

        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }
        //DAO(Data Access Object)
        //themplate method
        public function cambiarRol($request){
            try {
                $this->pdo->beginTransaction();
                $query = $this->pdo->prepare("UPDATE usuarios SET rol_usuario = :rol WHERE id_usuario = :id");
                $query->bindParam(':rol', $request['rol_nuevo'], PDO::PARAM_INT);
                $query->bindParam(':id', $request['id_usuario'] , PDO::PARAM_INT);
                $query->execute();
                $this->pdo->commit();
                return True;
            }  
            catch (PDOException $e) {
                $this->pdo->rollBack();
                throw new Exception("error al cambiar del rol"); 
                throw $e;   
            }
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
                throw new Exception("Error al verificar registrar usuario"); 
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

        public function listarUsuarios(){
            try{
                $query = $this->pdo->prepare("SELECT * FROM usuarios");
                $query->execute();
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }catch(PDOException $e){
                throw new Exception("Error al listar usuarios");
            }
        }

        public function buscarUsuarios($request){
            try{
                $query = $this->pdo->prepare("SELECT * FROM usuarios WHERE nombre LIKE :letras OR email LIKE :letras");
                $query->bindValue(':letras', '%'.$request['filtro'].'%', PDO::PARAM_STR);
                $query->execute();
                return $query->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e){
                throw new Exception("Error al buscar usuarios");
            }
        }

        public function recuperarContrasena($request){
            try{
                $query = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :correo LIMIT 1");
                $query->bindParam(':correo', $request['email'], PDO::PARAM_STR);
                $query->execute();
                return $query->fetch(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e){
                throw new Exception("Error al recuperar contraseña");
            }
        }

        public function actualizarContrasena($request){
            try{
                $query = $this->pdo->prepare("UPDATE usuarios SET password = :password WHERE email = :email");
                $query->bindParam(':password', $request['password'], PDO::PARAM_STR);
                $query->bindParam(':email', $request['email'], PDO::PARAM_STR);
                $query->execute();
                return True;
            }
            catch(PDOException $e){
                throw new Exception("Error al actualizar contraseña");
            }
        }
    }
?>