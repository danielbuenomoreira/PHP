<?php
declare(strict_types=1);
require_once 'AcoesVideo.php';

class Video implements AcoesVideo {
    private float $avaliacao;
    private int $views;
    private bool $reproduzindo;
    private int $totalAvaliacoes;

    public function __construct(private string $titulo) {
        $this->avaliacao = 0.0;
        $this->views = 0;
        $this->reproduzindo = false;
        $this->totalAvaliacoes = 0;
    }

    public function play(): void {
        $this->reproduzindo = true;
    }

    public function pause(): void {
        $this->reproduzindo = false;
    }

    // Getters and Setters
    public function getTitulo(): string {
        return $this->titulo;
    }
    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getAvaliacao(): float {
        return $this->avaliacao;
    }
    public function setAvaliacao(float $nota): void {
        // Calculamos a soma de todas as notas anteriores
        $somaAnterior = $this->avaliacao * $this->totalAvaliacoes;
        // Incrementamos o número de avaliações
        $this->totalAvaliacoes++;
        // Somamos a nova nota e dividimos pelo novo total
        $novaMedia = ($somaAnterior + $nota) / $this->totalAvaliacoes;
        $this->avaliacao = round($novaMedia, 2);
    }

    public function getViews(): int {
        return $this->views;
    }
    public function setViews(int $views): void {
        $this->views = $views;
    }

    public function isReproduzindo(): bool {
        return $this->reproduzindo;
    }
    public function setReproduzindo(bool $reproduzindo): void {
        $this->reproduzindo = $reproduzindo;
    }

    public function getTotalAvaliacoes(): int {
        return $this->totalAvaliacoes;
    }
    public function setTotalAvaliacoes(int $totalAvaliacoes): void {
        $this->totalAvaliacoes = $totalAvaliacoes;
    }
}