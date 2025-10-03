<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisador de Número Real</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>
    <main>
        <h1>Analisador de Número Real</h1>
        <h2>Informe um número real:</h2>
        <form action="resposta.php" method="post">
            <input type="number" name="num" id="num" step="0.001" placeholder="Máximo de 3 casas decimais" required>
            <input type="submit" value="Calcular">
        </form>
    </main>
</body>
</html>