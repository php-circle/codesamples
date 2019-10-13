<?php
declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;
use Throwable;

final class InvalidSubscriptionTypeException extends RuntimeException
{
    /**
     * InvalidSubscriptionTypeException constructor.
     *
     * @param int $code
     * @param string $message
     * @param \Throwable|null $previous
     */
    public function __construct(String $message, Int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * Returns Exception message
     *
     * @return string
     */
    public function __toString(): string
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
