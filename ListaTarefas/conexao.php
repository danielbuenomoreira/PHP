<?php

$servidor = "localhost:3306";    // O servidor onde o MySQL está
$usuario_db = "root";       // O nome de utilizador do MySQL
$senha_db = "";             // A senha do MySQL
$banco = "lista_tarefas_db"; // O nome do banco de dados

// Criar a conexão
$conexao = new mysqli($servidor, $usuario_db, $senha_db, $banco);

// Definir o charset para UTF-8 para evitar problemas com acentos
$conexao->set_charset("utf8mb4");

// Verificar se a conexão falhou
if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

// Se chegou até aqui, a conexão foi bem-sucedida.
?>