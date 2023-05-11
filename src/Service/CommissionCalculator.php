<?php

namespace Ypppa\Commissions\Service;

use Ypppa\Commissions\Contract\BinProviderInterface;
use Ypppa\Commissions\Exception\BinLookupErrorException;
use Ypppa\Commissions\Model\Transaction;
use Ypppa\Commissions\Utils\CountryHelper;

class CommissionCalculator
{
    const EU_COMMISSION = 0.01;
    const NON_EU_COMMISSION = 0.02;

    private BinList $binList;
    private string $baseCurrency;
    private array $currencyRates;

    public function __construct(
        BinProviderInterface $binList,
        array $currencyRates,
        string $baseCurrency
    ) {
        $this->binList = $binList;
        $this->baseCurrency = $baseCurrency;
        $this->currencyRates = $currencyRates;
    }

    /**
     * @param Transaction $transaction
     *
     * @return void
     * @throws BinLookupErrorException
     */
    public function calculate(Transaction $transaction): void
    {
        $bin = $this->binList->lookup($transaction->getBin());
        $commission = CountryHelper::isEUCountry($bin->GetAlpha2CountryCode()) ? self::EU_COMMISSION : self::NON_EU_COMMISSION;
        $rate = $this->currencyRates[$transaction->getCurrency()];
        $commissionAmount = round($transaction->getAmount() / $rate * $commission, 2);
        $transaction->setCommissionCurrency($this->baseCurrency);
        $transaction->setCommissionAmount($commissionAmount);
    }

    public function setCurrencyRates(array $currencyRates): void
    {
        $this->currencyRates = $currencyRates;
    }
}