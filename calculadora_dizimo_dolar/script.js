
function obterSalario() {
    const salario = parseFloat(document.getElementById('salario').value);
    return isNaN(salario) ? null : salario;
}

function exibirResultado(elementoId, mensagem) {
    document.getElementById(elementoId).textContent = mensagem;
}

function limparResultados() {
    exibirResultado('resultadoDizimo', '');
    exibirResultado('resultadoOferta', '');
}

function calcularDizimo() {
    const salario = obterSalario();
    if (salario === null) {
        exibirResultado('resultadoDizimo', 'Por favor, digite um valor válido para o salário.');
        exibirResultado('resultadoOferta', '');
        return;
    }

    const dizimo = salario * 0.1;
    exibirResultado('resultadoDizimo', `10% de R$${salario.toFixed(2)} é R$${dizimo.toFixed(2)}`);
}

function calcularOferta() {
    const salario = obterSalario();
    if (salario === null) {
        exibirResultado('resultadoOferta', 'Por favor, digite um valor válido para o salário.');
        exibirResultado('resultadoDizimo', '');
        return;
    }

    const oferta = salario * 0.05;
    exibirResultado('resultadoOferta', `5% de R$${salario.toFixed(2)} é R$${oferta.toFixed(2)}`);
}
