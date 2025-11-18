<?php
declare(strict_types=1);
require_once 'Mamifero.php';

class Canguru extends Mamifero {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        string $corPelo,
    ) {
        parent::__construct($peso, $idade, $membros, $corPelo);
    }

    public function locomover(): string {
        return "Saltando";
    }
    public function usarBolsa(): string {
        return "Usando a bolsa para carregar filhotes";
    }
}