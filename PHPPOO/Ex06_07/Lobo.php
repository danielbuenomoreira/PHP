<?php
declare(strict_types=1);
require_once 'Mamifero.php';

class Lobo extends Mamifero {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        string $corPelo,
    ) {
        parent::__construct($peso, $idade, $membros, $corPelo);
    }

    public function emitirSom(): string {
        return "Auuuuuuuuuuu!";
    }
    public function locomover(): string {
        return "Correndo agressivamente!";
    }
}