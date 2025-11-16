<?php
/*
 * Ficheiro de Conexão com o BANCO LOCAL (WAMP)
 */

$servidor = "localhost";    
$usuario_db = "root";       // O seu nome de utilizador do MySQL
$senha_db = "";             // A sua senha do MySQL (em branco por padrão no WAMP)
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