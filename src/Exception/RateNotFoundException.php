<?php
namespace Ypppa\Commissions\Exception;

use Exception;
use Throwable;

class RateNotFoundException extends Exception
{
    public function __construct(string $currency, Throwable $previous = null)
    {
        parent::__construct(sprintf("Got error while trying to get rate for currency = [ %s ]", $currency), 0, $previous);
    }
}