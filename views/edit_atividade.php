<?php
require_once '../config/db.php';
require_once '../controllers/AtividadeController.php';
require_once 'includes/auth_check.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: diario.php");
    exit;
}

$id = intval($_GET['id']);

$database = new Database();
$db = $database->getConnection();
$atividadeController = new AtividadeController($db);
$atividade = $atividadeController->getAtividadeById($id);

if (!$atividade) {
    header("Location: diario.php");
    exit;
}

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $data = isset($_POST['data']) ? $_POST['data'] : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $turma_id = isset($_POST['turma_id']) ? intval($_POST['turma_id']) : 0;

    if (empty($titulo) || empty($data) || empty($descricao) || $turma_id <= 0) {
        $mensagem = "Erro: Preencha todos os campos obrigatórios.";
        $tipoMensagem = "error";
    } else {
        if ($atividadeController->atualizarAtividade($id, $titulo, $data, $descricao, $turma_id)) {
            $mensagem = "Atividade atualizada com sucesso!";
            $tipoMensagem = "success";
            // Atualizar dados locais
            $atividade['titulo'] = $titulo;
            $atividade['data'] = $data;
            $atividade['descricao'] = $descricao;
            $atividade['turma_id'] = $turma_id;
        } else {
            $mensagem = "Erro ao atualizar a atividade.";
            $tipoMensagem = "error";
        }
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Editar Atividade';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto mt-10 max-w-xl">
    <h1 class="text-3xl font-bold text-center mb-8">Editar Atividade</h1>

    <?php include 'includes/messages.php'; ?>

    <div class="bg-white p-8 shadow-md rounded-lg">
        <form method="POST">
            <div class="mb-4">
                <label for="titulo" class="block text-gray-700 text-sm font-bold mb-2">
                    Título: <span class="text-red-500">*</span>
                </label>
                <input 
                    type="text" 
                    name="titulo" 
                    id="titulo" 
                    value="<?php echo htmlspecialchars($atividade['titulo']); ?>" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                >
            </div>

            <div class="mb-4">
                <label for="data" class="block text-gray-700 text-sm font-bold mb-2">
                    Data: <span class="text-red-500">*</span>
                </label>
                <input 
                    type="date" 
                    name="data" 
                    id="data" 
                    value="<?php echo htmlspecialchars($atividade['data']); ?>" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                >
            </div>

            <div class="mb-4">
                <label for="descricao" class="block text-gray-700 text-sm font-bold mb-2">
                    Descrição: <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="descricao" 
                    id="descricao" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                    rows="4"
                ><?php echo htmlspecialchars($atividade['descricao']); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="turma_id" class="block text-gray-700 text-sm font-bold mb-2">
                    Turma: <span class="text-red-500">*</span>
                </label>
                <input 
                    type="number" 
                    name="turma_id" 
                    id="turma_id" 
                    value="<?php echo htmlspecialchars($atividade['turma_id']); ?>" 
                    required 
                    class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:border-blue-500"
                >
            </div>

            <div class="flex justify-center space-x-4">
                <input 
                    type="submit" 
                    value="Atualizar Atividade" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer transition"
                >
                <a 
                    href="diario.php" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer transition"
                >
                    Voltar
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
