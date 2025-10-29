<?php
session_start();
require_once 'conexao.php';
// (A lógica de login/verificação do $_POST['nome_usuario'])
if (isset($_POST['nome_usuario']) && !empty(trim($_POST['nome_usuario']))) {
    
    $nome_usuario = trim($_POST['nome_usuario']);

    $stmt = $conexao->prepare("SELECT id_usuario FROM usuarios WHERE nome = ?");
    $stmt->bind_param("s", $nome_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        
    } else {
        $stmt_insert = $conexao->prepare("INSERT INTO usuarios (nome) VALUES (?)");
        $stmt_insert->bind_param("s", $nome_usuario);
        $stmt_insert->execute();
        $_SESSION['id_usuario'] = $stmt_insert->insert_id;
        $stmt_insert->close();
    }
    
    $_SESSION['nome_usuario'] = $nome_usuario;
    $stmt->close();
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
        if (isset($_SESSION['id_usuario'])): 
        ?>
            <h2>Lista de <?php echo htmlspecialchars($_SESSION['nome_usuario']); ?></h2>
            
            <form action="processar.php" method="POST" class="form-tarefa" id="formAdicionar">
                <input type="text" 
                       name="descricao_tarefa" 
                       id="inputTarefa" 
                       placeholder="Adicione nova tarefa..." required>
                <input type="hidden" name="acao" value="adicionar">
                <button type="submit">Adicionar</button>
            </form>

            <ul id="ListaTarefas">
                <?php
                // --- LÓGICA PARA MOSTRAR AS TAREFAS ---
                $id_usuario_atual = $_SESSION['id_usuario'];
                $sql = "SELECT id_tarefa, descricao, concluida FROM tarefas 
                        WHERE id_usuario = ? 
                        ORDER BY concluida ASC, id_tarefa DESC";
                
                $stmt_tarefas = $conexao->prepare($sql);
                $stmt_tarefas->bind_param("i", $id_usuario_atual);
                $stmt_tarefas->execute();
                $resultado_tarefas = $stmt_tarefas->get_result();

                if ($resultado_tarefas->num_rows > 0) {
                    while ($tarefa = $resultado_tarefas->fetch_assoc()) {
                        $classe_concluida = $tarefa['concluida'] == 1 ? 'done' : '';
                        
                        echo "<li class='{$classe_concluida}'>";
                        echo "<a href='processar.php?acao=concluir&id={$tarefa['id_tarefa']}' class='link-tarefa'>";
                        echo htmlspecialchars($tarefa['descricao']);
                        echo "</a>";
                        echo "<a href='processar.php?acao=remover&id={$tarefa['id_tarefa']}' class='link-remover'>&#x2716;</a>";
                        echo "</li>";
                    }
                } else {
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
        endif; 
        ?>
    </main>

    <?php
    $conexao->close();
    ?>
    
    <script src="app.js" defer></script>
</body>
</html>