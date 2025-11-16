<?php
// Inclui o arquivo da classe
require_once 'Caneta.php';
require_once 'ContaBanco.php';
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
    <pre>
        <p>Exercício 01</p>
    <?php
    $c1 = new Caneta("BIC Cristal", "azul", 0.5);
    $c1->setCarga(99);
    $c1->destampar();

    print_r($c1);

    echo "<p>" . $c1->rabiscar() . "</p>";
    print "<p>Eu tenho uma caneta \"{$c1->getModelo()}\" {$c1->getCor()} de ponta {$c1->getPonta()}.";

    echo "<hr>"; // Separador

    $c2 = new Caneta("NIC", "verde", 1.0);
    $c2->setCarga(50);

    print_r($c2);
    echo "<p>" . $c2->rabiscar() . "</p>";
    ?>
    </pre>

    <pre>
        <p>Exercício 02</p>
    <?php
        // Criando as contas
        $pes1 = new ContaBanco(); // Jubileu
        $pes2 = new ContaBanco(); // Creuza

        // Abrindo a conta do Jubileu (CC)
        $pes1->setDono("Jubileu");
        echo "<p>" . $pes1->abrirConta("CC") . "</p>";

        // Abrindo a conta da Creuza (CP)
        $pes2->setDono("Creuza");
        echo "<p>" . $pes2->abrirConta("CP") . "</p>";

        // Testando depósitos
        echo "<p>" . $pes1->depositar(300) . "</p>";
        echo "<p>" . $pes2->depositar(500) . "</p>";

        // Testando saque (Creuza)
        echo "<p>" . $pes2->sacar(100) . "</p>";
        
        // Testando pagar mensalidade
        echo "<p>" . $pes1->pagarMensal() . "</p>";
        echo "<p>" . $pes2->pagarMensal() . "</p>";
        
        // Testando fechar conta (Jubileu)
        echo "<p>" . $pes1->fecharConta() . "</p>"; // Vai dar erro (tem saldo)
        
        // Sacando todo o dinheiro para fechar
        echo "<p>" . $pes1->sacar(338) . "</p>"; // 50 + 300 - 12 = 338
        echo "<p>" . $pes1->fecharConta() . "</p>"; // Agora funciona
        
        // Testando erros
        echo "<p>" . $pes1->sacar(50) . "</p>"; // Erro (conta fechada)
        echo "<p>" . $pes2->sacar(1000) . "</p>"; // Erro (saldo insuficiente)

        // Exibindo o estado final dos objetos
        echo "<hr><p>Estado Final:</p>";
        print_r($pes1);
        print_r($pes2);
    ?>
    </pre>
</body>

</html>