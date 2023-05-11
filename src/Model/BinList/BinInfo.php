<?php

namespace Ypppa\Commissions\Model\BinList;

use Ypppa\Commissions\Contract\BinInfoInterface;

class BinInfo implements BinInfoInterface
{
    private array $data;

    public function __construct(string $jsonData)
    {
        $this->data = json_decode($jsonData, true);
    }

    public function GetAlpha2CountryCode(): string
    {
        return $this->data['country']['alpha2'];
    }
}