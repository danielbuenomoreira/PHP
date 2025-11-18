<?php
declare(strict_types=1);
require_once 'Mamifero.php';

class Cachorro extends Mamifero {
    
    public function __construct(
        float $peso,
        int $idade,
        int $membros,
        string $corPelo,
    ) {
        parent::__construct($peso, $idade, $membros, $corPelo);
    }

    public function emitirSom(): string {
        return "Au! Au! Au!";
    }

    public function locomover(): string {
        return "Correndo e abanando o rabo";
    }
    
    public function enterrarOsso(): string {
        return "Enterrando osso";
    }
    
    public function abanarRabo(): string {
        return "Abanando o rabo";
    }
    /**
     * --- MÉTODO DE "SOBRECARGA" (PHP 8.0+) ---
     * Aceita Frase (string), Hora (int) ou Dono (bool)
     * O parâmetro $min é opcional, usado apenas se o estímulo for Hora.
     */
    public function reagir(string|int|bool $estimulo, int $min = 0): string {
        // 1. Reagir a FRASE (String)
        if (is_string($estimulo)) {
            $frase = strtolower($estimulo);
            if ($frase === "toma comida" || $frase === "olá") {
                return "Abanar o rabo e latir de alegria.";
            } else {
                return "Rosnar!";
            }
        }
        // 2. Reagir a HORA (Int)
        if (is_int($estimulo)) {
            $hora = $estimulo;
            if ($hora < 12) {
                return "Abanar o rabo (Manhã)";
            } elseif ($hora >= 18) {
                return "Ignorar (Dormindo)";
            } else {
                return "Abanar o rabo e Latir (Tarde)";
            }
        }
        // 3. Reagir a DONO (Bool)
        if (is_bool($estimulo)) {
            $dono = $estimulo;
            if ($dono === true) {
                return "Abanar o rabo e fazer festa";
            } else {
                return "Rosnar e Latir (Desconhecido)";
            }
        }
        return "Cachorro confuso...";
    }
}