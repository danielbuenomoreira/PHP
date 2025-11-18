<?php
declare(strict_types=1);
require_once 'Pessoa.php';

class Aluno extends Pessoa {
    public function __construct(
        string $nome,
        int $idade,
        string $sexo,
        protected int $matricula,
        protected string $curso
    ) {
        parent::__construct($nome, $idade, $sexo);
    }

    public function pagarMensalidade(): string {
        return "Pagando mensalidade do aluno <strong>{$this->nome}</strong> do curso <strong>{$this->curso}</strong>.";
    }

    // Getters and Setters
    public function getMatricula(): int {
        return $this->matricula;
    }
    public function setMatricula(int $matricula): void {
        $this->matricula = $matricula;
    }

    public function getCurso(): string {
        return $this->curso;
    }
    public function setCurso(string $curso): void {
        $this->curso = $curso;
    }
}