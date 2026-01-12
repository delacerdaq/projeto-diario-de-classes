<?php
require_once '../config/db.php';
require_once '../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $this->db = Database::getConnection();
        $this->user = new User($this->db);
    }

    public function register($username, $email, $password) {
        $this->user->username = $username;
        $this->user->email = $email;
        $this->user->password = $password;

        if ($this->user->register()) {
            return "Cadastro realizado com sucesso!";
        } else {
            return "Erro ao cadastrar o usuário.";
        }
    }

    public function login($email, $password) {
        $this->user->email = $email;
        $this->user->password = $password;

        if ($this->user->login()) {
            session_start();
            $_SESSION['user_id'] = $this->user->id;
            header("Location: ../views/dashboard.php");
        } else {
            return "Credenciais incorretas.";
        }
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        if (session_status() == PHP_SESSION_NONE) {
            header("Location: ../views/login.php");
            exit;
        } else {
            echo "Erro ao destruir a sessão.";
        }
    }
}
?>
