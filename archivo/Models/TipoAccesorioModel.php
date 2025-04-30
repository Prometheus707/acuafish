<?php
    class TipoAccesorioModel{
        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }
        public function listarTipoAccesorio(){
            try{
                $query = $this->pdo->prepare("SELECT id_tipo_accesorio, nombre_tipo_accesorio FROM tipo_accesorios");
                if($query->execute()){
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(PDOException $e){
                return []; 
            }
        }
    }
?>