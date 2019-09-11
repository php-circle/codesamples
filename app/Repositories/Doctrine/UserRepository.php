<?php
declare(strict_types=1);

namespace App\Repositories\Doctrine;

use App\Database\Entities\User;
use App\Repositories\Doctrine\ORM\AbstractRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;

final class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    /**
     * Get entity class managed by the repository.
     *
     * @return string
     */
    protected function getEntityClass(): string
    {
        return User::class;
    }
}
