<?php
declare(strict_types=1);
require_once 'Reptil.php';

class Tartaruga extends Reptil {
    public function locomover(): string {
        return "Andando lentamente";
    }
}