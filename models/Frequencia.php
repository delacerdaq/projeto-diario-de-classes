<?php

class Frequencia {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function saveFrequencia($alunoId, $turmaId, $dataChamada, $presenca) {
        $query = "INSERT INTO frequencias (aluno_id, turma_id, data_chamada, presenca) VALUES (:aluno_id, :turma_id, :data_chamada, :presenca)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $alunoId);
        $stmt->bindParam(':turma_id', $turmaId);
        $stmt->bindParam(':data_chamada', $dataChamada);
        $stmt->bindParam(':presenca', $presenca);
        return $stmt->execute();
    }

    public function getFrequenciasByTurmaAndData($turmaId, $dataChamada)
{
    $sql = "SELECT DISTINCT a.id, a.nome AS aluno_nome, f.presenca 
            FROM alunos a 
            LEFT JOIN frequencias f ON a.id = f.aluno_id 
            WHERE a.turma_id = :turma_id AND f.data_chamada = :data_chamada";
    
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
    $stmt->bindParam(':data_chamada', $dataChamada, PDO::PARAM_STR);
    $stmt->execute();

    return $stmt;
}
}
?>
