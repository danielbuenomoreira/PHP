<?php
declare(strict_types=1);

abstract class Pessoa {
    protected int $experiencia;

    public function __construct(
        protected string $nome,
        protected int $idade,
        protected string $sexo
        ) {
        $this->experiencia = 0;
    }

    public function ganharExperiencia(int $xp): void {
        $this->experiencia += $xp;
    }

    // Getters and Setters
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

    public function getExperiencia(): int {
        return $this->experiencia;
    }
    public function setExperiencia(int $experiencia): void {
        $this->experiencia = $experiencia;
    }
    
}