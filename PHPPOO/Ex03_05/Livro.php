<?php
declare(strict_types=1);

require_once 'Pessoa.php';
require_once 'Publicacao.php';

class Livro implements Publicacao {
    private int $pagAtual = 0;
    private bool $aberto = false;

    public function detalhes(): string {
        $statusAberto = $this->getAberto() ? "Sim" : "Não";
        
        return <<<HTML
            <div class='detalhes-livro'>
                <p>Livro: <strong>{$this->getTitulo()}</strong>
                Escrito por: {$this->getAutor()}
                Páginas: {$this->getTotPaginas()} | Atual: {$this->getPagAtual()}
                Está aberto? {$statusAberto}
                Leitor: {$this->getLeitor()->getNome()} ({$this->getLeitor()->getIdade()} anos, {$this->getLeitor()->getSexo()})</p>
            </div>
        HTML;
    }

    public function __construct(
        private string $titulo,
        private string $autor,
        private int $totPaginas,
        private Pessoa $leitor
        ) {
    }

    // Getters and Setters
    public function getTitulo(): string {
        return $this->titulo;
    }
    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getAutor(): string {
        return $this->autor;
    }
    public function setAutor(string $autor): void {
        $this->autor = $autor;
    }

    public function getTotPaginas(): int {
        return $this->totPaginas;
    }
    public function setTotPaginas(int $totPaginas): void {
        $this->totPaginas = $totPaginas;
    }

    public function getPagAtual(): int {
        return $this->pagAtual;
    }
    public function setPagAtual(int $pagAtual): void {
        $this->pagAtual = $pagAtual;
    }

    public function getAberto(): bool {
        return $this->aberto;
    }
    public function setAberto(bool $aberto): void {
        $this->aberto = $aberto;
    }

    public function getLeitor(): Pessoa {
        return $this->leitor;
    }
    public function setLeitor(Pessoa $leitor): void {
        $this->leitor = $leitor;
    }

    // Implementação dos métodos de Publicacao.php
    public function abrir(): void {
        $this->aberto = true;
    }
    public function fechar(): void {
        $this->aberto = false;
        $this->setPagAtual(0);
    }

    public function folhear(int $p): void {
        if (!$this->getAberto()) {
            echo "<p>O livro está fechado. Não é possível folhear.</p>";
            return;
        }

        if ($p > $this->getTotPaginas()) {
            $this->pagAtual = $this->getTotPaginas(); // Vai para a última página
        } else {
            $this->pagAtual = $p;
        }
    }

    public function avancarPag(): void {
        if ($this->getAberto() && $this->getPagAtual() < $this->getTotPaginas()) {
            $this->pagAtual++;
        }
    }

    public function voltarPag(): void {
        if ($this->getAberto() && $this->getPagAtual() > 0) {
            $this->pagAtual--;
        }
    }
}