<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipos primitivos em PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Teste de tipos primitivos</h1>
    <?php
        // 0x = hexadecimal -- 0b = binário -- 0 ou 0o= octal -- 0d = decimal
        $num = 300;
        print "<p>O valor da variável num1(300 - decimal) é $num e o var_dump dele é: ";
        var_dump($num);
        echo ".</p>";

        $num2 = 0x1A;
        print "<p>O valor da variável num2(0x1A - hexadecimal) é $num2 e o var_dump dele é: ";
        var_dump($num2);
        echo ".</p>";

        $num3 = 0b101010;
        print "<p>O valor da variável num3(0b101010 - binário) é $num3 e o var_dump dele é: ";
        var_dump($num3);
        echo ".</p>";

        $num4 = 0o456;
        print "<p>O valor da variável num4(0o456 - octal) é $num4 e o var_dump dele é: ";
        var_dump($num4);
        echo ".</p>";

        $num5 = 3e2; // 3 * 10^2 = 300
        print "<p>O valor da variável num5(3e2 - notação científica) é $num5 e o var_dump dele é: ";
        var_dump($num5);
        echo ".</p>";

        $num6 = (int) 3e2; // converte 3e2 para inteiro
        print "<p>O valor da variável num6(3e2 - notação científica) é $num6 e o var_dump dele é: ";
        var_dump($num6);
        echo ",<br>pois digitei a variável num6 = (int) 3e2, 'forçando' a variável virar int (número inteiro).</p>";

        $nome = "Daniel Moreira";
        print "<p>O valor da variável nome é $nome e o var_dump dele é: ";
        var_dump($nome);
        echo ".</p>";

        $vet = [6, 2.5, "Maria", false, true, null];

        // Função para converter valores false e null para uma representação mais explícita
        function formatArray($array) {
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
        echo ".</p>";
    ?>
</body>
</html>