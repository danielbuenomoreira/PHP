let operadorPendente = '';

function atualizarOperador() {
    const operador = document.getElementById('operador').value;
    const isAdmin = document.body.dataset.isAdmin === 'true';

    // Dispara o modal de senha se for Daniel e não estiver autenticado
    if (operador === 'Daniel Moreira' && !isAdmin) {
        operadorPendente = operador;
        document.getElementById('modal_senha').style.display = 'flex';
        document.getElementById('senha_modal_input').value = '';
        document.getElementById('senha_modal_input').focus();

        // Reverte visualmente o select até a confirmação ou cancelamento
        document.getElementById('operador').value = localStorage.getItem('operadorHelpDesk') || '';
        return;
    }

    prosseguirAtualizacaoOperador(operador);
}

function prosseguirAtualizacaoOperador(operador) {
    document.getElementById('operador').value = operador;
    localStorage.setItem('operadorHelpDesk', operador);
    aplicarOperador(operador);
}

function confirmarSenha() {
    const senha = document.getElementById('senha_modal_input').value;
    document.getElementById('input_senha').value = senha;
    document.getElementById('login_operador').value = operadorPendente;
    document.getElementById('form_login').submit();
}

function cancelarSenha() {
    document.getElementById('modal_senha').style.display = 'none';
    // Se cancelar, prossegue como Daniel Moreira, mas sem privilégios de Admin
    prosseguirAtualizacaoOperador(operadorPendente);
}

// Permite confirmar a senha apertando "Enter"
document.getElementById('senha_modal_input')?.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') confirmarSenha();
});

function aplicarOperador(operador) {
    document.querySelectorAll('.input-operador').forEach(input => input.value = operador);
    document.getElementById('box-novo-chamado').style.display = operador ? 'block' : 'none';
    document.querySelectorAll('.form-interacao').forEach(div => div.style.display = operador ? 'block' : 'none');

    const isAdmin = document.body.dataset.isAdmin === 'true';

    document.querySelectorAll('.form-excluir-chamado, .form-excluir-anexo').forEach(form => {
        const autor = form.getAttribute('data-autor');
        form.style.display = (isAdmin || autor === operador) ? 'inline-block' : 'none';
    });
}

function abrirAba(status) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    document.getElementById('aba-' + status.replace(' ', '-')).classList.add('active');
    event.currentTarget.classList.add('active');
}

window.onload = function () {
    const operadorSessao = document.body.dataset.operadorSessao;
    const salvo = operadorSessao || localStorage.getItem('operadorHelpDesk');

    if (salvo) {
        document.getElementById('operador').value = salvo;
        localStorage.setItem('operadorHelpDesk', salvo);
        aplicarOperador(salvo);
    }
}