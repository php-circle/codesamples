<?php


namespace App\Repositories\Doctrine\ORM;


use App\Database\Entities\Account;
use App\Exceptions\InvalidSubscriptionTypeException;
use App\Repositories\Interfaces\AccountRepositoryInterface;

final class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    /**
     * Find by subscription type
     *
     * @param string $subscriptionType
     * @return array
     * @throws \Exception
     */
    public function findBySubscriptionType(string $subscriptionType): array
    {
        $entity = new Account();
        if (!in_array(strtolower($subscriptionType), $entity->doGetTypes())) {
            Throw new InvalidSubscriptionTypeException();
        }
        $this->repository->findby(['subscriptionType' => $subscriptionType]);
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