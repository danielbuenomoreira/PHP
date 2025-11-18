<?php
declare(strict_types=1);
require_once 'Ave.php';

class Arara extends Ave {
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        string $corPena,
    ) {
        parent::__construct($peso, $idade, $membros, $corPena);
    }

    public function emitirSom(): string {
        return "Squawk! Squawk!";
    }
}