<?php
declare(strict_types=1);
require_once 'Pessoa.php';

class Funcionario extends Pessoa {
    public function __construct(
        string $nome,
        int $idade,
        string $sexo,
        private string $setor,
        private bool $trabalhando = true
    ) {
        parent::__construct($nome, $idade, $sexo);
    }

    public function mudarTrabalho(): void {
        $this->trabalhando = !$this->trabalhando;
    }

    // Getters and Setters
    public function getSetor(): string {
        return $this->setor;
    }
    public function setSetor(string $setor): void {
        $this->setor = $setor;
    }

    public function isTrabalhando(): bool {
        return $this->trabalhando;
    }
    public function setTrabalhando(bool $trabalhando): void {
        $this->trabalhando = $trabalhando;
    }
}