<?php

declare(strict_types=1);
require_once 'Lutador.php';

class Luta {
    private ?Lutador $desafiado;
    private ?Lutador $desafiante;
    private bool $aprovada = false;

    public function marcarLuta(Lutador $l1, Lutador $l2): bool {
        if ($l1->getCategoria() === $l2->getCategoria() && ($l1 !== $l2)) {
            $this->aprovada = true;
            $this->setDesafiado($l1);
            $this->setDesafiante($l2);
            return true;
        } else {
            $this->aprovada = false;
            $this->setDesafiado(null);
            $this->setDesafiante(null);
            return false;
        }
    }
    public function lutar(): string {
        if ($this->aprovada) {
            $vencedor = rand(0, 2);
            switch($vencedor) {
                case 0: // Empate
                    $this->desafiado->empatarLuta();
                    $this->desafiante->empatarLuta();
                    return "<div class='resultado-luta empate'>A luta empatou!</div>";

                case 1: // Desafiado vence
                    $this->desafiado->ganharLuta();
                    $this->desafiante->perderLuta();
                    
                    $nome = $this->desafiado->getNome();
                    return "<div class='resultado-luta'>O desafiado {$nome} venceu a luta!</div>";

                case 2: // Desafiante vence
                    $this->desafiante->ganharLuta();
                    $this->desafiado->perderLuta();
                    
                    $nome = $this->desafiante->getNome();
                    return "<div class='resultado-luta'>O desafiante {$nome} venceu a luta!</div>";
            }
        }
        return "<div class='erro-luta'>ERRO: Esta luta não pode acontecer!</div>";
    }

    public function getDesafiado(): ?Lutador {
        return $this->desafiado;
    }
    private function setDesafiado(?Lutador $desafiado): void {
        $this->desafiado = $desafiado;
    }

    // Desafiante
    public function getDesafiante(): ?Lutador {
        return $this->desafiante;
    }
    private function setDesafiante(?Lutador $desafiante): void {
        $this->desafiante = $desafiante;
    }

    // Aprovada
    public function isAprovada(): bool {
        return $this->aprovada;
    }
    private function setAprovada(bool $aprovada): void {
        $this->aprovada = $aprovada;
    }
}