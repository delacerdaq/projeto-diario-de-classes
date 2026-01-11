<?php
/**
 * Componente de Head HTML reutilizável
 * @param string $title Título da página
 * @param array $additionalStyles Array de URLs de CSS adicionais
 * @param array $additionalScripts Array de URLs de scripts adicionais (head)
 */
if (!isset($pageTitle)) {
    $pageTitle = 'Sistema de Diário de Classe';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php if (isset($additionalStyles) && is_array($additionalStyles)): ?>
        <?php foreach ($additionalStyles as $style): ?>
            <link rel="stylesheet" href="<?php echo htmlspecialchars($style); ?>">
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if (isset($additionalScripts) && is_array($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo htmlspecialchars($script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body class="bg-gray-100">
