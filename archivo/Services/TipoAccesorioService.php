<?php
    include_once __DIR__ . '/../Models/tipoAccesorioModel.php';
    class TipoAccesorioService{
        private $tipoAccesorioModel;

        public function __construct($pdo) {
            $this->tipoAccesorioModel = new TipoAccesorioModel($pdo);
        }

        public function listarTipoAccesorio() {
            return $this->tipoAccesorioModel->listarTipoAccesorio();  
        }
    }
?>