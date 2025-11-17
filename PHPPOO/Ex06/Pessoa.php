<?php
declare(strict_types=1);

abstract class Pessoa {
    public function __construct(
        protected string $nome,
        protected int $idade,
        protected string $sexo
    ) {}
        
    public final function fazerAniversario(): void {
        $this->idade++;
    }

    public function getNome(): string {
        return $this->nome;
    }
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getIdade(): int {
        return $this->idade;
    }
    public function setIdade(int $idade): void {
        $this->idade = $idade;
    }

    public function getSexo(): string {
        return $this->sexo;
    }
    public function setSexo(string $sexo): void {
        $this->sexo = $sexo;
    }
}