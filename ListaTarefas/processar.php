<?php
// Sempre iniciar a sessão e incluir a conexão
session_start();
require_once 'conexao.php';

// VERIFICAÇÃO DE SEGURANÇA:
// Se o utilizador não está logado, não pode processar nada.
// (Exceto a ação 'sair', que não precisa de id_usuario)
if (!isset($_SESSION['id_usuario']) && $_GET['acao'] !== 'sair') {
    // Redireciona para o login se tentar fazer algo sem estar logado
    header('Location: index.php');
    exit;
}

// Pega o ID do utilizador da sessão (se ele estiver logado)
$id_usuario_atual = $_SESSION['id_usuario'] ?? null;

// Pega a ação (funciona para POST do 'adicionar' e GET do 'remover'/'concluir')
$acao = $_REQUEST['acao'] ?? null;

// Decide o que fazer com base na ação
switch ($acao) {

    case 'adicionar':
        // Ação de ADICIONAR TAREFA (vem do formulário POST)
        if (isset($_POST['descricao_tarefa']) && !empty(trim($_POST['descricao_tarefa']))) {
            
            $descricao = trim($_POST['descricao_tarefa']);
            
            $stmt = $conexao->prepare("INSERT INTO tarefas (descricao, id_usuario) VALUES (?, ?)");
            $stmt->bind_param("si", $descricao, $id_usuario_atual);
            $stmt->execute();
            $stmt->close();
        }
        break;

    case 'remover':
        // Ação de REMOVER TAREFA (vem do link GET)
        if (isset($_GET['id'])) {
            $id_tarefa = (int)$_GET['id']; // Converte para inteiro por segurança
            
            // Query de segurança: só apaga se a tarefa (id_tarefa) 
            // pertencer ao utilizador logado (id_usuario_atual)
            $stmt = $conexao->prepare("DELETE FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
            $stmt->bind_param("ii", $id_tarefa, $id_usuario_atual);
            $stmt->execute();
            $stmt->close();
        }
        break;

    case 'concluir':
        // Ação de CONCLUIR/DESMARCAR TAREFA (vem do link GET)
        if (isset($_GET['id'])) {
            $id_tarefa = (int)$_GET['id'];
            
            // 1. Descobrir o estado atual da tarefa (só podemos alterar tarefas do user logado)
            $stmt_select = $conexao->prepare("SELECT concluida FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
            $stmt_select->bind_param("ii", $id_tarefa, $id_usuario_atual);
            $stmt_select->execute();
            $resultado = $stmt_select->get_result();

            if ($resultado->num_rows == 1) {
                $tarefa = $resultado->fetch_assoc();
                
                // 2. Inverter o estado (se era 0 vira 1, se era 1 vira 0)
                $novo_estado = $tarefa['concluida'] == 0 ? 1 : 0;
                
                // 3. Atualizar o banco com o novo estado
                $stmt_update = $conexao->prepare("UPDATE tarefas SET concluida = ? WHERE id_tarefa = ? AND id_usuario = ?");
                $stmt_update->bind_param("iii", $novo_estado, $id_tarefa, $id_usuario_atual);
                $stmt_update->execute();
                $stmt_update->close();
            }
            $stmt_select->close();
        }
        break;

    case 'sair':
        // Ação de SAIR (trocar de utilizador)
        session_destroy(); // Destrói todos os dados da sessão
        break;
}

// Fecha a conexão
$conexao->close();

// Após qualquer ação, redireciona o utilizador de volta para a página principal
header('Location: index.php');
exit; // Termina o script
?>