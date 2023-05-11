<?php

namespace Ypppa\Commissions\Contract;

interface BinProviderInterface
{
    public function lookup(string $bin): BinInfoInterface;
}