<?php
namespace Ypppa\Commissions\Exception;

use Exception;
use Throwable;

class BinLookupErrorException extends Exception
{
    public function __construct(Throwable $previous = null)
    {
        parent::__construct('Got error while trying to get bin info', 0, $previous);
    }
}