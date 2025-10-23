<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos primitivos em PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <main>
        <article>
            <h1>Teste de tipos primitivos</h1>
            <?php
            // 0x = hexadecimal -- 0b = binário -- 0 ou 0o= octal -- 0d = decimal
            $num = 300;
            print "<p>O valor da variável num1(300 - decimal) é $num e o var_dump dele é: ";
            var_dump($num);

            $num2 = 0x1A;
            print "<hr></p><p>O valor da variável num2(0x1A - hexadecimal) é $num2 e o var_dump dele é: ";
            var_dump($num2);

            $num3 = 0b101010;
            print "<hr></p><p>O valor da variável num3(0b101010 - binário) é $num3 e o var_dump dele é: ";
            var_dump($num3);

            $num4 = 0o456;
            print "<hr></p><p>O valor da variável num4(0o456 - octal) é $num4 e o var_dump dele é: ";
            var_dump($num4);

            $num5 = 3e2; // 3 * 10^2 = 300
            print "<hr></p><p>O valor da variável num5(3e2 - notação científica) é $num5 e o var_dump dele é: ";
            var_dump($num5);

            $num6 = (int) 3e2; // converte 3e2 para inteiro
            print "<hr></p><p>O valor da variável num6(3e2 - notação científica) é $num6 e o var_dump dele é: ";
            var_dump($num6);
            echo ",<br>pois digitei a variável num6 = (int) 3e2, 'forçando' a variável virar int (número inteiro).<hr></p>";

            $nome = "Daniel Moreira";
            print "<p>O valor da variável nome é $nome e o var_dump dele é: ";
            var_dump($nome);
            echo "<hr></p>";

            $vet = [6, 2.5, "Maria", false, true, null];

            // Função para converter valores false e null para uma representação mais explícita
            function formatArray($array)
            {
                return array_map(function ($item) {
                    if ($item === false) {
                        return "false<br>"; // Transformar false em string "false"
                    }
                    if ($item === true) {
                        return "true<br>"; // Transformar true em string "true"
                    }
                    if ($item === null) {
                        return "null"; // Transformar null em string "null"
                    }
                    return $item . "<br>"; // Deixar os outros valores como estão
                }, $array);
            }

            $formattedVet = formatArray($vet);

            echo "<p>O valor da variável vet é<br>" . print_r($formattedVet, true) . "<br>e o var_dump dele é:<br>";
            var_dump($vet);
            echo "</p>";

            // Cálculo das Médias:
            $valor1 = $_GET['v1'] ?? "";
            $peso1 = $_GET['p1'] ?? 1;
            $valor2 = $_GET['v2'] ?? "";
            $peso2 = $_GET['p2'] ?? 1;

            ?>
        </article>
        <article>
            <h1>Médias Aritméticas</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="v1">1º Valor:</label>
                <input type="number" name="v1" id="v1" required value="<?=$valor1?>">
                <label for="p1">Peso do 1º Valor:</label>
                <input type="number" name="p1" id="p1" min="1" required value="<?=$peso1?>">
                <label for="v2">2º Valor:</label>
                <input type="number" name="v2" id="v2" required value="<?=$valor2?>">
                <label for="p2">Peso do 2º Valor:</label>
                <input type="number" name="p2" id="p2" min="1" required value="<?=$peso2?>">
                <input type="submit" name="calcular_medias" value="Calcular Médias">
            </form>
            <?php
            // VERIFICAÇÃO: Este bloco só aparece se o formulário de soma for enviado
            if (isset($_GET['calcular_medias'])) {
                $ma = ($valor1 + $valor2) / 2;
                $mp = ($valor1 * $peso1 + $valor2 * $peso2)/($peso1 + $peso2);

                echo <<<HTML
                <section>
                    <h2>Cálculo das Médias:</h2>
                    <p>Analisando os valores $valor1 e $valor2:</p>
                    <ul>
                        <li>
                            A <strong>Média Aritmética Simples</strong> entre os valores é igual a $ma.
                        </li>
                        <li>
                            A <strong>Média Aritmética Ponderada</strong> com pesos $peso1 e $peso2 é igual a $mp.
                        </li>
                    </ul>
                </section>
                HTML;
            }
            ?>
        </article>
    </main>
</body>

</html>