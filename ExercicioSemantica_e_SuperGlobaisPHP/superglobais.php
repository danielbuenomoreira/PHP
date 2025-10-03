<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo de Semântica</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h3>Eu moro na <address>Vila Asa Branca, bairro Sarandi, zona norte de Porto Alegre/RS</address></h3>
    <hr>
    <h1>Principais formatações</h1>
    <h2>Negrito / Destaque</h2>
    <p>Nesta frase, temos um <b>termo em negrito</b> usando a  tag &lt;b&gt; (não semântica).</p>
    <p>Nesta frase, temos um <strong>termo em destaque</strong> usando a  tag &lt;strong&gt; (semântica).</p>
    <h2>Itálico / Ênfase</h2>
    <p>Nesta frase, temos um <i>termo em itálico</i> usando a  tag &lt;i&gt; (não semântica).</p>
    <p>Nesta frase, temos um <em>termo em ênfase</em> usando a  tag &lt;em&gt; (semântica).</p>
    <h2>Texto marcado</h2>
    <p>Podemos criar também <mark>um texto marcado</mark> usando a tag &lt;mark&gt;.</p>
    <p>E no outro parágrafo, temos <mark>outro texto marcado</mark> no final.</p>
    <h2>Texto grande e pequeno - tag &lt;big&gt; e tag &lt;small&gt;</h2>
    <p>Estamos criando um <big>texto grande</big> e um <small>texto pequeno</small> nesse parágrafo.<br>Lembrando que a tag &lt;big&gt; é obsoleta.</p>
    <h2>Texto apagado - tag &lt;del&gt;</h2>
    <p>Podemos marcar <del>um texto como excluído</del> para indicar que ele deve ser lido, mas não considerado.</p>
    <h2>Texto inserido - tag &lt;ins&gt;</h2>
    <p>Podemos marcar <ins>um texto inserido</ins> para dar ênfase e indicar que ele foi adicionado depois.</p>
    <p>Existe também o <u>texto sublinhado</u> com a tag &lt;u&gt; (não semântica).</p>
    <h2>Texto sobrescrito - tag &lt;sup&gt;</h2>
    <p>Para inserir coisas do tipo x<sup>20</sup> + 3</p>
    <h2>Texto subscrito - tag &lt;sub&gt;</h2>
    <p>Para inserir coisas do tipo H<sub>2</sub>O</p>
    <h2>Trecho de código de programação com a tag &lt;code&gt;</h2>
    <h3>Exemplo de código em Python <del>usando as tags &lt;pre&gt; e &lt;code&gt;</del></h3>
    <pre><strong><code>
num = int(input('Digite um número'))
if num % 2 == 0:
    print(f'O número {num} é par')
else:
    print(f'O número {num} é ímpar')
print('FIM DO PROGRAMA')
    </code></strong></pre>

    <main>
        <pre>
            <?php
            setcookie("dia-da-semana","QUINTA-FEIRA", time() + 3600);

            session_start();
            $_SESSION["teste"] = "FUNCIONOU!";

            echo "<h1>Superglobal GET:</h1><br>";
            var_dump($_GET);
            echo "<br>Escreva: \"?nome=Daniel&idade=33\" (ou alguma outra coisa depois de ?)<br>após o endereço da barra de endereço e dê Enter.<br>É isso que vai aparecer aqui pela Superglobal GET.";

            echo "<p><h1>Superglobal POST:</h1></p><br>";
            var_dump($_POST);
            echo "<br>Na Superglobal POST vem os dados do formulário preenchido anteriormente.";

            echo "<p><h1>Superglobal REQUEST:</h1></p><br>";
            var_dump($_REQUEST);
            echo "<br>Na Superglobal REQUEST unifica as Superglobais GET e POST.";

            echo "<p><h1>Superglobal COOKIE:</h1></p><br>";
            var_dump($_COOKIE);
            echo "<br>Só vai funcionar se configurou (por exemplo:)<br>\"setcookie(\"dia-da-semana\",\"QUINTA-FEIRA\", time() + 3600)\" antes.";

            echo "<p><h1>Superglobal SESSION:</h1></p><br>";
            var_dump($_SESSION);

            echo "<p><h1>Superglobal ENV:</h1></p><br>";
            echo "Diferentemente dos anteriores, feito num for:<br>";
            foreach (getenv() as $c => $v) {
                echo "<br> $c -> $v";
            }

            echo "<p><h1>Superglobal SERVER:</h1></p><br>";
            var_dump($_SERVER);

            echo "<p><h1>Superglobal GLOBALS:</h1></p><br>";
            var_dump($GLOBALS);
            ?>
        </pre>
    </main>
</body>
</html>