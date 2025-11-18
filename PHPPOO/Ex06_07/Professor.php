<?php
declare(strict_types=1);
require_once 'Pessoa.php';

class Professor extends Pessoa {
    public function __construct(
        string $nome,
        int $idade,
        string $sexo,
        private string $especialidade,
        private float $salario
    ) {
        parent::__construct($nome, $idade, $sexo);
    }

    public function receberAumento(float $aum): string {
        $this->salario += $aum;
        return "O professor <strong>{$this->getNome()}</strong> recebeu um aumento de R$ " . number_format($aum, 2) . " e agora passa a ter um salário de R$ " . number_format($this->salario, 2) . ".";
    }

    public function apresentar(): string {
        return "Olá, eu sou o professor <strong>{$this->getNome()}</strong>, tenho <strong>{$this->getIdade()}</strong> anos e sou professor de <strong>{$this->especialidade}</strong>.";
    }

    // Getters and Setters
    public function getEspecialidade(): string {
        return $this->especialidade;
    }
    public function setEspecialidade(string $especialidade): void {
        $this->especialidade = $especialidade;
    }

    public function getSalario(): float {
        return $this->salario;
    }
    public function setSalario(float $salario): void {
        $this->salario = $salario;
    }
}