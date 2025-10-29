<?php
// Sempre iniciar a sessão e incluir a conexão
session_start();
require_once 'conexao.php';

// Prepara a resposta como JSON
header('Content-Type: application/json');

// Array que será convertido em JSON no final
$resposta = [
    'status' => 'erro',
    'mensagem' => 'Ação inválida.'
];

// Se o utilizador não está logado, não pode processar nada.
if (!isset($_SESSION['id_usuario']) && $_REQUEST['acao'] !== 'sair') {
    $resposta['mensagem'] = 'Utilizador não autenticado.';
    echo json_encode($resposta);
    exit;
}

$id_usuario_atual = $_SESSION['id_usuario'] ?? null;
$acao = $_REQUEST['acao'] ?? null;

// Decide o que fazer com base na ação
switch ($acao) {

    case 'adicionar':
        if (isset($_POST['descricao_tarefa']) && !empty(trim($_POST['descricao_tarefa']))) {
            $descricao = trim($_POST['descricao_tarefa']);
            
            $stmt = $conexao->prepare("INSERT INTO tarefas (descricao, id_usuario) VALUES (?, ?)");
            $stmt->bind_param("si", $descricao, $id_usuario_atual);
            
            if ($stmt->execute()) {
                $resposta['status'] = 'sucesso';
                $resposta['mensagem'] = 'Tarefa adicionada!';
                // Retorna os dados da nova tarefa para o JS poder adicioná-la à lista
                $resposta['nova_tarefa'] = [
                    'id' => $conexao->insert_id,
                    'descricao' => $descricao
                ];
            } else {
                $resposta['mensagem'] = 'Erro ao adicionar tarefa.';
            }
            $stmt->close();
        } else {
            $resposta['mensagem'] = 'Descrição da tarefa não pode ser vazia.';
        }
        break;

    case 'remover':
        if (isset($_GET['id'])) {
            $id_tarefa = (int)$_GET['id'];
            
            $stmt = $conexao->prepare("DELETE FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
            $stmt->bind_param("ii", $id_tarefa, $id_usuario_atual);
            
            if ($stmt->execute()) {
                $resposta['status'] = 'sucesso';
                $resposta['mensagem'] = 'Tarefa removida.';
            } else {
                $resposta['mensagem'] = 'Erro ao remover tarefa.';
            }
            $stmt->close();
        }
        break;

    case 'concluir':
        if (isset($_GET['id'])) {
            $id_tarefa = (int)$_GET['id'];
            
            // 1. Descobrir o estado atual
            $stmt_select = $conexao->prepare("SELECT concluida FROM tarefas WHERE id_tarefa = ? AND id_usuario = ?");
            $stmt_select->bind_param("ii", $id_tarefa, $id_usuario_atual);
            $stmt_select->execute();
            $resultado = $stmt_select->get_result();

            if ($resultado->num_rows == 1) {
                $tarefa = $resultado->fetch_assoc();
                $novo_estado = $tarefa['concluida'] == 0 ? 1 : 0;
                
                // 3. Atualizar
                $stmt_update = $conexao->prepare("UPDATE tarefas SET concluida = ? WHERE id_tarefa = ? AND id_usuario = ?");
                $stmt_update->bind_param("iii", $novo_estado, $id_tarefa, $id_usuario_atual);
                
                if ($stmt_update->execute()) {
                    $resposta['status'] = 'sucesso';
                    $resposta['mensagem'] = 'Estado da tarefa atualizado.';
                    $resposta['novo_estado'] = $novo_estado; // 1 (concluída) ou 0 (não)
                } else {
                    $resposta['mensagem'] = 'Erro ao atualizar tarefa.';
                }
                $stmt_update->close();
            }
            $stmt_select->close();
        }
        break;

    case 'sair':
        session_destroy();
        // Sair é a única ação que redireciona
        header('Location: index.php');
        exit;
}

// Fecha a conexão
$conexao->close();

// Envia a resposta JSON para o JavaScript
echo json_encode($resposta);
exit;
?>