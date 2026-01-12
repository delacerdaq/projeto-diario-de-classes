<?php
require_once '../controllers/NotaController.php';
require_once 'includes/auth_check.php';

$notaController = new NotaController();

$trimestre = isset($_GET['trimestre']) && $_GET['trimestre'] !== '' ? intval($_GET['trimestre']) : null;
$ano = isset($_GET['ano']) && $_GET['ano'] !== '' ? intval($_GET['ano']) : null;

$stmt = $notaController->listarAlunosComNotas($trimestre, $ano);
$alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

$alunosAgrupados = [];
foreach ($alunos as $aluno) {
    $key = ($aluno['aluno_id'] ?? '') . '_' . ($aluno['turma_id'] ?? '');
    
    if (!isset($alunosAgrupados[$key])) {
        $alunosAgrupados[$key] = $aluno;
    }
}

$alunos = array_values($alunosAgrupados);

$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Lançar Notas' => 'salvar_notas.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Notas dos Alunos';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto p-4">
    <h1 class="text-2xl font-semibold text-center mb-6">Notas dos Alunos</h1>
    
    <form method="GET" action="avaliacoes.php" class="mb-6">
        <div class="flex justify-center space-x-4 mb-4">
            <div class="w-1/3">
                <label for="ano" class="block text-sm font-medium text-gray-700">Ano</label>
                <input 
                    type="number" 
                    id="ano" 
                    name="ano" 
                    value="<?php echo $ano !== null ? htmlspecialchars($ano) : ''; ?>"
                    placeholder="Digite o ano" 
                    min="2000"
                    max="2100"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                />
            </div>

            <div class="w-1/3">
                <label for="trimestre" class="block text-sm font-medium text-gray-700">Trimestre</label>
                <select 
                    id="trimestre" 
                    name="trimestre" 
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Selecione o trimestre</option>
                    <option value="1" <?php echo $trimestre === 1 ? 'selected' : ''; ?>>Trimestre 1</option>
                    <option value="2" <?php echo $trimestre === 2 ? 'selected' : ''; ?>>Trimestre 2</option>
                    <option value="3" <?php echo $trimestre === 3 ? 'selected' : ''; ?>>Trimestre 3</option>
                </select>
            </div>
        </div>

        <div class="flex justify-center space-x-4">
            <button 
                type="submit" 
                class="w-1/4 px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
            >
                Filtrar
            </button>
            <a 
                href="avaliacoes.php" 
                class="w-1/4 px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition text-center"
            >
                Limpar Filtros
            </a>
        </div>
    </form>

    <?php if ($trimestre !== null || $ano !== null): ?>
        <div class="mb-4 p-3 bg-blue-100 text-blue-800 rounded-lg text-center">
            <p class="text-sm">
                Exibindo notas 
                <?php if ($trimestre !== null): ?>
                    do <?php echo $trimestre; ?>º Trimestre
                <?php endif; ?>
                <?php if ($ano !== null): ?>
                    de <?php echo $ano; ?>
                <?php endif; ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <div class="max-w-full mx-auto">
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Foto</th>
                        <th class="py-3 px-4 text-left">Nome</th>
                        <th class="py-3 px-4 text-left">Turma</th>
                        <th class="py-3 px-4 text-left">PI</th>
                        <th class="py-3 px-4 text-left">PR</th>
                        <th class="py-3 px-4 text-left">PF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($alunos)): ?>
                        <?php 
                        $avatarCache = [];
                        foreach ($alunos as $aluno): 
                            $alunoKey = md5($aluno['aluno_nome'] ?? '');
                            if (!isset($avatarCache[$alunoKey])) {
                                $avatarCache[$alunoKey] = rand(1, 100);
                            }
                            $avatarId = $avatarCache[$alunoKey];
                        ?>
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-4">
                                <img 
                                    src="https://avatar.iran.liara.run/public/<?php echo $avatarId; ?>" 
                                    alt="Foto de <?php echo htmlspecialchars($aluno['aluno_nome'] ?? 'Aluno Desconhecido'); ?>" 
                                    class="h-12 w-12 rounded-full"
                                />
                            </td>
                            <td class="py-3 px-4 font-medium">
                                <?php echo htmlspecialchars($aluno['aluno_nome'] ?? 'Nome não disponível'); ?>
                            </td>
                            <td class="py-3 px-4">
                                <?php echo htmlspecialchars($aluno['turma_nome'] ?? 'Turma não disponível'); ?>
                            </td>
                            <td class="py-3 px-4">
                                <?php 
                                $pi = $aluno['PI'] ?? null;
                                echo $pi !== null ? number_format($pi, 2, ',', '.') : '<span class="text-gray-400">-</span>'; 
                                ?>
                            </td>
                            <td class="py-3 px-4">
                                <?php 
                                $pr = $aluno['PR'] ?? null;
                                echo $pr !== null ? number_format($pr, 2, ',', '.') : '<span class="text-gray-400">-</span>'; 
                                ?>
                            </td>
                            <td class="py-3 px-4">
                                <?php 
                                $pf = $aluno['PF'] ?? null;
                                echo $pf !== null ? number_format($pf, 2, ',', '.') : '<span class="text-gray-400">-</span>'; 
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">
                                <?php if ($trimestre !== null || $ano !== null): ?>
                                    Nenhum aluno encontrado com notas para os filtros selecionados.
                                <?php else: ?>
                                    Nenhum aluno encontrado.
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
