<?php

namespace Ypppa\Commissions\Contract;

use Ypppa\Commissions\Model\Transaction;

interface TransactionRepositoryInterface
{
    /**
     * @return Transaction[]
     */
    public function getTransactions(): array;

    /**
     * @return string[]
     */
    public function getCurrenciesList(): array;
}