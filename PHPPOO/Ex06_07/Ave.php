<?php
declare(strict_types=1);
require_once 'Animal.php';

class Ave extends Animal {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        private string $corPena
    ) {
        parent::__construct($peso, $idade, $membros);
    }

    public function locomover(): string {
        return "Voando";
    }
    public function alimentar(): string {
        return "Comendo frutas e sementes";
    }
    public function emitirSom(): string {
        return "Som de Ave";
    }
    public function fazerNinho(): string {
        return "Construindo ninho";
    }

    // Getters and Setters
    public function getCorPena(): string {
        return $this->corPena;
    }
    public function setCorPena(string $corPena): void {
        $this->corPena = $corPena;
    }
}