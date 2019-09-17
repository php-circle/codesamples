<?php
declare(strict_types=1);

namespace App\Repositories\Doctrine;

use App\Database\Entities\UserAccount;
use App\Database\Exceptions\InvalidSubscriptionTypeException;
use App\Repositories\Doctrine\ORM\AbstractRepository;
use App\Repositories\Interfaces\AccountRepositoryInterface;

final class AccountRepository extends AbstractRepository implements AccountRepositoryInterface
{
    /**
     * Get entity class managed by the repository.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return UserAccount::class;
    }

    /**
     * @param string $subscriptionType
     * @return array
     * @throws InvalidSubscriptionTypeException
     */
    public function findBySubscriptionType(string $subscriptionType): array
    {
        if( \in_array($subscriptionType, UserAccount::SUBSCRIPTION_TYPES) === false ){
            throw new InvalidSubscriptionTypeException( "Invalid Subscription Type." );
        }

        $queryBuilder = $this->createQueryBuilder('a')
            ->where('a.subscriptionType = :subscriptionType')
            ->setParameter('subscriptionType', $subscriptionType);

        return $queryBuilder->getQuery()->getResult();
    }
}
