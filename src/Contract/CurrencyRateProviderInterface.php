<?php

namespace Ypppa\Commissions\Contract;

interface CurrencyRateProviderInterface
{
    /**
     * @param string $base
     * @param array  $currencies
     *
     * @return array
     */
    public function getRates(string $base, array $currencies): array;
}