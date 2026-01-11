<?php
/**
 * Arquivo de verificação de autenticação
 * Use este arquivo no início de todas as páginas que requerem autenticação
 */
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
