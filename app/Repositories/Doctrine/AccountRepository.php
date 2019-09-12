<?php
declare(strict_types=1);

namespace App\Repositories\Doctrine;

use App\Database\Entities\Account;
use App\Database\Exceptions\InvalidTypeSubscriptionException;
use App\Repositories\Doctrine\ORM\AbstractRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;

final class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    /**
     * Find by subscription type.
     *
     * @param string $subscriptionType
     *
     * @return mixed[]
     */
    public function findBySubscriptionType(string $subscriptionType): array
    {
        try {
            if ($subscriptionType !== Account::SUBSCRIPTION_TYPE_MONTHLY
                && $subscriptionType !== Account::SUBSCRIPTION_TYPE_LIFETIME
            ) {
                throw new InvalidTypeSubscriptionException();
            }

            return $this->repository->findBy(['subscriptionType' => $subscriptionType]);
        } catch (InvalidTypeSubscriptionException $ex) {
            return ['error' => $ex->getErrorCode()];
        }
    }

    /**
     * Get entity class managed by the repository.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return Account::class;
    }
}
