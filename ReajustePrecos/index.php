<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reajuste de Preços</title>
</head>

<body>
    <?php
    $preco = $_REQUEST['preco'] ?? 0;
    $reaj = $_REQUEST['reaj'] ?? 0;
    $formatador_brl = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
    ?>
    <main>
        <article>
            <h1>Reajustador de Preços</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="preco">Preço do produto (R$)</label>
                <input type="number" name="preco" id="preco" min="0.01" step="0.01" value="<?= $preco ?>">

                <label for="reaj">Qual será o percentual de reajuste? (<strong><span id="porc">?</span>%</strong>)</label>
                <input type="range" name="reaj" id="reaj" min="0" max="200" step="1" oninput="mudaValor()" value="<?= $reaj ?>">

                <input type="submit" name="reajustar" value="Reajustar">
            </form>
            <?php
            if (isset($_GET['reajustar'])) {
                $aumento = $preco + ($preco * $reaj / 100);

                $preco_formatado = $formatador_brl->format($preco);
                $aumento_formatado = $formatador_brl->format($aumento);

                echo <<<HTML
                <section>
                    <h2>Resultado do reajuste</h2>
                    <p>
                        O produto que custava $preco_formatado, com <strong>$reaj% de aumento</strong> vai passar a custar <strong>$aumento_formatado</strong> a partir de agora.
                    </p>
                </section>
                HTML;
            }
            ?>
        </article>
    </main>
    <script>
        mudaValor();

        function mudaValor() {
            porc.innerText = reaj.value;
        }
    </script>
</body>

</html>