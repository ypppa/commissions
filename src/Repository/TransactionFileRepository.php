<?php

namespace Ypppa\Commissions\Repository;

use Generator;
use Ypppa\Commissions\Contract\TransactionRepositoryInterface;
use Ypppa\Commissions\Model\Transaction;

class TransactionFileRepository implements TransactionRepositoryInterface
{
    private string $filePath;

    /**
     * @var Transaction[]
     */
    private array $transactions;
    private array $currenciesList;

    /**
     * @param string $filePath
     */
    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->readFile();

    }

    private function readFile(): void
    {
        $file = fopen($this->filePath, 'r');

        function getAllLines($f): Generator
        {
            while (!feof($f)) {
                yield fgets($f);
            }
        }

        foreach (getAllLines($file) as $line) {
            $transaction = Transaction::newFromJson($line);
            $this->transactions[] = $transaction;
            $this->currenciesList[] = $transaction->getCurrency();
        }
        $this->currenciesList = array_unique($this->currenciesList);
        fclose($file);
    }

    /**
     * @return Transaction[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }

    /**
     * @return string[]
     */
    public function getCurrenciesList(): array
    {
        return $this->currenciesList;
    }
}