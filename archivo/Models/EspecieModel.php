<?php
    class EspecieModel{
        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }
        public function listarEspecie(){
            try{
                $query = $this->pdo->prepare("SELECT id_especie, nombre_especie FROM especies");
                if($query->execute()){
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(PDOException $e){
                return []; 
            }
        }
    }
?>