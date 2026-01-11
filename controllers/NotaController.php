<?php
require_once '../models/Nota.php';
class NotaController {
    private $nota;

    public function __construct($db) {
        $this->nota = new Nota($db);
    }

    public function salvarNota($aluno_id, $turma_id, $trimestre, $ano, $pi, $pr, $pf) {
        return $this->nota->salvarNota($aluno_id, $turma_id, $trimestre, $ano, $pi, $pr, $pf);
    }

    public function listarNotas($aluno_id, $turma_id, $trimestre, $ano) {
        return $this->nota->listarNotas($aluno_id, $turma_id, $trimestre, $ano);
    }

    public function listarAlunosComNotas($trimestre = null, $ano = null) {
        return $this->nota->listarAlunosComNotas($trimestre, $ano);
    }
}
