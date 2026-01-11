CREATE DATABASE sistema_diario;

USE sistema_diario;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    turma_id INT,
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);

-- Tabela de Atividades
CREATE TABLE atividades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    data DATE NOT NULL,
    descricao TEXT NOT NULL,
    turma_id INT NOT NULL,
    FOREIGN KEY (turma_id) REFERENCES turmas(id) ON DELETE CASCADE
);

CREATE TABLE frequencias (
    aluno_id INT,
    turma_id INT,
    data_chamada DATE,
    presenca ENUM('F', 'P'),
    PRIMARY KEY (aluno_id, turma_id, data_chamada),
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);

CREATE TABLE notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    turma_id INT NOT NULL,
    trimestre INT NOT NULL CHECK (trimestre BETWEEN 1 AND 3),
    ano INT NOT NULL,
    pi DECIMAL(5,2), -- 1º Trimestre: máx 6 pontos | 2º e 3º Trimestres: máx 7 pontos
    pr DECIMAL(5,2), -- 1º Trimestre: máx 12 pontos | 2º e 3º Trimestres: máx 14 pontos
    pf DECIMAL(5,2), -- 1º Trimestre: máx 12 pontos | 2º e 3º Trimestres: máx 14 pontos
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (turma_id) REFERENCES turmas(id)
);


