<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercício PHP</title>
    <link rel="stylesheet" href="style.css?v=2">
</head>

<body>
    <?php
    $totalSegundos = $_REQUEST['seg'] ?? 0;
    ?>
    <main>
        <article>
            <header>
                <h2>Instruções</h2>
                <p>Este exercício tem como objetivo demonstrar o uso das superglobais do PHP, como $_GET, $_POST e $_REQUEST.</p>
                <p>Ao clicar no botão "Ir para superglobais.php", você será redirecionado para outra página onde os dados enviados pelo formulário serão processados e exibidos.</p>
                <p>Os parâmetros "nome" e "idade" são passados via URL (método GET), enquanto os campos "usu" e "sen" são enviados via formulário (método POST).</p>
                <p>Na página de destino, você poderá ver como acessar esses dados usando as superglobais correspondentes.</p>
            </header>
            <form action="superglobais.php?nome=Daniel&idade=33" method="post" target="_blank">
                <input type="text" name="usu" id="usu" placeholder="Usuário (não obrigatório, apenas como teste...)">
                <input type="password" name="sen" id="sen" placeholder="Senha (para testar a superglobal POST e REQUEST)">
                <input type="submit" value="Ir para superglobais.php">
            </form>
        </article>
        <article>
            <h1>Calculadora de Tempo</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="seg">Qual é o total de segundos?</label>
                <input type="number" name="seg" id="seg" min="0" step="1" required value="<?= $totalSegundos ?>">
                <input type="submit" name="calcular_tempo" value="Calcular">
                <?php
                // VERIFICAÇÃO: Este bloco só aparece se o formulário for enviado
                if (isset($_GET['calcular_tempo'])) {
                    $semanas = floor($totalSegundos / 604800);
                    $dias = floor(($totalSegundos % 604800) / 86400);
                    $horas = floor(($totalSegundos % 86400) / 3600);
                    $minutos = floor(($totalSegundos % 3600) / 60);
                    $segundos = $totalSegundos % 60;
                    $totalFormatado = number_format($totalSegundos, 0, ',', '.');
                    echo <<<HTML
                    <section>
                        <h3>Analisando o valor que você digitou:</h3>
                        <p><strong>$totalFormatado segundos</strong> equivalem a um total de:</p>
                        <ul>
                            <li>$semanas semanas</li>
                            <li>$dias dias</li>
                            <li>$horas horas</li>
                            <li>$minutos minutos</li>
                            <li>$segundos segundos</li>
                        </ul>
                    </section>
                    HTML;
                }
                ?>
            </form>
        </article>
    </main>
</body>

</html>