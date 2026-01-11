<?php
/**
 * Componente para exibir mensagens de sucesso/erro
 * @param string $mensagem Mensagem a ser exibida
 * @param string $tipo Tipo da mensagem: 'success' ou 'error'
 */
if (isset($mensagem) && !empty($mensagem)):
    $bgColor = ($tipoMensagem === 'success') ? 'bg-green-100 text-green-800 border-green-400' : 'bg-red-100 text-red-800 border-red-400';
?>
    <div class="mb-4 p-4 rounded-lg border <?php echo $bgColor; ?>">
        <?php echo htmlspecialchars($mensagem); ?>
    </div>
<?php endif; ?>
