<?php
require_once '../controllers/TurmaController.php';
require_once '../controllers/FrequenciaController.php';
require_once 'includes/auth_check.php';

$turmaController = new TurmaController();
$frequenciaController = new FrequenciaController();
$turmas = $turmaController->getAllTurmas();

$frequencias = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['turma_id'], $_POST['data_chamada'])) {
    $turmaId = $_POST['turma_id'];
    $dataChamada = $_POST['data_chamada'];
    $frequencias = $frequenciaController->getFrequencias($turmaId, $dataChamada);
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Controle de Frequência' => 'frequencia.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Visualizar Frequência';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto px-4 my-10">
    <h1 class="text-3xl font-bold text-center mb-8">Visualizar Frequência</h1>

    <form method="POST" class="mb-6 bg-white p-6 rounded-lg shadow-md">
        <div class="mb-4">
            <label for="turma-select" class="block text-gray-700 font-semibold mb-2">
                Selecione a turma: <span class="text-red-500">*</span>
            </label>
            <select 
                id="turma-select" 
                name="turma_id" 
                class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
            >
                <option value="">Selecione uma turma</option>
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
        
        <div class="mb-4">
            <label for="data-chamada" class="block text-gray-700 font-semibold mb-2">
                Data da Chamada: <span class="text-red-500">*</span>
            </label>
            <input 
                type="date" 
                name="data_chamada" 
                id="data-chamada" 
                class="block w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required
                value="<?php echo isset($_POST['data_chamada']) ? htmlspecialchars($_POST['data_chamada']) : date('Y-m-d'); ?>"
            >
        </div>
        
        <button 
            type="submit" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full transition"
        >
            Buscar
        </button>
    </form>

    <!-- Tabela de Visualização de Frequência -->
    <?php if ($frequencias && $frequencias->rowCount() > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Foto</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Nome do Aluno</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600">Situação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $avatarCache = [];
                    while ($frequencia = $frequencias->fetch(PDO::FETCH_ASSOC)): 
                        $alunoNome = htmlspecialchars($frequencia['aluno_nome'] ?? 'Desconhecido');
                        $alunoKey = md5($alunoNome);
                        if (!isset($avatarCache[$alunoKey])) {
                            $avatarCache[$alunoKey] = rand(1, 100);
                        }
                        $avatarId = $avatarCache[$alunoKey];
                    ?>
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">
                                <img 
                                    class="h-12 w-12 rounded-full" 
                                    src="https://avatar.iran.liara.run/public/<?php echo $avatarId; ?>" 
                                    alt="Foto do aluno"
                                >
                            </td>
                            <td class="py-2 px-4 border-b"><?php echo $alunoNome; ?></td>
                            <td class="py-2 px-4 border-b">
                                <span class="<?php echo $frequencia['presenca'] === 'P' ? 'text-green-600 font-semibold' : 'text-red-600 font-semibold'; ?>">
                                    <?php echo $frequencia['presenca'] === 'P' ? 'Presente' : 'Faltou'; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center">
            Nenhuma frequência registrada para esta turma e data.
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
