<?php

// Ativa a verificação rigorosa de tipos
declare(strict_types=1);

class Caneta
{
    protected int $carga = 0;
    protected bool $tampada;

    public function __construct(
        protected string $modelo,
        protected string $cor,
        protected float $ponta
    ) {
        $this->tampar();
    }

    public function rabiscar(): string
    {
        if ($this->tampada) { // Verificação booleana
            return "Erro! Não posso rabiscar!";
        } else {
            return "Estou rabiscando...";
        }
    }

    public function tampar(): void
    {
        $this->tampada = true;
    }

    public function destampar(): void
    {
        $this->tampada = false;
    }

    // --- Métodos Getters e Setters ---

    public function getModelo(): string
    {
        return $this->modelo;
    }

    public function setModelo(string $mo): void
    {
        $this->modelo = $mo;
    }

    public function getCor(): string
    {
        return $this->cor;
    }

    public function setCor(string $co): void
    {
        $this->cor = $co;
    }

    public function getPonta(): float
    {
        return $this->ponta;
    }

    public function setPonta(float $po): void
    {
        $this->ponta = $po;
    }

    public function getCarga(): int
    {
        return $this->carga;
    }

    public function setCarga(int $ca): void
    {
        $this->carga = $ca;
    }
}
