<?php
// O fuso horário é necessário para a parte da cotação do dólar.
date_default_timezone_set('America/Sao_Paulo');

$salario = '';
$resultadoDizimo = '';
$resultadoOferta = '';

// Lógica para o cálculo do Dízimo e Oferta
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pega e converte o valor do salário do formulário
    $salario = floatval(str_replace(',', '.', $_POST['salario'] ?? ''));

    if ($salario > 0) {
        // Realiza os cálculos
        $dizimo = $salario * 0.10;
        $oferta = $salario * 0.05;

        // Formata os resultados para exibição
        $resultadoDizimo = number_format($dizimo, 2, ',', '.');
        $resultadoOferta = number_format($oferta, 2, ',', '.');

    } else {
        // Mensagem de erro se o valor não for válido
        $resultadoDizimo = 'Digite um valor válido.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora de Dízimo e Oferta - Cotação do Dólar</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>

<body>
    <main>
        <section class="dizimo-oferta">
            <h1>Calculadora de Dízimo e Oferta:</h1>
            <form method="POST" action="">
                <div class="input-group">
                    <input type="number" name="salario" id="salario" placeholder="Digite o salário aqui" step="0.01" value="<?= htmlspecialchars($salario) ?>">
                </div>

                <div class="buttons">
                    <input type="submit" value="Calcular no Servidor (PHP)">
                    <button type="button" onclick="calcularDizimo()">Calcular Dízimo (JS)</button>
                    <button type="button" onclick="calcularOferta()">Calcular Oferta (JS)</button>
                </div>
            </form>

            <section class="results">
                <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                    <p><strong>Dízimo (10%):</strong> R$ <?= $resultadoDizimo ?></p>
                    <?php if ($resultadoOferta): ?>
                        <p><strong>Oferta (5%):</strong> R$ <?= $resultadoOferta ?></p>
                    <?php endif; ?>
                <?php endif; ?>

                <p id="resultadoDizimo"></p>
                <p id="resultadoOferta"></p>
            </section>
        </section>

        <section class="conversor-moedas">
            <h1>Cotação do Dólar:</h1>
            <form action="" method="get">
                <input type="number" name="din" id="din" step="0.01" placeholder="Digite o valor para conversão em reais" required>
                <input type="submit" value="Converter">
            </form>

            <section class="results">
                <?php
                if (isset($_GET['din']) && $_GET['din'] !== ''):

                    // --- INÍCIO DA LÓGICA INTELIGENTE PARA ACHAR A ÚLTIMA COTAÇÃO ---

                    $dataAlvo = new DateTime();

                    if ((int)$dataAlvo->format('H') < 14) {
                        $dataAlvo->modify('-1 day');
                    }

                    while ($dataAlvo->format('N') >= 6) {
                        $dataAlvo->modify('-1 day');
                    }

                    $fim = $dataAlvo->format('m-d-Y');
                    $inicio = $fim;

                    // --- FIM DA LÓGICA INTELIGENTE ---

                    $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                    $response = @file_get_contents($url);

                    if ($response === FALSE) {
                        echo "<p><strong>Erro:</strong> Não foi possível conectar à API do Banco Central. Tente novamente mais tarde.</p>";
                    } else {
                        $dados = json_decode($response, true);

                        if (empty($dados['value'])) {
                            echo "<p><strong>Não foi possível obter a cotação.</strong> Pode ser um feriado. Tente novamente mais tarde.</p>";
                        } else {
                            $cotacao = $dados['value'][0]['cotacaoCompra'];
                            $real = floatval($_GET['din']);
                            $dolar = $real / $cotacao;

                            $padrao = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
                ?>

                            <p>Resultado: <em><?= numfmt_format_currency($padrao, $real, 'BRL') ?></em> equivalem a
                                <em><?= numfmt_format_currency($padrao, $dolar, 'USD') ?></em>.
                            </p>
                            <h6>*Cotação de compra referente ao último dia útil (<?= $dataAlvo->format('d/m/Y') ?>), obtida do Banco Central.</h6>

                <?php
                        }
                    }
                endif;
                ?>
            </section>
        </section>
    </main>

    <script src="script.js"></script>
</body>

</html>