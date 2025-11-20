<?php
declare(strict_types=1);
require_once 'Gafanhoto.php';
require_once 'Video.php';

class Visualizacao {
    public function __construct(
        private Gafanhoto $espectador,
        private Video $filme
    ) {
        $this->filme->setViews($this->filme->getViews() + 1);
        $this->espectador->assistirMaisUm();
    }

    public function avaliar(float|int|null $nota = null): void {
        if ($nota === null) {
            $nota = 6.0;
        }
        
        if ($nota > 10.0) {
            $nota = 10.0;
        } elseif ($nota < 0) {
            $nota = 0.0;
        }

        $this->filme->setAvaliacao((float)$nota);
    }

    // Getters e Setters
    public function getEspectador(): Gafanhoto {
        return $this->espectador;
    }
    public function setEspectador(Gafanhoto $espectador): void {
        $this->espectador = $espectador;
    }

    public function getFilme(): Video {
        return $this->filme;
    }
    public function setFilme(Video $filme): void {
        $this->filme = $filme;
    }
}