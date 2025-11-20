<?php
declare(strict_types=1);
require_once 'Pessoa.php';

class Gafanhoto extends Pessoa {
    private int $totAssistido;

    public function __construct(
        string $nome, 
        int $idade, 
        string $sexo, 
        private string $login
    ) {
        parent::__construct($nome, $idade, $sexo);
        $this->totAssistido = 0;
    }

    public function assistirMaisUm(): void {
        $this->totAssistido++;
    }

    // --- Getters e Setters ---
    public function getLogin(): string {
        return $this->login;
    }
    public function setLogin(string $login): void {
        $this->login = $login;
    }

    public function getTotAssistido(): int {
        return $this->totAssistido;
    }
    public function setTotAssistido(int $totAssistido): void {
        $this->totAssistido = $totAssistido;
    }
}