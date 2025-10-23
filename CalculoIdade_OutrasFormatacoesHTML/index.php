<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de idade e Outras formatações</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
        $atual = date("Y");
        $nasc = $_GET['nasc'] ?? '1992';
        $ano = $_GET['ano'] ?? $atual;
    ?>
    <main>
        <article>
            <h1>Calculando a sua Idade</h1>
            <form action="<?= $_SERVER['PHP_SELF'] ?>" method="get">
                <label for="nasc">Em que ano você nasceu?</label>
                <input type="number" name="nasc" id="nasc" min="1500" value="<?=$nasc?>">
                <label for="ano">Quer saber sua idade em que ano? (atualmente estamos em <strong><?=$atual?></strong>)</label>
                <input type="number" name="ano" id="ano" min="1900" value="<?=$ano?>">
                <input type="submit" name="calcular_idade" value="Qual será minha idade?">
            </form>
            <?php
            // VERIFICAÇÃO: Este bloco só aparece se o formulário de soma for enviado
            if (isset($_GET['calcular_idade'])) {
                //$ma = ($valor1 + $valor2) / 2;
                //$mp = ($valor1 * $peso1 + $valor2 * $peso2) / ($peso1 + $peso2);

                echo <<<HTML
                <section>
                    <h2>Resultado:</h2>
                    <p>Quem nasceu em {} vai ter <strong>{}</strong> anos em {}!</p>
                </section>
                HTML;
            }
            ?>
        </article>
        <article>
            <h1>Outras formatações</h1>
            <h2>Código-fonte / Pré-formatação</h2>
            <p>O comando <code>document.getElementbyId('teste')</code> é escrito em linguagem JavaScript.</p>
            <h4>Exemplo de código em Python <small>usando as tags &lt;pre&gt; e &lt;code&gt;</small>:</h4>
            <pre><code>
num = int(input('Digite um número'))
if num % 2 == 0:
    print(f'O número {num} é par')
else:
    print(f'O número {num} é ímpar')
print('FIM DO PROGRAMA')
            </code></pre>
            <p>
            <h2>Citações simples <small>usando a tag &lt;q&gt;</small></h2>
            </p>
            <p>Como diria o pai de um amigo: <q>O computador é um burro muito rápido.</q></p>
            <h2>Citações completas</h2>
            <p>Exemplo do livro: <q>CSS Eficiente (Técnicas e ferramentes que fazem a diferença nos seus estilos)</q>
            </p>

            <figure>
                <blockquote
                    cite="https://www.google.com.br/books/edition/CSS_Eficiente/j2iCCwAAQBAJ?hl=pt-BR&gbpv=1&dq=CSS&printsec=frontcover">
                    <p>Quando aprendemos a trabalhar com CSS, frequentemente nos pegamos perdidos em detalhes
                        fundamentais que não nos são explicados. Por vezes, alguns desses detalhes passam despercebidos
                        até pelo desenvolvedor front-end mais experiente. Mas como ir além do conhecimento básico do CSS
                        e preparar o caminho para explorar tópicos mais avançados? Neste livro, Tárcio Zemel ensina como
                        organizar seu estilo, entender especificidade, como usar diferentes seletores, trabalhar
                        orientado a objetos com CSS e várias outras técnicas que farão diferença no dia a dia do
                        trabalho com os estilos e abrirão novas possibilidades para você explorar ainda mais o CSS.</p>
                </blockquote>

                <figcaption>
                    — Fonte: <cite><a
                            href="https://www.google.com.br/books/edition/CSS_Eficiente/j2iCCwAAQBAJ?hl=pt-BR&gbpv=1&dq=CSS&printsec=frontcover">CSS
                            Eficiente</a></cite>
                </figcaption>
            </figure>
            <pre><code>
 1  body, form {
 2      margin: 0;
 3      padding;
 4  }
 5
 6  input[type="text"] {
 7      border: 1px solid #999;
 8  }
 9
10  a {
11      color: #039,
12  }
13
14  a:hover {
15      color: #03c;
16  }
            </code></pre>
            <p>
            <h2>Abreviações <small>usando a tag &lt;abbr&gt;</small></h2>
            </p>
            <p>Estou estudando <abbr title="HyperText Markup Language">HTML</abbr> e <abbr
                    title="Cascading Style Sheets">CSS</abbr>. Estou adorando!</p>
            <h2>Texto invertido <small>usando a tag &lt;bdo dir="rtl"&gt;</small></h2>
            <p><bdo dir="rtl">Estou aprendendo a criar coisas em HTML.</bdo></p>
        </article>
    </main>
</body>

</html>