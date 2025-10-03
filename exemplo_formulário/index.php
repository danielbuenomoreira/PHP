<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interação com Formulários</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    // Capturando os dados do formulário retroalimentado
    // Esses valores só existirão de fato quando o formulário for enviado
    $valor1 = $_GET['v1'] ?? "";
    $valor2 = $_GET['v2'] ?? "";
    $nome = $_GET['nome'] ?? "";
    $sobrenome = $_GET['sobrenome'] ?? "";
    ?>
    <main>
        <article>
            <h2>Digite seu nome:</h2>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <input type="text" name="nome" id="nome" value="<?= $nome ?>" placeholder="Nome" required>
                <input type="text" name="sobrenome" id="sobrenome" value="<?= $sobrenome ?>" placeholder="Sobrenome" required>
                <input type="submit" name="enviar_nome" value="Enviar">
            </form>

            <?php
            // VERIFICAÇÃO: Este bloco só aparece se o formulário de nome for enviado
            if (isset($_GET['enviar_nome']) && !empty($nome)) {
                echo "<section>";
                echo "<h2>Resultado</h2>";
                echo "<p>É um prazer te conhecer, <strong>$nome $sobrenome</strong>!<br>
                Este é meu site!</p>";
                echo "</section>";
            }
            ?>
        </article>

        <article>
            <div style="display: flex; align-items: baseline; gap: 8px;">
                <h2>Soma: </h2>
                <h5><em>(pode ter casas decimais)</em></h5>
            </div>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <input type="number" name="v1" id="v1" value="<?= $valor1 ?>" placeholder="Valor 1" step="any" required>
                <input type="number" name="v2" id="v2" value="<?= $valor2 ?>" placeholder="Valor 2" step="any" required>
                <input type="submit" name="somar_valores" value="Somar">
            </form>

            <?php
            // VERIFICAÇÃO: Este bloco só aparece se o formulário de soma for enviado
            if (isset($_GET['somar_valores'])) {
                echo "<section>";
                echo "<h2>Resultado</h2>";

                $soma = $valor1 + $valor2;
                // Lógica para determinar as casas decimais dinamicamente
                $casas_decimais = 0;
                if (floor($soma) != $soma) {
                    $casas_decimais = strlen(substr(strrchr((string)$soma, '.'), 1));
                }
                $casas_decimais_valor1 = 0;
                if (floor($valor1) != $valor1) {
                    $casas_decimais_valor1 = strlen(substr(strrchr((string)$valor1, '.'), 1));
                }
                $casas_decimais_valor2 = 0;
                if (floor($valor2) != $valor2) {
                    $casas_decimais_valor2 = strlen(substr(strrchr((string)$valor2, '.'), 1));
                }

                // Formata o número com a quantidade correta de casas decimais
                $soma_formatada = number_format($soma, $casas_decimais, ",", ".");
                $valor1_formatada = number_format($valor1, $casas_decimais_valor1, ",", ".");
                $valor2_formatada = number_format($valor2, $casas_decimais_valor2, ",", ".");

                print "<p>A soma entre os valores $valor1_formatada e $valor2_formatada é igual a <strong>$soma_formatada</strong>.</p>";
                echo "</section>";
            }
            ?>
        </article>
    </main>
</body>

</html>