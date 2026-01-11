<?php
require_once '../controllers/TurmaController.php';
require_once 'includes/auth_check.php';

$turmaController = new TurmaController();
$turmas = $turmaController->getAllTurmas();

$mensagem = '';
$tipoMensagem = '';
if (isset($_GET['success'])) {
    $mensagem = urldecode($_GET['success']);
    $tipoMensagem = 'success';
}

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Adicionar Turma' => 'add_turmas.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Diário de Classe';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto px-4 my-10">
    <h1 class="text-3xl font-bold text-center mb-8">Diário de Classe</h1>

    <!-- Mensagens -->
    <?php include 'includes/messages.php'; ?>

    <!-- Select para filtrar turmas -->
    <div class="mb-6">
        <label for="turma-select" class="block text-gray-700 text-lg mb-2">Selecione a turma:</label>
        <div class="flex items-center space-x-4">
            <select 
                id="turma-select" 
                onchange="updateTurma()" 
                class="block w-full p-2 border border-gray-300 rounded-lg"
            >
                <option value="">Selecione uma turma</option>
                <?php 
                $turmas->execute();
                while ($row = $turmas->fetch(PDO::FETCH_ASSOC)): 
                ?>
                    <option 
                        value="<?php echo $row['id']; ?>" 
                        <?php echo isset($_GET['turma_id']) && $_GET['turma_id'] == $row['id'] ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($row['nome']); ?>
                    </option>
                <?php endwhile; ?>
            </select>

            <!-- Link para editar o nome da turma -->
            <?php if (isset($_GET['turma_id'])): ?>
                <a 
                    href="edit_turmas.php?turma_id=<?php echo htmlspecialchars($_GET['turma_id']); ?>" 
                    class="bg-blue-500 text-white py-2 px-4 rounded-md shadow hover:bg-blue-600 transition duration-300"
                >
                    Editar nome da Turma
                </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tabela de Alunos -->
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
                    <th class="py-2 px-4 border-b text-left text-gray-600">Ações</th>
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
                            <a 
                                href="edit_aluno.php?aluno_id=<?php echo $aluno['id']; ?>" 
                                class="text-blue-500 hover:text-blue-700 mr-4"
                            >
                                Editar
                            </a>
                            <a 
                                href="delete_aluno.php?id=<?php echo $aluno['id']; ?>" 
                                class="text-red-500 hover:text-red-700"
                            >
                                Excluir
                            </a>
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
    <?php else: ?>
        <p class="text-center text-gray-500">Selecione uma turma para exibir os alunos.</p>
    <?php endif; ?>
</div>

<script src="js/turmas.js"></script>
<?php include 'includes/footer.php'; ?>
