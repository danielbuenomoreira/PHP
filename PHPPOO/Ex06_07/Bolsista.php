<?php
declare(strict_types=1);
require_once 'Aluno.php';

class Bolsista extends Aluno {
    public function __construct(
        string $nome,
        int $idade,
        string $sexo,
        int $matricula,
        string $curso,
        protected float $bolsa
    ) {
        parent::__construct($nome, $idade, $sexo, $matricula, $curso);
    }
    
    public function renovarBolsa(): string {
        return "A bolsa do aluno <strong>{$this->getNome()}</strong> foi renovada.";
    }

    public function pagarMensalidade(): string {
        return "O aluno <strong>{$this->getNome()}</strong> é bolsista e tem desconto na mensalidade.";
    }

    // Getters and Setters
    public function getBolsa(): float {
        return $this->bolsa;
    }
    public function setBolsa(float $bolsa): void {
        $this->bolsa = $bolsa;
    }
}