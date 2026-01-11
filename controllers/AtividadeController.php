<?php
require_once '../models/Atividade.php';
require_once '../models/Turma.php';

class AtividadeController {
    private $atividadeModel;
    private $turmaModel;

    public function __construct($db) {
        $this->atividadeModel = new Atividade($db);
        $this->turmaModel = new Turma($db);
    }

    public function listarAtividades() {
        return $this->atividadeModel->readAll();
    }

    public function listarAtividadesPorTurma($turma_id) {
        return $this->atividadeModel->readByTurma($turma_id);
    }

    public function adicionarAtividade($titulo, $data, $descricao, $turma_id) {
        $this->atividadeModel->titulo = $titulo;
        $this->atividadeModel->data = $data;
        $this->atividadeModel->descricao = $descricao;
        $this->atividadeModel->turma_id = $turma_id;
        return $this->atividadeModel->create();
    }

    public function atualizarAtividade($id, $titulo, $data, $descricao, $turma_id) {
        $this->atividadeModel->id = $id;
        $this->atividadeModel->titulo = $titulo;
        $this->atividadeModel->data = $data;
        $this->atividadeModel->descricao = $descricao;
        $this->atividadeModel->turma_id = $turma_id;
        return $this->atividadeModel->update();
    }

    public function excluirAtividade($id) {
        $this->atividadeModel->id = $id;
        return $this->atividadeModel->delete();
    }

    public function listarTurmas() {
        return $this->turmaModel->readAll();
    }

    public function getAtividadeById($id) {
        $atividade = $this->atividadeModel->readById($id);
        
        if ($atividade) {
            return $atividade;
        } else {
            return false;
        }
    }
    
}
?>
