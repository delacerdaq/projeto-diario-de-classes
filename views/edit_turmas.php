<?php
require_once '../controllers/TurmaController.php';
require_once 'includes/auth_check.php';

$turmaController = new TurmaController();

$turma = null;
$turma_id = isset($_GET['turma_id']) ? intval($_GET['turma_id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $turma_id = isset($_POST['turma_id']) ? intval($_POST['turma_id']) : $turma_id;
}

if ($turma_id > 0) {
    $turma = $turmaController->getTurmaById($turma_id);
}

if (!$turma || !is_array($turma)) {
    header("Location: turmas.php");
    exit;
}

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $turma_id = isset($_POST['turma_id']) ? intval($_POST['turma_id']) : 0;
    
    if (empty($nome)) {
        $mensagem = "Erro: O nome da turma é obrigatório.";
        $tipoMensagem = "error";
    } elseif ($turma_id <= 0) {
        $mensagem = "Erro: ID da turma inválido.";
        $tipoMensagem = "error";
    } else {
        $nomeAntigo = isset($turma['nome']) ? $turma['nome'] : '';
        if ($nome !== $nomeAntigo) {
            if ($turmaController->updateTurma($turma_id, $nome)) {
                header("Location: turmas.php?turma_id=" . $turma_id . "&success=" . urlencode("Turma atualizada com sucesso!"));
                exit;
            } else {
                $mensagem = "Erro ao atualizar a turma. Tente novamente.";
                $tipoMensagem = "error";
            }
        } else {
            $mensagem = "Nenhuma alteração foi feita.";
            $tipoMensagem = "success";
        }
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Adicionar Turma' => 'add_turmas.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Editar Turma';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto my-10 max-w-lg">
    <h1 class="text-3xl font-bold text-center mb-8">Editar Turma</h1>

    <?php include 'includes/messages.php'; ?>

    <form method="POST" action="edit_turmas.php" class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-4">
            <label for="turma_nome" class="block text-gray-700 font-semibold mb-2">
                Nome da Turma: <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="nome" 
                id="turma_nome" 
                value="<?php echo htmlspecialchars($turma['nome']); ?>" 
                required 
                class="mt-1 block w-full p-2 border rounded focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
            <input type="hidden" name="turma_id" value="<?php echo $turma_id; ?>">
        </div>
        
        <div class="flex justify-center space-x-4">
            <button 
                type="submit" 
                class="bg-blue-500 text-white py-2 px-4 rounded w-full hover:bg-blue-600 transition"
            >
                Atualizar Turma
            </button>
        </div>
    </form>

    <div class="flex justify-center mt-4">
        <a 
            href="turmas.php" 
            class="bg-gray-300 text-gray-800 py-2 px-6 rounded hover:bg-gray-400 transition"
        >
            Voltar
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
