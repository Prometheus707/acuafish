<?php
 include_once __DIR__ . '/../Models/EspecieModel.php';
 class EspecieService{
    private $EspecieModel;

    public function __construct($pdo) {
        $this->EspecieModel = new EspecieModel($pdo);
    }

    public function listarEspecie() {
        return $this->EspecieModel->listarEspecie();
    }
 }
?>