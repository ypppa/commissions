<?php

namespace Ypppa\Commissions\Model;

class Transaction
{
    private string $bin;
    private float $amount;
    private string $currency;
    private float $commissionAmount;
    private string $commissionCurrency;

    public function __construct(string $bin, float $amount, string $currency)
    {
        $this->bin = $bin;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public static function newFromJson(string $jsonData): Transaction
    {
        $data = json_decode($jsonData, true);

        return new Transaction($data['bin'], $data['amount'], $data['currency']);
    }

    public function getBin(): string
    {
        return $this->bin;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getCommissionAmount(): float
    {
        return $this->commissionAmount;
    }

    public function setCommissionAmount(float $commissionAmount): void
    {
        $this->commissionAmount = $commissionAmount;
    }

    public function getCommissionCurrency(): string
    {
        return $this->commissionCurrency;
    }

    public function setCommissionCurrency(string $commissionCurrency): void
    {
        $this->commissionCurrency = $commissionCurrency;
    }
}