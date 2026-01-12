<?php
require_once '../models/Aluno.php';
require_once '../models/Turma.php';
require_once '../config/db.php';
class AlunoController {
    private $alunoModel;
    private $turmaModel;

    public function __construct() {
        $db = Database::getConnection();
        $this->alunoModel = new Aluno($db);
        $this->turmaModel = new Turma($db);
    }

    public function listarAlunosPorTurma() {
        return $this->alunoModel->readAllByTurma();
    }

    public function listarAlunosPorTurmaId($turma_id) {
        return $this->alunoModel->readByTurmaId($turma_id);
    }

    public function listarTurmas() {
        return $this->turmaModel->readAll();
    }

    public function atualizarAluno($id, $nome, $turma_id) {
        $this->alunoModel->id = $id;
        $this->alunoModel->nome = $nome;
        $this->alunoModel->turma_id = $turma_id;
        return $this->alunoModel->update();
    }

    public function getAlunoById($id) {
        return $this->alunoModel->readById($id);
    }
}
?>
