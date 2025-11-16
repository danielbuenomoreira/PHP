<?php
require_once 'Lutador.php';
require_once 'Luta.php';
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
    <h1>Ultra Emoji Combat</h1>
    <?php
    $lut = [];
    $lut[0] = new Lutador("Pretty Boy", "França", 30, 1.75, 68.9, 11, 2, 1);
    $lut[1] = new Lutador("Putscript", "Brasil", 29, 1.68, 57.8, 14, 2, 3);
    $lut[2] = new Lutador("SnapShadow", "EUA", 35, 1.65, 80.9, 12, 2, 1);
    $lut[3] = new Lutador("Dead Code", "Australia", 28, 1.93, 81.6, 13, 0, 2);
    $lut[4] = new Lutador("UFOCobol", "Brasil", 37, 1.70, 119.3, 5, 4, 3);
    $lut[5] = new Lutador("NerdaArt", "EUA", 30, 1.81, 105.7, 12, 2, 4);
    $lut[6] = new Lutador("Invalidor", "Brasil", 25, 1.50, 50.0, 0, 0, 0);
    ?>

    <hr>
    <h3>Tabela de Lutadores</h3>
    <h4>(Antes do evento de hoje)</h4>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Nacionalidade</th>
                <th>Idade</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Categoria</th>
                <th>Cartel (V-D-E)</th>
            </tr>
        </thead>
        <tbody> <?php
                foreach ($lut as $lutador) {
                ?>
                <tr>
                    <td><?php echo $lutador->getNome() ?></td>
                    <td><?php echo $lutador->getNacionalidade() ?></td>
                    <td><?php echo $lutador->getIdade() ?></td>
                    <td><?php echo $lutador->getAltura() ?> m</td>
                    <td><?php echo $lutador->getPeso() ?> kg</td>
                    <td><?php echo $lutador->getCategoria() ?></td>
                    <td><?php echo "{$lutador->getVitorias()}-{$lutador->getDerrotas()}-{$lutador->getEmpates()}" ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

    <hr>
    <h2>🥊 O EVENTO PRINCIPAL 🥊</h2>

    <?php
    // --- Peso Leve vs Peso Leve ---
    echo "<div class='evento-luta'>";
    $UEC01 = new Luta();
    if ($UEC01->marcarLuta($lut[0], $lut[1])) {
        echo "<h3>LUTA APROVADA: {$lut[0]->getNome()} vs {$lut[1]->getNome()}</h3>";
        echo $lut[0]->apresentar();
        echo $lut[1]->apresentar();
        echo $lut[0]->status();
        echo $lut[1]->status();
        echo $UEC01->lutar();
    }
    echo "</div>";

    // --- Categorias Diferentes ---
    echo "<div class='evento-luta'>";
    $UEC02 = new Luta();
    if (!$UEC02->marcarLuta($lut[2], $lut[4])) {
        echo "<h3>LUTA RECUSADA: {$lut[2]->getNome()} vs {$lut[4]->getNome()}</h3>";
        echo $lut[2]->status();
        echo $lut[4]->status();
        echo "<div class='erro-luta'>Motivo: Os lutadores não são da mesma categoria.</div>";
    }
    echo "</div>";

    // --- Peso Médio vs Peso Médio ---
    echo "<div class='evento-luta'>";
    $UEC03 = new Luta();
    if ($UEC03->marcarLuta($lut[2], $lut[3])) {
        echo "<h3>LUTA APROVADA: {$lut[2]->getNome()} vs {$lut[3]->getNome()}</h3>";
        echo $lut[2]->apresentar();
        echo $lut[3]->apresentar();
        echo $lut[2]->status();
        echo $lut[3]->status();
        echo $UEC03->lutar();
    }
    echo "</div>";

    // --- Peso Pesado vs Peso Pesado ---
    echo "<div class='evento-luta'>";
    $UEC04 = new Luta();
    if ($UEC04->marcarLuta($lut[4], $lut[5])) {
        echo "<h3>LUTA APROVADA: {$lut[4]->getNome()} vs {$lut[5]->getNome()}</h3>";
        echo $lut[4]->apresentar();
        echo $lut[5]->apresentar();
        echo $lut[4]->status();
        echo $lut[5]->status();
        echo $UEC04->lutar();
    }
    echo "</div>";
    ?>

    <hr>
    <h3>Tabela de Lutadores</h3>
    <h4>(Depois do evento de hoje)</h4>

    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Nacionalidade</th>
                <th>Idade</th>
                <th>Altura</th>
                <th>Peso</th>
                <th>Categoria</th>
                <th>Cartel (V-D-E)</th>
            </tr>
        </thead>
        <tbody> <?php
                foreach ($lut as $lutador) {
                ?>
                <tr>
                    <td><?php echo $lutador->getNome() ?></td>
                    <td><?php echo $lutador->getNacionalidade() ?></td>
                    <td><?php echo $lutador->getIdade() ?></td>
                    <td><?php echo $lutador->getAltura() ?> m</td>
                    <td><?php echo $lutador->getPeso() ?> kg</td>
                    <td><?php echo $lutador->getCategoria() ?></td>
                    <td><?php echo "{$lutador->getVitorias()}-{$lutador->getDerrotas()}-{$lutador->getEmpates()}" ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>

</body>

</html>