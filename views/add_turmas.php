<?php
require_once '../controllers/TurmaController.php';
require_once 'includes/auth_check.php';

$turmaController = new TurmaController();

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeTurma = isset($_POST['nome_turma']) ? trim($_POST['nome_turma']) : '';
    $alunos = isset($_POST['alunos']) ? array_filter($_POST['alunos']) : [];

    if (empty($nomeTurma)) {
        $mensagem = "Erro: O nome da turma é obrigatório.";
        $tipoMensagem = "error";
    } elseif (empty($alunos)) {
        $mensagem = "Erro: Adicione pelo menos um aluno.";
        $tipoMensagem = "error";
    } else {
        if ($turmaController->adicionarTurmaComAlunos($nomeTurma, $alunos)) {
            $mensagem = "Turma e alunos adicionados com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Erro ao adicionar turma ou alunos.";
            $tipoMensagem = "error";
        }
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Adicionar Turma';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto my-10 max-w-2xl">
    <h1 class="text-3xl font-bold text-center mb-8">Adicionar Turma e Alunos</h1>
    
    <?php include 'includes/messages.php'; ?>
    
    <form action="add_turmas.php" method="POST" class="bg-white p-6 rounded-lg shadow-lg">
        <div class="mb-4">
            <label for="nome_turma" class="block text-gray-700 text-sm font-bold mb-2">
                Nome da Turma: <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                name="nome_turma" 
                id="nome_turma" 
                class="border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
                value="<?php echo isset($_POST['nome_turma']) ? htmlspecialchars($_POST['nome_turma']) : ''; ?>"
            >
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">
                Alunos: <span class="text-red-500">*</span>
            </label>
            <div id="alunos-container">
                <input 
                    type="text" 
                    name="alunos[]" 
                    placeholder="Nome do Aluno" 
                    class="border rounded w-full py-2 px-3 text-gray-700 mb-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    required
                >
            </div>
            <button 
                type="button" 
                onclick="adicionarCampoAluno()" 
                class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 transition"
            >
                Adicionar novo aluno
            </button>
        </div>

        <div class="flex justify-center space-x-4 mt-6">
            <a 
                href="diario.php" 
                class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded focus:outline-none focus:shadow-outline transition"
            >
                Voltar
            </a>
            <button 
                type="submit" 
                class="bg-blue-700 text-white py-2 px-4 rounded hover:bg-blue-800 transition"
            >
                Adicionar turma e alunos
            </button>
        </div>
    </form>
</div>

<script src="js/add_turmas.js"></script>
<?php include 'includes/footer.php'; ?>
