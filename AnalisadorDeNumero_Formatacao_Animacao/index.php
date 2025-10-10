<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analisador de Número Real</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>

<body>
    <?php
    $nu = $_POST["num"] ?? "";
    ?>
    <main>
        <article>
            <h1>Analisador de Número Real</h1>
            <h2>Informe um número real:</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="number" name="num" id="num" step="0.001" placeholder="Máximo de 3 casas decimais" value="<?= $nu ?>" required>
                <input type="submit" name="enviar_num" value="Calcular">
            </form>
            <?php
            // VERIFICAÇÃO: Este bloco só aparece se o formulário de nome for enviado
            if (isset($_POST['enviar_num']) && !empty($nu)) {

                $intnu = (int)$nu;
                $franu = $nu - $intnu;
                $ant = $intnu - 1;
                $suc = $intnu + 1;
                $rqnu = sqrt($nu);
                $rcnu = pow($nu, (1 / 3));
                $nu_dobro = $nu * 2;

                $nu_decimais = 0;
                if (floor($nu) != $nu) {
                    $nu_decimais = strlen(substr(strrchr((string)$nu, '.'), 1));
                }
                $nu_formatada = number_format($nu, $nu_decimais, ",", ".");

                $nu_dobro_decimais = 0;
                if (floor($nu_dobro) != $nu_dobro) {
                    $nu_dobro_decimais = strlen(substr(strrchr((string)$nu_dobro, '.'), 1));
                }
                $nu_dobro_formatado = number_format($nu_dobro, $nu_dobro_decimais, ",", ".");

                echo "<section>";
                echo "<p>Analisando o número <strong>$nu_formatada</strong> informado pelo usuário:</p>";
                echo "<ul>
                <li>A <em>parte inteira</em> do número é <strong>" . number_format($intnu, 0, ",", ".") . "</strong>;</li>
                <li>O seu <em>antecessor</em> é <strong>$ant</strong>;</li>
                <li>O seu <em>sucessor</em> é <strong>$suc</strong>;</li>
                <li>A sua <em>raiz quadrada</em> é <strong>" . number_format($rqnu, 4, ",", ".") . "</strong>;</li>
                <li>A sua <em>raiz cúbica</em> é <strong>" . number_format($rcnu, 4, ",", ".") . "</strong>;</li>
                <li>A <em>parte fracionária</em> do número é <strong>" . number_format($franu, 3, ",", ".") . "</strong>;</li>
                <li>O seu <em>dobro</em> é <strong>$nu_dobro_formatado</strong>.</li>
                </ul>";
                echo "</section>";
            }
            ?>
        </article>
    </main>
    <div id="wrapper">
        <div class="glass"></div>
        <div class="glass"></div>
        <div class="glass"></div>
        <div class="glass"></div>
    </div>
</body>

</html>