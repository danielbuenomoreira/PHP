<?php
require_once 'Video.php';
require_once 'Gafanhoto.php';
require_once 'Visualizacao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto YouTube POO</title>
    <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
</head>
<body>
    <h1>Projeto Youtube: Vídeo e Visualização</h1>

    <?php
    // PASSO 1: CRIAÇÃO DOS VÍDEOS
    echo "<h2>1. Criando o Banco de Dados (Vídeos e Gafanhotos)</h2>";
    
    $v = [];
    $v[0] = new Video("Aula 1 de POO");
    $v[1] = new Video("Aula 12 de PHP");
    $v[2] = new Video("HTML5 e CSS3");

    $g = [];
    $g[0] = new Gafanhoto("Jubileu", 22, "M", "juba");
    $g[1] = new Gafanhoto("Creuza", 12, "F", "creuzita");

    echo "<div class='card'><p>Objetos criados com sucesso! Os vídeos iniciam com Avaliação 0 e Views 0.</p></div>";
    ?>

    <h2>2. Teste de Visualização Simples</h2>
    <h3>Jubileu assiste 'Aula 1 de POO' e avalia sem especificar nota (Nota Padrão 6)</h3>
    <?php
    // Cria a visualização
    $vis[0] = new Visualizacao($g[0], $v[0]);
    // Avalia sem parâmetro
    $vis[0]->avaliar();
    ?>
    <div class="card">
        <p><strong>Resultado Esperado:</strong> O vídeo deve ter média <span class="destaque">6.0</span> e 1 View.</p>
        <pre><?php print_r($vis[0]); ?></pre>
    </div>


    <h2>3. Teste com Nota Float (Decimal)</h2>
    <h3>Creuza assiste 'Aula 12 de PHP' e dá nota 8.5</h3>
    <?php
    $vis[1] = new Visualizacao($g[1], $v[1]);
    
    // Avalia com float
    $vis[1]->avaliar(8.5);
    ?>
    <div class="card">
        <p><strong>Resultado Esperado:</strong> O vídeo deve ter média <span class="destaque">8.5</span>.</p>
        <pre><?php print_r($vis[1]); ?></pre>
    </div>

    <h2>4. A Prova da Média Ponderada</h2>
    <p>Vamos usar o vídeo "HTML5" ($v[2]) e simular 3 visualizações consecutivas.</p>

    <h3>4.1. Jubileu assiste e dá nota 10</h3>
    <?php
    $vis[2] = new Visualizacao($g[0], $v[2]);
    $vis[2]->avaliar(10);
    ?>
    <div class="card">
        <p>Cálculo: (0 + 10) / 1 = <strong>10.0</strong></p>
        <pre>Média Atual do Vídeo: <?= $v[2]->getAvaliacao() ?></pre>
    </div>

    <h3>4.2. Creuza assiste e dá nota 5</h3>
    <?php
    $vis[3] = new Visualizacao($g[1], $v[2]);
    $vis[3]->avaliar(5);
    ?>
    <div class="card">
        <p>Lógica: A soma anterior era 10. Nova nota 5.</p>
        <p>Cálculo: (10 + 5) / 2 = 15 / 2 = <strong>7.5</strong></p>
        <pre>Média Atual do Vídeo: <?= $v[2]->getAvaliacao() ?></pre>
    </div>

    <h3>4.3. Jubileu assiste DE NOVO e dá nota 2 (Odiou ter assistido de novo)</h3>
    <?php
    $vis[4] = new Visualizacao($g[0], $v[2]); // Sim, ele pode assistir de novo
    $vis[4]->avaliar(2);
    ?>
    <div class="card">
        <p>Lógica: Média era 7.5 com 2 avaliações (Soma = 15).</p>
        <p>Cálculo: (15 + 2) / 3 = 17 / 3 = <strong>5.666...</strong> (Deve arredondar para 5.67)</p>
        <pre><?php print_r($v[2]); ?></pre>
    </div>

    <h2>5. Estado Final dos Gafanhotos</h2>
    <div class="card">
        <p>Verificando se a experiência e o 'totAssistido' subiram corretamente.</p>
        <p><strong>Jubileu:</strong> Assistiu 3 vídeos (HTML duas vezes + POO).</p>
        <pre><?php print_r($g[0]); ?></pre>
        
        <p><strong>Creuza:</strong> Assistiu 2 vídeos (PHP + HTML).</p>
        <pre><?php print_r($g[1]); ?></pre>
    </div>

</body>
</html>