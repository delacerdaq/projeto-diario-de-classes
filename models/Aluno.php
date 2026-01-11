<?php
class Aluno {
    private $conn;
    private $table_name = "alunos";

    public $id;
    public $nome;
    public $turma_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nome, turma_id) VALUES (:nome, :turma_id)";
        
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->turma_id = htmlspecialchars(strip_tags($this->turma_id));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":turma_id", $this->turma_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAllByTurma() {
        $query = "
            SELECT a.nome AS aluno_nome, t.nome AS turma_nome
            FROM " . $this->table_name . " a
            JOIN turmas t ON a.turma_id = t.id
            ORDER BY t.nome, a.nome;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByTurmaId($turma_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE turma_id = :turma_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turma_id', $turma_id);
        $stmt->execute();
        
        return $stmt;
    }

    public function ListingReadByTurmaId($turma_id) {
        $query = "SELECT id, nome FROM " . $this->table_name . " WHERE turma_id = :turma_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
    
        try {
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao listar alunos por turma: " . $e->getMessage());
            return [];
        }
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nome = :nome, turma_id = :turma_id WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);

        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->turma_id = htmlspecialchars(strip_tags($this->turma_id));

        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":turma_id", $this->turma_id);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt;
    }
}
?>
