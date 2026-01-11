<?php
/**
 * Arquivo de constantes do sistema
 */

// Limites de notas por trimestre
define('NOTA_LIMITS', [
    1 => [
        'PI_MAX' => 6,
        'PR_MAX' => 12,
        'PF_MAX' => 12
    ],
    2 => [
        'PI_MAX' => 7,
        'PR_MAX' => 14,
        'PF_MAX' => 14
    ],
    3 => [
        'PI_MAX' => 7,
        'PR_MAX' => 14,
        'PF_MAX' => 14
    ]
]);

// Configurações gerais
define('SITE_NAME', 'Sistema de Diário de Classe');
define('CURRENT_YEAR', date('Y'));
