<?php
// Inicia a sessão para guardar quem é o utilizador
session_start();

// Inclui o ficheiro de conexão
require_once 'conexao.php';

// Verifica se o formulário de nome foi enviado
if (isset($_POST['nome_usuario']) && !empty(trim($_POST['nome_usuario']))) {

    $nome_usuario = trim($_POST['nome_usuario']);

    // Usamos prepared statements para segurança (evitar SQL Injection)
    // 1. Verificar se o utilizador já existe
    $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome_usuario); // "s" = string
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        // Utilizador encontrado, pega o ID
        $usuario = $resultado->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
    } else {
        // Utilizador não encontrado, cria um novo
        $stmt_insert = $conexao->prepare("INSERT INTO usuarios (nome) VALUES (?)");
        $stmt_insert->bind_param("s", $nome_usuario);
        $stmt_insert->execute();

        // Pega o ID do utilizador que acabamos de criar
        $_SESSION['id_usuario'] = $stmt_insert->insert_id;
        $stmt_insert->close();
    }

    // Guarda também o nome na sessão
    $_SESSION['nome_usuario'] = $nome_usuario;

    $stmt->close();

    // Redireciona para a própria página para limpar o POST
    header("Location: index.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de tarefas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <?php
        // Verifica se o utilizador já "entrou" (tem sessão ativa)
        if (isset($_SESSION['id_usuario'])):
        ?>

            <h2>Lista de <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></h2>

            <form action="processar.php" method="POST" class="form-tarefa">
                <input type="text" name="descricao_tarefa" placeholder="Adicione nova tarefa..." required>
                <input type="hidden" name="acao" value="adicionar">
                <button type="submit">Adicionar</button>
            </form>

            <ul id="ListaTarefas">
                <?php
                $id_usuario_atual = $_SESSION['id_usuario'];

                // Busca as tarefas do utilizador atual, ordenadas (não concluídas primeiro)
                $sql = "SELECT id_tarefa, descricao, concluida FROM tarefas 
                        WHERE id_usuario = ? 
                        ORDER BY concluida ASC, id_tarefa DESC";

                $stmt_tarefas = $conexao->prepare($sql);
                $stmt_tarefas->bind_param("i", $id_usuario_atual); // "i" = integer
                $stmt_tarefas->execute();
                $resultado_tarefas = $stmt_tarefas->get_result();

                if ($resultado_tarefas->num_rows > 0) {
                    // Loop para exibir cada tarefa
                    while ($tarefa = $resultado_tarefas->fetch_assoc()) {

                        // Define a classe CSS se a tarefa estiver concluída
                        $classe_concluida = $tarefa['concluida'] == 1 ? 'done' : '';

                        // Exibe o item da lista (<li>)
                        echo "<li class='{$classe_concluida}'>";

                        // Link para CONCLUIR/DESMARCAR tarefa
                        // Aponta para processar.php
                        echo "<a href='processar.php?acao=concluir&id={$tarefa['id_tarefa']}' class='link-tarefa'>";
                        echo htmlspecialchars($tarefa['descricao']);
                        echo "</a>";

                        // Link para REMOVER tarefa (o 'X')
                        // Aponta para processar.php
                        echo "<a href='processar.php?acao=remover&id={$tarefa['id_tarefa']}' class='link-remover'>&#x2716;</a>";

                        echo "</li>";
                    }
                } else {
                    // Mensagem se não houver tarefas
                    echo "<li class='info'>Nenhuma tarefa na lista.</li>";
                }
                $stmt_tarefas->close();
                ?>
            </ul>

            <a href="processar.php?acao=sair" class="link-sair">Trocar de utilizador</a>

        <?php
        else:
        ?>

            <h2>Quem é você?</h2>
            <form action="index.php" method="POST" class="form-login">
                <input type="text" name="nome_usuario" placeholder="Digite seu nome..." required>
                <button type="submit">Entrar</button>
            </form>

        <?php
        endif; // Fim da verificação de sessão
        ?>
    </main>

    <?php
    // Fecha a conexão com o banco de dados no final da página
    $conexao->close();
    ?>
</body>

</html>