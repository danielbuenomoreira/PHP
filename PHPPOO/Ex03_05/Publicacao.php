<?php

declare(strict_types=1);

interface Publicacao {
    public function abrir(): void;
    public function fechar(): void;
    public function folhear(int $p): void;
    public function avancarPag(): void;
    public function voltarPag(): void;
}
