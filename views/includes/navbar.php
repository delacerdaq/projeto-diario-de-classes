<?php
/**
 * Componente de Navbar reutilizável
 * @param array $links Array associativo com os links [texto => url]
 */
if (!isset($navLinks)) {
    // Links padrão se não for especificado
    $navLinks = [
        'Home' => 'dashboard.php',
        'Diário de Classe' => 'diario.php',
        'Avaliações' => 'avaliacoes.php',
        'Lançar Notas' => 'salvar_notas.php',
        'Sair' => 'logout.php'
    ];
}
?>
<nav class="bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-white text-lg font-bold">Sistema de Diário de Classe</h1>
        <div class="flex space-x-4">
            <?php foreach ($navLinks as $text => $url): ?>
                <a href="<?php echo htmlspecialchars($url); ?>" 
                   class="text-gray-300 hover:text-white transition">
                    <?php echo htmlspecialchars($text); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</nav>
