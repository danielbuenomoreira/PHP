<?php
declare(strict_types=1);
require_once 'Animal.php';

class Mamifero extends Animal {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        private string $corPelo,
    ) {
        parent::__construct($peso, $idade, $membros);
    }

    public function locomover(): string {
        return "Correndo";
    }
    public function alimentar(): string {
        return "Mamando";
    }
    public function emitirSom(): string {
        return "Som de Mamífero";
    }

    // Getters and Setters
    public function getCorPelo(): string {
        return $this->corPelo;
    }
    public function setCorPelo(string $corPelo): void {
        $this->corPelo = $corPelo;
    }
}