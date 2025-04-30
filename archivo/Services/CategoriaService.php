<?php
 include_once __DIR__ . '/../Models/CategoriaModel.php';
 class CategoriaService{
    private $CategoriaModel;

    public function __construct($pdo) {
        $this->CategoriaModel = new CategoriaModel($pdo);
    }

    public function listarCategorias() {
        return $this->CategoriaModel->listarCategoria();
    }
 }
?>