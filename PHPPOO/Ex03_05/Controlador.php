<?php

declare(strict_types=1);

interface Controlador
{
    public function ligar(): void;
    public function desligar(): void;
    public function abrirMenu(): string;
    public function fecharMenu(): string;
    public function maisVolume(): void;
    public function menosVolume(): void;
    public function ligarMudo(): void;
    public function desligarMudo(): void;
    public function play(): void;
    public function pause(): void;
}
