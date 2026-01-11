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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $atividadeId = intval($_POST['id']);
        if ($atividadeController->excluirAtividade($atividadeId)) {
            header("Location: diario.php?success=" . urlencode("Atividade excluída com sucesso!"));
            exit;
        } else {
            $mensagem = "Erro ao excluir a atividade.";
            $tipoMensagem = "error";
        }
    } else {
        $mensagem = "ID da atividade não encontrado.";
        $tipoMensagem = "error";
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Excluir Atividade';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto px-4 py-8 max-w-md">
    <form id="delete-form" method="post" action="" class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Excluir Atividade</h1>
        
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        
        <p class="mb-4 text-gray-700">
            Você tem certeza de que deseja excluir a atividade 
            "<strong class="text-blue-500"><?php echo htmlspecialchars($atividade['titulo']); ?></strong>"?
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
                href="diario.php" 
                class="bg-gray-500 hover:bg-gray-700 text-white py-2 px-4 rounded transition"
            >
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
