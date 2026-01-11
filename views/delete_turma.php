<?php
require_once '../controllers/TurmaController.php';
require_once 'includes/auth_check.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: turmas.php");
    exit;
}

$turmaId = intval($_GET['id']);

$turmaController = new TurmaController();
$turma = $turmaController->getTurmaById($turmaId);

if (!$turma) {
    header("Location: turmas.php");
    exit;
}

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $turmaId = intval($_POST['id']);
        if ($turmaController->excluirTurma($turmaId)) {
            header("Location: turmas.php?success=" . urlencode("Turma excluída com sucesso!"));
            exit;
        } else {
            $mensagem = "Erro ao excluir a turma.";
            $tipoMensagem = "error";
        }
    } else {
        $mensagem = "ID da turma não encontrado.";
        $tipoMensagem = "error";
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Excluir Turma';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto px-4 py-8 max-w-md">
    <form id="delete-form" method="post" action="" class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Excluir Turma</h1>
        
        <input type="hidden" name="id" value="<?php echo $turmaId; ?>">
        
        <p class="mb-4 text-gray-700">
            Você tem certeza de que deseja excluir a turma 
            "<strong class="text-blue-500"><?php echo htmlspecialchars($turma['nome']); ?></strong>"?
        </p>
        
        <?php include 'includes/messages.php'; ?>
        
        <div class="flex justify-center space-x-4 mt-6">
            <button 
                type="submit" 
                class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded transition"
            >
                Excluir
            </button>
            <a 
                href="turmas.php" 
                class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded transition"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
