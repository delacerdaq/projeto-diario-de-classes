<?php
require_once '../controllers/TurmaController.php';
require_once '../controllers/FrequenciaController.php';
require_once 'includes/auth_check.php';

$turmaController = new TurmaController();
$frequenciaController = new FrequenciaController();
$turmas = $turmaController->getAllTurmas();

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['turma_id'], $_POST['data_chamada'])) {
    $turmaId = $_POST['turma_id'];
    $dataChamada = $_POST['data_chamada'];
    $alunosFrequencia = $_POST['frequencia'] ?? [];
    
    $sucesso = true;
    foreach ($alunosFrequencia as $alunoId => $presenca) {
        if (!$frequenciaController->saveFrequencia($alunoId, $turmaId, $dataChamada, $presenca)) {
            $sucesso = false;
        }
    }

    if ($sucesso) {
        $mensagem = "Chamada salva com sucesso!";
        $tipoMensagem = "success";
    } else {
        $mensagem = "Erro ao salvar a chamada.";
        $tipoMensagem = "error";
    }
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Visualizar Frequência' => 'visualizar_frequencia.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Controle de Frequência';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto px-4 my-10">
    <h1 class="text-3xl font-bold text-center mb-8">Controle de Frequência</h1>

    <!-- Mensagens -->
    <?php include 'includes/messages.php'; ?>

    <!-- Campo para inserir a data da chamada -->
    <form method="POST">
        <div class="mb-6 text-center">
            <label for="data-chamada" class="block text-gray-700 text-lg mb-2">Data da Chamada:</label>
            <input 
                type="date" 
                name="data_chamada" 
                id="data-chamada" 
                class="p-2 border border-gray-300 rounded-lg" 
                required
                value="<?php echo isset($_POST['data_chamada']) ? htmlspecialchars($_POST['data_chamada']) : date('Y-m-d'); ?>"
            >
        </div>

        <!-- Select para filtrar turmas -->
        <div class="mb-6">
            <label for="turma-select" class="block text-gray-700 text-lg mb-2">Selecione a turma:</label>
            <select 
                id="turma-select" 
                name="turma_id" 
                onchange="updateTurma()" 
                class="block w-full p-2 border border-gray-300 rounded-lg" 
                required
            >
                <option value="">Selecione uma turma</option>
                <?php 
                if ($turmas instanceof PDOStatement) {
                    $turmas->execute();
                    while ($row = $turmas->fetch(PDO::FETCH_ASSOC)): 
                ?>
                    <option 
                        value="<?php echo $row['id']; ?>" 
                        <?php echo isset($_GET['turma_id']) && $_GET['turma_id'] == $row['id'] ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($row['nome']); ?>
                    </option>
                <?php 
                    endwhile;
                }
                ?>
            </select>
        </div>

        <!-- Tabela de Controle de Frequência -->
        <?php if (isset($_GET['turma_id'])): 
            $turmaId = $_GET['turma_id'];
            $alunos = $turmaController->getAlunosByTurmaId($turmaId);
        ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Foto</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Nome do Aluno</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Presença</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($alunos && $alunos->rowCount() > 0): ?>
                        <?php 
                        $avatarCache = [];
                        while ($aluno = $alunos->fetch(PDO::FETCH_ASSOC)): 
                            $alunoKey = md5($aluno['nome']);
                            if (!isset($avatarCache[$alunoKey])) {
                                $avatarCache[$alunoKey] = rand(1, 100);
                            }
                            $avatarId = $avatarCache[$alunoKey];
                        ?>
                        <tr>
                            <td class="py-2 px-4 border-b">
                                <img 
                                    class="h-12 w-12 rounded-full" 
                                    src="https://avatar.iran.liara.run/public/<?php echo $avatarId; ?>" 
                                    alt="Avatar do aluno"
                                >
                            </td>
                            <td class="py-2 px-4 border-b"><?php echo htmlspecialchars($aluno['nome']); ?></td>
                            <td class="py-2 px-4 border-b">
                                <label class="inline-flex items-center">
                                    <input 
                                        type="radio" 
                                        name="frequencia[<?php echo $aluno['id']; ?>]" 
                                        value="P" 
                                        class="form-radio text-green-500" 
                                        checked
                                    >
                                    <span class="ml-2 text-gray-700">P</span>
                                </label>
                                <label class="inline-flex items-center ml-4">
                                    <input 
                                        type="radio" 
                                        name="frequencia[<?php echo $aluno['id']; ?>]" 
                                        value="F" 
                                        class="form-radio text-red-500"
                                    >
                                    <span class="ml-2 text-gray-700">F</span>
                                </label>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">
                                Nenhum aluno encontrado nesta turma.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Botão de salvar chamada -->
        <div class="mt-6 text-center">
            <button 
                type="submit" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition"
            >
                Salvar Chamada
            </button>
        </div>
        <?php else: ?>
            <p class="text-center text-gray-500">Selecione uma turma para exibir os alunos.</p>
        <?php endif; ?>
    </form>
</div>

<script src="js/turmas.js"></script>
<?php include 'includes/footer.php'; ?>
