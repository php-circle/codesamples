<?php
declare(strict_types=1);


namespace App\Repositories\Doctrine\ORM;


use App\Database\Entities\Account;
use App\Exceptions\InvalidSubscriptionTypeException;
use App\Repositories\Interfaces\AccountRepositoryInterface;
use Exception;

final class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    /**
     * Allowed subscription types
     *
     * @var array
     */
    static $subscriptionTypes = ['monthly', 'lifetime'];
    
    /**
     * Find by subscription type
     *
     * @param string $subscriptionType
     *
     * @return mixed[]
     *
     * @throws Exception
     */
    public function findBySubscriptionType(string $subscriptionType): array
    {
        if (in_array(strtolower($subscriptionType), self::$subscriptionTypes) === false) {
            throw new InvalidSubscriptionTypeException('Invalid subscription type.', 0);
        }
        return $this->repository->findby(['subscriptionType' => $subscriptionType]);
    }
    
    /**
     * Get entity manage by this repository
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Account::class;
    }
}