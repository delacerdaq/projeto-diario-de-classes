/**
 * JavaScript para adicionar campos de alunos dinamicamente
 */

window.adicionarCampoAluno = function() {
    const container = document.getElementById('alunos-container');
    if (!container) return;

    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'alunos[]';
    input.placeholder = 'Nome do Aluno';
    input.className = 'border rounded w-full py-2 px-3 text-gray-700 mb-2';
    container.appendChild(input);
};
