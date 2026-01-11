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

        // Inicializa os modelos
        $this->turmaModel = new Turma($db);
        $this->alunoModel = new Aluno($db); // Adicionando o modelo de aluno
    }

    public function listarTurmas() {
        return $this->turmaModel->readAll();
    }

    public function adicionarTurmaComAlunos($nomeTurma, $alunos) {
        // Adicionar a turma
        $this->turmaModel->nome = $nomeTurma;
        if ($this->turmaModel->create()) {
            // Obtém o ID da última turma inserida
            $turma_id = $this->turmaModel->getConnection()->lastInsertId();

            // Adicionar os alunos à turma
            foreach ($alunos as $alunoNome) {
                $this->alunoModel->nome = $alunoNome;
                $this->alunoModel->turma_id = $turma_id;
                if (!$this->alunoModel->create()) {
                    return false; // Caso um aluno não seja inserido, interrompe
                }
            }
            return true;
        }
        return false;
    }

    public function listarAlunosPorTurma() {
        // Aqui você deve ter um método que busca todos os alunos com suas respectivas turmas
        return $this->alunoModel->readAllByTurma(); // Assumindo que você tenha esse método
    }

    public function getTurmaById($id) {
        return $this->turmaModel->readById($id); // Obtenha a turma pelo ID
    }
    
    public function updateTurma($id, $nome) {
        return $this->turmaModel->update($id, $nome); // Atualize a turma no modelo e retorna o resultado
    }    
    
    public function getAlunosByTurmaId($turma_id) {
        return $this->alunoModel->readByTurmaId($turma_id); // Chama o método no modelo
    }

    public function getAllTurmas() {
        return $this->turmaModel->readAll(); // Chama o método readAll() do modelo Turma
    }

    // Em TurmaController.php
    public function excluirTurma($turma_id) {
        return $this->turmaModel->delete($turma_id);
    }

}
?>
