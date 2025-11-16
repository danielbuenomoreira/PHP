<?php

declare(strict_types=1);

class Lutador {
    private string $nome;
    private string $nacionalidade;
    private int $idade;
    private float $altura;
    private float $peso;
    private string $categoria;
    private int $vitorias;
    private int $derrotas;
    private int $empates;

    public function apresentar(): string {
        return <<<HTML
            <div class="lutador-card apresentar">
                <p>CHEGOU A HORA!<br>Apresentando o lutador <strong>{$this->getNome()}</strong>, diretamente de {$this->getNacionalidade()}!<br>
                Com {$this->getIdade()} anos e peso de {$this->getPeso()}kg...<br>
                Com {$this->getVitorias()} vitória(s), {$this->getDerrotas()} derrota(s) e {$this->getEmpates()} empate(s).</p>
            </div>
            HTML;
    }
    
    public function status(): string {
        return <<<HTML
            <div class="lutador-card status">
                <p><strong>{$this->getNome()}</strong> é da categoria <strong>{$this->getCategoria()}</strong>.<br>
                Estatísticas (V-D-E): {$this->getVitorias()} - {$this->getDerrotas()} - {$this->getEmpates()}</p>
            </div>
            HTML;
    }
    
    public function ganharLuta() {
        $this->setVitorias($this->getVitorias() + 1);
    }
    
    public function perderLuta() {
        $this->setDerrotas($this->getDerrotas() + 1);
    }
    
    public function empatarLuta() {
        $this->setEmpates($this->getEmpates() + 1);
    }

    public function __construct(string $no, string $na, int $id, float $al, float $pe, int $vi, int $de, int $em) {
        $this->nome = $no;
        $this->nacionalidade = $na;
        $this->idade = $id;
        $this->altura = $al;
        $this->setPeso($pe);
        $this->vitorias = $vi;
        $this->derrotas = $de;
        $this->empates = $em;
    }

    
    // --- Métodos Getters e Setters ---
    public function getNome(): string {
        return $this->nome;
    }
    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function getNacionalidade(): string {
        return $this->nacionalidade;
    }
    public function setNacionalidade(string $nacionalidade): void {
        $this->nacionalidade = $nacionalidade;
    }

    public function getIdade(): int {
        return $this->idade;
    }
    public function setIdade(int $idade): void {
        $this->idade = $idade;
    }

    public function getAltura(): float {
        return $this->altura;
    }
    public function setAltura(float $altura): void {
        $this->altura = $altura;
    }

    public function getPeso(): float {
        return $this->peso;
    }
    public function setPeso(float $peso): void {
        $this->peso = $peso;
        $this->setCategoria();
    }

    public function getCategoria(): string {
        return $this->categoria;
    }
    private function setCategoria(): void {
        if ($this->peso < 52.2) {
            $this->categoria = "Inválido (Abaixo do Peso Leve)";
        } elseif ($this->peso <= 70.3) {
            $this->categoria = "Peso Leve";
        } elseif ($this->peso <= 83.9) {
            $this->categoria = "Peso Médio";
        } elseif ($this->peso <= 120.2) {
            $this->categoria = "Peso Pesado";
        } else {
            $this->categoria = "Inválido (Acima do Peso Pesado)";
        }
    }

    public function getVitorias(): int {
        return $this->vitorias;
    }
    private function setVitorias(int $vitorias): void {
        $this->vitorias = $vitorias;
    }

    public function getDerrotas(): int {
        return $this->derrotas;
    }
    private function setDerrotas(int $derrotas): void {
        $this->derrotas = $derrotas;
    }

    public function getEmpates(): int {
        return $this->empates;
    }
    private function setEmpates(int $empates): void {
        $this->empates = $empates;
    }
}