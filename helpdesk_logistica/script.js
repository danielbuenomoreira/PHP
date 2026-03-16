let operadorPendente = '';

function atualizarOperador() {
    const operador = document.getElementById('operador').value;
    const isAdmin = document.body.dataset.isAdmin === 'true';

    if (operador === 'Daniel Moreira' && !isAdmin) {
        operadorPendente = operador;
        document.getElementById('modal_senha').style.display = 'flex';
        document.getElementById('senha_modal_input').value = '';
        document.getElementById('senha_modal_input').focus();
        
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
    prosseguirAtualizacaoOperador(operadorPendente);
}

document.getElementById('senha_modal_input')?.addEventListener('keypress', function(e) {
    if (e.key === 'Enter') confirmarSenha();
});

function aplicarOperador(operador) {
    document.querySelectorAll('.input-operador').forEach(input => input.value = operador);
    document.getElementById('box-novo-chamado').style.display = operador ? 'block' : 'none';
    document.querySelectorAll('.form-interacao').forEach(div => div.style.display = operador ? 'block' : 'none');

    const isAdmin = document.body.dataset.isAdmin === 'true';

    // Atualizado para incluir os botões de edição (.form-editar-comentario)
    document.querySelectorAll('.form-excluir-chamado, .form-excluir-anexo, .form-editar-comentario').forEach(elemento => {
        const autor = elemento.getAttribute('data-autor');
        elemento.style.display = (isAdmin || autor === operador) ? 'inline-block' : 'none';
    });
}

function abrirAba(status) {
    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));

    document.getElementById('aba-' + status.replace(' ', '-')).classList.add('active');
    event.currentTarget.classList.add('active');
}

// Funções para controle do formulário de edição
function mostrarFormEdicao(id) {
    document.getElementById('texto-comentario-' + id).style.display = 'none';
    document.getElementById('form-edicao-' + id).style.display = 'block';
}

function esconderFormEdicao(id) {
    document.getElementById('texto-comentario-' + id).style.display = 'block';
    document.getElementById('form-edicao-' + id).style.display = 'none';
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