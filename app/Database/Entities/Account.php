<?php


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
     * Get entity specific validation rules as an array.
     *
     * @return array
     */
    protected function doGetRules(): array
    {
        return [
            'account_number' => 'required|string',
            'subscription_type' => 'required|in:monthly,lifetime'
        ];
    }
    
    /**
     * Get array representation of children.
     *
     * @return array
     */
    protected function doToArray(): array
    {
        return [
            'account_number' => $this->getAccountNumber(),
            'subscription_type' => $this->getSubscriptionType()
        ];
    }
    
    /**
     * Get id property of this entity
     *
     * @return string
     */
    protected function getIdProperty(): string
    {
        return 'accountId';
    }
}