<?php
    class CategoriaModel{
        private $pdo ;

        public function __construct($pdo)
        {
            $this->pdo= $pdo;
        }
        public function listarCategoria(){
            try{
                $query = $this->pdo->prepare("SELECT id_categoria, nombre FROM categorias");
                if($query->execute()){
                    return $query->fetchAll(PDO::FETCH_ASSOC);
                }
            }catch(PDOException $e){
                return []; 
            }
        }
    }
?>