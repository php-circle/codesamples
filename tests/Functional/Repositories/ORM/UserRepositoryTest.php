<?php
declare(strict_types=1);

namespace Tests\App\Functional\Repositories\ORM;

use App\Database\Entities\User;
use App\Repositories\Doctrine\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Tests\App\Tools\TestCases\AbstractDatabaseTestCase;

/**
 * @covers \App\Repositories\Doctrine\UserRepository
 */
final class UserRepositoryTest extends AbstractDatabaseTestCase
{
    /**
     * Test entity class.
     *
     * @return void
     *
     * @throws \ReflectionException
     */
    public function testEntityClass(): void
    {
        $repository = $this->app->get(UserRepositoryInterface::class);

        $method = $this->getMethodAsPublic(UserRepository::class, 'getEntityClass');

        self::assertEquals(User::class, $method->invoke($repository));
    }

    /**
     * Test to search by first name.
     *
     * @return void
     */
    public function testFindByFirstName(): void
    {
    }

    /**
     * Test to set user.
     *
     * @throws \Exception
     */
    public function testSetUser(): void
    {
        $repository = $this->app->get(UserRepositoryInterface::class);

        $user = new User([
            'email' => 'johndoe@gmail.com',
            'firstName' => 'John',
            'lastName' => 'Doe'
        ]);

        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();

        $users = $repository->findByFirstName('John');
        self::assertContains($user, $users);



    }
}
