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
     * Constant variable for monthly.
     *
     * @const string
     */
    public const SUBSCRIPTION_TYPE_MONTHLY = 'monthly';

    /**
     * Constant variable for lifetime.
     *
     * @const string
     */
    public const SUBSCRIPTION_TYPE_LIFETIME = 'lifetime';

    /**
     * Constant variable for acount number rule.
     *
     * @const string
     */
    public const ACCOUNT_NUMBER_RULE = 'required|string';

    /**
     * Constant variable for subscription type rule.
     *
     * @const string
     */
    public const SUBSCRIPTION_TYPE_RULE = 'required|in:monthly,lifetime';

    /**
     * Get entity specific validation rules as an array.
     *
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'accountNumber' => self::ACCOUNT_NUMBER_RULE,
            'subscriptionType' => self::SUBSCRIPTION_TYPE_RULE
        ];
    }

    /**
     * Get array representation of children.
     *
     * @return mixed[]
     */
    protected function doToArray(): array
    {
        return [
            'account_number' => $this->getAccountNumber(),
            'id' => $this->getAccountId(),
            'subscription_type' => $this->getSubscriptionType()
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
