<?php
$host = 'localhost'; // Porta personalizada para o ambiente local
$dbname = 'helpdesk_logistica';
$user = 'root';
$pass = 'd92791215'; // Senha do seu ambiente local

try {
    $pdo = new PDO("mysql:host=localhost;port=3306;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>