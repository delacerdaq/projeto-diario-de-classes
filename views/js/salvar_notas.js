/**
 * JavaScript para a página de lançamento de notas
 */

// Tornar função global para uso em atributos HTML
window.listarAlunosPorTurma = function(turmaId) {
    const alunoSelect = document.getElementById('aluno_id');
    if (!alunoSelect) return;

    alunoSelect.innerHTML = '<option value="">Carregando...</option>';
    alunoSelect.disabled = true;

    if (!turmaId || turmaId === "") {
        alunoSelect.innerHTML = '<option value="">Selecione uma turma primeiro</option>';
        alunoSelect.disabled = false;
        return;
    }

    fetch(`salvar_notas.php?turma_id=${turmaId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro na resposta do servidor');
            }
            return response.json();
        })
        .then(alunos => {
            alunoSelect.innerHTML = '<option value="">Selecione um aluno</option>';
            if (alunos && alunos.length > 0) {
                alunos.forEach(aluno => {
                    const option = document.createElement('option');
                    option.value = aluno.id;
                    option.textContent = aluno.nome;
                    alunoSelect.appendChild(option);
                });
            } else {
                alunoSelect.innerHTML = '<option value="">Nenhum aluno encontrado nesta turma</option>';
            }
            alunoSelect.disabled = false;
        })
        .catch(error => {
            console.error('Erro ao carregar alunos:', error);
            alunoSelect.innerHTML = '<option value="">Erro ao carregar alunos</option>';
            alunoSelect.disabled = false;
        });
};

/**
 * Atualiza os limites das notas baseado no trimestre selecionado
 */
function atualizarLimitesNotas() {
    const trimestre = document.getElementById('trimestre')?.value;
    const piInput = document.getElementById('pi');
    const prInput = document.getElementById('pr');
    const pfInput = document.getElementById('pf');
    const piLabel = document.getElementById('pi-max-label');
    const prLabel = document.getElementById('pr-max-label');
    const pfLabel = document.getElementById('pf-max-label');

    if (!piInput || !prInput || !pfInput) return;

    let maxPi, maxPr, maxPf, labelPi, labelPr, labelPf;

    if (trimestre === '1') {
        // 1º Trimestre: PI=6, PR=12, PF=12
        maxPi = 6;
        maxPr = 12;
        maxPf = 12;
        labelPi = '(máx: 6 pontos)';
        labelPr = '(máx: 12 pontos)';
        labelPf = '(máx: 12 pontos)';
    } else if (trimestre === '2' || trimestre === '3') {
        // 2º e 3º Trimestres: PI=7, PR=14, PF=14
        maxPi = 7;
        maxPr = 14;
        maxPf = 14;
        labelPi = '(máx: 7 pontos)';
        labelPr = '(máx: 14 pontos)';
        labelPf = '(máx: 14 pontos)';
    } else {
        // Sem trimestre selecionado, usar valores padrão do 1º trimestre
        maxPi = 6;
        maxPr = 12;
        maxPf = 12;
        labelPi = '(máx: 6 pontos)';
        labelPr = '(máx: 12 pontos)';
        labelPf = '(máx: 12 pontos)';
    }

    piInput.max = maxPi;
    prInput.max = maxPr;
    pfInput.max = maxPf;

    if (piLabel) piLabel.textContent = labelPi;
    if (prLabel) prLabel.textContent = labelPr;
    if (pfLabel) pfLabel.textContent = labelPf;

    // Limpar valores se excederem o novo máximo
    if (parseFloat(piInput.value) > maxPi) piInput.value = '';
    if (parseFloat(prInput.value) > maxPr) prInput.value = '';
    if (parseFloat(pfInput.value) > maxPf) pfInput.value = '';
}

/**
 * Valida o formulário antes do envio
 */
function validarFormularioNotas(e) {
    const pi = parseFloat(document.getElementById('pi')?.value) || 0;
    const pr = parseFloat(document.getElementById('pr')?.value) || 0;
    const pf = parseFloat(document.getElementById('pf')?.value) || 0;
    const trimestre = document.getElementById('trimestre')?.value;

    if (!pi && !pr && !pf) {
        e.preventDefault();
        alert('Por favor, preencha pelo menos uma nota (PI, PR ou PF).');
        return false;
    }

    if (!trimestre) {
        e.preventDefault();
        alert('Por favor, selecione um trimestre.');
        return false;
    }

    // Validar limites baseado no trimestre
    let maxPi, maxPr, maxPf;
    if (trimestre === '1') {
        maxPi = 6;
        maxPr = 12;
        maxPf = 12;
    } else if (trimestre === '2' || trimestre === '3') {
        maxPi = 7;
        maxPr = 14;
        maxPf = 14;
    } else {
        e.preventDefault();
        alert('Trimestre inválido.');
        return false;
    }

    if (pi > maxPi) {
        e.preventDefault();
        alert(`A nota PI não pode ser maior que ${maxPi} pontos para o ${trimestre}º trimestre.`);
        return false;
    }

    if (pr > maxPr) {
        e.preventDefault();
        alert(`A nota PR não pode ser maior que ${maxPr} pontos para o ${trimestre}º trimestre.`);
        return false;
    }

    if (pf > maxPf) {
        e.preventDefault();
        alert(`A nota PF não pode ser maior que ${maxPf} pontos para o ${trimestre}º trimestre.`);
        return false;
    }

    return true;
}

// Inicialização quando o DOM estiver pronto
document.addEventListener('DOMContentLoaded', function() {
    const trimestreSelect = document.getElementById('trimestre');
    const notaForm = document.getElementById('notaForm');

    if (trimestreSelect) {
        trimestreSelect.addEventListener('change', atualizarLimitesNotas);
    }

    if (notaForm) {
        notaForm.addEventListener('submit', validarFormularioNotas);
    }

    // Inicializar limites ao carregar a página
    atualizarLimitesNotas();
});
