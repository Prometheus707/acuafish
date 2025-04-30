<?php
    class TipoPezModel{
        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }

        public function listarTipoPez(){
            try{
                $query = $this->pdo->prepare("SELECT id_tipo_pez, nombre_tipo_pez FROM tipo_pez");
                if($query->execute()){
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(PDOException $e){
                return []; 
            }
        }
    }
?>