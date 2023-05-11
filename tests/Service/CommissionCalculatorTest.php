<?php

namespace Service;

use Ypppa\Commissions\Contract\BinInfoInterface;
use Ypppa\Commissions\Exception\BinLookupErrorException;
use Ypppa\Commissions\Exception\RateNotFoundException;
use Ypppa\Commissions\Model\BinList\BinInfo;
use Ypppa\Commissions\Model\Transaction;
use Ypppa\Commissions\Service\BinList;
use Ypppa\Commissions\Service\CommissionCalculator;
use PHPUnit\Framework\TestCase;

class CommissionCalculatorTest extends TestCase
{


    /**
     * @param Transaction      $transaction
     * @param BinInfoInterface $binInfo
     * @param array            $currencyRates
     * @param string           $baseCurrency
     * @param float            $commissionAmount
     *
     * @return void
     * @throws BinLookupErrorException
     * @throws RateNotFoundException
     * @dataProvider calculateProvider
     *
     */
    public function testCalculate(Transaction $transaction, BinInfoInterface $binInfo, array $currencyRates, string $baseCurrency, float $commissionAmount)
    {
        $mockBinProvider = $this->createMock(BinList::class);
        $mockBinProvider->expects(self::once())
                        ->method('lookup')
                        ->willReturn($binInfo);

        $calculator = new CommissionCalculator($mockBinProvider, $currencyRates, $baseCurrency);
        $calculator->calculate($transaction);

        $this->assertEquals($commissionAmount, $transaction->getCommissionAmount());
        $this->assertEquals($baseCurrency, $transaction->getCommissionCurrency());
    }

    public function calculateProvider(): array
    {
        return [
            'non-eu country different currency' => [
                Transaction::newFromJson('{"bin":"41417360","amount":"100.00","currency":"USD"}'),
                new BinInfo('{"country":{"alpha2":"US"}}'),
                ['USD' => 1.090811],
                'EUR',
                1.83,
            ],
            'non-eu country same currency' => [
                Transaction::newFromJson('{"bin":"45717360","amount":"100.00","currency":"EUR"}'),
                new BinInfo('{"country":{"alpha2":"US"}}'),
                ['EUR' => 1],
                'EUR',
                2,
            ],
            'eu country different currency' => [
                Transaction::newFromJson('{"bin":"516793","amount":"100.00","currency":"GBP"}'),
                new BinInfo('{"country":{"alpha2":"LT"}}'),
                ['GBP' => 0.870869],
                'EUR',
                1.15,
            ],
            'eu country same currency' => [
                Transaction::newFromJson('{"bin":"516793","amount":"100.00","currency":"EUR"}'),
                new BinInfo('{"country":{"alpha2":"LT"}}'),
                ['EUR' => 1],
                'EUR',
                1,
            ],
            'zero amount commission' => [
                Transaction::newFromJson('{"bin":"516793","amount":"0","currency":"EUR"}'),
                new BinInfo('{"country":{"alpha2":"LT"}}'),
                ['EUR' => 1],
                'EUR',
                0,
            ],
        ];
    }
}
