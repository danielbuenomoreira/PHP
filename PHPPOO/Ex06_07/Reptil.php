<?php
declare(strict_types=1);
require_once 'Animal.php';

class Reptil extends Animal {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        private string $corEscama,
    ) {
        parent::__construct($peso, $idade, $membros);
    }

    public function locomover(): string {
        return "Rastejando";
    }
    public function alimentar(): string {
        return "Comendo vegetais e pequenos animais";
    }
    public function emitirSom(): string {
        return "Som de Réptil";
    }

    // Getters and Setters
    public function getCorEscama(): string {
        return $this->corEscama;
    }
    public function setCorEscama(string $corEscama): void {
        $this->corEscama = $corEscama;
    }
}