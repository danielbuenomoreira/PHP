<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sorteador e tags pouco usadas em HTML</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>
    <header>
    <h1>Tags pouco usadas em HTML</h1>
    <h4>Mas aproveitando e misturando exercício de PHP</h4><br>
    </header>
    <main>
        <h2>Trabalhando com números aleatórios</h2>
        <?php
        $min = 0;
        $max = 100;
        $num = mt_rand($min, $max);
        echo "<p>Gerando um número aleatório entre $min e $max... <br>
        O valor gerado foi <strong>$num</strong>.</p>";
        // Verifica se o número é par ou ímpar
        if ($num % 2 == 0) {
            echo "<p>O número $num é par.</p>";
        } else {
            echo "<p>O número $num é ímpar.</p>";
        }
        ?>
        <button onclick="javascript:document.location.reload()">&#x1f504 Gerar outro</button>
    </main>
    <!-- Navegador -->
    <label for="browser">Escolha seu navegador na lista:</label>
    <input list="browsers" name="browser" id="browser">
    <datalist id="browsers">
        <option value="Chrome">
        <option value="Firefox">
        <option value="Internet Explorer">
        <option value="Opera">
        <option value="Safari">
    </datalist><br>

    <!-- Barra de progresso -->
    <label for="file">Progresso do download:</label>
    <progress id="file" value="32" max="100">32%</progress><br>

    <!-- Medidores -->
    <label for="disk_c">Uso do disco C:</label>
    <meter id="disk_c" value="2" min="0" max="10">2 de 10</meter><br>

    <label for="disk_d">Uso do disco D:</label>
    <meter id="disk_d" value="0.6">60%</meter><br>

    <!-- Detalhes -->
    <details>
        <summary>Detalhes</summary>
        <p>Informações adicionais.</p>
    </details><br>

    <details>
        <summary>Lista de linguagens</summary>
        <dl>
            <dt>Linguagens</dt>
            <dd>JavaScript</dd>
            <dd>Python</dd>
            <dd>PHP</dd>
        </dl>
    </details><br>

    <!-- Tabela -->
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Nascimento</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Daniel</td>
                <td>Moreira</td>
                <td>1992</td>
            </tr>
            <tr>
                <td>Noé</td>
                <td>Moreira</td>
                <td>2013</td>
            </tr>
        </tbody>
    </table>
</body>
</html>