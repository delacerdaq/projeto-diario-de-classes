<?php
class Atividade {
    private $conn;
    private $table_name = "atividades";

    public $id;
    public $titulo;
    public $data;
    public $descricao;
    public $turma_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (titulo, data, descricao, turma_id) VALUES (:titulo, :data, :descricao, :turma_id)";
        $stmt = $this->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":turma_id", $this->turma_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readByTurma($turma_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE turma_id = :turma_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":turma_id", $turma_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET titulo = :titulo, data = :data, descricao = :descricao, turma_id = :turma_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
    
        $stmt->bindParam(":titulo", $this->titulo);
        $stmt->bindParam(":data", $this->data);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":turma_id", $this->turma_id);
        $stmt->bindParam(":id", $this->id);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function ReadById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
