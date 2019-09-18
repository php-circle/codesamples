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
     * Constant variable for account number rule.
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
     * Constant variable for subscription types.
     *
     * @const array
     */
    public const SUBSCRIPTION_TYPES = [
        'lifetime',
        'monthly'
    ];

    /**
     * Constant variable for user rule.
     *
     * @const string
     */
    public const USER_RULE = 'required';

    /**
     * @ORM\ManyToOne(targetEntity="\App\Database\Schema\User", inversedBy="account")
     * @ORM\JoinColumn(nullable=false)
     * 
     * @var \App\Database\Schema\User
     */
    protected $user;

    /**
     * Get entity specific validation rules as an array.
     *
     * @return mixed[]
     */
    protected function doGetRules(): array
    {
        return [
            'accountNumber' => 'required|string',
            'subscriptionType' => 'required|in:monthly,lifetime',
            'user' => 'required|' . $this->instanceOfRuleAsString(User::class)
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
            'subscription_type' => $this->getSubscriptionType(),
            'user' => $this->getUser()
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
