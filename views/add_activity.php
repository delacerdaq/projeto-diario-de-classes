<?php
require_once '../controllers/AtividadeController.php';
require_once 'includes/auth_check.php';

$atividadeController = new AtividadeController();

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
    $data = isset($_POST['data']) ? $_POST['data'] : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $turma_id = isset($_POST['turma_id']) ? intval($_POST['turma_id']) : 0;

    if (empty($titulo) || empty($data) || empty($descricao) || $turma_id <= 0) {
        $mensagem = "Erro: Preencha todos os campos obrigatórios.";
        $tipoMensagem = "error";
    } else {
        if ($atividadeController->adicionarAtividade($titulo, $data, $descricao, $turma_id)) {
            $mensagem = "Atividade adicionada com sucesso!";
            $tipoMensagem = "success";
        } else {
            $mensagem = "Erro ao adicionar a atividade.";
            $tipoMensagem = "error";
        }
    }
}

$turmas = $atividadeController->listarTurmas();

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Adicionar Atividade';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto my-10 max-w-md">
    <h2 class="text-2xl font-bold mb-4 text-center">Adicionar Atividade</h2>

    <?php include 'includes/messages.php'; ?>
    
    <form method="POST" class="bg-white p-5 rounded shadow-lg">
        <div class="mb-4">
            <label for="titulo" class="block mb-2 font-semibold text-gray-700">
                Título: <span class="text-red-500">*</span>
            </label>
            <input 
                type="text" 
                id="titulo" 
                name="titulo" 
                class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
                value="<?php echo isset($_POST['titulo']) ? htmlspecialchars($_POST['titulo']) : ''; ?>"
            >
        </div>
        
        <div class="mb-4">
            <label for="data" class="block mb-2 font-semibold text-gray-700">
                Data: <span class="text-red-500">*</span>
            </label>
            <input 
                type="date" 
                id="data" 
                name="data" 
                class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
                value="<?php echo isset($_POST['data']) ? htmlspecialchars($_POST['data']) : date('Y-m-d'); ?>"
            >
        </div>
        
        <div class="mb-4">
            <label for="descricao" class="block mb-2 font-semibold text-gray-700">
                Descrição: <span class="text-red-500">*</span>
            </label>
            <textarea 
                id="descricao" 
                name="descricao" 
                class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
                rows="4"
            ><?php echo isset($_POST['descricao']) ? htmlspecialchars($_POST['descricao']) : ''; ?></textarea>
        </div>
        
        <div class="mb-4">
            <label for="turma_id" class="block mb-2 font-semibold text-gray-700">
                Turma: <span class="text-red-500">*</span>
            </label>
            <select 
                id="turma_id" 
                name="turma_id" 
                class="border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
            >
                <option value="">Selecione a turma</option>
                <?php 
                $turmas->execute();
                while ($row = $turmas->fetch(PDO::FETCH_ASSOC)): 
                ?>
                    <option 
                        value="<?php echo $row['id']; ?>"
                        <?php echo isset($_POST['turma_id']) && $_POST['turma_id'] == $row['id'] ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($row['nome']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        
        <div class="flex justify-center space-x-4">
            <button 
                type="submit" 
                class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600 transition"
            >
                Adicionar Atividade
            </button>
            <a 
                href="diario.php" 
                class="bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600 transition"
            >
                Voltar
            </a>
        </div>
    </form>
</div>

<?php include 'includes/footer.php'; ?>
