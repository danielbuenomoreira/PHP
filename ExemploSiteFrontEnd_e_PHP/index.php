<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de site</title>
    <link rel="stylesheet" href="styles.css">
    <script defer src="script.js"></script>
</head>

<body>
    <header>
        <h1>Este é um exemplo de site utilizando HTML, CSS, JavaScript e PHP.</h1>
    </header>
    <main>
        <p>Este botão é feito com JavaScript:</p>
        <button onclick="ativarEasterEgg()">Clique Aqui <del>SURPRESA!</del></button>
        <audio id="easter-egg-player" src="wakemeup.mp3" controls></audio><br>
        <h1>Dados do Servidor (feito em PHP):</h1>
        <?php
        phpinfo(); // Exibe informações sobre a configuração do PHP
        ?>
    </main>
    <footer>
        <p>&copy; 2025 - Daniel Moreira</p>
    </footer>
</body>

</html>