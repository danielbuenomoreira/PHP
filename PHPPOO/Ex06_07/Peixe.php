<?php
declare(strict_types=1);
require_once 'Animal.php';

class Peixe extends Animal {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        private string $corEscama
    ) {
        parent::__construct($peso, $idade, $membros);
    }

    public function locomover(): string {
        return "Nadando";
    }
    public function alimentar(): string {
        return "Comendo substâncias";
    }
    public function emitirSom(): string {
        return "Peixe não emite som";
    }
    public function soltarBolha(): string {
        return "Soltando bolhas";
    }

    // Getters and Setters
    public function getCorEscama(): string {
        return $this->corEscama;
    }
    public function setCorEscama(string $corEscama): void {
        $this->corEscama = $corEscama;
    }
}