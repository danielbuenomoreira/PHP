<?php
declare(strict_types=1);

abstract class Animal {
    public function __construct(
        protected float $peso,
        protected int $idade,
        protected int $membros
    ) {}
    
    abstract public function locomover(): string;
    abstract public function alimentar(): string;
    abstract public function emitirSom(): string;

    public function getPeso(): float {
        return $this->peso;
    }
    public function setPeso(float $peso): void {
        $this->peso = $peso;
    }

    public function getIdade(): int {
        return $this->idade;
    }
    public function setIdade(int $idade): void {
        $this->idade = $idade;
    }

    public function getMembros(): int {
        return $this->membros;
    }
    public function setMembros(int $membros): void {
        $this->membros = $membros;
    }
}