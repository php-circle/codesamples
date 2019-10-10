<?php
declare(strict_types=1);

namespace App\Repositories\Interfaces;


interface AccountRepositoryInterface extends AppRepositoryInterface
{
    /**
     * Find by subscription type.
     *
     * @param string $subscriptionType
     * @return array
     */
    public function findBySubscriptionType(string $subscriptionType): array;
}