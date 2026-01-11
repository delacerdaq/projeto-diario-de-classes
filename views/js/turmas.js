function updateTurma() {
    const turmaId = document.getElementById("turma-select")?.value;
    if (turmaId) {
        window.location.href = "?turma_id=" + turmaId;
    }
}
