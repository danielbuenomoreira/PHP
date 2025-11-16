<?php

declare(strict_types=1);

class ContaBanco
{
    public ?int $numConta = null;
    protected ?string $tipo = null;
    private ?string $dono = null;
    private bool $status = false;
    private float $saldo = 0.0;

    public function __construct()
    {
        echo "<p>Objeto ContaBanco criado!</p>"; // Feedback
    }

    public function abrirConta(string $tip): string
    {
        $this->setTipo($tip);
        $this->setStatus(true);
        $this->setNumConta(rand(10000, 99999)); // Atribui um nº de conta

        if ($tip == "CC") {
            $this->setSaldo(50);
        } elseif ($tip == "CP") {
            $this->setSaldo(150);
        }
        return "Conta de {$this->getDono()} aberta com sucesso!";
    }

    public function fecharConta(): string
    {
        if ($this->getSaldo() > 0) {
            return "Erro: Conta ainda tem dinheiro, não posso fechá-la.";
        } elseif ($this->getSaldo() < 0) {
            return "Erro: Conta está em débito. Impossível encerrar!";
        } else {
            $this->setStatus(false);
            return "Conta de {$this->getDono()} fechada com sucesso.";
        }
    }

    public function depositar(float $val): string
    {
        if ($this->getStatus()) {
            $this->setSaldo($this->getSaldo() + $val);
            return "Depósito de R$ $val realizado na conta de {$this->getDono()}.";
        } else {
            return "Erro: Conta fechada. Não consigo depositar.";
        }
    }

    public function sacar(float $val): string
    {
        if ($this->getStatus()) {
            if ($this->getSaldo() >= $val) {
                $this->setSaldo($this->getSaldo() - $val);
                return "Saque de R$ $val autorizado na conta de {$this->getDono()}.";
            } else {
                return "Erro: Saldo insuficiente para saque.";
            }
        } else {
            return "Erro: Não é possível sacar de uma conta fechada.";
        }
    }

    /** Paga a mensalidade da conta. */
    public function pagarMensal(): string
    {
        $val = 0;
        if ($this->getTipo() == "CC") {
            $val = 12;
        } elseif ($this->getTipo() == "CP") {
            $val = 20;
        } else {
            return "Erro: Tipo de conta inválido.";
        }

        if ($this->getStatus()) {
            if ($this->getSaldo() >= $val) {
                $this->setSaldo($this->getSaldo() - $val);
                return "Mensalidade de R$ $val debitada da conta de {$this->getDono()}.";
            } else {
                return "Erro: Saldo insuficiente para pagar mensalidade.";
            }
        } else {
            return "Erro: Problemas com a conta. Não posso cobrar.";
        }
    }

    // --- Getters e Setters ---

    public function getNumConta(): ?int
    {
        return $this->numConta;
    }

    public function setNumConta(int $nc): void
    {
        $this->numConta = $nc;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getDono(): ?string
    {
        return $this->dono;
    }

    public function setDono(string $dono): void
    {
        $this->dono = $dono;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    public function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }
}