<?php

namespace Ypppa\Commissions\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Logger\ConsoleLogger;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;
use Ypppa\Commissions\Repository\TransactionFileRepository;
use Ypppa\Commissions\Service\BinList;
use Ypppa\Commissions\Service\CommissionCalculator;
use Ypppa\Commissions\Service\ApiLayer;

class CalculateCommand extends Command
{
    const BASE_CURRENCY = 'EUR';

    protected static $defaultDescription = 'Calculate transactions\' commissions.';
    protected static $defaultName = 'app:calc-commissions';

    protected function configure(): void
    {
        $this
            ->setHelp('This command allows you to calculate transactions\' commissions.')
            ->addArgument('filePath', InputArgument::REQUIRED, 'Destination to file with transactions')
            ->addArgument('baseCurrency', InputArgument::OPTIONAL, 'Base currency alpha3 code');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $baseCurrency = $input->getArgument('baseCurrency') ? : self::BASE_CURRENCY;
        $filePath = $input->getArgument('filePath');

        $logger = new ConsoleLogger($output);

        try {
            $currencyRate = new ApiLayer($logger);
            $binService = new BinList($logger);
            $transactionRepository = new TransactionFileRepository($filePath);
            $currencyRates = $currencyRate->getRates($baseCurrency, $transactionRepository->getCurrenciesList());
            $commissionCalculator = new CommissionCalculator($binService, $currencyRates, $baseCurrency);
            $progressBar = new ProgressBar($output, count($transactionRepository->getTransactions()));
            $progressBar->start();
            foreach ($transactionRepository->getTransactions() as $transaction) {
                $commissionCalculator->calculate($transaction);

                $output->writeln(" <comment>Transaction: " .
                    $transaction->getAmount() . " " .
                    $transaction->getCurrency() . " </comment> <info> Commission: " .
                    $transaction->getCommissionAmount() . " " .
                    $transaction->getCommissionCurrency() . "</info>");

                $progressBar->advance();
            }

            $progressBar->finish();

            return Command::SUCCESS;
        } catch (Throwable $t) {
            return Command::FAILURE;
        }
    }
}