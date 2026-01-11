/**
 * JavaScript para páginas relacionadas a turmas
 */

/**
 * Atualiza a página com a turma selecionada
 */
function updateTurma() {
    const turmaId = document.getElementById("turma-select")?.value;
    if (turmaId) {
        window.location.href = "?turma_id=" + turmaId;
    }
}
