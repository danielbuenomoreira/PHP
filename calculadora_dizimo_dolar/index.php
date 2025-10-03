<?php
date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário

$salario = '';
$resultadoDizimo = '';
$resultadoOferta = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $salario = floatval(str_replace(',', '.', $_POST['salario'] ?? ''));

    if ($salario > 0) {
        $dizimo = $salario * 0.10;
        $oferta = $salario * 0.05;

        $resultadoDizimo = number_format($dizimo, 2, ',', '.');
        $resultadoOferta = number_format($oferta, 2, ',', '.');

        // Monta a linha para salvar
        $data = date('d/m/Y H:i:s');
        $linha = "$data | Salário: R$ " . number_format($salario, 2, ',', '.') . " | Dízimo: R$ $resultadoDizimo | Oferta: R$ $resultadoOferta\n";

        // Salva no arquivo
        file_put_contents('historico_dizimo.txt', $linha, FILE_APPEND);
    } else {
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
        <!-- Seção do Dízimo e Oferta -->
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

        <!-- Seção do Conversor de Moedas -->
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

                    // Define o fuso horário correto para não haver erros de data
                    date_default_timezone_set('America/Sao_Paulo');

                    // Pega a data de hoje como ponto de partida
                    $dataAlvo = new DateTime();

                    // 1. VERIFICA A HORA: Se for antes das 14h, a cotação do dia ainda não saiu.
                    //    Então, nosso ponto de partida para a busca será ontem.
                    if ((int)$dataAlvo->format('H') < 14) {
                        $dataAlvo->modify('-1 day');
                    }

                    // 2. VERIFICA FIM DE SEMANA: Se a data for um sábado (6) ou domingo (7),
                    //    volta no tempo até encontrar um dia de semana.
                    //    O formato 'N' retorna 1 para segunda-feira e 7 para domingo.
                    while ($dataAlvo->format('N') >= 6) {
                        $dataAlvo->modify('-1 day');
                    }

                    // Neste ponto, $dataAlvo contém a data do último dia útil com cotação publicada.
                    $fim = $dataAlvo->format('m-d-Y');

                    // A data de início pode ser a mesma da final, pois só queremos a última cotação.
                    $inicio = $fim;

                    // --- FIM DA LÓGICA INTELIGENTE ---

                    // Agora, montamos a URL com a certeza de que estamos pedindo por um dia que tem dados
                    $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\'' . $inicio . '\'&@dataFinalCotacao=\'' . $fim . '\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

                    $response = @file_get_contents($url);

                    if ($response === FALSE) {
                        echo "<p><strong>Erro:</strong> Não foi possível conectar à API do Banco Central. Tente novamente mais tarde.</p>";
                    } else {
                        $dados = json_decode($response, true);

                        if (empty($dados['value'])) {
                            // Esta mensagem agora só apareceria em caso de um feriado, o que podemos refinar depois se quiser
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