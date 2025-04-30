<?php
 include_once __DIR__ . '/../Models/TipoPezModel.php';
 class tipoPezService{
    private $TipoPezModel;

    public function __construct($pdo) {
        $this->TipoPezModel = new TipoPezModel($pdo);
    }

    public function listarTipoPez() {
        return $this->TipoPezModel->listarTipoPez();
    }
 }
?>