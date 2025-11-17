<?php
require_once 'Pessoa.php';
require_once 'Aluno.php';
require_once 'Professor.php';
require_once 'Funcionario.php';
require_once 'Visitante.php';
require_once 'Bolsista.php';
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
            <h2>Projeto Pessoas</h2>
            <pre>
            <?php
            // TESTE 1: VISITANTE (Herança Simples)
            echo "<h3>--- Visitante ---</h3>";
            $v1 = new Visitante("Juvenal", 33, "M");
            echo "<p>O visitante <strong>{$v1->getNome()}</strong> chegou.</p>";
            // Testando método herdado de Pessoa
            $v1->fazerAniversario();
            echo "<p>Fez aniversário! Agora tem {$v1->getIdade()} anos.</p>";

            // TESTE 2: ALUNO vs BOLSISTA (Polimorfismo)
            echo "<hr><h3>--- Aluno vs Bolsista ---</h3>";
            $a1 = new Aluno("Pedro", 16, "M", 1111, "Informática");
            $b1 = new Bolsista("Jubileu", 17, "M", 1112, "Administração", 12.5);

            // Comparando o pagamento (O mesmo método agindo diferente)
            echo "<p><strong>Aluno Normal:</strong> " . $a1->pagarMensalidade() . "</p>";
            // Testando método específico do bolsista
            echo "<p>" . $b1->renovarBolsa() . "</p>";
            echo "<p><strong>Aluno Bolsista:</strong> " . $b1->pagarMensalidade() . "</p>";

            // TESTE 3: PROFESSOR (Lógica de Negócio)
            echo "<hr><h3>--- Professor ---</h3>";
            $p3 = new Professor("Cláudio", 40, "M", "Matemática", 3500.75);
            echo "<p>" . $p3->apresentar() . "</p>";
            // Mostrando o aumento formatado
            echo "<p>Salário Anterior: R$ " . number_format($p3->getSalario(), 2) . "</p>";
            echo "<p>" . $p3->receberAumento(550.20) . "</p>";

            // TESTE 4: FUNCIONÁRIO (Mudança de Estado)
            echo "<hr><h3>--- Funcionário ---</h3>";
            $p4 = new Funcionario("Fabiana", 25, "F", "Estoque");
            echo "<p>Funcionária: {$p4->getNome()} | Setor: {$p4->getSetor()}</p>";

            // Usando ternário para mostrar SIM/NÃO
            echo "<p>Está trabalhando? " . ($p4->isTrabalhando() ? "SIM" : "NÃO") . "</p>";
            $p4->mudarTrabalho(); // Inverte o status
            echo "<p>Mudou o status...</p>";
            echo "<p>Está trabalhando? " . ($p4->isTrabalhando() ? "SIM" : "NÃO") . "</p>";

            // DEBUG (Visualização dos Objetos)
            echo "<hr><h3>--- Estrutura dos Objetos ---</h3>";
            print_r($v1);
            print_r($a1);
            print_r($b1);
            print_r($p3);
            print_r($p4);
            ?>
            </pre>
        </div>

        <div class="coluna">
            <h2>Próximo Projeto</h2>
            <pre>
                <?php
                echo "<p>Espaço reservado para o próximo exercício...</p>";
                ?>
            </pre>
        </div>
    </div>
</body>

</html>