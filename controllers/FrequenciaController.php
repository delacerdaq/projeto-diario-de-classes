<?php
require_once '../models/Frequencia.php';
require_once '../config/db.php';
class FrequenciaController {
    private $frequenciaModel;

    public function __construct() {
        $db = Database::getConnection();
        $this->frequenciaModel = new Frequencia($db);
    }

    public function saveFrequencia($alunoId, $turmaId, $dataChamada, $presenca) {
        return $this->frequenciaModel->saveFrequencia($alunoId, $turmaId, $dataChamada, $presenca);
    }
    public function getFrequencias($turmaId, $dataChamada) {
        return $this->frequenciaModel->getFrequenciasByTurmaAndData($turmaId, $dataChamada);
    }
}
?>
