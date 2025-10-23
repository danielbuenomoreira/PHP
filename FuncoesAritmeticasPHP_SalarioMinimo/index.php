<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Funções Aritméticas em PHP</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>

<body>
    <?php
    // 1. É PRECISO CRIAR O FORMATADOR PRIMEIRO
    $padrao = numfmt_create('pt_BR', NumberFormatter::CURRENCY);
    $salminimo = 1518;
    $salario = $_GET['sal'] ?? "";
    ?>
    <header>
        <h1>Funções aritméticas do PHP</h1>
    </header>
    <main>
        <article>
            <?php
            date_default_timezone_set('America/Sao_Paulo'); // Define o fuso horário
            print "<p>Hoje é dia " . date("d/m/Y") . "<br>";
            echo "Agora são " . date("H:i:s") . "</p>";

            $valor_absoluto = abs(-2000); // Retorna o valor absoluto
            print "<h3>O valor absoluto de -2000 é $valor_absoluto.</h3>";

            $convertor_bases = base_convert(254, 10, 8); // Converte o número 254 da base 10 para a base 8 <octal>
            print "<p><h3>O número 254 na base 8 (octal) é $convertor_bases.</h3>";
            $convertor_bases = base_convert(254, 10, 16); // Converte o número 254 da base 10 para a base 16 <hexadecimal>
            print "<h3>O número 254 na base 16 (hexadecimal) é $convertor_bases.</h3>";
            $convertor_bases = base_convert(254, 10, 2); // Converte o número 254 da base 10 para a base 2 <binário>
            print "<h3>O número 254 na base 2 (binário) é $convertor_bases.</h3><p>";

            $arredondamento_ceil = ceil(3.141592); // Arredonda para cima
            print "<p><h3>O arredondamento para cima de 3.141592 é $arredondamento_ceil.</h3>";
            $arredondamento_floor = floor(3.141592); // Arredonda para baixo
            print "<h3>O arredondamento para baixo de 3.141592 é $arredondamento_floor.</h3>";
            $arredondamento_round = round(3.141592); // Arredonda para o inteiro mais próximo
            print "<h3>O arredondamento de 3.141592 é $arredondamento_round.</h3>";
            $arredondamento_round2 = round(3.52); // Arredonda para o inteiro mais próximo
            print "<h3>O arredondamento de 3.52 é $arredondamento_round2.</h3></p>";

            $hipotenusa = hypot(3, 4); // Calcula a hipotenusa
            print "<p><h3>A hipotenusa de um triângulo retângulo com catetos 3 e 4 é $hipotenusa.</h3>";
            $divisao_inteira = intdiv(10, 3); // Realiza a divisão inteira
            print "<h3>A divisão inteira de 10 por 3 é $divisao_inteira.</h3>";
            $minimo = min(10, 20, 9, 40, 50); // Retorna o menor valor
            print "<h3>O menor valor entre 10, 20, 9, 40 e 50 é $minimo.</h3>";
            $maximo = max(10, 20, 9, 40, 50); // Retorna o maior valor
            print "<h3>O maior valor entre 10, 20, 9, 40 e 50 é $maximo.</h3><p>";

            $variavel_pi = pi(); // Retorna o valor de pi
            print "<p><h3>O valor da \$variavel_pi <span>pi()</span> é $variavel_pi.</h3>";
            $constante_pi = M_PI; // Retorna o valor de pi
            print "<h3>O valor da \$constante_pi <span>M_PI</span> é $constante_pi.</h3></p>";

            $potencia = pow(2, 3); // Calcula a potência
            print "<p><h3>O valor de 2 elevado a 3 é $potencia.</h3>";
            $raiz_quadrada = sqrt(16); // Calcula a raiz quadrada
            print "<h3>A raiz quadrada de 16 é $raiz_quadrada.</h3></p>";

            $seno = sin(45); // Calcula o seno
            print "<p><h3>O seno de 45 graus é $seno.</h3>";
            $cosseno = cos(45); // Calcula o cosseno
            print "<h3>O cosseno de 45 graus é $cosseno.</h3>";
            $tangente = tan(45); // Calcula a tangente
            print "<h3>A tangente de 45 graus é $tangente.</h3></p>";

            $seno_rad = sin(deg2rad(45)); // Converte graus para radianos e calcula o seno
            print "<p><h3>O seno de 45 graus (convertido para radianos) é $seno_rad.</h3>";
            $cosseno_rad = cos(deg2rad(45)); // Converte graus para radianos e calcula o cosseno
            print "<h3>O cosseno de 45 graus (convertido para radianos) é $cosseno_rad.</h3>";
            $tangente_rad = tan(deg2rad(45)); // Converte graus para radianos e calcula a tangente
            print "<h3>A tangente de 45 graus (convertido para radianos) é $tangente_rad.</h3></p>";
            ?>
        </article>
        <article>
            <h1>Informe seu salário:</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <input type="number" name="sal" id="sal" value="<?= $salario ?>" step="0.01" placeholder="Salário (R$)" required>
                <input type="submit" name="calc_sal" value="Calcular">
                <p>O valor do salário mínimo em 2025 é de <strong><?= numfmt_format_currency($padrao, $salminimo, "BRL") ?></strong>, válido a partir de 1º de janeiro de 2025, conforme Decreto nº 12.342, de 30 de dezembro de 2024. Esse valor representa um aumento de R$ 106 em relação a 2024, totalizando um reajuste de 7,5%. </p>
            </form>
        </article>
        <section>
            <?php
            if (isset($_GET['calc_sal'])) {
                // 1. Converta o salário (que vem como string) para float
                $salario_float = (float)$salario;

                // 2. Calcule o total de salários usando floor() (arredondar para baixo)
                // Esta é a maneira correta de encontrar a parte inteira da divisão de floats
                $total = floor($salario_float / $salminimo);

                // 3. Calcule o "resto" (a diferença) usando fmod()
                // Esta função é o "operador %" para floats
                $diferenca = fmod($salario_float, $salminimo);

                // Formata os valores para exibição
                // Use a $salario_float aqui para garantir a formatação correta
                $salario_formatado = numfmt_format_currency($padrao, $salario_float, "BRL");
                $diferenca_formatada = numfmt_format_currency($padrao, $diferenca, "BRL");

                echo "<h2>Resultado final:</h2>
              <p>Quem recebe um salário de $salario_formatado ganha <strong>$total salário(s) mínimo(s)</strong> + $diferenca_formatada.</p>";
            }
            ?>
        </section>
    </main>
</body>

</html>