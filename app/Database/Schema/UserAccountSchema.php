<?php
declare(strict_types=1);

namespace App\Database\Schema;
use App\Database\Entities\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method null|string getAccountNumber()
 * @method null|string getUserAcctId()
 * @method null|User getUser()
 * @method null|string getSubscriptionType()
 * @method self setSubscriptionType(string $subscriptionType)
 * @method self setAccountNumber(string $accountNumber)
 * @method self setUserId(string $userId)
 */
trait UserAccountSchema
{
    /**
     * @ORM\Column(type="string", name="account_number")
     *
     * @var string
     */
    protected $accountNumber;

    /**
     * @ORM\Column(type="string", name="subscription_type")
     *
     * @var string
     */
    protected $subscriptionType;

    /**
     * @ORM\Column(type="guid", name="id")
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Id()
     *
     * @var string
     */
    protected $userAcctId;

    /**
     * @ORM\Column(type="guid", name="user_id")
     *
     * @var string
     */
    protected $userId;
}
