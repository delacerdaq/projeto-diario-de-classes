<?php
require_once 'includes/auth_check.php';

$navLinks = [
    'Sair' => 'logout.php'
];

$pageTitle = 'Dashboard';
include 'includes/head.php';
?>

<header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto text-center">
        <h1 class="text-3xl font-bold">Sistema de Diário de Classes</h1>
        <p class="text-sm text-gray-400">Organize suas aulas, registros de frequência e avaliações</p>
    </div>
</header>

<main class="container mx-auto mt-10">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <a href="turmas.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Gerenciar Turmas</h2>
            <p class="mt-2 text-gray-600">Adicione e edite turmas, veja detalhes dos alunos.</p>
        </a>

        <a href="diario.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Registrar Aulas</h2>
            <p class="mt-2 text-gray-600">Crie registros diários das aulas ministradas.</p>
        </a>

        <a href="frequencia.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Controle de Frequência</h2>
            <p class="mt-2 text-gray-600">Mantenha o controle da presença dos alunos em cada aula.</p>
        </a>

        <a href="avaliacoes.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Avaliações</h2>
            <p class="mt-2 text-gray-600">Registre e acompanhe o desempenho dos alunos.</p>
        </a>

        <a href="salvar_notas.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Lançar Notas</h2>
            <p class="mt-2 text-gray-600">Registre as notas (PI, PR, PF) dos alunos por trimestre.</p>
        </a>

        <a href="relatorios.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Gerar Relatórios</h2>
            <p class="mt-2 text-gray-600">Gere relatórios de desempenho e frequência.</p>
        </a>

        <a href="configuracoes.php" class="bg-white p-6 rounded-lg shadow-lg hover:bg-blue-100 transition">
            <h2 class="text-xl font-semibold text-blue-700">Configurações</h2>
            <p class="mt-2 text-gray-600">Ajuste as configurações do sistema de acordo com suas preferências.</p>
        </a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
