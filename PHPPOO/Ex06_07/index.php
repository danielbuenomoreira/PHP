<?php
// PROJETO PESSOAS (CLASSES)
require_once 'Pessoa.php';
require_once 'Visitante.php';
require_once 'Aluno.php';
require_once 'Bolsista.php';
require_once 'Professor.php';
require_once 'Funcionario.php';
// PROJETO ANIMAIS (CLASSES)
require_once 'Animal.php';
require_once 'Mamifero.php';
require_once 'Reptil.php';
require_once 'Peixe.php';
require_once 'Ave.php';
require_once 'Canguru.php';
require_once 'Cachorro.php';
require_once 'Cobra.php';
require_once 'Tartaruga.php';
require_once 'GoldFish.php';
require_once 'Arara.php';
require_once 'Lobo.php';
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
            <h2>Projeto Pessoas (Herança)</h2>
            <pre>
            <?php
            // TESTE 1: VISITANTE
            echo "<h3>--- Visitante ---</h3>";
            $v1 = new Visitante("Juvenal", 33, "M");
            echo "<p>O visitante <strong>{$v1->getNome()}</strong> chegou.</p>";
            $v1->fazerAniversario();
            echo "<p>Fez aniversário! Agora tem {$v1->getIdade()} anos.</p>";

            // TESTE 2: ALUNO vs BOLSISTA
            echo "<hr><h3>--- Aluno vs Bolsista ---</h3>";
            $a1 = new Aluno("Pedro", 16, "M", 1111, "Informática");
            $b1 = new Bolsista("Jubileu", 17, "M", 1112, "Administração", 12.5);
            echo "<p><strong>Aluno Normal:</strong> " . $a1->pagarMensalidade() . "</p>";
            echo "<p><strong>Aluno Bolsista:</strong> " . $b1->pagarMensalidade() . "</p>";

            // TESTE 3: PROFESSOR
            echo "<hr><h3>--- Professor ---</h3>";
            $p3 = new Professor("Cláudio", 40, "M", "Matemática", 3500.75);
            echo "<p>" . $p3->apresentar() . "</p>";
            echo "<p>" . $p3->receberAumento(550.20) . "</p>";

            // TESTE 4: FUNCIONÁRIO
            echo "<hr><h3>--- Funcionário ---</h3>";
            $p4 = new Funcionario("Fabiana", 25, "F", "Estoque");
            echo "<p>Funcionária: {$p4->getNome()} | Setor: {$p4->getSetor()}</p>";
            echo "<p>Trabalhando? " . ($p4->isTrabalhando() ? "SIM" : "NÃO") . "</p>";
            $p4->mudarTrabalho();
            echo "<p>Mudou status... Trabalhando? " . ($p4->isTrabalhando() ? "SIM" : "NÃO") . "</p>";
            ?>
            </pre>
        </div>

        <div class="coluna">
            <h2>Projeto Animais (POLIMORFISMO)</h2>
            <pre>
            <?php
            echo "<h3>=== Parte 1: Sobreposição ===</h3>";
            // Mamíferos
            $m = new Mamifero(85.5, 2, 4, "Marrom");
            $k = new Canguru(55.0, 3, 4, "Castanho");
            $c = new Cachorro(25.0, 5, 4, "Branco");
            // Répteis
            $r = new Reptil(0.5, 1, 0, "Verde");
            $t = new Tartaruga(45.0, 100, 4, "Verde Musgo");
            $cob = new Cobra(2.0, 2, 0, "Cinza");
            // Peixes e Aves
            $p = new Peixe(0.35, 1, 0, "Azul");
            $g = new GoldFish(0.1, 1, 0, "Dourado");
            $a = new Ave(0.8, 2, 2, "Vermelho");
            $ara = new Arara(1.5, 3, 2, "Colorida");

            // TESTES DE LOCOMOÇÃO
            echo "<h4>--- Como eles se movem? ---</h4>";
            echo "<p>Mamífero genérico: " . $m->locomover() . "</p>";
            echo "<p>Canguru (Override): " . $k->locomover() . "</p>";
            echo "<p>Cachorro: " . $c->locomover() . "</p>";
            echo "<hr><p>Reptil genérico: " . $r->locomover() . "</p>";
            echo "<p>Tartaruga (Override): " . $t->locomover() . "</p>";
            echo "<p>Cobra (Herança): " . $cob->locomover() . "</p>";
            echo "<hr><p>Peixe: " . $p->locomover() . "</p>";
            echo "<p>Ave: " . $a->locomover() . "</p>";
            // TESTES DE SOM
            echo "<hr><h4>--- Que som eles fazem? ---</h4>";
            echo "<p>Mamífero: " . $m->emitirSom() . "</p>";
            echo "<p>Cachorro (Override): " . $c->emitirSom() . "</p>";
            echo "<p>Peixe genérico: " . $p->emitirSom() . "</p>";
            echo "<p>GoldFish (Override): " . $g->emitirSom() . "</p>";
            echo "<p>Ave genérica: " . $a->emitirSom() . "</p>";
            echo "<p>Arara (Override): " . $ara->emitirSom() . "</p>";

            // AÇÕES ESPECÍFICAS
            echo "<hr><h4>--- Ações Específicas ---</h4>";
            echo "<p>Canguru: " . $k->usarBolsa() . "</p>";
            echo "<p>Cachorro: " . $c->abanarRabo() . "</p>";
            echo "<p>Cachorro: " . $c->enterrarOsso() . "</p>";
            echo "<p>Peixe: " . $p->soltarBolha() . "</p>";
            echo "<p>Ave: " . $a->fazerNinho() . "</p>";

            echo "<br><br>";
            echo "<h3>=== Parte 2: Sobrecarga (Simulada - PHP 8) ===</h3>";
            // --- LOBO (Simples) ---
            echo "<h4>--- Lobo ---</h4>";
            $lobo = new Lobo(35.5, 6, 4, "Cinza");
            echo "<p>Som: " . $lobo->emitirSom() . "</p>";
            echo "<p>Ação: " . $lobo->locomover() . "</p>";
            // --- CACHORRO (Sobrecarga Moderna) ---
            echo "<hr><h4>--- Cachorro Inteligente ---</h4>";
            // Criando um segundo cachorro para testar a sobrecarga
            $dog = new Cachorro(12.0, 3, 4, "Caramelo");
            echo "<p><strong>Reação a Frase (String):</strong></p>";
            echo "Olá -> " . $dog->reagir("Olá") . "<br>";
            echo "Vai apanhar -> " . $dog->reagir("Vai apanhar");

            echo "<p><strong>Reação a Hora (Int):</strong></p>";
            echo "11:00 -> " . $dog->reagir(11, 0) . "<br>";
            echo "21:00 -> " . $dog->reagir(21, 0);

            echo "<p><strong>Reação a Dono (Bool):</strong></p>";
            echo "É o dono? -> " . $dog->reagir(true) . "<br>";
            echo "Não é? -> " . $dog->reagir(false);
            ?>
            </pre>
        </div>

    </div>
</body>

</html>