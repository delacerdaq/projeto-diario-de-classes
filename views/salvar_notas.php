<?php
require_once '../config/db.php';
require_once '../config/constants.php';
require_once '../controllers/NotaController.php';
require_once '../controllers/TurmaController.php';
require_once '../controllers/AlunoController.php';
require_once 'includes/auth_check.php';

$database = new Database();
$db = $database->getConnection();

// Cria instâncias do controlador
$notaController = new NotaController($db);
$turmaController = new TurmaController();
$alunoController = new AlunoController($db);

// Recupera as turmas
$turmas = $turmaController->getAllTurmas();

// Endpoint para listar alunos por turma (AJAX)
if (isset($_GET['turma_id'])) {
    $turma_id = intval($_GET['turma_id']);
    $stmt = $alunoController->listarAlunosPorTurmaId($turma_id);
    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($alunos);
    exit;
}

// Verifica se os dados foram enviados pelo método POST
$mensagem = '';
$tipoMensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $turma_id = isset($_POST['turma_id']) ? intval($_POST['turma_id']) : 0;
    $aluno_id = isset($_POST['aluno_id']) ? intval($_POST['aluno_id']) : 0;
    $trimestre = isset($_POST['trimestre']) ? intval($_POST['trimestre']) : 0;
    $ano = isset($_POST['ano']) ? intval($_POST['ano']) : 0;
    $pi = isset($_POST['pi']) && $_POST['pi'] !== '' ? floatval($_POST['pi']) : null;
    $pr = isset($_POST['pr']) && $_POST['pr'] !== '' ? floatval($_POST['pr']) : null;
    $pf = isset($_POST['pf']) && $_POST['pf'] !== '' ? floatval($_POST['pf']) : null;

    // Validação básica
    if ($turma_id && $aluno_id && $trimestre && $ano && ($pi !== null || $pr !== null || $pf !== null)) {
        // Validar limites por trimestre usando constantes
        $erroValidacao = false;
        
        if (isset(NOTA_LIMITS[$trimestre])) {
            $limits = NOTA_LIMITS[$trimestre];
            
            if ($pi !== null && $pi > $limits['PI_MAX']) {
                $mensagem = "Erro: A nota PI não pode ser maior que {$limits['PI_MAX']} pontos no {$trimestre}º trimestre.";
                $tipoMensagem = "error";
                $erroValidacao = true;
            }
            if ($pr !== null && $pr > $limits['PR_MAX']) {
                $mensagem = "Erro: A nota PR não pode ser maior que {$limits['PR_MAX']} pontos no {$trimestre}º trimestre.";
                $tipoMensagem = "error";
                $erroValidacao = true;
            }
            if ($pf !== null && $pf > $limits['PF_MAX']) {
                $mensagem = "Erro: A nota PF não pode ser maior que {$limits['PF_MAX']} pontos no {$trimestre}º trimestre.";
                $tipoMensagem = "error";
                $erroValidacao = true;
            }
        } else {
            $mensagem = "Erro: Trimestre inválido.";
            $tipoMensagem = "error";
            $erroValidacao = true;
        }

        if (!$erroValidacao) {
            if ($notaController->salvarNota($aluno_id, $turma_id, $trimestre, $ano, $pi, $pr, $pf)) {
                $mensagem = "Nota salva com sucesso!";
                $tipoMensagem = "success";
            } else {
                $mensagem = "Erro ao salvar a nota. Tente novamente.";
                $tipoMensagem = "error";
            }
        }
    } else {
        $mensagem = "Erro: Preencha todos os campos obrigatórios!";
        $tipoMensagem = "error";
    }
}

// Configurar links da navbar
$navLinks = [
    'Home' => 'dashboard.php',
    'Diário de Classe' => 'diario.php',
    'Avaliações' => 'avaliacoes.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Lançar Notas';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto p-6 max-w-4xl">
    <!-- Título -->
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Lançar Notas dos Alunos</h1>
    
    <!-- Mensagem de sucesso/erro -->
    <?php include 'includes/messages.php'; ?>

    <!-- Formulário -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form method="POST" action="salvar_notas.php" id="notaForm" class="space-y-6">
            <!-- Turma -->
            <div>
                <label for="turma_id" class="block text-sm font-medium text-gray-700 mb-2">Turma *</label>
                <select 
                    name="turma_id" 
                    id="turma_id" 
                    required
                    onchange="listarAlunosPorTurma(this.value)"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Selecione uma turma</option>
                    <?php foreach ($turmas as $turma): ?>
                        <option value="<?php echo htmlspecialchars($turma['id']); ?>">
                            <?php echo htmlspecialchars($turma['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Aluno -->
            <div>
                <label for="aluno_id" class="block text-sm font-medium text-gray-700 mb-2">Aluno *</label>
                <select 
                    name="aluno_id" 
                    id="aluno_id" 
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">Selecione uma turma primeiro</option>
                </select>
            </div>

            <!-- Trimestre e Ano -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="trimestre" class="block text-sm font-medium text-gray-700 mb-2">Trimestre *</label>
                    <select 
                        name="trimestre" 
                        id="trimestre" 
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    >
                        <option value="">Selecione o trimestre</option>
                        <option value="1">1º Trimestre</option>
                        <option value="2">2º Trimestre</option>
                        <option value="3">3º Trimestre</option>
                    </select>
                </div>

                <div>
                    <label for="ano" class="block text-sm font-medium text-gray-700 mb-2">Ano *</label>
                    <input 
                        type="number" 
                        name="ano" 
                        id="ano" 
                        required
                        min="2000"
                        max="2100"
                        value="<?php echo date('Y'); ?>"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>
            </div>

            <!-- Notas -->
            <div class="border-t pt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Notas</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <label for="pi" class="block text-sm font-medium text-gray-700 mb-2">
                            PI (Prova Individual) 
                            <span id="pi-max-label" class="text-gray-500 font-normal">(máx: 6 pontos)</span>
                        </label>
                        <input 
                            type="number" 
                            name="pi" 
                            id="pi" 
                            step="0.01"
                            min="0"
                            max="6"
                            placeholder="0.00"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div>
                        <label for="pr" class="block text-sm font-medium text-gray-700 mb-2">
                            PR (Projetos em Sala) 
                            <span id="pr-max-label" class="text-gray-500 font-normal">(máx: 12 pontos)</span>
                        </label>
                        <input 
                            type="number" 
                            name="pr" 
                            id="pr" 
                            step="0.01"
                            min="0"
                            max="12"
                            placeholder="0.00"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>

                    <div>
                        <label for="pf" class="block text-sm font-medium text-gray-700 mb-2">
                            PF (Prova Final) 
                            <span id="pf-max-label" class="text-gray-500 font-normal">(máx: 12 pontos)</span>
                        </label>
                        <input 
                            type="number" 
                            name="pf" 
                            id="pf" 
                            step="0.01"
                            min="0"
                            max="12"
                            placeholder="0.00"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        />
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">* Pelo menos uma nota deve ser preenchida</p>
                <p class="text-sm text-blue-600 mt-1" id="limites-info">
                    <strong>Limites por trimestre:</strong> 1º Trimestre: PI=6, PR=12, PF=12 | 2º e 3º Trimestres: PI=7, PR=14, PF=14
                </p>
            </div>

            <!-- Botões -->
            <div class="flex justify-end space-x-4 pt-4 border-t">
                <a 
                    href="dashboard.php" 
                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition"
                >
                    Voltar
                </a>
                <button 
                    type="submit" 
                    class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                >
                    Salvar Notas
                </button>
            </div>
        </form>
    </div>
</div>

<script src="js/salvar_notas.js"></script>
<?php include 'includes/footer.php'; ?>
