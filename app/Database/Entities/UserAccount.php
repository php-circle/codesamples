<?php
declare(strict_types=1);

namespace App\Database\Entities;
use App\Database\Schema\UserAccountSchema;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
class UserAccount extends AbstractEntity
{
    use UserAccountSchema;

    /** string */
    public const SUBSCRIPTION_TYPE_LIFETIME = 'lifetime';
    public const SUBSCRIPTION_TYPE_MONTHLY = 'monthly';

    /** string[] */
    public const SUBSCRIPTION_TYPES = [
        self::SUBSCRIPTION_TYPE_LIFETIME,
        self::SUBSCRIPTION_TYPE_MONTHLY
    ];

    /**
     * @ORM\ManyToOne(
     *     targetEntity="\App\Database\Entities\User",
     *     inversedBy="accounts",
     *     cascade={"persist"}
     * )
     *
     * @var User
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
            'subscriptionType' => 'required|in:' . \implode( ',', self::SUBSCRIPTION_TYPES ),
            'user' => 'required|' . $this->instanceOfRuleAsString( User::class )
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
            'id' => $this->getIdProperty(),
            'subscription_type' => $this->getSubscriptionType(),
            'user' => $this->getUser()
        ];
    }

    /**
     * Set user association.
     *
     * @param User $user
     *
     * @return UserAccount
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        if ($user->getUserId() !== null) {
            $this->userId = $user->getUserId();
        }

        return $this;
    }

    /**
     * Get the id property for this entity
     *
     * @return string
     */
    protected function getIdProperty(): string
    {
        return 'userAcctId';
    }

}
