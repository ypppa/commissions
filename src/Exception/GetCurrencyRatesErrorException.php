<?php
namespace Ypppa\Commissions\Exception;

use Exception;
use Throwable;

class GetCurrencyRatesErrorException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Got error while trying to get currencies rates', 0, $previous);
    }
}