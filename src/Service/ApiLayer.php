<?php

namespace Ypppa\Commissions\Service;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Throwable;
use Ypppa\Commissions\Contract\CurrencyRateProviderInterface;
use Ypppa\Commissions\Exception\GetCurrencyRatesErrorException;

class ApiLayer implements CurrencyRateProviderInterface
{
    const API_URL = 'https://api.apilayer.com';
    const API_KEY = 'XFZk4Zlk9guCp20JYWLT5zBIVFqxTCHI';

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param string $base
     * @param array  $currencies
     *
     * @return array
     * @throws GetCurrencyRatesErrorException
     */
    public function getRates(string $base, array $currencies): array
    {
        $client = new Client(['base_uri' => self::API_URL, 'timeout' => 10.0]);
        $headers = ['Content-Type' => 'text/plain', 'apikey' => self::API_KEY];

        try {
            $response = $client->request('GET', '/exchangerates_data/latest', [
                'query'   => ['base' => $base, 'symbols' => implode(',', $currencies)],
                'headers' => $headers,
            ]);

            $body = json_decode($response->getBody()->getContents(), true);

            return $body['rates'];
        } catch (Throwable $t) {
            $e = new GetCurrencyRatesErrorException($t);
            $this->logger->error($e->getMessage());
            throw new GetCurrencyRatesErrorException($t);
        }
    }
}