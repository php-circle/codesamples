<?php
declare(strict_types=1);

namespace App\Database\Entities;

use App\Database\Schema\AccountSchema;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class Account extends AbstractEntity
{
    use AccountSchema;

    /**
     * Get array representation of children.
     *
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'id' => $this->getAccountId(),
            'account_number' => $this->getAccountNumber(),
            'subscription_type' => $this->getSubscriptionType()
        ];
    }

    /**
     * Get entity specific validation rules as an array.
     *
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'accountNumber' => 'required|string',
            'subscriptionType' => 'required|in:monthly,lifetime'
        ];
    }

    /**
     * Get the id property for this entity
     *
     * @return string
     */
    protected function getIdProperty(): string
    {
        return 'accountId';
    }
}
