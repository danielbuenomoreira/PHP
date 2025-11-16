<?php
// Ativa a verificação rigorosa de tipos
declare(strict_types=1);

// Importa a interface que esta classe deve seguir
require_once 'Controlador.php';

class ControleRemoto implements Controlador {
    private int $volume;
    private bool $ligado;
    private bool $tocando;

    public function __construct() {
        $this->volume = 50;
        $this->ligado = false;
        $this->tocando = false;
    }

    protected function getVolume(): int {
        return $this->volume;
    }

    protected function setVolume(int $volume): void {
        $this->volume = $volume;
    }

    protected function isLigado(): bool {
        return $this->ligado;
    }

    protected function setLigado(bool $ligado): void {
        $this->ligado = $ligado;
    }

    protected function isTocando(): bool {
        return $this->tocando;
    }

    protected function setTocando(bool $tocando): void {
        $this->tocando = $tocando;
    }

    public function ligar(): void {
        $this->setLigado(true);
    }

    public function desligar(): void {
        $this->setLigado(false);
    }

    public function abrirMenu(): string {
        $menuString = "------ MENU ------<br>";
        $menuString .= "Está ligado? " . ($this->isLigado() ? "SIM" : "NÃO");
        // Usamos '.=' para concatenar (adicionar) mais texto à variável
        $menuString .= "<br>Está tocando? " . ($this->isTocando() ? "SIM" : "NÃO");
        $menuString .= "<br>Volume: " . $this->getVolume() . " ";

        // Loop para construir a barra de volume
        for ($i = 5; $i <= $this->getVolume(); $i += 5) {
            $menuString .= "I";
        }
        $menuString .= "<br>";
        // No final, retornamos a string COMPLETA
        return $menuString;
    }

    public function fecharMenu(): string {
        return "Fechando menu...";
    }

    public function maisVolume(): void {
        if ($this->isLigado() && $this->getVolume() < 100) {
            $this->setVolume($this->getVolume() + 5);
        }
    }

    public function menosVolume(): void {
        if ($this->isLigado() && $this->getVolume() > 0) {
            $this->setVolume($this->getVolume() - 5);
        }
    }

    public function ligarMudo(): void {
        if ($this->isLigado() && $this->getVolume() > 0) {
            $this->setVolume(0);
        }
    }

    public function desligarMudo(): void {
        if ($this->isLigado() && $this->getVolume() == 0) {
            $this->setVolume(50);
        }
    }

    public function play(): void {
        if ($this->isLigado() && !$this->isTocando()) {
            $this->setTocando(true);
        }
    }

    public function pause(): void {
        if ($this->isLigado() && $this->isTocando()) {
            $this->setTocando(false);
        }
    }
}