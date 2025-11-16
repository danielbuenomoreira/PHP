<?php
require_once 'ControleRemoto.php';
require_once 'Pessoa.php';
require_once 'Publicacao.php';
require_once 'Livro.php';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POO PHP Moderno</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>

<body>
    <div class="container">

        <div class="coluna">
            <h2>Projeto Controle Remoto</h2>
            <pre>
            <?php
            $c = new ControleRemoto();

            echo "<h3>--- Teste 1: Controle Desligado ---</h3>";
            $c->maisVolume();
            $c->play();
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 2: Ligando e Aumentando Volume ---</h3>";
            $c->ligar();
            $c->play();
            $c->maisVolume(); // 55
            $c->maisVolume(); // 60
            $c->maisVolume(); // 65
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 3: Testando o Mudo ---</h3>";
            $c->ligarMudo();
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 4: Desligando o Mudo ---</h3>";
            $c->desligarMudo();
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 5: Pausando ---</h3>";
            $c->pause();
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 6: Desligando ---</h3>";
            $c->desligar();
            echo $c->abrirMenu();
            echo "<hr>";

            echo "<h3>--- Teste 7: Estado final do Objeto ---</h3>";
            print_r($c);
            ?>
            </pre>
        </div>
        <div class="coluna">
            <h2>Projeto Livro</h2>
            <pre>
                <?php
                $p[0] = new Pessoa("Daniel B. Moreira", 33, "M");
                $p[1] = new Pessoa("Maria", 31, "F");

                // Livros reais de programação
                $l[0] = new Livro("Modern PHP", "Josh Lockhart", 274, $p[0]);
                $l[1] = new Livro("Learning PHP, MySQL & JavaScript", "Robin Nixon", 812, $p[0]);
                $l[2] = new Livro("PHP: The Right Way", "Vários Autores", 350, $p[1]);

                
                // --- Início dos Testes ---
                echo "<h3>--- Teste 1: Livro Fechado ---</h3>";
                $l[0]->avancarPag(); // Não deve funcionar
                $l[0]->voltarPag();  // Não deve funcionar
                echo $l[0]->detalhes();
                echo "<hr>";
                
                echo "<h3>--- Teste 2: Abrindo e Lendo ---</h3>";
                $l[0]->abrir();
                $l[0]->avancarPag(); // Pág 1
                $l[0]->avancarPag(); // Pág 2
                $l[0]->avancarPag(); // Pág 3
                $l[0]->voltarPag();  // Pág 2
                echo $l[0]->detalhes();
                echo "<hr>";

                echo "<h3>--- Teste 3: Folheando (Pág. 150) ---</h3>";
                $l[0]->folhear(150);
                echo $l[0]->detalhes();
                echo "<hr>";

                echo "<h3>--- Teste 4: Folheando (Pág. Inválida 999) ---</h3>";
                $l[0]->folhear(999); // Deve ir para a última pág
                echo $l[0]->detalhes();
                echo "<hr>";

                echo "<h3>--- Teste 5: Fechando o Livro ---</h3>";
                $l[0]->fechar(); // Deve fechar e voltar à pág. 0
                echo $l[0]->detalhes();
                echo "<hr>";

                echo "<h3>--- Teste 6: Status dos Outros Livros ---</h3>";
                echo $l[1]->detalhes();
                echo $l[2]->detalhes();
                ?>
            </pre>
        </div>
    </div>
</body>

</html>