<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
    <title>Reajuste de Preços</title>
</head>

<body>
    <?php
    $preco = $_GET['preco'] ?? 0;
    $reaj = $_GET['reaj'] ?? 0;
    $formatador_brl = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
    $saque = $_POST['saque'] ?? 0;
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
        <article>
            <h1>Caixa Eletrônico</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                <label for="saque">Qual valor você deseja sacar? (R$)<sup>*</sup></label>
                <input type="number" name="saque" id="saque" step="1" value="<?= $saque ?>" required>
                <p style="font-size: 0.7em;"><sup>*</sup>Notas disponíveis: R$100, R$50, R$20, R$10, R$5, R$2 e moedas de R$1</p>

                <input type="submit" name="sacar" value="Sacar">
            </form>
            <?php
            if (isset($_POST['sacar'])) {

                $resto = $saque;

                // 1. Define as notas disponíveis (da maior para a menor)
                $notas = [100, 50, 20, 10, 5, 2, 1];

                // 2. Cria um array para guardar os totais de cada nota
                $totais = [];

                // 3. Loop!
                foreach ($notas as $nota) {
                    // Calcula quantas notas cabem no resto atual
                    $totais[$nota] = floor($resto / $nota);

                    // Atualiza o resto (o que sobrou)
                    $resto %= $nota;
                }

                // 4. Formata o saque para exibição
                $saqueFormatado = $formatador_brl->format($saque);

                echo <<<HTML
                <section>
                    <h2>Saque de $saqueFormatado realizado</h2>
                    <p>O caixa eletrônico vai te entregar os seguintes valores:</p>
                    <ul class="nota">
                        <li><img src="imagens/100-reais.jpg" alt="Nota de 100 reais"> x {$totais[100]}</li>
                        <li><img src="imagens/50-reais.jpg" alt="Nota de 50 reais"> x {$totais[50]}</li>
                        <li><img src="imagens/20-reais.jpg" alt="Nota de 20 reais"> x {$totais[20]}</li>
                        <li><img src="imagens/10-reais.jpg" alt="Nota de 10 reais"> x {$totais[10]}</li>
                        <li><img src="imagens/5-reais.jpg" alt="Nota de 5 reais"> x {$totais[5]}</li>
                        <li><img src="imagens/2-reais.jpg" alt="Nota de 2 reais"> x {$totais[2]}</li>
                        <li><img src="imagens/1-real.png" alt="Moeda de 1 real" class="real"> x {$totais[1]}</li>
                    </ul>
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