<?php
require_once '../controllers/AtividadeController.php';
require_once 'includes/auth_check.php';

$atividadeController = new AtividadeController();
$atividades = $atividadeController->listarAtividades();

$navLinks = [
    'Home' => 'dashboard.php',
    'Sair' => 'logout.php'
];

$pageTitle = 'Diário de Classe';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<div class="container mx-auto mt-6">
    <h2 class="text-2xl font-semibold text-gray-800">Atividades Desenvolvidas com a Turma</h2>
    
    <div class="mt-4 mb-4">
        <a 
            href="add_activity.php" 
            class="bg-blue-800 text-white px-4 py-2 rounded hover:bg-blue-600 transition"
        >
            Adicionar Nova Atividade
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-semibold mb-4">Lista de Atividades</h3>

        <?php if ($atividades && $atividades->rowCount() > 0): ?>
            <?php while ($atividade = $atividades->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="border-b mb-4 pb-4">
                    <h4 class="text-lg font-semibold"><?php echo htmlspecialchars($atividade['titulo']); ?></h4>
                    <p class="text-gray-600">Data: <?php echo htmlspecialchars($atividade['data']); ?></p>
                    <p class="text-gray-600">Descrição: <?php echo htmlspecialchars($atividade['descricao']); ?></p>
                    <div class="flex space-x-4 mt-2">
                        <a 
                            href="edit_atividade.php?id=<?php echo htmlspecialchars($atividade['id']); ?>" 
                            class="text-blue-500 hover:text-blue-600"
                        >
                            Editar
                        </a>
                        <a 
                            href="delete_atividade.php?id=<?php echo htmlspecialchars($atividade['id']); ?>" 
                            class="text-red-500 hover:text-red-600"
                        >
                            Excluir
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="text-gray-500 text-center py-4">Nenhuma atividade cadastrada ainda.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
