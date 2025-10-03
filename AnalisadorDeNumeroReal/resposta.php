<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desafio PHP</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>
    <main>
        <h1>Analisador de Número Real</h1>
        <?php
            $nu = $_POST["num"] ?? 0;

            echo "<p>Analisando o número <strong>" . number_format($nu, 3, ",", ".") . "</strong> informado pelo usuário:</p>";

            $intnu = (int)$nu;
            $franu = $nu - $intnu;

            $ant = $intnu - 1;
            $suc = $intnu + 1;
            echo "<ul><li>A <em>parte inteira</em> do número é <strong>". number_format($intnu, 0, ",", ".") ."</strong>;</li>
            <li>O seu <em>antecessor</em> é <strong>$ant</strong>;</li>
            <li>O seu <em>sucessor</em> é <strong>$suc</strong>;</li>
            <li>A <em>parte fracionária</em> do número é <strong>". number_format($franu, 3, ",", ".") ."</strong>;</li>
            <li>O seu <em>dobro</em> é <strong>". number_format(($nu * 2), 3, ",", ".") ."</strong>.</li>
            </ul>";
        ?>
        <button onclick="javascript:history.go(-1)">&#x2B05; Voltar</button>
    </main>
</body>
</html>