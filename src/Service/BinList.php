<?php

namespace Ypppa\Commissions\Service;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;
use Throwable;
use Ypppa\Commissions\Contract\BinInfoInterface;
use Ypppa\Commissions\Contract\BinProviderInterface;
use Ypppa\Commissions\Exception\BinLookupErrorException;
use Ypppa\Commissions\Model\BinList\BinInfo;

class BinList implements BinProviderInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;

    }

    public function lookup(string $bin): BinInfoInterface
    {
        $client = new Client(['base_uri' => 'https://lookup.binlist.net/', 'timeout' => 10.0]);
        $headers = ['Accept-Version' => '3'];

        try {
            $response = $client->request('GET', $bin, [
                'headers' => $headers,
            ]);

            return new BinInfo($response->getBody()->getContents());
        } catch (Throwable $t) {
            $e = new BinLookupErrorException($t);
            $this->logger->error($e->getMessage());

            throw new BinLookupErrorException($t);
        }
    }
}