<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\User;
use App\Database\Entities\UserAccount;
use App\Repositories\Doctrine\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use ReflectionException;
use Tests\App\TestCases\AbstractDatabaseTestCase;

final class UserRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test entity class.
     *
     * @return void
     *
     * @throws ReflectionException
     */
    public function testEntityClass(): void
    {
        $repository = $this->app->get(UserRepositoryInterface::class);

        $method = $this->getMethodAsPublic(UserRepository::class, 'getEntityClass');

        self::assertEquals(User::class, $method->invoke($repository));
    }

}
