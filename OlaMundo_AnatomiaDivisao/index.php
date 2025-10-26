<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olá, Mundo e Anatomia de uma Divisão</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>

<body>
    <?php
    print "<h1>Olá, mundo! \u{1f30E}</h1>";

    const CANAL = "Curso em Vídeo! \u{1f499}";
    $nome = 'Daniel'; // Aspas simples não interpretam variáveis
    $sobrenome = "Moreira \u{1f596}"; // Aspas duplas interpretam variáveis

    echo "<h2>Meu nome é $nome $sobrenome. \u{1f30E} Aqui tem aspas duplas.</h2>";
    echo '<h2>Meu nome é $nome $sobrenome. \u{1f30E} Aqui tem aspas simples.</h2>';
    echo "<h2>Mesmo tendo o mesmo conteúdo nos dois ECHOS, eles não são iguais</h2><br>";
    echo "<h2>Eu adoro o " . CANAL . "</h2>";
    print "<h2>Estamos no ano de " . date("Y") . ".<br>";
    print "Hoje é " . date("d/m/Y") . ".</h2><br>";

    // Sequência de escape
    $nom = "Rodrigo";
    $snom = "Nogueira";
    $apelido = "Minotauro";
    echo "<p><h2>$nom \"$apelido\" $snom</h2><br></p><br>";

    $dividendo = $_GET['d1'] ?? 0;
    $divisor = $_GET['d2'] ?? 1;
    ?>
    <article>
        <h1>Anatomia de uma divisão:</h1>
        <form id="divisao" action="<?= $_SERVER['PHP_SELF'] ?>" method="get" novalidate>
            <label for="d1">Dividendo:</label>
            <input type="number" name="d1" id="d1" required value="<?= $dividendo ?>" required>
            <label for="d2">Divisor:</label>
            <input type="number" name="d2" id="d2" required value="<?= $divisor ?>" required>
            <input type="submit" value="Calcular">
        </form>
        <span id="divisor-erro" style="color: red; display: block; margin-top: 5px;"></span>
    </article>


    <?php
    // --- LÓGICA DO CÁLCULO E EXIBIÇÃO ---
    // Verifica se o formulário já foi enviado uma vez
    if (isset($_GET['d1']) && isset($_GET['d2'])) {

        // VALIDAÇÃO SERVER-SIDE (ESSENCIAL)
        if ($divisor == 0) {
            echo "<p style='color: red;'><strong>ERRO: Divisor não pode ser zero. Impossível calcular.</strong></p>";
        } else {
            // Se tudo estiver ok, faz o cálculo
            $quociente = intdiv($dividendo, $divisor); // Divisão inteira
            $resto = $dividendo % $divisor; // Módulo (resto da divisão)

            // Exibe a tabela com o resultado
            echo <<<HTML
                <section>
                    <h1>Estrutura da Divisão:</h1>
                    <table class='divisao'>
                        <tr>
                            <td>$dividendo</td>
                            <td>$divisor</td>
                        </tr>
                        <tr>
                            <td>$resto</td>
                            <td>$quociente</td>
                        </tr>
                    </table>
                </section>
                HTML;
        }
    }
    ?>
    <script src="script.js"></script>
</body>

</html>