<?php
declare(strict_types=1);
require_once 'Peixe.php';

class GoldFish extends Peixe {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        string $corEscama,
    ) {
        parent::__construct($peso, $idade, $membros, $corEscama);
    }

    public function emitirSom(): string {
        return "Blub! Blub! Blub!";
    }
}