<?php


namespace App\Exceptions;

use RuntimeException;
use Throwable;

class InvalidSubscriptionTypeException extends RuntimeException
{
    /**
     * InvalidSubscriptionTypeException constructor.
     *
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "Invalid subscription type.", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}