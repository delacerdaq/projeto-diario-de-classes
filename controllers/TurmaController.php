<?php
require_once '../models/Turma.php';
require_once '../models/Aluno.php'; // Adicionando o modelo de Aluno
require_once '../config/db.php';

class TurmaController {
    private $turmaModel;
    private $alunoModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();

        $this->turmaModel = new Turma($db);
        $this->alunoModel = new Aluno($db);
    }

    public function listarTurmas() {
        return $this->turmaModel->readAll();
    }

    public function adicionarTurmaComAlunos($nomeTurma, $alunos) {
        $this->turmaModel->nome = $nomeTurma;
        if ($this->turmaModel->create()) {
            $turma_id = $this->turmaModel->getConnection()->lastInsertId();

            foreach ($alunos as $alunoNome) {
                $this->alunoModel->nome = $alunoNome;
                $this->alunoModel->turma_id = $turma_id;
                if (!$this->alunoModel->create()) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function listarAlunosPorTurma() {
        return $this->alunoModel->readAllByTurma();
    }

    public function getTurmaById($id) {
        return $this->turmaModel->readById($id);
    }
    
    public function updateTurma($id, $nome) {
        return $this->turmaModel->update($id, $nome);
    }    
    
    public function getAlunosByTurmaId($turma_id) {
        return $this->alunoModel->readByTurmaId($turma_id);
    }

    public function getAllTurmas() {
        return $this->turmaModel->readAll();
    }

    public function excluirTurma($turma_id) {
        return $this->turmaModel->delete($turma_id);
    }

}
?>
