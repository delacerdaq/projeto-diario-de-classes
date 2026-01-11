<?php
class Nota {
    private $conn;
    private $table_name = "notas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function salvarNota($aluno_id, $turma_id, $trimestre, $ano, $pi, $pr, $pf) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE aluno_id = :aluno_id AND turma_id = :turma_id AND trimestre = :trimestre AND ano = :ano";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':turma_id', $turma_id);
        $stmt->bindParam(':trimestre', $trimestre);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $query = "UPDATE " . $this->table_name . " 
                      SET pi = :pi, pr = :pr, pf = :pf 
                      WHERE aluno_id = :aluno_id AND turma_id = :turma_id AND trimestre = :trimestre AND ano = :ano";
        } else {
            $query = "INSERT INTO " . $this->table_name . " (aluno_id, turma_id, trimestre, ano, pi, pr, pf) 
                      VALUES (:aluno_id, :turma_id, :trimestre, :ano, :pi, :pr, :pf)";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':turma_id', $turma_id);
        $stmt->bindParam(':trimestre', $trimestre);
        $stmt->bindParam(':ano', $ano);
        $stmt->bindParam(':pi', $pi);
        $stmt->bindParam(':pr', $pr);
        $stmt->bindParam(':pf', $pf);

        return $stmt->execute();
    }

    public function listarNotas($aluno_id, $turma_id, $trimestre, $ano) {
        $query = "SELECT * FROM " . $this->table_name . " 
                  WHERE aluno_id = :aluno_id AND turma_id = :turma_id AND trimestre = :trimestre AND ano = :ano";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':aluno_id', $aluno_id);
        $stmt->bindParam(':turma_id', $turma_id);
        $stmt->bindParam(':trimestre', $trimestre);
        $stmt->bindParam(':ano', $ano);
        $stmt->execute();
        return $stmt;
    }

    public function listarAlunosComNotas($trimestre = null, $ano = null) {
        $conditions = [];
        $params = [];

        if (($trimestre !== null && $trimestre !== '') || ($ano !== null && $ano !== '')) {
            $query = "
                SELECT 
                    a.id AS aluno_id,
                    a.nome AS aluno_nome,
                    t.id AS turma_id,
                    t.nome AS turma_nome,
                    n.pi AS PI,
                    n.pr AS PR,
                    n.pf AS PF,
                    n.trimestre,
                    n.ano
                FROM alunos a
                INNER JOIN turmas t ON a.turma_id = t.id
                INNER JOIN " . $this->table_name . " n ON a.id = n.aluno_id AND a.turma_id = n.turma_id
            ";

            if ($trimestre !== null && $trimestre !== '') {
                $conditions[] = "n.trimestre = :trimestre";
                $params[':trimestre'] = $trimestre;
            }

            if ($ano !== null && $ano !== '') {
                $conditions[] = "n.ano = :ano";
                $params[':ano'] = $ano;
            }

            if (count($conditions) > 0) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
        } else {
            $query = "
                SELECT 
                    a.id AS aluno_id,
                    a.nome AS aluno_nome,
                    t.id AS turma_id,
                    t.nome AS turma_nome,
                    n.pi AS PI,
                    n.pr AS PR,
                    n.pf AS PF,
                    n.trimestre,
                    n.ano
                FROM alunos a
                INNER JOIN turmas t ON a.turma_id = t.id
                LEFT JOIN " . $this->table_name . " n ON a.id = n.aluno_id AND a.turma_id = n.turma_id
            ";
        }

        $query .= " ORDER BY t.nome, a.nome";

        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();
        return $stmt;
    }
}
