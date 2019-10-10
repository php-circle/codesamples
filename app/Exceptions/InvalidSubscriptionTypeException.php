<?php
declare(strict_types=1);


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
    public function __construct(String $message, Int $code, Throwable $previous = null)
    {
        $code = 0;
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